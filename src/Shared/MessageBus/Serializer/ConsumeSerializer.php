<?php

namespace App\Shared\MessageBus\Serializer;

use App\Inventory\Event\OrderCreated;
use App\Shared\MessageBus\Stamp\MessageDispatchDateStamp;
use App\Shared\MessageBus\Stamp\MessageIdStamp;
use App\Shared\MessageBus\Stamp\MessageTypeStamp;
use App\Shared\MessageBus\Stamp\Stamp;
use App\Shared\Model\DomainMessage;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Throwable;

final readonly class ConsumeSerializer implements SerializerInterface
{
    public function __construct(
        private SerializerInterface $serializer,
    ) { }

    public function decode(array $encodedEnvelope): Envelope
    {
        try {
            return $this->serializer->decode($encodedEnvelope);
        } catch (Throwable) { }

        if (empty($encodedEnvelope['body'])) {
            throw new MessageDecodingFailedException('Encoded envelope should have a "body".');
        }

        if (empty($encodedEnvelope['headers']['message_type'])) {
            throw new MessageDecodingFailedException('Encoded envelope should have a "headers.message_type".');
        }

        $stamps = $this->decodeStamps($encodedEnvelope['headers']);
        $payload = json_decode($encodedEnvelope['body'], true, 512, JSON_THROW_ON_ERROR);

        $typeStamp = MessageTypeStamp::deserialize($encodedEnvelope['headers']['message_type']);
        $message = match ($typeStamp->type) {
            OrderCreated::getType() => OrderCreated::deserialize($payload),
            default => throw new RuntimeException('Unmatched message type "' . $typeStamp->type . '".'),
        };

        return new Envelope($message, $stamps);
    }

    public function encode(Envelope $envelope): array
    {
        return $this->serializer->encode($envelope);
    }

    private function decodeStamps(mixed $headers): array
    {
        $stamps = [];

        foreach ($headers as $key => $header) {
            $stamp = match ($key) {
                MessageDispatchDateStamp::getName() => MessageDispatchDateStamp::deserialize($header),
                MessageIdStamp::getName() => MessageIdStamp::deserialize($header),
                MessageTypeStamp::getName() => MessageTypeStamp::deserialize($header),
                default => null,
            };

            if (null === $stamp) {
                continue;
            }

            $stamps[] = $stamp;
        }

        return $stamps;
    }
}
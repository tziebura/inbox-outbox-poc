<?php

namespace App\Shared\MessageBus\Serializer;

use App\Shared\MessageBus\Stamp\Stamp;
use App\Shared\Model\DomainMessage;
use InvalidArgumentException;
use LogicException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

final class PublishSerializer implements SerializerInterface
{
    public function decode(array $encodedEnvelope): Envelope
    {
        throw new LogicException('This should never be called.');
    }

    public function encode(Envelope $envelope): array
    {
        if (!$envelope->getMessage() instanceof DomainMessage) {
            throw new InvalidArgumentException('Only messages implementing ' . DomainMessage::class . ' can be encoded.');
        }

        $encoded = [];

        /** @var Stamp[] $ownStamps */
        $ownStamps = array_filter(
            $envelope->all(),
            static fn (string $key): bool => is_subclass_of($key, Stamp::class),
            ARRAY_FILTER_USE_KEY
        );

        $headers = [];

        foreach ($ownStamps as $stamps) {
            foreach ($stamps as $stamp) {
                $headers[$stamp->getName()] = $stamp->serialize();
            }
        }

        $encoded['headers'] = $headers;
        $encoded['body'] = json_encode($envelope->getMessage()->serialize(), JSON_THROW_ON_ERROR);

        return $encoded;
    }
}
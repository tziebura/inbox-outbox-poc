<?php

namespace App\Shared\MessageBus\Middleware;

use App\Shared\Inbox\Message;
use App\Shared\Inbox\MessageStore;
use App\Shared\MessageBus\Stamp\MessageIdStamp;
use DateTimeImmutable;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

final readonly class InboxMiddleware implements MiddlewareInterface
{
    public function __construct(
        private MessageStore $messageStore,
        private LoggerInterface $logger,
    ) { }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $messageIdStamp = $envelope->last(MessageIdStamp::class);

        // Skip this middleware
        if (null === $messageIdStamp) {
            return $stack->next()->handle($envelope, $stack);
        }

        if ($this->messageStore->exists($messageIdStamp->messageId)) {
            $this->logger->info(sprintf('Skipping message "%s" - message found in inbox.', $messageIdStamp->messageId));
            return $envelope; // TODO check if this works.
        }

        $receivedAt = new DateTimeImmutable();

        $envelope = $stack->next()->handle($envelope, $stack);

        $message = new Message(
            $messageIdStamp->messageId,
            $receivedAt,
            new DateTimeImmutable(),
        );

        $this->messageStore->save($message);
        $this->logger->info(sprintf('Received message "%s" - saved in inbox as processed', $messageIdStamp->messageId));
        return $envelope;
    }
}
<?php

namespace App\Shared\Outbox;

use App\Shared\EventBus\EventBus;
use App\Shared\MessageBus\Stamp\MessageDispatchDateStamp;
use App\Shared\MessageBus\Stamp\MessageIdStamp;
use App\Shared\MessageBus\Stamp\MessageTypeStamp;
use App\Shared\Model\DomainMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class MessageHandler
{
    public function __construct(
        private EventBus $eventBus,
    ) { }

    public function __invoke(Message $message): void
    {
        /** @var DomainMessage $domainMessage */
        $domainMessage = $message->messageClass::deserialize($message->payload);

        $this->eventBus->publish(
            $domainMessage,
            [
                new MessageIdStamp($message->id),
                new MessageDispatchDateStamp($message->occurredAt),
                new MessageTypeStamp($domainMessage::getType()),
            ],
        );
    }
}
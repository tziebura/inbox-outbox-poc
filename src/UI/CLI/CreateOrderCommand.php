<?php

namespace App\UI\CLI;

use App\Inventory\ValueObject\ProductId;
use App\Order\ValueObject\OrderId;
use App\Order\ValueObject\OrderItem;
use DateTimeImmutable;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand('app:order:create')]
final class CreateOrderCommand extends Command
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->messageBus->dispatch(new \App\Order\Command\CreateOrderCommand(
            OrderId::newOne()->toString(),
            new DateTimeImmutable(),
            [
                new OrderItem('item1', ProductId::newOne()->toString(), 2),
                new OrderItem('item2', ProductId::newOne()->toString(), 4),
            ]
        ));

        return Command::SUCCESS;
    }
}
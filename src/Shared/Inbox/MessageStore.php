<?php

namespace App\Shared\Inbox;

interface MessageStore
{
    public function exists(string $id): bool;
    public function save(Message $message): void;
}
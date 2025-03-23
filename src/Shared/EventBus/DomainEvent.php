<?php

namespace App\Shared\EventBus;

use App\Shared\Model\DomainMessage;

abstract readonly class DomainEvent implements DomainMessage
{
}
<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Attribute\Tests\Domain\Event;

use PHPUnit\Framework\TestCase;
use Ergonode\Attribute\Domain\Event\Option\OptionLabelChangedEvent;
use Ergonode\SharedKernel\Domain\AggregateId;
use Ergonode\Core\Domain\ValueObject\TranslatableString;

/**
 */
class OptionChangedEventTest extends TestCase
{
    /**
     */
    public function testEventCreation(): void
    {
        /** @var AggregateId $id */
        $id = $this->createMock(AggregateId::class);
        /** @var TranslatableString $from */
        $from = $this->createMock(TranslatableString::class);
        /** @var TranslatableString $to */
        $to = $this->createMock(TranslatableString::class);
        $event = new OptionLabelChangedEvent($id, $from, $to);
        $this->assertEquals($id, $event->getAggregateId());
        $this->assertEquals($from, $event->getFrom());
        $this->assertEquals($to, $event->getTo());
    }
}

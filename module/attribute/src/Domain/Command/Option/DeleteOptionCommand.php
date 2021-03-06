<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Attribute\Domain\Command\Option;

use Ergonode\SharedKernel\Domain\Aggregate\AttributeId;
use Ergonode\EventSourcing\Infrastructure\DomainCommandInterface;
use Ergonode\SharedKernel\Domain\AggregateId;

/**
 */
class DeleteOptionCommand implements DomainCommandInterface
{
    /**
     * @var AggregateId
     *
     * @JMS\Type("Ergonode\SharedKernel\Domain\AggregateId")
     */
    private AggregateId $id;

    /**
     * @var AttributeId
     *
     * @JMS\Type("Ergonode\SharedKernel\Domain\Aggregate\AttributeId")
     */
    private AttributeId $attributeId;

    /**
     * @param AggregateId $id
     * @param AttributeId $attributeId
     */
    public function __construct(AggregateId $id, AttributeId $attributeId)
    {
        $this->id = $id;
        $this->attributeId = $attributeId;
    }

    /**
     * @return AggregateId
     */
    public function getId(): AggregateId
    {
        return $this->id;
    }

    /**
     * @return AttributeId
     */
    public function getAttributeId(): AttributeId
    {
        return $this->attributeId;
    }
}

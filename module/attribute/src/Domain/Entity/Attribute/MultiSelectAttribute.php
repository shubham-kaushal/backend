<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Attribute\Domain\Entity\Attribute;

/**
 */
class MultiSelectAttribute extends AbstractOptionAttribute
{
    public const TYPE = 'MULTI_SELECT';

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE;
    }
}

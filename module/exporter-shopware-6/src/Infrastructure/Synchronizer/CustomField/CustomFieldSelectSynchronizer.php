<?php
/*
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\ExporterShopware6\Infrastructure\Synchronizer\CustomField;

use Ergonode\Attribute\Domain\Entity\AbstractAttribute;
use Ergonode\Attribute\Domain\Entity\Attribute\SelectAttribute;
use Ergonode\ExporterShopware6\Domain\Entity\Shopware6Channel;
use Ergonode\ExporterShopware6\Infrastructure\Synchronizer\AbstractCustomFieldOptionSynchronizer;

/**
 */
class CustomFieldSelectSynchronizer extends AbstractCustomFieldOptionSynchronizer
{
    /**
     * {@inheritDoc}
     */
    public function getType(): string
    {
        return SelectAttribute::TYPE;
    }

    /**
     * {@inheritDoc}
     */
    protected function getMapping(Shopware6Channel $channel, AbstractAttribute $attribute): array
    {
        $code = $attribute->getCode()->getValue();

        return
            [
                'name' => $code,
                'type' => 'select',
                'config' => [
                    'customFieldType' => 'select',
                    'componentName' => 'sw-single-select',
                    'options' => $this->getOptions($channel, $attribute),
                ],
            ];
    }
}

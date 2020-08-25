<?php
/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\ExporterShopware6\Application\Model\Type;

use Symfony\Component\Validator\Constraints as Assert;

/**
 */
class PropertyGroupAttributeModel
{
    /**
     * @var string|null
     *
     * @Assert\NotBlank()
     */
    public ?string $id;

    /**
     * @param string|null $id
     */
    public function __construct(?string $id = null)
    {
        $this->id = $id;
    }
}
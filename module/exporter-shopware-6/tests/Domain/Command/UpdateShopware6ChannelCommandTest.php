<?php
/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\ExporterShopware6\Tests\Domain\Command;

use Ergonode\Core\Domain\ValueObject\Language;
use Ergonode\ExporterShopware6\Domain\Command\UpdateShopware6ChannelCommand;
use Ergonode\SharedKernel\Domain\Aggregate\AttributeId;
use Ergonode\SharedKernel\Domain\Aggregate\CategoryTreeId;
use Ergonode\SharedKernel\Domain\Aggregate\ChannelId;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 */
class UpdateShopware6ChannelCommandTest extends TestCase
{
    /**
     * @var ChannelId|MockObject
     */
    private ChannelId $id;

    /**
     * @var string
     */
    private string $name;
    /**
     * @var string
     */
    private string $host;

    /**
     * @var string
     */
    private string $clientId;

    /**
     * @var string
     */
    private string $clientKey;

    /**
     * @var Language|MockObject
     */
    private Language $defaultLanguage;

    /**
     * @var AttributeId|MockObject
     */
    private AttributeId $productName;

    /**
     * @var AttributeId|MockObject
     */
    private AttributeId $productActive;

    /**
     * @var AttributeId|MockObject
     */
    private AttributeId $productStock;

    /**
     * @var AttributeId|MockObject
     */
    private AttributeId $productPrice;

    /**
     * @var AttributeId|MockObject
     */
    private AttributeId $productTax;

    /**
     * @var AttributeId|MockObject
     */
    private AttributeId $productDescription;

    /**
     * @var CategoryTreeId|MockObject
     */
    private CategoryTreeId $categoryTreeId;

    /**
     */
    protected function setUp(): void
    {
        $this->id = $this->createMock(ChannelId::class);
        $this->name = 'Any Name';
        $this->host = 'http://example';
        $this->clientId = 'Any Client ID';
        $this->clientKey = 'Any Client KEY';
        $this->defaultLanguage = $this->createMock(Language::class);
        $this->productName = $this->createMock(AttributeId::class);
        $this->productActive = $this->createMock(AttributeId::class);
        $this->productStock = $this->createMock(AttributeId::class);
        $this->productPrice = $this->createMock(AttributeId::class);
        $this->productTax = $this->createMock(AttributeId::class);
        $this->productDescription = $this->createMock(AttributeId::class);
        $this->categoryTreeId = $this->createMock(CategoryTreeId::class);
    }

    /**
     */
    public function testCreateCommand(): void
    {
        $command = new UpdateShopware6ChannelCommand(
            $this->id,
            $this->name,
            $this->host,
            $this->clientId,
            $this->clientKey,
            $this->defaultLanguage,
            $this->productName,
            $this->productActive,
            $this->productStock,
            $this->productPrice,
            $this->productTax,
            $this->productDescription,
            $this->categoryTreeId,
            [],
            []
        );

        self::assertEquals($this->id, $command->getId());
        self::assertEquals($this->name, $command->getName());
        self::assertEquals($this->host, $command->getHost());
        self::assertEquals($this->clientId, $command->getClientId());
        self::assertEquals($this->clientKey, $command->getClientKey());
        self::assertEquals($this->defaultLanguage, $command->getDefaultLanguage());
        self::assertEquals($this->productName, $command->getProductName());
        self::assertEquals($this->productActive, $command->getProductActive());
        self::assertEquals($this->productStock, $command->getProductStock());
        self::assertEquals($this->productPrice, $command->getProductPrice());
        self::assertEquals($this->productTax, $command->getProductTax());
        self::assertEquals($this->productDescription, $command->getProductDescription());
        self::assertEquals($this->categoryTreeId, $command->getCategoryTree());
        self::assertIsArray($command->getPropertyGroup());
        self::assertIsArray($command->getCustomField());
    }
}
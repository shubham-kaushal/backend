<?php
/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\ExporterShopware6\Infrastructure\Handler\Export;

use Ergonode\Exporter\Domain\Repository\ExportRepositoryInterface;
use Webmozart\Assert\Assert;
use Ergonode\Exporter\Domain\Entity\Export;
use Ergonode\ExporterShopware6\Infrastructure\Processor\Process\StartShopware6ExportProcess;
use Ergonode\Channel\Domain\Repository\ChannelRepositoryInterface;
use Ergonode\ExporterShopware6\Domain\Entity\Shopware6Channel;
use Ergonode\ExporterShopware6\Domain\Command\Export\StartShopware6ExportCommand;

/**
 */
class StartShopware6ExportCommandHandler
{
    /**
     * @var ExportRepositoryInterface
     */
    private ExportRepositoryInterface $exportRepository;

    /**
     * @var ChannelRepositoryInterface
     */
    private ChannelRepositoryInterface $channelRepository;

    /**
     * @var StartShopware6ExportProcess
     */
    private StartShopware6ExportProcess $processor;

    /**
     * @param ExportRepositoryInterface   $exportRepository
     * @param ChannelRepositoryInterface  $channelRepository
     * @param StartShopware6ExportProcess $processor
     */
    public function __construct(
        ExportRepositoryInterface $exportRepository,
        ChannelRepositoryInterface $channelRepository,
        StartShopware6ExportProcess $processor
    ) {
        $this->exportRepository = $exportRepository;
        $this->channelRepository = $channelRepository;
        $this->processor = $processor;
    }

    /**
     * @param StartShopware6ExportCommand $command
     */
    public function __invoke(StartShopware6ExportCommand $command)
    {
        $export = $this->exportRepository->load($command->getExportId());
        Assert::isInstanceOf($export, Export::class);
        /** @var Shopware6Channel $channel */
        $channel = $this->channelRepository->load($export->getChannelId());
        Assert::isInstanceOf($channel, Shopware6Channel::class);
        $export->start();
        $this->exportRepository->save($export);

        $this->processor->process($export->getId(), $channel);
    }
}

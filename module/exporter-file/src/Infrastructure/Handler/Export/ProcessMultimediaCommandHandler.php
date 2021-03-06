<?php
/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\ExporterFile\Infrastructure\Handler\Export;

use Webmozart\Assert\Assert;
use Ergonode\Exporter\Infrastructure\Exception\ExportException;
use Ergonode\Core\Infrastructure\Service\TempFileStorage;
use Ergonode\ExporterFile\Infrastructure\Provider\WriterProvider;
use Ergonode\Exporter\Domain\Entity\Export;
use Ergonode\ExporterFile\Domain\Entity\FileExportChannel;
use Ergonode\Exporter\Domain\Repository\ExportRepositoryInterface;
use Ergonode\Channel\Domain\Repository\ChannelRepositoryInterface;
use Ergonode\ExporterFile\Domain\Command\Export\ProcessMultimediaCommand;
use Ergonode\Multimedia\Domain\Repository\MultimediaRepositoryInterface;
use Ergonode\Multimedia\Domain\Entity\AbstractMultimedia;
use Ergonode\ExporterFile\Infrastructure\Processor\MultimediaProcessor;

/**
 */
class ProcessMultimediaCommandHandler
{
    /**
     * @var MultimediaRepositoryInterface
     */
    private MultimediaRepositoryInterface $multimediaRepository;

    /**
     * @var ExportRepositoryInterface
     */
    private ExportRepositoryInterface $exportRepository;

    /**
     * @var ChannelRepositoryInterface
     */
    private ChannelRepositoryInterface $channelRepository;

    /**
     * @var MultimediaProcessor
     */
    private MultimediaProcessor $processor;

    /**
     * @var TempFileStorage
     */
    private TempFileStorage $storage;

    /**
     * @var WriterProvider
     */
    private WriterProvider $provider;

    /**
     * @param MultimediaRepositoryInterface $multimediaRepository
     * @param ExportRepositoryInterface     $exportRepository
     * @param ChannelRepositoryInterface    $channelRepository
     * @param MultimediaProcessor           $processor
     * @param TempFileStorage               $storage
     * @param WriterProvider                $provider
     */
    public function __construct(
        MultimediaRepositoryInterface $multimediaRepository,
        ExportRepositoryInterface $exportRepository,
        ChannelRepositoryInterface $channelRepository,
        MultimediaProcessor $processor,
        TempFileStorage $storage,
        WriterProvider $provider
    ) {
        $this->multimediaRepository = $multimediaRepository;
        $this->exportRepository = $exportRepository;
        $this->channelRepository = $channelRepository;
        $this->processor = $processor;
        $this->storage = $storage;
        $this->provider = $provider;
    }

    /**
     * @param ProcessMultimediaCommand $command
     *
     * @throws ExportException
     */
    public function __invoke(ProcessMultimediaCommand $command)
    {
        /** @var FileExportChannel $channel */
        $export = $this->exportRepository->load($command->getExportId());
        Assert::isInstanceOf($export, Export::class);
        $channel = $this->channelRepository->load($export->getChannelId());
        Assert::isInstanceOf($channel, FileExportChannel::class);
        $multimedia = $this->multimediaRepository->load($command->getMultimediaId());
        Assert::isInstanceOf($multimedia, AbstractMultimedia::class);

        $filename = sprintf('%s/multimedia.%s', $command->getExportId()->getValue(), $channel->getFormat());
        $data = $this->processor->process($channel, $multimedia);
        $writer = $this->provider->provide($channel->getFormat());
        $lines = $writer->add($data);

        $this->storage->open($filename);
        $this->storage->append($lines);
        $this->storage->close();
    }
}

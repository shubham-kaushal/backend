<?php
/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\ExporterFile\Infrastructure\Processor\Step;

use Ergonode\ExporterFile\Domain\Command\Export\ProcessCategoryCommand;
use Ergonode\SharedKernel\Domain\Aggregate\CategoryId;
use Ergonode\Category\Domain\Query\CategoryQueryInterface;
use Ergonode\SharedKernel\Domain\Aggregate\ExportId;
use Ergonode\EventSourcing\Infrastructure\Bus\CommandBusInterface;
use Ergonode\Core\Domain\ValueObject\Language;
use Ergonode\ExporterFile\Domain\Entity\FileExportChannel;

/**
 */
class CategoryExportProcessorStep implements ExportStepProcessInterface
{
    /**
     * @var CategoryQueryInterface
     */
    private CategoryQueryInterface $categoryQuery;

    /**
     * @var CommandBusInterface
     */
    private CommandBusInterface $commandBus;

    /**
     * @param CategoryQueryInterface $categoryQuery
     * @param CommandBusInterface    $commandBus
     */
    public function __construct(CategoryQueryInterface $categoryQuery, CommandBusInterface $commandBus)
    {
        $this->categoryQuery = $categoryQuery;
        $this->commandBus = $commandBus;
    }

    /**
     * @param ExportId          $exportId
     * @param FileExportChannel $channel
     */
    public function export(ExportId $exportId, FileExportChannel $channel): void
    {
        $categories = $this->categoryQuery->getAll(new Language('en_GB'));
        foreach ($categories as $category) {
            $command = new ProcessCategoryCommand($exportId, new CategoryId($category['id']));
            $this->commandBus->dispatch($command, true);
        }
    }
}

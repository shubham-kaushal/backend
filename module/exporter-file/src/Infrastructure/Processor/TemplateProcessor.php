<?php
/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\ExporterFile\Infrastructure\Processor;

use Ergonode\Exporter\Infrastructure\Exception\ExportException;
use Ergonode\Core\Domain\ValueObject\Language;
use Ergonode\ExporterFile\Infrastructure\DataStructure\ExportData;
use Ergonode\ExporterFile\Infrastructure\DataStructure\LanguageData;
use Ergonode\ExporterFile\Domain\Entity\FileExportChannel;
use Ergonode\Designer\Domain\Entity\TemplateElement;
use Ergonode\Designer\Domain\Entity\Template;

/**
 */
class TemplateProcessor
{
    /**
     * @param FileExportChannel $channel
     * @param Template          $template
     *
     * @return ExportData
     *
     * @throws ExportException
     */
    public function process(FileExportChannel $channel, Template $template): ExportData
    {
        try {
            $data = new ExportData();

            foreach ($template->getElements() as $element) {
                $data->set($this->getLanguage($template, $element));
            }

            return $data;
        } catch (\Exception $exception) {
            throw new ExportException(
                sprintf('Can\'t process export for %s', $template->getId()->getValue()),
                $exception
            );
        }
    }

    /**
     * @param Template        $template
     * @param TemplateElement $element
     *
     * @return LanguageData
     */
    private function getLanguage(Template $template, TemplateElement $element): LanguageData
    {
        $result = new LanguageData();
        $result->set('_id', $template->getId()->getValue());
        $result->set('_name', $template->getName());
        $result->set('_type', (string) $element->getType());
        $result->set('_x', (string) $element->getPosition()->getX());
        $result->set('_y', (string) $element->getPosition()->getY());
        $result->set('_width', (string) $element->getSize()->getWidth());
        $result->set('_height', (string) $element->getSize()->getHeight());

        return $result;
    }
}

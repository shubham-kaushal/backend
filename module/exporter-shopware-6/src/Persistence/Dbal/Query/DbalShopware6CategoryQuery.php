<?php
/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\ExporterShopware6\Persistence\Dbal\Query;

use Doctrine\DBAL\Connection;
use Ergonode\ExporterShopware6\Domain\Query\Shopware6CategoryQueryInterface;
use Ergonode\SharedKernel\Domain\Aggregate\CategoryId;
use Ergonode\SharedKernel\Domain\Aggregate\ChannelId;

/**
 */
class DbalShopware6CategoryQuery implements Shopware6CategoryQueryInterface
{
    private const TABLE = 'exporter.shopware6_category';
    private const FIELDS = [
        'channel_id',
        'category_id',
        'shopware6_id',
    ];

    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param ChannelId $channel
     * @param string    $shopwareId
     *
     * @return CategoryId|null
     */
    public function loadByShopwareId(ChannelId $channel, string $shopwareId): ?CategoryId
    {
        $query = $this->connection->createQueryBuilder();
        $record = $query
            ->select(self::FIELDS)
            ->from(self::TABLE, 'cs')
            ->where($query->expr()->eq('cs.channel_id', ':channelId'))
            ->setParameter(':channelId', $channel->getValue())
            ->andWhere($query->expr()->eq('cs.shopware6_id', ':shopware6Id'))
            ->setParameter(':shopware6Id', $shopwareId)
            ->execute()
            ->fetch();

        if ($record) {
            return new CategoryId($record['category_id']);
        }

        return null;
    }

    /**
     * @param ChannelId          $channel
     * @param \DateTimeImmutable $dateTime
     */
    public function cleanData(ChannelId $channel, \DateTimeImmutable $dateTime): void
    {
        $query = $this->connection->createQueryBuilder();
        $query->delete(self::TABLE, 'cs')
            ->where($query->expr()->eq('channel_id', ':channelId'))
            ->setParameter(':channelId', $channel->getValue())
            ->andWhere($query->expr()->lt('cs.update_at', ':updateAt'))
            ->setParameter(':updateAt', $dateTime->format('Y-m-d H:i:s'))
            ->execute();
    }

    /**
     * @param ChannelId $channelId
     * @param array     $categoryIds
     *
     * @return array
     */
    public function getCategoryToDelete(ChannelId $channelId, array $categoryIds): array
    {
        $query = $this->connection->createQueryBuilder();

        return $query
            ->select('cs.category_id')
            ->from(self::TABLE, 'cs')
            ->where($query->expr()->eq('cs.channel_id', ':channelId'))
            ->setParameter(':channelId', $channelId->getValue())
            ->andWhere($query->expr()->notIn('cs.category_id', ':categoryIds'))
            ->setParameter(':categoryIds', $categoryIds, Connection::PARAM_STR_ARRAY)
            ->execute()
            ->fetchAll(\PDO::FETCH_COLUMN);
    }
}

<?php

declare(strict_types=1);

namespace App\Repository;

use App\DataSource\DataRow;
use App\DataSource\DataSourceInterface;
use Iterator;

abstract class AbstractRepository
{
    /** @var DataSourceInterface */
    private $dataSource;

    /**
     * @required
     *
     * @param DataSourceInterface $dataSource
     *
     * @return AbstractRepository
     */
    public function setDataSource(DataSourceInterface $dataSource): AbstractRepository
    {
        $this->dataSource = $dataSource;

        return $this;
    }

    /**
     * @return Iterator|DataRow[]
     */
    public function getDataIterator(): Iterator
    {
        return $this->dataSource->loadData();
    }
}
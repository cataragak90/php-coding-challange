<?php

declare(strict_types=1);

namespace App\DataSource;

use Generator;

interface DataSourceInterface
{
    /**
     * @return Generator|DataRow[]
     */
    public function loadData(): Generator;
}
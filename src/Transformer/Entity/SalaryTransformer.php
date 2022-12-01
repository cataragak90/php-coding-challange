<?php

declare(strict_types=1);

namespace App\Transformer\Entity;

use App\DataSource\DataRow;
use App\Entity\Salary;

class SalaryTransformer
{
    /**
     * @param DataRow $dataRow
     *
     * @return Salary
     */
    public static function transform(DataRow $dataRow): Salary
    {
        return new Salary($dataRow->salary, $dataRow->salaryCurrency);
    }
}
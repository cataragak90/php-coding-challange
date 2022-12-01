<?php

declare(strict_types=1);

namespace App\Transformer\Entity;

use App\DataSource\DataRow;
use App\Entity\Company;

class CompanyTransformer
{
    /**
     * @param DataRow $dataRow
     *
     * @return Company
     */
    public static function transform(DataRow $dataRow): Company
    {
        return new Company($dataRow->companySize, $dataRow->companyDomain);
    }
}
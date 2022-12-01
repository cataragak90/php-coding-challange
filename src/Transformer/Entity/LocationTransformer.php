<?php

declare(strict_types=1);

namespace App\Transformer\Entity;

use App\DataSource\DataRow;
use App\Entity\Location;

class LocationTransformer
{
    /**
     * @param DataRow $dataRow
     *
     * @return Location
     */
    public static function transform(DataRow $dataRow): Location
    {
        return new Location($dataRow->country, $dataRow->city);
    }
}
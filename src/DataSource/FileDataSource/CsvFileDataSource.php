<?php

declare(strict_types=1);

namespace App\DataSource\FileDataSource;

use App\DataSource\DataRow;
use Box\Spout\Common\Exception\IOException;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\ReaderInterface;

class CsvFileDataSource extends AbstractFileDataSource
{
    private const COLUMN_DELIMITER = ',';

    /** @var string */
    private $csvFilePath;

    /**
     * @param string $csvDataSourceFilePath
     */
    public function __construct(string $csvDataSourceFilePath)
    {
        $this->csvFilePath = $csvDataSourceFilePath;
    }

    /**
     * @return ReaderInterface
     *
     * @throws IOException
     */
    protected function getFileReader(): ReaderInterface
    {
        $csvReader = ReaderEntityFactory::createCSVReader();

        $csvReader->setFieldDelimiter(self::COLUMN_DELIMITER)
            ->open($this->csvFilePath);

        return $csvReader;
    }

    /**
     * {@inheritDoc}
     */
    protected function createDataRowObject(array $cells): DataRow
    {
        $response = new DataRow();

        $response->id = isset($cells[0]) ? (int)$cells[0]->getValue() : null;
        $response->jobTitle = isset($cells[1]) ? $cells[1]->getValue() : null;
        $response->seniorityLevel = isset($cells[2]) ? $cells[2]->getValue() : null;
        $response->country = isset($cells[3]) ? $cells[3]->getValue() : null;
        $response->city = isset($cells[4]) ? $cells[4]->getValue() : null;
        $response->salary = isset($cells[5]) ? (float)$cells[5]->getValue() : null;
        $response->salaryCurrency = isset($cells[6]) ? $cells[6]->getValue() : null;
        $response->requiredSkills = isset($cells[7])
            ? array_map('trim', explode(',', $cells[7]->getValue()))
            : null;
        $response->companySize = isset($cells[8]) ? $cells[8]->getValue() : null;
        $response->companyDomain = isset($cells[9]) ? $cells[9]->getValue() : null;

        return $response;
    }

    /**
     * {@inheritDoc}
     */
    protected function ignoreFirstRow(): bool
    {
        return true;
    }
}
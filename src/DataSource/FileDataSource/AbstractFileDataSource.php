<?php

declare(strict_types=1);

namespace App\DataSource\FileDataSource;

use App\DataSource\DataRow;
use App\DataSource\DataSourceInterface;
use Box\Spout\Common\Entity\Cell;
use Box\Spout\Reader\Exception\ReaderNotOpenedException;
use Box\Spout\Reader\ReaderInterface;
use Box\Spout\Reader\SheetInterface;
use Generator;

abstract class AbstractFileDataSource implements DataSourceInterface
{
    /**
     * @return ReaderInterface
     */
    abstract protected function getFileReader(): ReaderInterface;

    /**
     * @param Cell[] $row
     *
     * @return DataRow
     */
    abstract protected function createDataRowObject(array $row): DataRow;

    /**
     * @return bool
     */
    abstract protected function ignoreFirstRow(): bool;

    /**
     * @throws ReaderNotOpenedException
     *
     * @return Generator|DataRow[]
     */
    public function loadData(): Generator
    {
        $reader = $this->getFileReader();

        foreach ($reader->getSheetIterator() as $sheet) {
            yield from $this->processSheet($sheet);
        }
    }

    /**
     * @param SheetInterface $sheet
     *
     * @return Generator|DataRow[]
     */
    private function processSheet(SheetInterface $sheet): Generator
    {
        foreach ($sheet->getRowIterator() as $index => $row) {
            if ($index === 1 && $this->ignoreFirstRow()) {
                continue;
            }

            yield $this->createDataRowObject($row->getCells());
        }
    }
}
<?php

declare(strict_types=1);

namespace App\Tests\DataSource\FileDataSource;

use App\DataSource\DataRow;
use App\DataSource\FileDataSource\CsvFileDataSource;
use Box\Spout\Reader\Exception\ReaderNotOpenedException;
use PHPUnit\Framework\TestCase;

class CsvFileDataSourceTest extends TestCase
{
    /** @var resource */
    private $file;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->file = tmpfile();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        fclose($this->file);
    }

    /**
     * @throws ReaderNotOpenedException
     *
     * @return void
     */
    public function testLoadData(): void
    {
        $this->addContentToFile("ID,Job title,Seniority level,Country,City,Salary,Currency,Required skills,Company size,Company domain\n1,Senior PHP Developer,Senior,DE,Berlin,747500,SVU,\"PHP, Symfony, REST, Unit-testing, Behat, SOLID, Docker, AWS\",100-500,Automotive");

        $fileDataSource = new CsvFileDataSource($this->getFilePath());

        $response = $fileDataSource->loadData();

        /** @var DataRow $item */
        $item = $response->current();
        $this->assertDataRowIsTheGoodOne($item);
    }

    /**
     * @param DataRow $dataRow
     *
     * @return void
     */
    private function assertDataRowIsTheGoodOne(DataRow $dataRow): void
    {
        $this->assertSame(1, $dataRow->id);
        $this->assertSame('Senior PHP Developer', $dataRow->jobTitle);
        $this->assertSame('Senior', $dataRow->seniorityLevel);
        $this->assertSame('DE', $dataRow->country);
        $this->assertSame('Berlin', $dataRow->city);
        $this->assertSame(747500.0, $dataRow->salary);
        $this->assertSame('SVU', $dataRow->salaryCurrency);
        $this->assertSame(
            ['PHP', 'Symfony', 'REST', 'Unit-testing', 'Behat', 'SOLID', 'Docker', 'AWS'],
            $dataRow->requiredSkills
        );
        $this->assertSame('100-500', $dataRow->companySize);
        $this->assertSame('Automotive', $dataRow->companyDomain);
    }

    /**
     * @return string
     */
    private function getFilePath(): string
    {
        return stream_get_meta_data($this->file)['uri'];
    }

    /**
     * @param string $content
     */
    private function addContentToFile(string $content): void
    {
        fwrite($this->file, $content);
    }
}

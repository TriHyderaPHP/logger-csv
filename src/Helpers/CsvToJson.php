<?php

namespace Trihydera\Log\Helpers;

/**
 * Class CsvToJson
 * Helps with turning csv table to JSON format
 */
class CsvToJson
{
    /**
     * @var string The path to the CSV file
     */
    private $csvFile;

    /**
     * CsvToJson constructor.
     * @param string $csvFile The path to the CSV file
     */
    public function __construct($csvFile)
    {
        $this->csvFile = $csvFile;
    }

    /**
     * Converts CSV data to JSON format
     *
     * @return array The JSON representation of the CSV data
     */
    public function convertToJson()
    {
        $csv = array_map('str_getcsv', file($this->csvFile));
        $headers = $csv[0];
        array_shift($csv);

        $json = [];
        foreach ($csv as $row) {
            $jsonRow = [];
            foreach ($headers as $index => $header) {
                $jsonRow[$header] = $row[$index];
            }
            $json[] = $jsonRow;
        }

        return json_decode(json_encode($json));
    }
}

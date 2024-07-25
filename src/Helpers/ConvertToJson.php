<?php
namespace Trihydera\Log\Helpers;

use Trihydera\File\JsonFile;
use Trihydera\Log\Helpers\CsvToJson;

/**
 * Class ConvertToJson
 * Converts CSV data to JSON format and writes the JSON data to a file.
 */
class ConvertToJson {
    /**
     * @var CsvToJson The CsvToJson object used for conversion.
     */
    private $csvtojson;

    /**
     * @var JsonFile The JsonFile object used for writing JSON data.
     */
    private $jsonfile;

    /**
     * @var string The path where the files are located.
     */
    private $path;

    /**
     * ConvertToJson constructor.
     *
     * @param string $path The path where the files are located.
     */
    public function __construct($path) {
        $this->csvtojson = new CsvToJson($path . '.csv');
        $this->jsonfile = new JsonFile();
        $this->path = $path;
    }

    /**
     * Converts CSV data to JSON format and writes the JSON data to a file.
     */
    public function convert() {
        $jsonData = $this->csvtojson->convertToJson();
        $this->jsonfile->write($this->path . '.json', $jsonData);
    }
}
?>
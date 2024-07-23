<?php

namespace Trihydera\Log;

use Symfony\Component\Console\Output\ConsoleOutput;
use Trihydera\File\JsonFile;
use Trihydera\Log\Helpers\CsvToJson;

/**
 * Class Log
 *
 * Represents a simple logging functionality that logs messages to a CSV file.
 */
class Log
{
    /**
     * @var string $name The name of the log file.
     */
    private $name;

    /**
     * @var string $logFile The path to the log file.
     */
    private $logFile;

    /**
     * @var bool $saveJson Toggle saving the log as json format.
     */
    private $saveJson;

    /**
     * @var ConsoleOutput $output Console output.
     */
    private $output;

    /**
     * Log constructor.
     *
     * @param string $name The name of the log file.
     * @param string $path The path to the log file without extension.
     */
    public function __construct($name, $path, $saveJson = false)
    {
        $this->name = $name;
        $this->logFile = $path;
        $this->saveJson = $saveJson;
        $this->output = new ConsoleOutput();

        if (!file_exists($this->logFile.'.csv')) {
            $header = "Date,Name,Action,Message\n";
            file_put_contents($this->logFile.'.csv', $header);
        }
    }

    /**
     * Logs a message to the log file.
     *
     * @param string $action The action being logged.
     * @param string $msg The message to be logged.
     */
    public function out($action, $msg)
    {
        $date = date('Y-m-d H:i');
        $name = $this->name;

        $logMessage = "$date,$name,$action,$msg\n";
        file_put_contents($this->logFile . '.csv', $logMessage, FILE_APPEND);

        if ($this->saveJson) {
            $converter = new CsvToJson($this->logFile . '.csv');
            $jsonFile = new JsonFile();

            $jsonData = $converter->convertToJson();
            $jsonFile->write($this->logFile . '.json', $jsonData);
        }

        $this->output->writeln("[$date] [$name] $action: $msg\n");
    }
}

<?php
namespace Trihydera\Log;

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
     * Log constructor.
     *
     * @param string $name The name of the log file.
     * @param string $path The path to the log file without extension.
     */
    public function __construct($name, $path)
    {
        $this->name = $name.'.csv';
        $this->logFile = $path;
        
	      if (!file_exists($this->logFile)) {
            $header = "Date,Name,Action,Message\n";
            file_put_contents($this->logFile, $header);
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

        error_log("$name: $action: $msg\n");
        $logMessage = "$date,$name,$action,$msg\n";
        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }
}

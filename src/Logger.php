<?php

namespace Trihydera\Log;

use Symfony\Component\Console\Output\ConsoleOutput;
use Trihydera\Log\Helpers\ConvertToJson;

/**
 * Class Logger
 * Represents a simple logging functionality that logs messages to a CSV file.
 */
class Logger
{
    private $name;
    private $logFile;
    private $saveJson;
    private $output;
    private $converter;

    /**
     * Logger constructor.
     *
     * @param string $name The name of the logger.
     * @param string $path The path to the log file.
     * @param bool $saveJson Whether to save log messages in JSON format.
     */
    public function __construct($name, $path, $saveJson = false)
    {
        $this->name = $name;
        $this->logFile = $path;
        $this->saveJson = $saveJson;
        $this->output = new ConsoleOutput();
        $this->converter = new ConvertToJson($path);

        if (!file_exists($this->logFile . '.csv')) {
            $header = "Timestamp,Name,Level,Message\n";
            file_put_contents($this->logFile . '.csv', $header);
        }
    }

    /**
     * Logs an emergency message.
     *
     * @param string $message The emergency message.
     * @param array $context An array of context data for message interpolation.
     */
    public function emergency($message, $context = [])
    {
        $this->log('emergency', $message, $context);
    }

    /**
     * Logs an alert message.
     *
     * @param string $message The alert message.
     * @param array $context An array of context data for message interpolation.
     */
    public function alert($message, $context = [])
    {
        $this->log('alert', $message, $context);
    }

    /**
     * Logs a critical message.
     *
     * @param string $message The critical message.
     * @param array $context An array of context data for message interpolation.
     */
    public function critical($message, $context = [])
    {
        $this->log('critical', $message, $context);
    }

    /**
     * Logs an error message.
     *
     * @param string $message The error message.
     * @param array $context An array of context data for message interpolation.
     */
    public function error($message, $context = [])
    {
        $this->log('error', $message, $context);
    }

    /**
     * Logs a warning message.
     *
     * @param string $message The warning message.
     * @param array $context An array of context data for message interpolation.
     */
    public function warning($message, $context = [])
    {
        $this->log('warning', $message, $context);
    }

    /**
     * Logs a notice message.
     *
     * @param string $message The notice message.
     * @param array $context An array of context data for message interpolation.
     */
    public function notice($message, $context = [])
    {
        $this->log('notice', $message, $context);
    }

    /**
     * Logs an info message.
     *
     * @param string $message The info message.
     * @param array $context An array of context data for message interpolation.
     */
    public function info($message, $context = [])
    {
        $this->log('info', $message, $context);
    }

    /**
     * Logs a debug message.
     *
     * @param string $message The debug message.
     * @param array $context An array of context data for message interpolation.
     */
    public function debug($message, $context = [])
    {
        $this->log('debug', $message, $context);
    }

    /**
     * Logs a message to the CSV file and outputs it to the console.
     *
     * @param string $level The log level.
     * @param string $message The log message.
     * @param array $context An array of context data for message interpolation.
     */
    public function log($level, $message, $context = [])
    {
        $date = date('Y-m-d H:i');
        $name = $this->name;
        $interpolatedMessage = $this->interpolate($message, $context);

        $logMessage = "$date,$name,$level,$interpolatedMessage\n";
        file_put_contents($this->logFile . '.csv', $logMessage, FILE_APPEND);
        if ($this->saveJson) {
            $this->converter->convert();
        }

        $outputMessage = "[$date] [$level] [$name] $interpolatedMessage";
        $this->output->writeln($outputMessage);
    }

    /**
     * Interpolates context values into the message placeholders.
     *
     * @param string $message The message with placeholders.
     * @param array $context An array of context data for interpolation.
     * @return string The interpolated message.
     */
    private function interpolate($message, $context = [])
    {
        $replace = [];

        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }

        return strtr($message, $replace);
    }
}

<?php
namespace Trihydera\Log;

use Symfony\Component\Console\Output\ConsoleOutput;
use Trihydera\Log\Helpers\ConvertToJson;

/**
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

        if (!file_exists($this->logFile.'.csv')) {
            $header = "Timestam,Name,Level,Message\n";
            file_put_contents($this->logFile.'.csv', $header);
        }
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

        $logMessage = "$date,$level,$name,$message\n";
        file_put_contents($this->logFile . '.csv', $logMessage, FILE_APPEND);

        if ($this->saveJson) {
            $this->converter->convert();
        }

        $interpolatedMessage = $this->interpolate($message, $context);
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
    private function interpolate($message, array $context = [])
    {
        $replace = [];
        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }

        return strtr($message, $replace);
    }
}
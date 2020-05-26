<?php

/**
 * 工厂方法模式
 */

interface Logger
{
    public function log(string $message);
}

class StdoutLogger implements Logger
{
    public function log(string $message)
    {
        echo $message;
    }
}

class FileLogger implements Logger
{
    /**
     * @var string
     */
    private $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function log(string $message)
    {
        file_put_contents($this->filePath, $message . PHP_EOL, FILE_APPEND);
    }
}

interface LoggerFactory
{
    public function createLogger(): Logger;
}

class StdoutLoggerFactory implements LoggerFactory
{
    public function createLogger(): Logger
    {
        return new StdoutLogger();
    }
}

class FileLoggerFactory implements LoggerFactory
{
    /**
     * @var string
     */
    private $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function createLogger(): Logger
    {
        return new FileLogger($this->filePath);
    }
}

$loggerFactory = new StdoutLoggerFactory();
$logger = $loggerFactory->createLogger();
$logger->log('o(*￣︶￣*)o');

$loggerFactory = new FileLoggerFactory(sys_get_temp_dir());
$logger = $loggerFactory->createLogger();
$logger->log('^_^');
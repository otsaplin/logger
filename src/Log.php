<?php

namespace Otsaplin\Logger;

class Log
{

    protected static $_instance = null;
    private $fileHandle;

    private function __construct($logFile)
    {
        if (empty($logFile))
            throw new \Exception('Empty path to log file.');

        $this->fileHandle = fopen($logFile, 'a');
    }

    private function __clone()
    {
        
    }

    private function __wakeup()
    {
        
    }

    public function __destruct()
    {
        if ($this->fileHandle) {
            fclose($this->fileHandle);
        }
    }

    public static function getInstance($logFile)
    {
        
        if(empty($logFile))
            $logFile = str_replace('src', 'log/log.txt', __DIR__);
        
        if (null === self::$_instance) {
            self::$_instance = new self($logFile);
        }
        return self::$_instance;
    }

    public function log($txt)
    {
        if (empty($txt) || empty($this->fileHandle))
            return false;

        $txt = '-------------------------------------------------'
                . PHP_EOL
                . '[' . date('d.m.Y H:i:s') . ']'
                . PHP_EOL
                . print_r($txt, true)
                . PHP_EOL;

        if (fwrite($this->fileHandle, $txt))
            return true;
        else
            return false;
    }

}

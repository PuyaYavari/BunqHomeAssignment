<?php
namespace App;

use Error;
use Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * @author Pouya
 */
class APILogger{
    private $log;

    public function __construct()
    {
        $this->log = new Logger('APILogger');
        $this->log->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
    }

    /**
     * Logs the given exception. Adds given string and context info.
     * 
     * @param Exception $e
     * @param string $logString
     * @param array $context
     */
    public function exception(Exception $e, ?string $logString, ?array $context)
    {
        $exceptionString = 'EXCEPTION:' . $e->getMessage();

        if($logString != null){
            $exceptionString = $exceptionString . ' ' . $logString;
        }

        $exceptionContext = [
            'file' => $e->getFile(), 
            'line' => $e->getLine(),
            'code' => $e->getCode()
        ];

        if($context != null){
            $exceptionContext = array_merge($exceptionContext, $context);
        }

        $this->critical($exceptionString, $exceptionContext);
    }

    /**
     * Logs the given php error. Adds given string and context info.
     * 
     * @param Error $e
     * @param string $logString
     * @param array $context
     */
    public function phpError(Error $e, ?string $logString, ?array $context)
    {
        $errorString = 'PHPERROR:' . $e->getMessage();

        if($logString != null){
            $errorString = $errorString . ' ' . $logString;
        }

        $errorContext = [
            'file' => $e->getFile(), 
            'line' => $e->getLine(),
            'code' => $e->getCode()
        ];

        if($context != null){
            $errorContext = array_merge($errorContext, $context);
        }

        $this->critical($errorString, $errorContext);
    }

    /**
     * Detailed debug information.
     * 
     * @param string $logString
     * @param array $context
     */
    public function debug(string $logString, ?array $context)
    {
        if($context != null) {
            $this->log->debug($logString, $context);
        } else {
            $this->log->debug($logString);
        }  
    }

    /**
     * Interesting events. Examples: User logs in, SQL logs.
     * 
     * @param string $logString
     * @param array $context
     */
    public function info(string $logString, ?array $context)
    {
        if($context != null) {
            $this->log->info($logString, $context);
        } else {
            $this->log->info($logString);
        }  
    }

    /**
     * Normal but significant events.
     * 
     * @param string $logString
     * @param array $context
     */
    public function notice(string $logString, ?array $context)
    {
        if($context != null) {
            $this->log->notice($logString, $context);
        } else {
            $this->log->notice($logString);
        }  
    }

    /**
     * Exceptional occurrences that are not errors. Examples: Use of deprecated 
     * APIs, poor use of an API, undesirable things that are not necessarily wrong.
     * 
     * @param string $logString
     * @param array $context
     */
    public function warning(string $logString, ?array $context)
    {
        if($context != null) {
            $this->log->warning($logString, $context);
        } else {
            $this->log->warning($logString);
        }
    }
    
    /**
     * Runtime errors that do not require immediate action but should typically 
     * be logged and monitored.
     * 
     * @param string $logString
     * @param array $context
     */
    public function error(string $logString, ?array $context)
    {
        if($context != null) {
            $this->log->error($logString, $context);
        } else {
            $this->log->error($logString);
        }
    }

    /**
     * Critical conditions. Example: Application component unavailable, unexpected exception.
     * 
     * @param string $logString
     * @param array $context
     */
    public function critical(string $logString, ?array $context)
    {
        if($context != null) {
            $this->log->critical($logString, $context);
        } else {
            $this->log->critical($logString);
        }
    }

    /**
     * Action must be taken immediately. Example: Entire website down, database 
     * unavailable, etc. This should trigger the SMS alerts and wake you up.
     * 
     * @param string $logString
     * @param array $context
     */
    public function alert(string $logString, ?array $context)
    {
        if($context != null) {
            $this->log->alert($logString, $context);
        } else {
            $this->log->alert($logString);
        }
    }

    /**
     * Emergency: system is unusable.
     * 
     * @param string $logString
     * @param array $context
     */
    public function emergency(string $logString, ?array $context)
    {
        if($context != null) {
            $this->log->emergency($logString, $context);
        } else {
            $this->log->emergency($logString);
        }
    }
}

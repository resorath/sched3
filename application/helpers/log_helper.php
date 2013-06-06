<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define("SLOG_DEBUG", 1);
define("SLOG_INFO", 2);
define("SLOG_WARNING", 4);
define("SLOG_CRITICAL", 8);
define("SLOG_SECURITY", 16);

class Slogger
{
    protected static $instance = null;
    protected $ci = null;
    protected $controller = null;
    protected $fp = null;

    private function __construct()
    {
        $this->fp = fopen(BASEPATH . "../logs/testlog.txt", "a+");
    }

    private function __clone()
    {

    }

    public function setController($controller)
    {
        $this->controller = $controller;
    }

    public static function getInstance()
    {
        if (!isset(Slogger::$instance)) {
            static::$instance = new Slogger;
        }
        return Slogger::$instance;
    }


    private function getLogLevelName($level)
    {
        switch($level)
        {
            case 1:
                return "DEBUG";
            case 2:
                return "INFO";
            case 4:
                return "WARNING";
            case 8:
                return "CRITICAL";
            case 16:
                return "SECURITY";
            default;
                return "LOGERROR";
        }
    }

    public function slog($message, $loglevel = SLOG_INFO, $controller = NULL)
    {
        if($controller == NULL)
            $controller = $this->controller;

        fwrite($this->fp, date("Y-m-d H:m:s") . " [". $this->getLogLevelName($loglevel) ."] (". $controller .") " . $message . PHP_EOL);
    }
}

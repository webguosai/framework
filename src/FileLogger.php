<?php

namespace Webguosai;

/**
* Light logging class.
*
* Usage:
* 
* $log = new FileLogger('logs/', FileLogger:: ERROR); // Init log with severity threshhold
* $log->info('App works just fine!', array('foo' => 'bar')); // Prints info to the log file
* $log->debug('Debug mode only.'); // Prints nothing due to current severity threshhold
* 
*
* @author  Ireneusz Kierkowski <ircykk@gmail.com>
* @link    https://github.com/ircykk/FileLogger
* @version 0.9.0
*/
class FileLogger
{
    /**
     * Logger options
     *
     * @var array
     */
    protected $options = array (
        'extension'		=> 'txt', 				// Log file extension
        'nameFormat'	=> 'log', 				// Name format
        'dateFormat'	=> 'd-m-Y G:i:s',		// In log time format
        'clearAfter'	=> 1024*1024*10,		// 10MB default
        'serialize'		=> true,				// Serialize $context to one line
    );


    /**
     * Log levels
     */
    const INFO 		= 1;
    const WARNING 	= 2;
    const ERROR 	= 3;
    const DEBUG 	= 4;


    /**
     * Path to log file
     *
     * @var string
     */
    protected $file;


    /**
     * Current minimum logging threshold
     * 
     * @var integer
     */
    protected $logLevel = FileLogger::ERROR;


    /**
     * Class constructor
     *
     * @param string $logDirectory      File path to the logging directory
     * @param string $LogLevel The LogLevel Threshold
     * @param array $options Override default config
     *
     */
	function __construct($logDirectory, $logLevel = FileLogger::ERROR, $options = array())
	{
		$this->logLevel = (int)$logLevel;
		$this->options 	= array_merge($this->options, $options);
		$this->file 	= $logDirectory.$this->options['nameFormat'].'.'.$this->options['extension'];
	}


    /**
     * Writes log message to file
     *
     * @param string $message Formatted log message
     * @return boolean
     */
	protected function writeLog($message)
	{
        $size = @filesize($this->file);
        if ($size > $this->options['clearAfter']) {
        	$this->clear();
        }

        $handle = @fopen($this->file, 'ab');
        if ($handle === false) {
            throw new \RuntimeException("Could not open log file {$this->file} for writing.");
        }

        $result = fwrite($handle, $message);
        if ($result === false) {
            throw new \RuntimeException("Could write to log file {$this->file}.");
        }
        fclose($handle);
        return $result > 0;
	}


    /**
     * Formats log message
     *
     * @param intiger $level Log level
     * @param string $message Log message
     * @param array $context Extra Data
     *
     * @return string Formatted log message
     */
	protected function formatMessage($level, $message, $context)
	{
		$time = date($this->options['dateFormat']);
		if (!empty($context)) {
			if ($this->options['serialize']) {
	        	$context = json_encode($context);
	        } else {
	        	$context = print_r($context, true);
	        }
	    } else {
	    	$context = '';
	    }
        $message = trim($message);

        switch ($level) {
        	case self::INFO:
        		$levelName = 'INFO';
        		break;
        	case self::WARNING:
        		$levelName = 'WARNING';
        		break;
        	case self::ERROR:
        		$levelName = 'ERROR';
        		break;
        	case self::DEBUG:
        		$levelName = 'DEBUG';
        		break;
        	default:
        		throw new \InvalidArgumentException("Invalid log priority: {$level}.");
        		break;
        }

        return "{$time} [{$levelName}] {$message} {$context}\n";
	}


    /**
     * Clear log file.
     *
     * @return null
     */
	public function clear()
	{
		$handle = @fopen($this->file, 'ab');
		ftruncate($handle, 0);
		fclose($handle);
	}


    /**
     * Logs message.
     *
     * @param integer $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        if ($this->logLevel < $level) {
            return;
        }
        $message = $this->formatMessage($level, $message, $context);
        $this->writeLog($message);
    }


    /**
     * Logs info.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function info($message, array $context = array())
    {
        $this->log(self::INFO, $message, $context);
    }


    /**
     * Logs warning.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function warning($message, array $context = array())
    {
        $this->log(self::WARNING, $message, $context);
    }


    /**
     * Logs error.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function error($message, array $context = array())
    {
        $this->log(self::ERROR, $message, $context);
    }


    /**
     * Logs debug.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function debug($message, array $context = array())
    {
        $this->log(self::DEBUG, $message, $context);
    }
}
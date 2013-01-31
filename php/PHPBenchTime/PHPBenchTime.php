<?php
/**
 * PHPBenchTime
 * A light benchmark timer class for PHP
 *
 * @author Juan L. Sanchez <juanleonardosanchez.com>
 * @license MIT
 * @version 1.3.0
 * @internal 12.04.2012
 * @github https://github.com/jsanc623/PHPBenchTime
 * @packagist https://packagist.org/packages/jsanc623/phpbenchtime
 */

namespace PHPBenchTime;

class Timer{
    private $_startTime;
    private $_pauseTime;
    private $_endTime;
    private $_phpVersion;
    private $_lapName;

    /**
     * Construct
     */
    public function __construct(){}


    /**
     * Start timer function
     *
     * @return true Always returns true
     */
    public final function Start($lapName){
        if(empty($this->_phpVersion))
            $this->_PHPVersion();

        if(isset($lapName)){
            $this->_startTime = (array)$this->_startTime;
            $this->_lapName = $lapName;
        }

        # Set the current start value
        if(is_array($this->_startTime)){ # Check if array (lap)
            if(empty($this->_lapName))
                $this->_startTime[] = $this->_CurrentTimeFloat();
            else
                $this->_startTime[$this->_lapName] = $this->_CurrentTimeFloat();
        } else {
            $this->_startTime = $this->_CurrentTimeFloat();
        }

        $this->_pauseTime = 0;
        $this->_endTime = 0;
        return true;
    }


    /**
     * Lap timer function
     * Modifies the return into an array
     *
     * @return true Always returns true
     */
    public final function Lap($lapName = ""){
        if(isset($lapName))
            $this->_lapName = $lapName;

        # Cast _startTime as array if its not an array, else
        if(!is_array($this->_startTime))
            $this->_startTime = array($this->_startTime);

        $this->Start();
    }


    /**
     * Pause timer function
     *
     * @return true Always returns true
     * @todo Implement Pause()
     */
    public final function Pause(){

    }

    
    /**
     * Unpause timer function
     *
     * @return true Always returns true
     * @todo Implement Unpause()
     */
    public final function Unpause(){}


    /**
     * End timer function
     *
     * @return true Always returns true
     */
    public final function End(){
        if(is_array($this->_startTime))
            return array(
                'Laps' => $this->_startTime,
                'Total' => round(($this->_CurrentTimeFloat() - $this->_startTime[0]), 4)
            );
            
        else {
            return array(
                    'Start' => $this->_startTime,
                    'End' => $this->_CurrentTimeFloat(),
                    'Total' => $this->_TotalTime()
                   );
        }
    }
    

    /**
     * Get the current timer value
     *
     * @return rounded current timer value
     * @param int $decimals Number of decimals to round to
     */
    private final function _TotalTime($decimals = 4){
        return round(($this->_CurrentTimeFloat() - $this->_startTime), $decimals);
    }

    /**
     * Get the current time in seconds
     *
     * @return float Returns current time in float seconds
     */
    private final function _CurrentTimeFloat(){
        if($this->_phpVersion < 5.0){
            list($usec, $sec) = explode(" ", microtime());
            return ( (float)$usec + (float)$sec );
        } else {
            return microtime(true);
        }
    }

    /**
     * Get the current PHP version
     *
     * @internal Sets $this->_phpVersion
     */
    private final function _PHPVersion(){
        $this->_phpVersion = (string)substr(PHP_VERSION, 0, 3);
    }
}
?>
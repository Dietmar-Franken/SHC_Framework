<?php 

namespace SHC\Sensor\Sensors;

//Imports
use SHC\Sensor\AbstractSensor;
use RWF\Date\DateTime;

/**
 * Feuchtigkeits Sensor
 * 
 * @author     Oliver Kleditzsch
 * @copyright  Copyright (c) 2014, Oliver Kleditzsch
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @since      2.0.0-0
 * @version    2.0.0-0
 */
class Hygrometer extends AbstractSensor {
    
    /**
     * Wert
     *  
     * @var Integer 
     */
    protected $value = 0;
    
    /**
     * Wert Anzeigen
     * 
     * @var Integer
     */
    protected $valueVisibility = 1;

    /**
     * Temperatur Offset
     *
     * @var Integer
     */
    protected $valueOffset = 0;
    
    /**
     * @param Array  $values   Sensorwerte
     */
    public function __construct(array $values = array()) {
        
        if(count($values) <= 25) {
            
            $this->oldValues = $values;
            $this->value = $values[0]['value'];
            $this->time = $values[0]['time'];
        }
    }
    
    /**
     * gibt den Aktuellen ANalogwert zurueck
     * 
     * @return Integer
     */
    public function getValue() {
        
        return $this->value + $this->valueOffset;
    }

    /**
     * setzt das Offset
     *
     * @param  Float $offset
     * @return \SHC\Sensor\Sensors\Hygrometer
     */
    public function setOffset($offset) {

        $this->valueOffset = $offset;
        return $this;
    }

    /**
     * gbit das Offset zurueck
     *
     * @return Float
     */
    public function getOffset() {

        return $this->valueOffset;
    }
    
    /**
     * setzt die Sichtbarkeit des Wertes
     * 
     * @param  Integer $visibility Sichtbarkeit
     * @return \SHC\Sensor\Sensors\Hygrometer
     */
    public function valueVisibility($visibility) {
        
        $this->valueVisibility = $visibility;
        return $this;
    }
    
    /**
     * gibt die Sichtbarkeit des Wertes an
     * 
     * @return Boolean
     */
    public function isValueVisible() {
        
        return ($this->valueVisibility == 1 ? true : false);
    }
    
    /**
     * setzt den aktuellen Sensorwert und schiebt ih in das Werte Array
     * 
     * @param Integer $value Wert
     */
    public function pushValues($value) {
        
        $date = DateTime::now();
        
        //alte Werte Schieben
        array_unshift($this->oldValues, array('value' => $value, 'time' => $date));
        //mehr als 5 Werte im Array?
        if(isset($this->oldValues[25])) {
            
            //aeltesten Wert loeschen
            unset($this->oldValues[25]);
        }
        
        //Werte setzten
        $this->value = $value;
        $this->time = $date;
        $this->isModified = true;
    }
}
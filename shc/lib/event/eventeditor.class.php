<?php

namespace SHC\Event;

//Imports
use RWF\Date\DateTime;
use RWF\Util\String;
use RWF\XML\XmlFileManager;
use SHC\Condition\Condition;
use SHC\Condition\ConditionEditor;
use SHC\Core\SHC;
use SHC\Switchable\Switchable;
use SHC\Switchable\SwitchableEditor;


/**
 * Ereignise Verwalten
 * 
 * @author     Oliver Kleditzsch
 * @copyright  Copyright (c) 2014, Oliver Kleditzsch
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @since      2.0.0-0
 * @version    2.0.0-0
 */
class EventEditor {

    /**
     * Ereignis Luftfeuchte steigt
     *
     * @var Integer
     */
    const EVENT_HUMIDITY_CLIMB = 1;

    /**
     * Ereignis Luftfeuchte faellt
     *
     * @var Integer
     */
    const EVENT_HUMIDITY_FALLS = 2;

    /**
     * Ereignis Eingang wechselt von LOW auf HIGH
     *
     * @var Integer
     */
    const EVENT_INPUT_HIGH = 4;

    /**
     * Ereignis EIngang wechselt von HIGH auf LOW
     *
     * @var Integer
     */
    const EVENT_INPUT_LOW = 8;

    /**
     * Ereignis Lichtstaerke steigt
     *
     * @var Integer
     */
    const EVENT_LIGHTINTENSITY_CLIMB = 16;

    /**
     * Ereignis Lichtsaerke faellt
     *
     * @var Integer
     */
    const EVENT_LIGHTINTENSITY_FALLS = 32;

    /**
     * Ereignis Feuchtigkeit steigt
     *
     * @var Integer
     */
    const EVENT_MOISTURE_CLIMB = 64;

    /**
     * Ereignis Feuchtigkeit steigt
     *
     * @var Integer
     */
    const EVENT_MOISTURE_FALLS = 128;

    /**
     * Ereignis Temperatur steigt
     *
     * @var Integer
     */
    const EVENT_TEMPERATURE_CLIMB = 256;

    /**
     * Ereignis Temperatur faellt
     *
     * @var Integer
     */
    const EVENT_TEMPERATURE_FALLS = 512;

    /**
     * Ereignis Benutzer kommt nach Hause
     *
     * @var Integer
     */
    const EVENT_USER_COMES_HOME = 1024;

    /**
     * Ereignis Benutzer verlaesst das Haus
     *
     * @var Integer
     */
    const EVENT_USER_LEAVE_HOME = 2048;

    /**
     * Ereignis Sonnenaufgang
     *
     * @var Integer
     */
    const EVENT_SUNRISE = 4096;

    /**
     * Ereignis Sonnenuntergang
     *
     * @var Integer
     */
    const EVENT_SUNSET = 8192;

    /**
     * nach ID sortieren
     *
     * @var String
     */
    const SORT_BY_ID = 'id';

    /**
     * nach Namen sortieren
     *
     * @var String
     */
    const SORT_BY_NAME = 'name';

    /**
     * nicht sortieren
     *
     * @var String
     */
    const SORT_NOTHING = 'unsorted';

    /**
     * Ereignisse
     *
     * @var Array
     */
    protected $events = array();

    /**
     * Singleton Instanz
     *
     * @var \SHC\Event\EventEditor
     */
    protected static $instance = null;

    protected function __construct() {

        $this->loadData();
    }

    /**
     * laedt die Ereignisse aus den XML Daten und erzeugt die Objekte
     */
    public function loadData() {

        $xml = XmlFileManager::getInstance()->getXmlObject(SHC::XML_EVENTS, true);

        //Daten Vorbereiten
        $oldEvents = $this->events;
        $this->events = array();

        //Daten einlesen
        foreach ($xml->event as $event) {

            //Variablen Vorbereiten
            $class = (string) $event->class;

            $data = array();
            foreach ($event as $index => $value) {

                if (!in_array($index, array('id', 'name', 'class', 'enabled'))) {

                    $data[$index] = (string) $value;
                }
            }

            /* @var $eventObj \SHC\Event\Event */
            $eventObj = new $class(
                (int) $event->id, (string) $event->name, $data, ((int) $event->enabled == 1 ? true : false), DateTime::createFromDatabaseDateTime((string) $event->lastExecute)
            );

            //Bedingungen anhaengen
            foreach (explode(',', (string) $event->conditions) as $conditionId) {

                $condition = ConditionEditor::getInstance()->getConditionByID($conditionId);
                if ($condition instanceof Condition) {

                    $eventObj->addCondition($condition);
                }
            }

            //schaltbare Elemente Hinzufuegen
            if(isset($event->switchable)) {

                foreach ($event->switchable as $switchable) {

                    $attr = $switchable->attributes();
                    $switchableObject = SwitchableEditor::getInstance()->getElementById((int) $attr->id);
                    if ($switchableObject instanceof Switchable) {

                        $eventObj->addSwitchable($switchableObject, (int) $attr->command);
                    }
                }
            }

            //Objekt status vom alten Objekt ins neue übertragen
            if(isset($oldEvents[(int) $event->id])) {

                $eventObj->setState($oldEvents[(int) $event->id]->getState());
            }
            $this->events[(int) $event->id] = $eventObj;
        }
    }

    /**
     * gibt das Ereignis mit der IOD zurueck
     *
     * @param  Integer ID $id Ereignis ID
     * @return \SHC\Event\Event
     */
    public function getEventById($id) {

        if (isset($this->events[$id])) {

            return $this->events[$id];
        }
        return null;
    }

    /**
     * prueft ob der Name des Events schon verwendet wird
     *
     * @param  String $name Name
     * @return Boolean
     */
    public function isEventNameAvailable($name) {

        foreach ($this->events as $event) {

            /* @var $condition \SHC\Event\Event */
            if (String::toLower($event->getName()) == String::toLower($name)) {

                return false;
            }
        }
        return true;
    }



    /**
     * gibt eine Liste mit allen Bedingungen zurueck
     *
     * @param  String $orderBy Art der Sortierung (
     *      id => nach ID sorieren,
     *      name => nach Namen sortieren,
     *      unsorted => unsortiert
     *  )
     * @return Array
     */
    public function listEvents($orderBy = 'id') {

        if ($orderBy == 'id') {

            //nach ID sortieren
            $events = $this->events;
            ksort($events, SORT_NUMERIC);
            return $events;
        } elseif ($orderBy == 'name') {

            //nach Namen sortieren
            $events = $this->events;

            //Sortierfunktion
            $orderFunction = function($a, $b) {

                if ($a->getName() == $b->getName()) {

                    return 0;
                }

                if ($a->getName() < $b->getName()) {

                    return -1;
                }
                return 1;
            };
            usort($events, $orderFunction);
            return $events;
        }
        return $this->events;
    }

    /**
     * erstellt ein Event
     *
     * @param  String  $class      Klassenname
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiv
     * @param  Array   $data       Zusatzdaten
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolean
     * @throws \Exception
     * @throws \RWF\XML\Exception\XmlException
     */
    protected function addEvent($class, $name, array $data = array(), $enabled = true, array $conditions) {

        //Ausnahme wenn Name des Events schon belegt
        if (!$this->isEventNameAvailable($name)) {

            throw new \Exception('Der Name des Events ist schon vergeben', 1502);
        }

        //XML Daten Laden
        $xml = XmlFileManager::getInstance()->getXmlObject(SHC::XML_EVENTS, true);

        //Autoincrement
        $nextId = (int) $xml->nextAutoIncrementId;
        $xml->nextAutoIncrementId = $nextId + 1;

        //Datensatz erstellen
        $condition = $xml->addChild('event');
        $condition->addChild('id', $nextId);
        $condition->addChild('class', $class);
        $condition->addChild('name', $name);
        $condition->addChild('enabled', ($enabled == true ? 1 : 0));
        $condition->addChild('conditions', implode(',', $conditions));
        $condition->addChild('lastExecute', '2000-01-01 00:00:00');

        //Daten hinzufuegen
        foreach ($data as $tag => $value) {

            if (!in_array($tag, array('id', 'name', 'class', 'enabled'))) {

                $condition->addChild($tag, $value);
            }
        }

        //Daten Speichern
        $xml->save();
        return true;
    }

    /**
     * bearbeitet ein Event
     *
     * @param  Integer $id         ID
     * @param  String  $name       Name
     * @param  Array   $data       Zusatzdaten
     * @param  Boolean $enabled    Aktiv
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolean
     * @throws \Exception
     * @throws \RWF\XML\Exception\XmlException
     */
    protected function editEvent($id, $name = null, array $data = null, $enabled = null, array $conditions = null) {

        //XML Daten Laden
        $xml = XmlFileManager::getInstance()->getXmlObject(SHC::XML_EVENTS, true);

        //Server Suchen
        foreach ($xml->event as $event) {

            if ((int) $event->id == $id) {

                //Name
                if ($name !== null) {

                    //Ausnahme wenn Name der Bedingung schon belegt
                    if ((string) $event->name != $name && !$this->isEventNameAvailable($name)) {

                        throw new \Exception('Der Name der Bedingung ist schon vergeben', 1502);
                    }

                    $event->name = $name;
                }

                //Aktiv
                if ($enabled !== null) {

                    $event->enabled = ($enabled == true ? 1 : 0);
                }

                //Bedingungen
                if($conditions !== null) {

                    $event->conditions = implode(',', $conditions);
                }

                //Zusatzdaten
                foreach($data as $tag => $value) {

                    if (!in_array($tag, array('id', 'name', 'class', 'enabled'))) {

                        if($value !== null) {

                            $event->$tag = $value;
                        }
                    }
                }

                //Daten Speichern
                $xml->save();
                return true;
            }
        }
        return false;
    }

    /**
     * Speichert den Zeitpunkt der letzten Ausfuehrung fuer ein Ereignis
     *
     * @param  Integer            $id          Ereignis ID
     * @param  \RWF\Date\DateTime $lastExecute letzte Ausfuehrung
     * @return Boolean
     * @throws \RWF\XML\Exception\XmlException
     */
    public function updateLastExecute($id, DateTime $lastExecute) {

        //XML Daten Laden
        $xml = XmlFileManager::getInstance()->getXmlObject(SHC::XML_EVENTS, true);

        //Server Suchen
        foreach ($xml->event as $event) {

            if ((int) $event->id == $id) {

                $event->lastExecute = $lastExecute->getDatabaseDateTime();

                //Daten Speichern
                $xml->save();
                return true;
            }
        }
        return false;
    }

    /**
     * erstellt ein Luftfeuchte Event
     *
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $sensors    Sensoren
     * @param  Float   $limit      Grenzwert (Prozent)
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function addHumidityClimbOverEvent($name, $enabled, array $sensors, $limit, $interval, array $conditions = array()) {

        //Daten vorbereiten
        $data = array(
            'sensors' => implode(',', $sensors),
            'limit' => $limit,
            'interval' => $interval
        );

        //Speichern
        return $this->addEvent('\SHC\Event\Events\HumidityClimbOver', $name, $data, $enabled, $conditions);
    }

    /**
     * bearbeitet ein Luftfeuchte Event
     *
     * @param  Integer $id         ID
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $sensors    Sensoren
     * @param  Float   $limit      Grenzwert (Prozent)
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function editHumidityClimbOverEvent($id, $name = null, $enabled = null, array $sensors = null, $limit = null, $interval = null, array $conditions = null) {

        //Daten vorbereiten
        $data = array(
            'sensors' => implode(',', $sensors),
            'limit' => $limit,
            'interval' => $interval
        );

        //Speichern
        return $this->editEvent($id, $name, $data, $enabled, $conditions);
    }

    /**
     * erstellt ein Luftfeuchte Event
     *
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $sensors    Sensoren
     * @param  Float   $limit      Grenzwert (Prozent)
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function addHumidityFallsBelowEvent($name, $enabled, array $sensors, $limit, $interval, array $conditions = array()) {

        //Daten vorbereiten
        $data = array(
            'sensors' => implode(',', $sensors),
            'limit' => $limit,
            'interval' => $interval
        );

        //Speichern
        return $this->addEvent('\SHC\Event\Events\HumidityFallsBelow', $name, $data, $enabled, $conditions);
    }

    /**
     * bearbeitet ein Luftfeuchte Event
     *
     * @param  Integer $id         ID
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $sensors    Sensoren
     * @param  Float   $limit      Grenzwert (Prozent)
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function editHumidityFallsBelowEvent($id, $name = null, $enabled = null, array $sensors = null, $limit = null, $interval = null, array $conditions = null) {

        //Daten vorbereiten
        $data = array(
            'sensors' => implode(',', $sensors),
            'limit' => $limit,
            'interval' => $interval
        );

        //Speichern
        return $this->editEvent($id, $name, $data, $enabled, $conditions);
    }

    /**
     * erstellt ein Lichtstaerke Event
     *
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $sensors    Sensoren
     * @param  Float   $limit      Grenzwert (Prozent)
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function addLightIntensityClimbOverEvent($name, $enabled, array $sensors, $limit, $interval, array $conditions = array()) {

        //Daten vorbereiten
        $data = array(
            'sensors' => implode(',', $sensors),
            'limit' => $limit,
            'interval' => $interval
        );

        //Speichern
        return $this->addEvent('\SHC\Event\Events\LightIntensityClimbOver', $name, $data, $enabled, $conditions);
    }

    /**
     * bearbeitet ein Lichtstaerke Event
     *
     * @param  Integer $id         ID
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $sensors    Sensoren
     * @param  Float   $limit      Grenzwert (Prozent)
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function editLightIntensityClimbOverEvent($id, $name = null, $enabled = null, array $sensors = null, $limit = null, $interval = null, array $conditions = null) {

        //Daten vorbereiten
        $data = array(
            'sensors' => implode(',', $sensors),
            'limit' => $limit,
            'interval' => $interval
        );

        //Speichern
        return $this->editEvent($id, $name, $data, $enabled, $conditions);
    }

    /**
     * erstellt ein Lichtstaerke Event
     *
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $sensors    Sensoren
     * @param  Float   $limit      Grenzwert (Prozent)
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function addLightIntensityFallsBelowEvent($name, $enabled, array $sensors, $limit, $interval, array $conditions = array()) {

        //Daten vorbereiten
        $data = array(
            'sensors' => implode(',', $sensors),
            'limit' => $limit,
            'interval' => $interval
        );

        //Speichern
        return $this->addEvent('\SHC\Event\Events\LightIntensityFallsBelow', $name, $data, $enabled, $conditions);
    }

    /**
     * bearbeitet ein Lichtstaerke Event
     *
     * @param  Integer $id         ID
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $sensors    Sensoren
     * @param  Float   $limit      Grenzwert (Prozent)
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function editLightIntensityFallsBelowEvent($id, $name = null, $enabled = null, array $sensors = null, $limit = null, $interval = null, array $conditions = null) {

        //Daten vorbereiten
        $data = array(
            'sensors' => implode(',', $sensors),
            'limit' => $limit,
            'interval' => $interval
        );

        //Speichern
        return $this->editEvent($id, $name, $data, $enabled, $conditions);
    }

    /**
     * erstellt ein Feuchtigkeits Event
     *
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $sensors    Sensoren
     * @param  Float   $limit      Grenzwert (Prozent)
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function addMoistureClimbOverEvent($name, $enabled, array $sensors, $limit, $interval, array $conditions = array()) {

        //Daten vorbereiten
        $data = array(
            'sensors' => implode(',', $sensors),
            'limit' => $limit,
            'interval' => $interval
        );

        //Speichern
        return $this->addEvent('\SHC\Event\Events\MoistureClimbOver', $name, $data, $enabled, $conditions);
    }

    /**
     * bearbeitet ein Feuchtigkeits Event
     *
     * @param  Integer $id         ID
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $sensors    Sensoren
     * @param  Float   $limit      Grenzwert (Prozent)
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function editMoistureClimbOverEvent($id, $name = null, $enabled = null, array $sensors = null, $limit = null, $interval = null, array $conditions = null) {

        //Daten vorbereiten
        $data = array(
            'sensors' => implode(',', $sensors),
            'limit' => $limit,
            'interval' => $interval
        );

        //Speichern
        return $this->editEvent($id, $name, $data, $enabled, $conditions);
    }

    /**
     * erstellt ein Feuchtigkeits Event
     *
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $sensors    Sensoren
     * @param  Float   $limit      Grenzwert (Prozent)
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function addMoistureFallsBelowEvent($name, $enabled, array $sensors, $limit, $interval, array $conditions = array()) {

        //Daten vorbereiten
        $data = array(
            'sensors' => implode(',', $sensors),
            'limit' => $limit,
            'interval' => $interval
        );

        //Speichern
        return $this->addEvent('\SHC\Event\Events\MoistureFallsBelow', $name, $data, $enabled, $conditions);
    }

    /**
     * bearbeitet ein Feuchtigkeits Event
     *
     * @param  Integer $id         ID
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $sensors    Sensoren
     * @param  Float   $limit      Grenzwert (Prozent)
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function editMoistureFallsBelowEvent($id, $name = null, $enabled = null, array $sensors = null, $limit = null, $interval = null, array $conditions = null) {

        //Daten vorbereiten
        $data = array(
            'sensors' => implode(',', $sensors),
            'limit' => $limit,
            'interval' => $interval
        );

        //Speichern
        return $this->editEvent($id, $name, $data, $enabled, $conditions);
    }

    /**
     * erstellt ein Temperatur Event
     *
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $sensors    Sensoren
     * @param  Float   $limit      Grenzwert
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function addTemperatureClimbOverEvent($name, $enabled, array $sensors, $limit, $interval, array $conditions = array()) {

        //Daten vorbereiten
        $data = array(
            'sensors' => implode(',', $sensors),
            'limit' => $limit,
            'interval' => $interval
        );

        //Speichern
        return $this->addEvent('\SHC\Event\Events\TemperatureClimbOver', $name, $data, $enabled, $conditions);
    }

    /**
     * bearbeitet ein Temperatur Event
     *
     * @param  Integer $id         ID
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $sensors    Sensoren
     * @param  Float   $limit      Grenzwert
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function editTemperatureClimbOverEvent($id, $name = null, $enabled = null, array $sensors = null, $limit = null, $interval = null, array $conditions = null) {

        //Daten vorbereiten
        $data = array(
            'sensors' => implode(',', $sensors),
            'limit' => $limit,
            'interval' => $interval
        );

        //Speichern
        return $this->editEvent($id, $name, $data, $enabled, $conditions);
    }

    /**
     * erstellt ein Temperatur Event
     *
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $sensors    Sensoren
     * @param  Float   $limit      Grenzwert
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function addTemperatureFallsBelowEvent($name, $enabled, array $sensors, $limit, $interval, array $conditions = array()) {

        //Daten vorbereiten
        $data = array(
            'sensors' => implode(',', $sensors),
            'limit' => $limit,
            'interval' => $interval
        );

        //Speichern
        return $this->addEvent('\SHC\Event\Events\TemperatureFallsBelow', $name, $data, $enabled, $conditions);
    }

    /**
     * bearbeitet ein Temperatur Event
     *
     * @param  Integer $id         ID
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $sensors    Sensoren
     * @param  Float   $limit      Grenzwert
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function editTemperatureFallsBelowEvent($id, $name = null, $enabled = null, array $sensors = null, $limit = null, $interval = null, array $conditions = null) {

        //Daten vorbereiten
        $data = array(
            'sensors' => implode(',', $sensors),
            'limit' => $limit,
            'interval' => $interval
        );

        //Speichern
        return $this->editEvent($id, $name, $data, $enabled, $conditions);
    }

    /**
     * erstellt ein Eingangsevent
     *
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $inputs     Eingaenge
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function addInputHighEvent($name, $enabled, array $inputs, $interval, array $conditions = array()) {

        //Daten vorbereiten
        $data = array(
            'inputs' => implode(',', $inputs),
            'interval' => $interval
        );

        //Speichern
        return $this->addEvent('\SHC\Event\Events\InputHigh', $name, $data, $enabled, $conditions);
    }

    /**
     * bearbeitet ein Eingangsevent
     *
     * @param  Integer $id         ID
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $inputs     Eingaenge
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function editInputHighEvent($id, $name = null, $enabled = null, array $inputs = null, $interval = null, array $conditions = null) {

        //Daten vorbereiten
        $data = array(
            'inputs' => implode(',', $inputs),
            'interval' => $interval
        );

        //Speichern
        return $this->editEvent($id, $name, $data, $enabled, $conditions);
    }

    /**
     * erstellt ein Eingangsevent
     *
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $inputs     Eingaenge
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function addInputLowEvent($name, $enabled, array $inputs, $interval, array $conditions = array()) {

        //Daten vorbereiten
        $data = array(
            'inputs' => implode(',', $inputs),
            'interval' => $interval
        );

        //Speichern
        return $this->addEvent('\SHC\Event\Events\InputLow', $name, $data, $enabled, $conditions);
    }

    /**
     * bearbeitet ein Eingangsevent
     *
     * @param  Integer $id         ID
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $inputs     Eingaenge
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function editInputLowEvent($id, $name = null, $enabled = null, array $inputs = null, $interval = null, array $conditions = null) {

        //Daten vorbereiten
        $data = array(
            'inputs' => implode(',', $inputs),
            'interval' => $interval
        );

        //Speichern
        return $this->editEvent($id, $name, $data, $enabled, $conditions);
    }

    /**
     * erstellt ein Benutzerevent
     *
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $users      benutzer zu Hause
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function addUserComesHomeEvent($name, $enabled, array $users, $interval, array $conditions = array()) {

        //Daten vorbereiten
        $data = array(
            'users' => implode(',', $users),
            'interval' => $interval
        );

        //Speichern
        return $this->addEvent('\SHC\Event\Events\UserComesHome', $name, $data, $enabled, $conditions);
    }

    /**
     * bearbeitet ein Benutzerevent
     *
     * @param  Integer $id         ID
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $users      benutzer zu Hause
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function editUserComesHomeEvent($id, $name = null, $enabled = null, array $users = null, $interval = null, array $conditions = null) {

        //Daten vorbereiten
        $data = array(
            'users' => implode(',', $users),
            'interval' => $interval
        );

        //Speichern
        return $this->editEvent($id, $name, $data, $enabled, $conditions);
    }

    /**
     * erstellt ein Benutzerevent
     *
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $users      benutzer zu Hause
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function addUserLeavesHomeEvent($name, $enabled, array $users, $interval, array $conditions = array()) {

        //Daten vorbereiten
        $data = array(
            'users' => implode(',', $users),
            'interval' => $interval
        );

        //Speichern
        return $this->addEvent('\SHC\Event\Events\UserLeavesHome', $name, $data, $enabled, $conditions);
    }

    /**
     * bearbeitet ein Benutzerevent
     *
     * @param  Integer $id         ID
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $users      benutzer zu Hause
     * @param  Integer $interval   Sperrzeit
     * @param  Array   $conditions Liste der Bedingunen
     * @return Boolaen
     * @throws \Exception
     */
    public function editUserLeavesHomeEvent($id, $name = null, $enabled = null, array $users = null, $interval = null, array $conditions = null) {

        //Daten vorbereiten
        $data = array(
            'users' => implode(',', $users),
            'interval' => $interval
        );

        //Speichern
        return $this->editEvent($id, $name, $data, $enabled, $conditions);
    }

    /**
     * erstellt ein neuen Event Sonnenaufgang
     *
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $conditions Liste der Bedingunen
     * @throws \Exception
     */
    public function addSunriseEvent($name, $enabled, array $conditions = null) {

        //Speichern
        return $this->addEvent('\SHC\Event\Events\Sunrise', $name, array(), $enabled, $conditions);
    }

    /**
     * bearbeitet ein Event Sonnenaufgang
     *
     * @param  Integer $id         ID
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $conditions Liste der Bedingunen
     * @throws \Exception
     */
    public function editSunriseEvent($id, $name = null, $enabled = null, array $conditions = null) {

        //Speichern
        return $this->editEvent($id, $name, array(), $enabled, $conditions);
    }

    /**
     * erstellt ein neuen Event Sonnenuntergang
     *
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $conditions Liste der Bedingunen
     * @throws \Exception
     */
    public function addSunsetEvent($name, $enabled, array $conditions = null) {

        //Speichern
        return $this->addEvent('\SHC\Event\Events\Sunset', $name, array(), $enabled, $conditions);
    }

    /**
     * bearbeitet ein Event Sonnenuntergang
     *
     * @param  Integer $id         ID
     * @param  String  $name       Name
     * @param  Boolean $enabled    Aktiviert
     * @param  Array   $conditions Liste der Bedingunen
     * @throws \Exception
     */
    public function editSunsetEvent($id, $name = null, $enabled = null, array $conditions = null) {

        //Speichern
        return $this->editEvent($id, $name, array(), $enabled, $conditions);
    }

    /**
     * loascht ein Event
     *
     * @param  Integer $id ID
     * @return Boolean
     * @throws \RWF\Xml\Exception\XmlException
     */
    public function removeEvent($id) {

        //XML Daten Laden
        $xml = XmlFileManager::getInstance()->getXmlObject(SHC::XML_EVENTS, true);

        //Element suchen
        for ($i = 0; $i < count($xml->event); $i++) {

            if ((int) $xml->event[$i]->id == $id) {

                //Element loeschen
                unset($xml->event[$i]);

                //Daten Speichern
                $xml->save();
                return true;
            }
        }
        return false;
    }

    /**
     * fuegt einem Event eine Bedingung hinzu
     *
     * @param  Integer $eventId      ID des Events
     * @param  Integer $conditionId  ID der Bedingung
     * @return Boolean
     * @throws \RWF\Xml\Exception\XmlException
     */
    public function addConditionToEvent($eventId, $conditionId) {

        //XML Daten Laden
        $xml = XmlFileManager::getInstance()->getXmlObject(SHC::XML_EVENTS, true);

        //Event Suchen
        foreach ($xml->event as $event) {

            /* @var $switchable \SimpleXmlElement */
            if ((int) $event->id == $eventId) {

                //Bedingung einfügen
                $data = explode(',', $event->conditions);
                if(!in_array($conditionId, $data)) {

                    $data[] = $conditionId;
                    $event->conditions = implode(',', $data);

                    //Daten Speichern
                    $xml->save();
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * entfernt eine Bedingung aus einem Event
     *
     * @param  Integer $eventId      ID des Events
     * @param  Integer $conditionId  ID der Bedingung
     * @return Boolean
     * @throws \RWF\Xml\Exception\XmlException
     */
    public function removeConditionFromEvent($eventId, $conditionId) {

        //XML Daten Laden
        $xml = XmlFileManager::getInstance()->getXmlObject(SHC::XML_EVENTS, true);

        //Event Suchen
        foreach ($xml->event as $event) {

            /* @var $switchable \SimpleXmlElement */
            if ((int) $event->id == $eventId) {

                //Bedingung einfügen
                $data = explode(',', $event->conditions);
                if(in_array($conditionId, $data)) {

                    foreach($data as $index => $id) {

                        if($id == $conditionId) {

                            unset($data[$index]);
                            $event->conditions = implode(',', $data);

                            //Daten Speichern
                            $xml->save();
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    /**
     * fuegt einem Event ein Schaltbares Element hinzu
     *
     * @param  Integer $eventId      ID des Events
     * @param  Integer $switchableId ID des Schaltbaren Elements
     * @param  Integer $command      Befehl
     * @return Boolean
     * @throws \RWF\Xml\Exception\XmlException
     */
    public function addSwitchableToEvent($eventId, $switchableId, $command) {

        //XML Daten Laden
        $xml = XmlFileManager::getInstance()->getXmlObject(SHC::XML_EVENTS, true);

        //Event Suchen
        foreach ($xml->event as $event) {

            /* @var $switchable \SimpleXmlElement */
            if ((int) $event->id == $eventId) {

                //Neues ELement erstellen
                $tag = $event->addChild('switchable');
                $tag->addAttribute('id', $switchableId);
                $tag->addAttribute('command', $command);

                //Daten Speichern
                $xml->save();
                return true;
            }
        }
        return false;
    }

    /**
     * setzt den Befehl eines Schaltbaren Elements in einem Event
     *
     * @param  Integer $eventId      ID des Events
     * @param  Integer $switchableId ID des Schaltbaren Elements
     * @param  Integer $command      Befehl
     * @return Boolean
     * @throws \RWF\Xml\Exception\XmlException
     */
    public function setEventSwitchableCommand($eventId, $switchableId, $command) {

        //XML Daten Laden
        $xml = XmlFileManager::getInstance()->getXmlObject(SHC::XML_EVENTS, true);

        //Aktivitaet Suchen
        foreach ($xml->event as $event) {

            /* @var $switchable \SimpleXmlElement */
            if ((int) $event->id == $eventId) {

                //Nach Element suchen
                foreach ($event->switchable as $eventSwitchable) {

                    $attr = $eventSwitchable->attributes();
                    if ((int) $attr->id == $switchableId) {

                        $attr->command = $command;

                        //Daten Speichern
                        $xml->save();
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * entfernt ein Schaltbares Element von einem Event
     *
     * @param  Integer $eventId      ID des Events
     * @param  Integer $switchableId ID des Schaltbaren Elements
     * @return Boolean
     * @throws \RWF\Xml\Exception\XmlException
     */
    public function removeSwitchableFromEvent($eventId, $switchableId) {

        //XML Daten Laden
        $xml = XmlFileManager::getInstance()->getXmlObject(SHC::XML_EVENTS, true);

        //Event suchen
        for ($i = 0; $i < count($xml->event); $i++) {

            if ((int) $xml->event[$i]->id == $eventId) {

                //Element suchen
                for ($j = 0; $j < count($xml->event[$i]->switchable); $j++) {

                    $attr = $xml->event[$i]->switchable[$j]->attributes();
                    if ((int) $attr->id == $switchableId) {

                        //Element loeschen
                        unset($xml->event[$i]->switchable[$j]);

                        //Daten Speichern
                        $xml->save();
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * geschuetzt wegen Singleton
     */
    private function __clone() {

    }

    /**
     * gibt den Ereignis Editor Editor zurueck
     *
     * @return \SHC\Event\EventEditor
     */
    public static function getInstance() {

        if (self::$instance === null) {

            self::$instance = new EventEditor();
        }
        return self::$instance;
    }
}

<?php

namespace RWF\Template\Plugin;

//Imports
use RWF\Core\RWF;
use RWF\Date\LanguageDateTime;
use RWF\Template\TemplateFunction;
use RWF\Template\Template;


/**
 * gibt ein Formatiertes Datum zurueck
 *
 * @author     Oliver Kleditzsch
 * @copyright  Copyright (c) 2014, Oliver Kleditzsch
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @since      2.0.0-0
 * @version    2.0.0-0
 */
class TimeLineFunction implements TemplateFunction {

    /**
     * Template Funktion
     *
     * @param  Array                  $value Werte
     * @param  \RWF\Template\Template $tpl   Template Objekt
     * @return String
     */
    public static function execute(array $value, Template $tpl) {

        //Zeitobjekt vorbereiten
        if($value[0] instanceof \DateTime) {

            $time = LanguageDateTime::createFormObject($value[0]);
        } else {

            $time = LanguageDateTime::now();
        }

        if(RWF::getSetting('rwf.date.useTimeline')) {

            return $time->showTimeline();
        }
        return $time->showDateTime(RWF::getSetting('rwf.date.defaultDateFormat'), RWF::getSetting('rwf.date.defaultTimeFormat'));
    }

}
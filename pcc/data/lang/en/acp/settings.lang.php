<?php

/**
 * Einstellungen Sprachvariablen
 *
 * @author     Oliver Kleditzsch
 * @copyright  Copyright (c) 2014, Oliver Kleditzsch
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @since        2.0.0-0
 * @version      2.0.0-0
 * @translation  Dietmar Franken
 * @SHC Forum    http://rpi-controlcenter.de/member.php?action=profile&uid=173
 */
 
$l = array();

//Allgemein
//General

//$l['acp.settings.title'] = 'Einstellungen';
$l['acp.settings.title'] = 'Settings';

//Meldungen
//Messages

//$l['acp.settings.form.success'] = 'Die Einstellungen wurden erfolgreich gespeichert';
$l['acp.settings.form.success'] = 'The settings has been saved successfully';
//$l['acp.settings.form.error.1102'] = 'Die Einstellungen konnten wegen fehlender Schreibrechte nicht gespeichert werden';
$l['acp.settings.form.error.1102'] = 'The settings could not be saved due to lack of write access';
//$l['acp.settings.form.error'] = 'Die Einstellungen konnten nicht gespeichert werden';
$l['acp.settings.form.error'] = 'The settings could not be saved';

//Formulare
//Forms

//$l['acp.settings.tabs.global'] = 'Allgemein';
$l['acp.settings.tabs.global'] = 'General';
//$l['acp.settings.tabs.global.description'] = 'Grundeinstellungen des SHC';
$l['acp.settings.tabs.global.description'] = 'Basic settings of SHC';
//$l['acp.settings.tabs.dateTime'] = 'Datum und Zeit';
$l['acp.settings.tabs.dateTime'] = 'Date und time';
//$l['acp.settings.tabs.dateTime.description'] = 'Einstellungen zu Datum und Zeit';
$l['acp.settings.tabs.dateTime.description'] = 'Settings date and time';
//$l['acp.settings.tabs.ui'] = 'Benutzeroberfläche';
$l['acp.settings.tabs.ui'] = 'User interface';
//$l['acp.settings.tabs.ui.description'] = 'Einstellungen zur Benutzeroberfläche';
$l['acp.settings.tabs.ui.description'] = 'Settings user interface';
//$l['acp.settings.tabs.fritzBox'] = 'Fritz!Box';
$l['acp.settings.tabs.fritzBox'] = 'Fritz!Box';
//$l['acp.settings.tabs.fritzBox.description'] = 'Zugangsdaten zur Fritz!Box';
$l['acp.settings.tabs.fritzBox.description'] = 'Access to the Fritz box';
//$l['acp.settings.tabs.redirect.pc'] = 'Weboberfläche';
$l['acp.settings.tabs.redirect.pc'] = 'Web interface';
//$l['acp.settings.tabs.redirect.tablet'] = 'Tabletoberfläche';
$l['acp.settings.tabs.redirect.tablet'] = 'Tablet interface';
//$l['acp.settings.tabs.redirect.smartphone'] = 'Smartphoneoberfläche';
$l['acp.settings.tabs.redirect.smartphone'] = 'Smartphone interface';
//$l['acp.settings.form.title'] = 'Titel';
$l['acp.settings.form.title'] = 'Title';
//$l['acp.settings.form.title.decription'] = 'Titel der in der Kopfzeile angezeit wird';
$l['acp.settings.form.title.decription'] = 'Title to be displayed in the header';
//$l['acp.settings.form.allowLongTimeLogin'] = 'Langzeit Login';
$l['acp.settings.form.allowLongTimeLogin'] = 'Longtime Login';
//$l['acp.settings.form.allowLongTimeLogin.decription'] = 'Benutzer können sich dauerhaft einloggen';
$l['acp.settings.form.allowLongTimeLogin.decription'] = 'Users can login permanently';
//$l['acp.settings.form.defaultStyle'] = 'Webstyle';
$l['acp.settings.form.defaultStyle'] = 'Webstyle';
//$l['acp.settings.form.defaultStyle.decription'] = 'Der hier eingestellte Webstyle gilt für alle Gäste und Benutzer die nicht selbst einen Webstyle gewählt haben';
$l['acp.settings.form.defaultStyle.decription'] = 'The webstyle set here is valid to all guests and users who do not select a webstyle itself';
//$l['acp.settings.form.defaultLanguage'] = 'Language';
$l['acp.settings.form.defaultLanguage'] = 'Sprache';
//$l['acp.settings.form.defaultLanguage.decription'] = 'Die hier eingestellte Sprache gilt für alle Gäste und Benutzer die nicht selbst ein Sprache gewählt haben';
$l['acp.settings.form.defaultLanguage.decription'] = 'The language set here is valid for all guests and users who do not select a language itself';
//$l['acp.settings.form.Timezone'] = 'Zeitzone';
$l['acp.settings.form.Timezone'] = 'Timezone';
//$l['acp.settings.form.Timezone.decription'] = 'Zeitzone';
$l['acp.settings.form.Timezone.decription'] = 'Timezone';
//$l['acp.settings.form.defaultDateFormat'] = 'Datumsformat';
$l['acp.settings.form.defaultDateFormat'] = 'Date format';
//$l['acp.settings.form.defaultDateFormat.decription'] = 'Standard Datumsformat, die Beschreibung der Formatierung ist in der PHP "date" Funktion zu finden';
$l['acp.settings.form.defaultDateFormat.decription'] = 'Default date format, the description of the formatting is in the PHP "date" function';
//$l['acp.settings.form.defaultTimeFormat'] = 'Zeitformat';
$l['acp.settings.form.defaultTimeFormat'] = 'Time format';
//$l['acp.settings.form.defaultTimeFormat.decription'] = 'Standard Zeitformat, die Beschreibung der Formatierung ist in der PHP "date" Funktion zu finden';
$l['acp.settings.form.defaultTimeFormat.decription'] = 'Default time format, the description of the formatting is in the PHP "date" function';
//$l['acp.settings.form.sunriseOffset'] = 'Offset Sonnenaufgang';
$l['acp.settings.form.sunriseOffset'] = 'Offset sunrise';
//$l['acp.settings.form.sunriseOffset.decription'] = 'mit dieser Einstellung kann der errechnete Sonnenaufgang verschoben werden (heutiger Sonnenaufgang mit Offset: {1:s} Uhr)';
$l['acp.settings.form.sunriseOffset.decription'] = 'with this setting, the calculated sunrise will be shifted (Todays sunrise with offset: {1: s})';
//$l['acp.settings.form.sunsetOffset'] = 'Offset Sonnenuntergang';
$l['acp.settings.form.sunsetOffset'] = 'Offset sunset';
//$l['acp.settings.form.sunsetOffset.decription'] = 'mit dieser Einstellung kann der errechnete Sonnenuntergang verschoben werden (heutiger Sonnenuntergang mit Offset: {1:s} Uhr)';
$l['acp.settings.form.sunsetOffset.decription'] = 'with this setting, the calculated sunrise will be shifted (Todays sunrise with offset: {1: s})';
//$l['acp.settings.form.Latitude'] = 'Breitengrad';
$l['acp.settings.form.Latitude'] = 'Latitude';
//$l['acp.settings.form.Latitude.decription'] = 'Geodaten für die Berechnung von Sonnenauf- und untergang';
$l['acp.settings.form.Latitude.decription'] = 'Geodata for the calculation of sunrise and sunset';
//$l['acp.settings.form.Longitude'] = 'Längengrad';
$l['acp.settings.form.Longitude'] = 'Longitude';
//$l['acp.settings.form.Longitude.decription'] = 'Geodaten für die Berechnung von Sonnenauf- und untergang';
$l['acp.settings.form.Longitude.decription'] = 'Geodata for the calculation of sunrise and sunset';
//$l['acp.settings.form.fbAddress'] = 'Adresse';
$l['acp.settings.form.fbAddress'] = 'Adress';
//$l['acp.settings.form.fbAddress.decription'] = 'Host oder IP Adresse der Fritz!Box';
$l['acp.settings.form.fbAddress.decription'] = 'Host or IP Adress of the Fritz!Box';
//$l['acp.settings.form.5GHzWlan'] = '5GHz Wlan';
$l['acp.settings.form.5GHzWlan'] = '5GHz Wlan';
//$l['acp.settings.form.5GHzWlan.decription'] = 'Hat die Fritz!Box ein 5GHz Wlan?';
$l['acp.settings.form.5GHzWlan.decription'] = 'Has the Fritzbox a 5GHz WLAN?';
//$l['acp.settings.form.fbUser'] = 'Benutzer';
$l['acp.settings.form.fbUser'] = 'User';
//$l['acp.settings.form.fbUser.decription'] = 'Benutzername des Fritz!Box Benutzers';
$l['acp.settings.form.fbUser.decription'] = 'Username of the  Fritz!Box user';
//$l['acp.settings.form.fbPassword'] = 'Passwort';
$l['acp.settings.form.fbPassword'] = 'Password';
//$l['acp.settings.form.fbPassword.decription'] = 'Passwort des Fritz!Box Benutzers';
$l['acp.settings.form.fbPassword.decription'] = 'Password of the Fritz!Box user';
//$l['acp.settings.form.fbShowState'] = 'Status anzeigen';
$l['acp.settings.form.fbShowState'] = 'Show status';
//$l['acp.settings.form.fbShowState.decription'] = 'Soll die Fritz!Box Statusübersicht angezeigt werden';
$l['acp.settings.form.fbShowState.decription'] = 'Soll die Fritz!Box Statusübersicht angezeigt werden';
//$l['acp.settings.form.fbDsl'] = 'DSL';
$l['acp.settings.form.fbDsl'] = 'DSL';
//$l['acp.settings.form.fbDsl.decription'] = 'Ist die Fritz!Box per DSL mit dem Internet verbunden?';
$l['acp.settings.form.fbDsl.decription'] = 'Is the Fritz!Box connected via DSL to the Internet??';
//$l['acp.settings.form.fbSmartHomeDevices'] = 'Smart Home Geräte';
$l['acp.settings.form.fbSmartHomeDevices'] = 'Smart Home devices';
//$l['acp.settings.form.fbSmartHomeDevices.decription'] = 'Soll die Fritz!Box Smarthome Geräteüberschit angezeigt werden?';
$l['acp.settings.form.fbSmartHomeDevices.decription'] = 'Should the Fritz! Box Smarthome device overview displayed?';
//$l['acp.settings.form.fbCallList'] = 'Anrufliste';
$l['acp.settings.form.fbCallList'] = 'Call list';
//$l['acp.settings.form.fbCallList.decription'] = 'Soll die Fritz!Box Anrufliste angezeigt werden';
$l['acp.settings.form.fbCallList.decription'] = 'Should the Fritz! call list displayed?';
//$l['acp.settings.form.fbCallListMax'] = 'Einträge';
$l['acp.settings.form.fbCallListMax'] = 'Posts';
//$l['acp.settings.form.fbCallListMax.decription'] = 'Wieviele Einträge der Anrufliste sollen Maximal angezeigt werden';
$l['acp.settings.form.fbCallListMax.decription'] = 'How many entries of the call list to be displayed maximum';
//$l['acp.settings.form.fbCallListDays'] = 'Tage';
$l['acp.settings.form.fbCallListDays'] = 'Days';
//$l['acp.settings.form.fbCallListDays.decription'] = 'gibt an wie alt die Einträge maxmal sein dürfen (1 = heute, 7 = die letzte Woche)';
$l['acp.settings.form.fbCallListDays.decription'] = 'specifies how old the messages can be up to (= 1 today, 7 = the last week)';
//$l['acp.settings.form.redirectActive'] = 'Umleitung Aktiv';
$l['acp.settings.form.redirectActive'] = 'Redirection active';
//$l['acp.settings.form.redirectActive.decription'] = 'Ist die Umleitung anktiv werden PCs, Tablets und Smartphones auf die EIngestellten Oberflächen umgeleitet';
$l['acp.settings.form.redirectActive.decription'] = 'Is the redirection active  PCs, tablets and smartphones are redirected to the selected surfaces';
//$l['acp.settings.form.redirectPcTo'] = 'PC Umleitung';
$l['acp.settings.form.redirectPcTo'] = 'PC redirection';
//$l['acp.settings.form.redirectPcTo.decription'] = 'Legt die Oberfläche fest auf die ein PC umgeleitet wird';
$l['acp.settings.form.redirectPcTo.decription'] = 'Sets the surface to the PC will be redirected';
//$l['acp.settings.form.redirectTabletTo'] = 'Tablet Umleitung';
$l['acp.settings.form.redirectTabletTo'] = 'Tablet redirection';
//$l['acp.settings.form.redirectTabletTo.decription'] = 'legt die Oberfläche fest auf die ein Tablet umgeleitet wird';
$l['acp.settings.form.redirectTabletTo.decription'] = 'Sets the surface to the tablet will be redirected';
//$l['acp.settings.form.redirectSmartphoneTo'] = 'Smartphone Umleitung';
$l['acp.settings.form.redirectSmartphoneTo'] = 'redirection';
//$l['acp.settings.form.redirectSmartphoneTo.decription'] = 'Legt die Oberfläche fest auf die ein Smartphone umgeleitet wird';
$l['acp.settings.form.redirectSmartphoneTo.decription'] = 'Sets the surface to the smartphone will be redirected';

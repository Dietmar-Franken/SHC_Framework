<?php

/**
 * Benutzerverwaltung Sprachvariablen
 *
 * @author     Oliver Kleditzsch
 * @copyright  Copyright (c) 2014, Oliver Kleditzsch
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @since      2.0.0-0
 * @version    2.0.0-0
 */
$l = array();

//Allgemein
$l['acp.userManagement.title'] = 'Benutzerverwaltung';

//Benutzer Tabelle
$l['acp.userManagement.userList.table.head.user'] = 'Benutzer';
$l['acp.userManagement.userList.table.head.registrationDate'] = 'Registrierung';
$l['acp.userManagement.userList.table.head.options'] = 'Optionen';
$l['acp.userManagement.groupList.table.head.name'] = 'Name';
$l['acp.userManagement.groupList.table.head.sysGroup'] = 'Systemgruppe';

//Buttons
$l['acp.userManagement.button.addUser'] = 'neuer Benutzer';
$l['acp.userManagement.button.viewGroupList'] = 'Benutzergruppen';
$l['acp.userManagement.button.addGroup'] = 'neue Benutzergruppe';

//Prompts
$l['acp.userManagement.prompt.deleteUser.title'] = 'Benutzer löschen';
$l['acp.userManagement.prompt.deleteUser'] = 'Willst du den Benutzer wirklich löschen?';
$l['acp.userManagement.prompt.deleteGroup.title'] = 'Benutzergruppe löschen';
$l['acp.userManagement.prompt.deleteGroup'] = 'Willst du die Benutzergruppe wirklich löschen?';

//Formulate
$l['acp.userManagement.form.user.addDescription'] = 'Benutzer erstellen';
$l['acp.userManagement.form.user.editDescription'] = 'Benutzer bearbeiten';
$l['acp.userManagement.form.user.name'] = 'Benutzername';
$l['acp.userManagement.form.user.name.description'] = 'Name des Benutzers';
$l['acp.userManagement.form.user.pass1'] = 'Passwort';
$l['acp.userManagement.form.user.pass1.description'] = 'Passwort des Benutzers';
$l['acp.userManagement.form.user.pass2'] = 'Passwort wiederholung';
$l['acp.userManagement.form.user.pass2.description'] = 'gib das Passwort nochmals ein um schreibfehler zu vermeiden';
$l['acp.userManagement.form.user.mainGroup'] = 'Hauptgruppe';
$l['acp.userManagement.form.user.mainGroup.description'] = 'Hauptgruppe des Benutzers';
$l['acp.userManagement.form.user.userGroups'] = 'Benutzergruppen';
$l['acp.userManagement.form.user.userGroups.description'] = 'Benutzergruppen zu denen der Benutzer zugeordnet wird';
$l['acp.userManagement.form.user.lang'] = 'Sprache';
$l['acp.userManagement.form.user.lang.description'] = 'Sprache in der das SHC dem Benutzer angezeigt wird';
$l['acp.userManagement.form.user.webStyle'] = 'Web Style';
$l['acp.userManagement.form.user.webStyle.description'] = 'Style der Web Oberfläche';

$l['acp.userManagement.form.group.tab1.title'] = 'Allgemeine Daten';
$l['acp.userManagement.form.group.tab1.description'] = 'Allgemeine Daten der Gruppe';
$l['acp.userManagement.form.group.tab2.title'] = 'Benutzer Rechte';
$l['acp.userManagement.form.group.tab2.description'] = 'Benutzer Rechte der Gruppe';
$l['acp.userManagement.form.group.tab3.title'] = 'Administrator Rechte';
$l['acp.userManagement.form.group.tab3.description'] = 'Administrator Rechte der Gruppe';
$l['acp.userManagement.form.group.name'] = 'Name';
$l['acp.userManagement.form.group.name.description'] = 'Name der Benutzergruppe';
$l['acp.userManagement.form.group.desc'] = 'Beschreibung';
$l['acp.userManagement.form.group.desc.description'] = 'Beschreibung der Benutzergruppe';

//Meldungen
$l['acp.userManagement.form.error.invalidName'] = 'Der Benutzername darf nur folgende Zeichen enthalten: a-z 0-9 # _ ! - . , ; + * ?';
$l['acp.userManagement.form.error.nameNotAvailable'] =  'Der Benutzername ist bereits vergeben';
$l['acp.userManagement.form.error.passwordError'] =  'Die Passwörter stimmen nicht überein';

$l['acp.userManagement.form.success.addUser'] =  'Der Benutzer wurde erfolgreich erstellt';
$l['acp.userManagement.form.success.editUser'] =  'Der Benutzer wurde erfolgreich bearbeitet';
$l['acp.userManagement.form.success.deleteUser'] =  'Der Benutzer wurde erfolgreich gelöscht';
$l['acp.userManagement.form.error.1110'] =  $l['acp.userManagement.form.error.nameNotAvailable'];
$l['acp.userManagement.form.error.1102'] =  'Der Benutzer konnte wegen fehlender Schreibrechte nicht gespeichert werden';
$l['acp.userManagement.form.error.1102.del'] =  'Der Benutzer konnte wegen fehlender Schreibrechte nicht gelöscht werden';
$l['acp.userManagement.form.error.1102.del'] =  'Der Benutzer konnte wegen fehlender Schreibrechte nicht gelöscht werden';
$l['acp.userManagement.form.error.1111.del'] =  'Der Hauptbenutzer darf nicht gelöscht werden';
$l['acp.userManagement.form.error.id'] =  'Ungültige Benutzer ID';
$l['acp.userManagement.form.error'] =  'Der Benutzer konnte nicht gespeichert werden';
$l['acp.userManagement.form.error.del'] =  'Der Benutzer konnte nicht gelöscht werden';

$l['acp.userManagement.form.success.addGroup'] =  'Die Benutzergruppe wurde erfolgreich erstellt';
$l['acp.userManagement.form.success.editGroup'] =  'Die Benutzergruppe wurde erfolgreich bearbeitet';
$l['acp.userManagement.form.success.deleteGroup'] =  'Die Benutzergruppe wurde erfolgreich gelöscht';
$l['acp.userManagement.form.error.1102.group'] =  'Die Benutzergruppe  konnte wegen fehlender Schreibrechte nicht gelöscht werden';
$l['acp.userManagement.form.error.1112.group'] =  'Der Name der Benutzergruppe  ist schon vergeben';
$l['acp.userManagement.form.error.1102.group.del'] =  'Die Benutzergruppe konnte wegen fehlender Schreibrechte nicht gelöscht werden';
$l['acp.userManagement.form.error.1113.group.del'] =  'Eine System Benutzergruppe darf nicht gelöscht werden';
$l['acp.userManagement.form.error.group'] =  'Die Benutzergruppe konnte nicht gespeichert werden';
$l['acp.userManagement.form.error.group.del'] =  'Die Benutzergruppe konnte nicht gelöscht werden';
$l['acp.userManagement.form.error.id.group'] =  'Ungültige Gruppen ID';

//Rechte
$l['acp.userManagement.premissions.shc.ucp.viewUserAtHome'] =  'Benutzer zu Hause';
$l['acp.userManagement.premissions.shc.ucp.viewUserAtHome.description'] =  'bekommt die Benutzer zu Hause auf der Indexseite angezeigt';
$l['acp.userManagement.premissions.shc.ucp.warnings'] =  'Warnmeldungen';
$l['acp.userManagement.premissions.shc.ucp.warnings.description'] =  'Der Benutzer bekommt eine Warnmeldung angezeigt wenn Wichtige Funktionen des SHC nicht laufen';

$l['acp.userManagement.premissions.shc.acp.menu'] =  'ACP Menü';
$l['acp.userManagement.premissions.shc.acp.menu.description'] =  'das ACP Menü betreten und die Funktionen verwenden die keine gesonderten Berechtigungen erfordern';
$l['acp.userManagement.premissions.shc.acp.userManagement'] =  'Benutzerverwaltung';
$l['acp.userManagement.premissions.shc.acp.userManagement.description'] =  'Benutzer und Gruppen erstellen, bearbeiten und löschen';
$l['acp.userManagement.premissions.shc.acp.settings'] =  'Einstellungen';
$l['acp.userManagement.premissions.shc.acp.settings.description'] =  'Der Benutzer kann die Einstellungen des SHC bearbeiten';
$l['acp.userManagement.premissions.shc.acp.databaseManagement'] = 'Datenbank';
$l['acp.userManagement.premissions.shc.acp.databaseManagement.description'] =  'Datenbank überwachen';
$l['acp.userManagement.premissions.shc.acp.backupsManagement'] =  'Backups';
$l['acp.userManagement.premissions.shc.acp.backupsManagement.description'] =  'Backups erstellen, löschen und herunterladen';
$l['acp.userManagement.premissions.shc.acp.roomManagement'] =  'Räume verwalten';
$l['acp.userManagement.premissions.shc.acp.roomManagement.description'] =  'Räume erstellen, bearbeiten und löschen';
$l['acp.userManagement.premissions.shc.acp.switchableManagement'] =  'Schaltfunktionen verwalten';
$l['acp.userManagement.premissions.shc.acp.switchableManagement.description'] =  'der Benutzer kann Sensoren, Schaltelementen und Lesnare elemente verwalten';
$l['acp.userManagement.premissions.shc.acp.conditionsManagement'] =  'Bedingungen verwalten';
$l['acp.userManagement.premissions.shc.acp.conditionsManagement.description'] =  'der Benutzer kann Bedingungen erstellen und verwalten';
$l['acp.userManagement.premissions.shc.acp.switchpointsManagement'] =  'Schaltpunkte verwalten';
$l['acp.userManagement.premissions.shc.acp.switchpointsManagement.description'] =  'der Benutzer kann Schaltpunkte erstellen und verwalten';
$l['acp.userManagement.premissions.shc.acp.sensorpointsManagement'] =  'Sensorpunkte verwalten';
$l['acp.userManagement.premissions.shc.acp.sensorpointsManagement.description'] =  'der Benutzer kann Sensorpunkte verwalten';
$l['acp.userManagement.premissions.shc.acp.usersathomeManagement'] =  'Benutzer zu Hause verwalten';
$l['acp.userManagement.premissions.shc.acp.usersathomeManagement.description'] =  'es können die Benutzer zu Hause verwaltet werden';
$l['acp.userManagement.premissions.shc.acp.eventsManagement'] =  'Ereignisse verwalten';
$l['acp.userManagement.premissions.shc.acp.eventsManagement.description'] =  'der Benutzer kann Ereignisse verwalten';
$l['acp.userManagement.premissions.shc.acp.switchserverManagement'] =  'Schaltserver verwalten';
$l['acp.userManagement.premissions.shc.acp.switchserverManagement.description'] =  'der Benutzer kann die Schaltserver verwalten';

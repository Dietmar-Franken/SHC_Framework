<?php

namespace SHC\Backup;

//Imports
use RWF\Date\DateTime;
use RWF\Util\FileUtil;
use RWF\XML\XmlFileManager;

/**
 * Backup Verwaltung
 *
 * @author     Oliver Kleditzsch
 * @copyright  Copyright (c) 2014, Oliver Kleditzsch
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @since      2.0.0-0
 * @version    2.0.0-0
 */
class BackupEditor {

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
     * Ordner in dem die Backups liegen
     *
     * @var String
     */
    protected $backupPath = '';

    /**
     * Liste mit allen Backups
     *
     * @var Array
     */
    protected $backups = array();

    /**
     * Singleton Instanz
     *
     * @var \SHC\Backup\BackupEditor
     */
    protected static $instance = null;

    protected function __construct(){}

    /**
     * laedt die Daten aus dem Dateisystem
     */
    public function loadData() {

        $files = FileUtil::listDirectoryFiles($this->backupPath, false, true, true);
        foreach($files as $file) {

            $hash = md5($file['name']);
            $this->backups[$hash] = new Backup($hash, $this->backupPath, $file['name']);

        }
    }

    /**
     * setzt den Pfad in dem sich die Backups befinden
     *
     * @param  String $path Pfad
     * @return \SHC\Backup\BackupEditor
     */
    public function setPath($path){

        $this->backupPath = $path;
        $this->loadData();
        return $this;
    }

    /**
     * gibt den Pfad in dem sich die Backups befinden zurueck
     *
     * @return String
     */
    public function getPath() {

        return $this->backupPath;
    }

    /**
     * gibt eine Backup aufgrund eines MD5 Haches des Dateinamens zurueck
     *
     * @param  String $hash MD5 Hash
     * @return \SHC\Backup\Backup
     */
    public function getBackupByMD5Hash($hash) {

        if(isset($this->backups[$hash])) {

            return $this->backups[$hash];
        }
        return null;
    }

    /**
     * gibt eine Liste mit allen vorhandenen Backups zurueck
     *
     * @param  String $orderBy Art der Sortierung (
     *      name => nach Namen sortieren,
     *      unsorted => unsortiert
     *  )
     * @return Array
     */
    public function listBackups($orderBy = 'name') {

        if ($orderBy == 'name') {

            //nach Namen sortieren
            $backups = $this->backups;

            //Sortierfunktion
            $orderFunction = function($a, $b) {

                if ($a->getFileName() == $b->getFileName()) {

                    return 0;
                }

                if ($a->getFileName() < $b->getFileName()) {

                    return -1;
                }
                return 1;
            };
            usort($backups, $orderFunction);
            return $backups;
        }
        return $this->backups;
    }

    /**
     * erstellt eun vollstaendiges Backup der Anwendung
     *
     * @param  Boolean $ignoreHiddenFiles versteckte Dateien ignorieren
     * @return Boolean
     */
    public function makeBackup($ignoreHiddenFiles = false) {

        return $this->makeFileBackup($ignoreHiddenFiles);
    }

    /**
     * loescht ein Backup
     *
     * @param  String  $hash MD5 Hash
     * @return Boolean
     */
    public function removeBackup($hash) {

        if(isset($this->backups[$hash])) {

            /* @var $backup \SHC\Backup\Backup  */
            $backup = $this->backups[$hash];
            if(@unlink($backup->getPath() . $backup->getFileName())) {

                return true;
            }
        }
        return false;
    }

    /**
     * Dateien sichern
     *
     * @param  Boolean $ignoreHiddenFiles versteckte Dateien ignorieren
     * @return Boolean
     */
    protected function makeFileBackup($ignoreHiddenFiles = false) {

        $filename = '';
        if(file_exists($this->backupPath .'shc_' . DateTime::now()->format('Y_m_d') . '.zip')) {

            for($i = 1; $i <= 20; $i++) {

                if(file_exists($this->backupPath .'shc_' . DateTime::now()->format('Y_m_d') . '_' . $i . '.zip')) {

                    continue;
                } else {

                    $filename = $this->backupPath .'shc_' . DateTime::now()->format('Y_m_d') . '_' . $i . '.zip';
                    break;
                }
            }

            if($filename == '') {

                $filename = $this->backupPath .'shc_' . DateTime::now()->format('Y_m_d') . '_21.zip';
            }
        } else {

            $filename = $this->backupPath .'shc_' . DateTime::now()->format('Y_m_d') . '.zip';
        }

        $zip = new \ZipArchive();
        if ($zip->open($filename, \ZIPARCHIVE::CREATE | \ZIPARCHIVE::OVERWRITE) === true) {

            /* Dateibackup
            if($this->addDir($zip, PATH_BASE, '', $ignoreHiddenFiles)) {

                $zip->close();
                return true;
            }
            */
            $xmlFiles = XmlFileManager::getInstance()->listKnownXmlFiles();
            foreach($xmlFiles as $xmlFile) {

                $dir = dirname($xmlFile['file']);
                $filename = str_replace($dir, '', $xmlFile['file']);

                if(file_exists($xmlFile['file'])) {

                    $archivePath = str_replace(PATH_BASE, '', $dir);
                    $zip->addEmptyDir($archivePath);
                    $zip->addFile($xmlFile['file'], $archivePath . $filename);
                }
            }
            $zip->close();
            return true;
            //var_dump($xmlFiles);
            //$zip->addEmptyDir('rwf/data/storage');
            //$zip->addFile();
        }
        return false;
    }

    /**
     * packt einen Ordner in ein Zip Archiv
     *
     * @param  ZipArchive $zip               geoeffnetes Zip Archiv
     * @param  String     $path              Pfad im Dateisystem
     * @param  String     $innerArchivePath  Pfad im Archiv
     * @param  Boolean    $ignoreHiddenFiles versteckte Dateien ignorieren
     * @return Boolean
     */
    protected function addDir($zip, $path, $innerArchivePath = '', $ignoreHiddenFiles = false) {
;
        //Ordner existiert nicht
        if (!@is_dir($path) || FileUtil::addTrailigSlash($innerArchivePath) == FileUtil::addTrailigSlash(str_replace(PATH_BASE, '', $this->backupPath))) {

            return false;
        }

        //Ordner Durchlaufen
        $dir = opendir($path);
        $path = FileUtil::addTrailigSlash($path);
        while ($file = readdir($dir)) {

            //Element
            $fileSystemElement = $path . $file;
            if ($innerArchivePath != '') {

                $innerArchiveElement = FileUtil::addTrailigSlash($innerArchivePath) . $file;
            } else {

                $innerArchiveElement = $file;
            }

            //nutzlose Elemente ueberspringen
            if ($file == '.' || $file == '..') {

                continue;
            }

            //Versteckte Elemente ueberspringen
            if ($ignoreHiddenFiles == true && preg_match('#^\.#', $file)) {

                continue;
            }

            //Datei
            if (@is_file($fileSystemElement)) {

                $zip->addFile($fileSystemElement, $innerArchiveElement);
                continue;
            }

            //Ordner
            if (@is_dir($fileSystemElement)) {

                $zip->addEmptyDir($innerArchiveElement);
                $this->addDir($zip, $fileSystemElement, $innerArchiveElement, $ignoreHiddenFiles);
                continue;
            }
        }
        return true;
    }

    /**
     * geschuetzt wegen Singleton
     */
    private function __clone() {

    }

    /**
     * gibt den Backup Editor zurueck
     *
     * @return \SHC\Backup\BackupEditor
     */
    public static function getInstance() {

        if (self::$instance === null) {

            self::$instance = new BackupEditor();
        }
        return self::$instance;
    }
}
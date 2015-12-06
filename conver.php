<?php


/**
 * @namespace
 */
namespace serovEU\Conver;

/**
 * @author   Serov.EU <evgensr@gmail.com>
 * Class ConverPHPFiles
 * @package SerovEU\Conver
 */
class ConverPHPFiles
{
    /**
     * @var string расширения файлов
     */
    static public $suffix = 'php';

    /**
     * @param string $directory начальная директория сканирование файлов
     */
    static function convert($directory)
    {

        $directory = realpath($directory);
        $scanned_directory = array_diff(scandir($directory), array('..', '.'));
        array_walk($scanned_directory, function(&$item) use($directory) {
            return $item = is_dir($directory.'/'.$item) ? $directory.'/'.$item : false ;
        });
        $scanned_directory = array_diff($scanned_directory, array(''));

        foreach ($scanned_directory as $folder)
        {
            self::convert($folder);
        }

        foreach (glob($directory."/*.".ConverPHPFiles::$suffix) as $filename) {
            $data = file_get_contents($filename);
            $data = iconv(mb_detect_encoding($data, mb_detect_order(), true), "UTF-8", $data);
            file_put_contents($filename, $data);
        }
    }



}


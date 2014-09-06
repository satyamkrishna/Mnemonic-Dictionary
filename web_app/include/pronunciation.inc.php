<?php

require_once 'error.inc.php';
require_once 'dbhelper.inc.php';

class Pronunciation
{
    public function __construct()
    {

    }

    public static function create_word_pronunciation($word,$save_path='word_pronunciation/')
    {
        $url = 'http://translate.google.com/translate_tts?ie=UTF-8&q='.$word.'&tl=en-us';
        $file = Pronunciation::getFileName($word,$save_path);
        if(!Pronunciation::check_word_file_is_present($word,$save_path))
        {
            Pronunciation::saveMP3($url,$file);
        }
    }

    public static function check_word_file_is_present($word,$save_path='word_pronunciation/')
    {
        $file = Pronunciation::getFileName($word,$save_path);
        if(file_exists($file))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function getFileName($word,$save_path='word_pronunciation/')
    {
        return $save_path.strtolower($word).'.mp3';
    }

    private static function saveMP3($url,$file)
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $output=curl_exec($ch);
        curl_close($ch);
        if($output === false)
            return false;

        $fp= fopen($file,"wb");
        fwrite($fp,$output);
        fclose($fp);

        return true;
    }
}
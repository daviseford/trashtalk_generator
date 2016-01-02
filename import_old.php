<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 1/2/2016
 * Time: 5:39 PM
 */
require_once(__DIR__ . '/php/shittalk_functions.php');

$file = "cfg/shittalk.cfg";
$myfile = fopen($file, "r") or die("Unable to open file!");

$fileContents = fread($myfile, filesize($file));
fclose($myfile);

$del = convert_smart_quotes(get_delimited($fileContents)); //an array of everything between quote marks. need to parse this

//UNCOMMENT FOR THIS TO RUN - IMPORTS OLD BINDS
//if (!empty($del)) {
//    for ($i = 0; $i < count($del); $i++) {
//
//        if (strpos($del[$i], 'say ') !== false) { //if "say " is the first part of the string
//            $fixedBind = str_replace('say ', '', $del[$i]);
//            createShittalkRow($fixedBind);
//
//        }
//    }
//}

function createShittalkRow($text)
{
    $text_escaped = mysql_escape_mimic(strip_double_quotes($text));
    $today = mysql_escape_mimic(date("Y-m-d H:i:s"));

    $sql = "INSERT INTO `shittalkDB`
            (`text`, `date_created`, `custom`)
            VALUES ('$text_escaped', '$today', 0);";
    $result = mySqlQuery($sql);

    return $result;
}

function get_delimited($str, $delimiter = '"')
{
    $escapedDelimiter = preg_quote($delimiter, '/');
    if (preg_match_all('/' . $escapedDelimiter . '(.*?)' . $escapedDelimiter . '/s', $str, $matches)) {
        return $matches[1];
    }
}

function convert_smart_quotes($string)
{
    $search = array(
        '&ldquo;',
        '&rdquo;',
        '“',
        '”',
        chr(147),
        chr(148),
        '&lsquo;',
        '&rsquo;',
        "‘",
        "’",
        chr(145),
        chr(146),
        chr(151),
        '—',
        '&mdash;',
        '&ndash;',
        chr(133));

    $replace = array(
        '"',
        '"',
        '"',
        '"',
        '"',
        '"',
        "'",
        "'",
        "'",
        "'",
        "'",
        "'",
        '-',
        '-',
        '-',
        '-',
        '...');

    return str_replace($search, $replace, $string);
}
<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 1/2/2016
 * Time: 5:39 PM
 */
require_once(__DIR__ . '/shittalk_functions.php');

$file = "../cfg/build.cfg";
$myfile = fopen($file, "r") or die("Unable to open file!");

$fileContents = fread($myfile, filesize($file));
fclose($myfile);
timestampDownload();
$trashcanBinds = makeTrashCanBinds();
if (!empty($trashcanBinds)) {
    $count = count($trashcanBinds);
    $trashcanAliases = makeTrashCanAliases($count);

    $cfg = str_replace('{{SAY}}', implode(PHP_EOL, $trashcanBinds), $fileContents);
    $cfg = str_replace('{{DICEROLL}}', implode(PHP_EOL, $trashcanAliases), $cfg);

    $content = $cfg;

    $filename = 'shittalk.cfg';


    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header('Content-Length: ' . strlen($content));
    header("Content-Disposition: attachment; filename=$filename");
    header("Content-Type: application/octet-stream; ");
    header("Content-Transfer-Encoding: binary");

    echo $content;

} else {
    echo "Error: Not enough votes in the database. No insults have over 5 net votes.";
}


function makeTrashCanBinds()
{
    $text_to_insert = getUpvotedTextRowsForCfg();
    $response = [];
    if (!empty($text_to_insert)) {
        $max = count($text_to_insert);
        for ($i = 0; $i < $max; $i++) {
            $textString = $text_to_insert[$i];
            $bind = 'alias "trashcan' . $i . '" "say ' . $textString . '"';
            $response[] = $bind;
        }
    }
    return $response;
}

function makeTrashCanAliases($limit)
{
    $response = [];
    for ($i = 0; $i < $limit - 1; $i++) {
        $next = $i + 1;
        $alias = 'alias "trashcan_diceroll_' . $i . '" "alias trashcan_result trashcan' . $i . ';alias trashcan_cycle trashcan_diceroll_' . $next . '"';
        $response[] = $alias;
    }
    $limitLessOne = $limit - 1;
    $response[] = 'alias "trashcan_diceroll_' . $limitLessOne . '" "alias trashcan_result trashcan' . $limitLessOne . ';alias trashcan_cycle trashcan_diceroll_0"'; //loop it back up
    return $response;
}


function getUpvotedTextRowsForCfg($limit = 2000)
{
    $response = [];
    $limit_escaped = mysql_escape_mimic($limit);
    $sql = "SELECT *, `upvotes` - `downvotes` AS `netVotes` FROM shittalk WHERE (`upvotes` - `downvotes`) >= 5 ORDER by upvotes DESC LIMIT $limit_escaped;";
    $result = mySqlQuery($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response[] = $row['text'];
        }
    }
    return $response;
}

function timestampDownload()
{
    date_default_timezone_set('America/New_York');
    $timestamp = date('Y-m-d G:i:s');


    $sql = "UPDATE `timestamps`
            SET uses = uses + 1,
            last_use = '$timestamp'
            WHERE `action` = 'download';";
    mySqlQuery($sql);

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
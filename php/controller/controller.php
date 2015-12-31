<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 12/31/2015
 * Time: 12:44 AM
 */


require_once(__DIR__ . '/../shittalk_functions.php');

//set_time_limit(0);
//error_reporting(E_ALL);
//ob_implicit_flush(TRUE);
//ob_end_flush();

$post = file_get_contents('php://input');    //workaround for $_POST, this data arrives in the form of a URL
$postdec = json_decode($post, true);

if (isset($postdec['query'])) {
    $query = $postdec['query'];

    $response = '';

    if (!empty($query)) {

        switch ($query) {

            case 'create_Shittalk':
                if (!empty($postdec['create_shittalk_Text'])) {
                    $response = createShittalkRow($postdec['create_shittalk_Text']); //returns true if successful, false otherwise
                }
                break;

            case 'upvote_Row':
                if (!empty($postdec['text'])) {
                    $response = upvoteRow($postdec['text']); //returns true if successful, false otherwise
                }
                break;
        }

    }
    returnResponse($response); //sends back the message
}

function createShittalkRow($text)
{
    $text_escaped = mysql_escape_mimic($text);
    $today = mysql_escape_mimic(date("Y-m-d H:i:s"));

    $sql = "INSERT INTO `shittalkDB`
            (`text`, `date_created`)
            VALUES ('$text_escaped', '$today');";
    $result = mySqlQuery($sql);

    return $result;
}

function upvoteRow($text){
    $text_escaped = mysql_escape_mimic($text);
    $sql = "UPDATE shittalkDB SET upvotes = upvotes + 1 WHERE text LIKE '$text_escaped';";
    $result = mySqlQuery($sql);

    return $result;
}
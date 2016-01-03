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
                if (!empty($postdec['id'])) {
                    $response = upvoteRow($postdec['id']); //returns true if successful, false otherwise
                }
                break;

            case 'downvote_Row':
                if (!empty($postdec['id'])) {
                    $response = downvoteRow($postdec['id']); //returns true if successful, false otherwise
                }
                break;

            case 'get_RandomRows':
                if (!empty($postdec['limit'])) {
                    $response = getRandomRows($postdec['limit']); //returns true if successful, false otherwise
                }
                break;

            case 'check_IfDuplicate':
                if (!empty($postdec['create_shittalk_Text'])) {
                    $response = checkIfDuplicate($postdec['create_shittalk_Text']); //returns true if successful, false otherwise
                }
                break;
        }

    }
    returnResponse($response); //sends back the message
}


function checkIfDuplicate($text)
{
    $response = 0;
    $text_escaped = mysql_escape_mimic($text);
    $sql = "SELECT COUNT(*) AS `total` FROM shittalkDB WHERE `text` = '$text_escaped';";
    $result = mySqlQuery($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response = $row['total'];
        }
    }
    return $response;
}

function getRandomRows($limit)
{
    $response = [];
    $limit_escaped = (int)$limit;
    $sql = "SELECT * FROM shittalkDB ORDER BY rand() LIMIT $limit_escaped;";
    $result = mySqlQuery($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response[] = $row;
        }
    }
    return $response;
}

function createShittalkRow($text)
{
    if (strlen($text) > 128) {
        $text = substr($text, 0, 128); //shorten to source game default length
    }
    $text_escaped = mysql_escape_mimic(strip_double_quotes($text));
    $today = mysql_escape_mimic(date("Y-m-d H:i:s"));

    $sql = "INSERT INTO `shittalkDB`
            (`text`, `date_created`, `custom`)
            VALUES ('$text_escaped', '$today', 1);";
    $result = mySqlQuery($sql);

    return $result;
}

function upvoteRow($id)
{
    $id_escaped = mysql_escape_mimic($id);
    $sql = "UPDATE shittalkDB SET upvotes = upvotes + 1 WHERE `id` = $id_escaped;";
    $result = mySqlQuery($sql);

    return $result;
}

function downvoteRow($id)
{
    $id_escaped = mysql_escape_mimic($id);
    $sql = "UPDATE shittalkDB SET downvotes = downvotes + 1 WHERE `id` = $id_escaped;";
    $result = mySqlQuery($sql);

    return $result;
}
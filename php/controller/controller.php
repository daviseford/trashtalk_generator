<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 12/31/2015
 * Time: 12:44 AM
 */

require_once(__DIR__ . '/../shittalk_functions.php');
require_once(__DIR__ . '/../lib/forceutf8/Encoding.php');
use ForceUTF8\Encoding;  // It's namespaced now.

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

            case 'check_IfDuplicate':
                if (!empty($postdec['create_shittalk_Text'])) {
                    $response = checkIfDuplicate($postdec['create_shittalk_Text']); //returns true if successful, false otherwise
                }
                break;

            case 'get_RandomRows':
                if (!empty($postdec['limit'])) {
                    $response = getRandomRows($postdec['limit']); //returns true if successful, false otherwise
                }
                break;

            case 'get_RateMoreTableRows':
                $response = createRateMoreTableRows(); //returns an array of table rows
                break;

            case 'get_RandomList':
                $response = getRandomList();
                break;

            case 'get_TopList':
                $response = getTopList();
                break;

            case 'get_RecentList':
                $response = getRecentList();
                break;

            case 'get_TotalBindCount':
                $response = getTotalBindCount();
                break;

            case 'get_IncludedBindCount':
                $response = getIncludedBindCount();
                break;

        }

    }
    returnResponse($response); //sends back the message
}


function getRecentList()
{
    $sql = "SELECT `id`, `text`, `upvotes`-`downvotes` AS `netVotes` FROM shittalkDB WHERE (`upvotes` - `downvotes`) > -5 ORDER by `date_created` DESC LIMIT 20;";
    $result = mySqlQuery($sql);
    $response = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response[] = array(
                'id'       => $row['id'],
                'netVotes' => $row['netVotes'],
                'text'     => htmlspecialchars($row['text'])
            );
        }
    }
    return $response;
}

function getTopList()
{
    $sql = "SELECT `id`, `text`, `upvotes`-`downvotes` AS `netVotes` FROM shittalkDB ORDER by `netVotes` DESC LIMIT 50;";
    $result = mySqlQuery($sql);
    $response = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response[] = array(
                'id'       => $row['id'],
                'netVotes' => $row['netVotes'],
                'text'     => htmlspecialchars($row['text'])
            );
        }
    }
    return $response;
}

function getRandomList()
{
    $sql = "SELECT `id`, `text`, `upvotes`-`downvotes` AS `netVotes` FROM shittalkDB WHERE (`upvotes` - `downvotes`) > -5 ORDER by rand() DESC LIMIT 20;";
    $result = mySqlQuery($sql);
    $response = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response[] = array(
                'id'       => $row['id'],
                'netVotes' => $row['netVotes'],
                'text'     => htmlspecialchars($row['text'])
            );
        }
    }
    return $response;
}

function createRateMoreTableRows()
{
    $sql = "SELECT `id`, `text`, `upvotes` - `downvotes` AS `netVotes` FROM shittalkDB WHERE (`upvotes` - `downvotes`) > -5 ORDER BY rand() LIMIT 25;";
    $result = mySqlQuery($sql);

    $response = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tr = '<tr id="ratemoreid_' . $row['id'] . '"><td><span class="glyphicon glyphicon-arrow-up text-success vote-arrow"  aria-hidden="true"> </span> <span class="glyphicon glyphicon-arrow-down text-danger vote-arrow" aria-hidden="true"></span></td><td>' . htmlspecialchars($row['text']) . '</td></tr>';
            $response[] = $tr;
        }
    }
    return $response;
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
    $randomInt = rand(0, 15);

    /* Let's try to target stuff without votes first */
    if ($randomInt <= 3) { //let's not bias it too much in favor, but we do want to include some new stuff when possible

        $sql = "SELECT `id`, `text` FROM shittalkDB WHERE `upvotes` < 2 AND `downvotes` < 2 AND `text`<>'' ORDER BY rand() LIMIT 1;";
        $result = mySqlQuery($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $text = $row['text'];
                $row['text'] = htmlspecialchars($text);
                $response[] = $row;
            }
            if (!empty($response)) {
                $limit_escaped--; //decrement the limit, as it'll be used by the normal, all-encompassing query
            }
        }
    }

    $sql = "SELECT `id`, `text` FROM shittalkDB WHERE (`upvotes` - `downvotes`) > -5 AND `text`<>'' ORDER BY rand() LIMIT $limit_escaped;";
    $result = mySqlQuery($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $text = $row['text'];
            $row['text'] = htmlspecialchars($text);
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

    $text_to_utf8 = Encoding::toUTF8($text);
    $text = Encoding::fixUTF8($text_to_utf8);
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
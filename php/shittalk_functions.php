<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 12/31/2015
 * Time: 12:31 AM
 */

/*
 * function mySqlQuery($query)
 * function mysql_escape_mimic($inp)
 * function returnResponse($response)
 *
 * function getIncludedBindCount()
 * function getTotalBindCount(){
 */

function getTotalUpvotes()
{
    $inDB_count = 0;
    $deleted_count = 0;
    $sql = "SELECT sum(`upvotes`) AS `count` FROM shittalk;";
    $result = mySqlQuery($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $inDB_count = $row['count'];
        }
    }

    $sql = "SELECT sum(`upvotes_deleted`) AS `count` FROM timestamps;";
    $result = mySqlQuery($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $deleted_count = $row['count'];
        }
    }

    $totalUpvotes = $inDB_count + $deleted_count;


    return $totalUpvotes;
}

function getTotalDownloads()
{
    $downloads = 0;
    $sql = "SELECT `uses` AS `count` FROM timestamps WHERE `action` = 'download' LIMIT 1;";
    $result = mySqlQuery($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $downloads = $row['count'];
        }
    }

    return $downloads;
}

function getTotalDownvotes()
{
    $inDB_count = 0;
    $deleted_count = 0;
    $sql = "SELECT sum(`downvotes`) AS `count` FROM shittalk;";
    $result = mySqlQuery($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $inDB_count = $row['count'];
        }
    }

    $sql = "SELECT sum(`downvotes_deleted`) AS `count` FROM timestamps;";
    $result = mySqlQuery($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $deleted_count = $row['count'];
        }
    }

    $totalDownvotes = $inDB_count + $deleted_count;


    return $totalDownvotes;
}

function getAverageVotesForConfigInsults()
{

    $response = 0;
    $sql = "SELECT sum(`upvotes`) + sum(`downvotes`) AS `totalVotes`, COUNT(*) AS `count` FROM shittalk WHERE (`upvotes` - `downvotes`) >= 5 ORDER by upvotes DESC LIMIT 1;";
    $result = mySqlQuery($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response = $row['totalVotes'] / $row['count'];
        }
    }
    return $response;

}

function getTotalSubmissionCount()
{
    $response = [];
    $sql = "SELECT MAX(id) AS `count` FROM shittalk ORDER BY id DESC LIMIT 1;";
    $result = mySqlQuery($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response = $row['count'];
        }
    }
    return $response;
}

function getActiveVoteStats()
{
    $response = [];
    $sql = "SELECT sum(`upvotes`) + sum(`downvotes`) AS `total`, sum(`upvotes`) AS `upvoteTotal`, sum(`downvotes`) AS `downvoteTotal` FROM shittalk ORDER BY id DESC LIMIT 1;";
    $result = mySqlQuery($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response['total'] = $row['total'];
            $response['upvoteTotal'] = $row['upvoteTotal'];
            $response['downvoteTotal'] = $row['downvoteTotal'];
        }
    }
    return $response;
}

function getDeletedStats()
{
    $response = [];
    $sql = "SELECT * FROM timestamps WHERE `action` = 'delete_Downvoted';";
    $result = mySqlQuery($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response = $row;
        }
    }
    return $response;
}


function getIncludedBindCount()
{
    $response = [];
    $sql = "SELECT COUNT(*) AS `count` FROM shittalk WHERE (`upvotes` - `downvotes`) >= 5;";
    $result = mySqlQuery($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response = $row['count'];
        }
    }
    return $response;
}

function getTotalBindCount()
{
    $response = '';
    $sql = "SELECT COUNT(*) AS `count` FROM shittalk;";
    $result = mySqlQuery($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response = $row['count'];
        }
    }
    return $response;
}


/*
 * Connect to testSchema and execute a query
 * Returns the query result
 */
function mySqlQuery($query)
{
    $servername = 'shittalk.cinwj67fm5hu.us-east-1.rds.amazonaws.com';
    $username = "shittalk";
    $password = "shittalk";
    $dbname = "shittalk";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $result = $conn->query($query);

    $conn->close();

    return $result;
}

function mysql_escape_mimic($inp)
{
    if (is_array($inp))
        return array_map(__METHOD__, $inp);

    if (!empty($inp) && is_string($inp)) {
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
    }

    return $inp;
}

/* RETURNS WHATEVER WE ASKED FOR IN THE QUERY */
function returnResponse($response)
{
    header('Content-type: application/json; charset=utf-8');
    if (!empty($response)) {
        echo json_encode($response);
    } else {
        echo json_encode('');
    }
}


function strip_double_quotes($string)
{
    $search = array(
        '"',
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
        chr(133),
        '//');

    $replace = array(
        "'",
        "'",
        "'",
        "'",
        "'",
        "'",
        "'",
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
        '...',
        '/');

    return str_replace($search, $replace, $string);
}
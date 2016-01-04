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
 */


/*
 * Connect to testSchema and execute a query
 * Returns the query result
 */
function mySqlQuery($query)
{
    $servername = 'testprocess.db';
    $username = "shittalk_user";
    $password = "Gq^qycnL6OByhMS";
    $dbname = "shittalk_generator";

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
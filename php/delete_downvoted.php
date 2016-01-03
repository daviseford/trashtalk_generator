<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 1/2/2016
 * Time: 5:39 PM
 */
require_once(__DIR__ . '/shittalk_functions.php');

$rowsToDelete = getRowsForDeletion(); //an array of ids to delete

if (!empty($rowsToDelete)) {
    deleteAllSelectedRows($rowsToDelete);
} else {
    echo 'No rows suitable for deletion<br />';
}
timestampDeletion();

function getRowsForDeletion()
{
    $response = [];
    $sql = "SELECT *, `upvotes` - `downvotes` AS `netVotes` FROM shittalkDB WHERE downvotes > 0;";
    $result = mySqlQuery($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['netVotes'] < -4) {
                $response[] = $row['id'];
            }
        }
    }
    return $response;
}

function deleteAllSelectedRows($arrayOfIDs)
{
    for ($i = 0; $i < count($arrayOfIDs); $i++) {
        $id = $arrayOfIDs[$i];
        $sql = "DELETE FROM shittalkDB WHERE `id` = $id;";
        $result = mySqlQuery($sql);
        if ($result === 1) {
            echo 'Deleted row ' . $id . '<br />';
        }
    }


}


function timestampDeletion()
{
    date_default_timezone_set('America/New_York');
    $timestamp = date('Y-m-d G:i:s');

    $sql = "UPDATE `timestamps`
            SET uses = uses + 1,
            last_use = '$timestamp'
            WHERE `action` = 'delete_Downvoted';";
    $result = mySqlQuery($sql);

    if ($result === true) {
        echo 'Updated timestamp<br />';
    } else {
        var_dump($result);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 1/2/2016
 * Time: 5:39 PM
 */
require_once(__DIR__ . '/shittalk_functions.php');

$rowsToDelete = getRowsForDeletion(); //an array of ids to delete
$count = count($rowsToDelete);

if (!empty($rowsToDelete)) {
    deleteAllSelectedRows($rowsToDelete);
} else {
    echo 'No rows suitable for deletion<br />';
}
timestampDeletion($count);

function getRowsForDeletion()
{
    $response = [];
    $sql = "SELECT *, `upvotes` - `downvotes` AS `netVotes` FROM shittalkDB WHERE downvotes > 0;";
    $result = mySqlQuery($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $totalVotes = $row['upvotes'] + $row['downvotes'];
            $threshold = $totalVotes * 0.55;

            /* Scaling metric of when to delete
             * For new stuff (under 70 votes), we'll use a hard indicator of poor quality - having -5 net votes
             *
             * The math of 55 percent:
             * at 70 total votes: requires 38 downvotes (vs. 32 upvotes, difference of 6) to delete
             * at 200 total votes: requires 110 downvotes (vs 90 upvotes, diff of 20) to deletion
             * at 1000 total votes: requires 550 downvotes (vs 450 upvotes, diff of 100) to delete
             *
             * Well, that 1000 total vote bit makes it harder. That's a lot of downwards pressure.
             * On the other hand, how likely is it that a truly bad insult will rise that high?
             * It theoretically should have been taken care of in the first 70 votes.
             *
             * The goal of the harder deletion is to 'preserve' insults - if something rose high initially, there's
             * a chance people really like it, and subjecting it to a trival -5 death is not desirable
             * for an insult that might have thousands of votes.
             *
             * TODO: Come back and check on the progress of how the scoring works.
             * I'm going to guess it won't work very well at scale.
             * I'll probably need some fancier math to keep a consistent way of bridging the gap.
             */
            if ($totalVotes >= 70) { //only use threshold once it's large enough
                if ($threshold <= $row['downvotes']) {
                    $response[] = $row['id'];
                }
            } else {
                if ($row['netVotes'] <= -5) {
                    $response[] = $row['id'];
                }
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
        if ($result === 1 || $result === true) {
            echo 'Deleted row ' . $id . '<br />';
        }
    }


}


function timestampDeletion($count = 0)
{
    date_default_timezone_set('America/New_York');
    $timestamp = date('Y-m-d G:i:s');
    $count_escaped = mysql_escape_mimic($count);

    $sql = "UPDATE `timestamps`
            SET uses = uses + 1,
            last_use = '$timestamp',
            num_deleted = num_deleted + '$count_escaped'
            WHERE `action` = 'delete_Downvoted';";
    $result = mySqlQuery($sql);

    if ($result === true) {
        echo 'Updated timestamp<br />';
    } else {
        var_dump($result);
    }

}
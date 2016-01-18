<?php
require_once(__DIR__ . '/php/shittalk_functions.php');

$totalUpvotes = getTotalUpvotes();
$totalDownvotes = getTotalDownvotes();
$totalVotes = $totalUpvotes + $totalDownvotes;
$activeVoteStats = getActiveVoteStats();
$totalActiveVotes = $activeVoteStats['total'];
$totalActiveUpvotes = $activeVoteStats['upvoteTotal'];
$totalActiveDownvotes = $activeVoteStats['downvoteTotal'];
$totalBindCount = getTotalBindCount();
$totalSubmissionCount = getTotalSubmissionCount();
$deletionStats = getDeletedStats();
$totalDeletedInsultCount = $deletionStats['num_deleted'];
$totalDeletedUpvoteCount = $deletionStats['upvotes_deleted'];
$totalDeletedDownvoteCount = $deletionStats['downvotes_deleted'];

$includedBindCount = getIncludedBindCount();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<!--    <meta name="description" content="Page Description">-->
    <meta name="author" content="Davis">
    <title>Stats</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Votes</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Total Votes</td>
                    <td><?php echo number_format($totalVotes); ?></td>
                </tr>

                <tr>
                    <td>Total Active Votes (votes on binds that haven't been deleted)</td>
                    <td><?php echo number_format($totalActiveVotes); ?></td>
                </tr>

                <tr>
                    <td>Total Active Upvotes</td>
                    <td><?php echo number_format($totalActiveUpvotes); ?></td>
                </tr>

                <tr>
                    <td>Total Active Downvotes</td>
                    <td><?php echo number_format($totalActiveDownvotes); ?></td>
                </tr>


                <tr>
                    <td>Total Deleted Upvotes</td>
                    <td><?php echo number_format($totalDeletedUpvoteCount); ?></td>
                </tr>

                <tr>
                    <td>Total Deleted Downvotes</td>
                    <td><?php echo number_format($totalDeletedDownvoteCount); ?></td>
                </tr>
                <tr>
                    <td>Total Upvotes (includes upvotes on deleted submissions)</td>
                    <td><?php echo number_format($totalUpvotes); ?></td>
                </tr>
                <tr>
                    <td>Total Downvotes (includes downvotes on deleted submissions)</td>
                    <td><?php echo number_format($totalDownvotes); ?></td>
                </tr>


                </tbody>
            </table>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Submissions</th>
                </tr>
                </thead>
                <tbody>
                <tr>

                    <td> Total Submissions</td>
                    <td><?php echo number_format($totalSubmissionCount); ?></td>
                </tr>

                <tr>
                    <td>Total Binds In Database</td>
                    <td>
                        <?php echo number_format($totalBindCount); ?>
                    </td>
                </tr>


                <tr>
                    <td>Total Deleted Submissions</td>
                    <td><?php echo number_format($totalDeletedInsultCount); ?></td>
                </tr>

                </tbody>
            </table>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Config</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Total Binds In Config (must be rated +5 net votes)</td>
                    <td>
                        <?php echo number_format($includedBindCount); ?>
                    </td>
                </tr>

                <tr>
                    <td>Average Votes (each bind)</td>
                    <td>
                        <?php echo number_format(round(getAverageVotesForConfigInsults())); ?>
                    </td>
                </tr>

                <tr>
                    <td>Downloads</td>
                    <td>
                        <?php echo number_format(getTotalDownloads()); ?>
                    </td>
                </tr>


                </tbody>
            </table>
        </div>

    </div>
</div>


</body>
</html>
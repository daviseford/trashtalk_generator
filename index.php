<?php
require_once(__DIR__ . '/php/shittalk_functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shittalk Generator</title>

    <!-- jQuery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <!-- SweetAlert CSS and JS -->
    <link rel="stylesheet" type="text/css" href="js/libraries/sweetalert/css/sweetalert.css">
    <script src="js/libraries/sweetalert/js/sweetalert.min.js" type="text/javascript"></script>

    <!-- Bootstrap Select CSS and JS -->
    <link href='js/libraries/bootstrap-select/css/bootstrap-select.min.css' rel='stylesheet'/>
    <script src="js/libraries/bootstrap-select/js/bootstrap-select.min.js"></script>

    <script src="js/shittalk.js"></script>

    <!-- Google Analytics -->
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-55820654-2', 'auto');
        ga('require', 'linkid', 'linkid.js');
        ga('send', 'pageview');

    </script>
</head>
<body>

<div class="jumbotron">
    <div class="container">
        <h1>Welcome to the Shittalk Generator</h1>
        <p>Help us out by rating this bind:</p>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php

                    $sql = "SELECT * FROM shittalkDB ORDER BY rand() LIMIT 1;";
                    $result = mySqlQuery($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $netVotes = $row['upvotes'] - $row['downvotes'];
                            $tr = '<span class="glyphicon glyphicon-arrow-up text-success" aria-hidden="true" title="' . $row['text'] . '"> </span> <span class="glyphicon glyphicon-arrow-down text-danger" aria-hidden="true" title="' . $row['text'] . '"></span>  <strong>' . $row['text'] . '</strong>';
                            echo $tr;
                        }
                    }

                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
        <div class="row clearfix"></div>
        <p>There may be additional features added, such as a rough imitation of machine learning to produce new insults.
            Let's get bayesian.
        </p>
        <p class="small">Coming soon: Download these binds to an easy-to-use Source script, which will work in TF2,
            Counterstrike, Dota, and all Source Engine games.</p>
    </div>
</div>

<div class="container">
    <form class="form-horizontal" role="form">

        <div class="form-group">
            <label for="create_shittalk_Text" class="col-sm-3 control-label">Create your own:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="create_shittalk_Text" placeholder="">
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3">
                <button type="submit" id="create_shittalk_Btn" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <legend>Rate Some More</legend>
        <div class="table-responsive">
            <table class="table">

                <!--                <thead>-->
                <!--                <tr>-->
                <!--                    <th>th is 0</th>-->
                <!--                    <th>th is 1</th>-->
                <!--                </tr>-->
                <!--                </thead>-->
                <tbody>


                <?php

                $sql = "SELECT *, `upvotes` - `downvotes` AS `netVotes` FROM shittalkDB ORDER BY rand() LIMIT 25;";
                $result = mySqlQuery($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $netVotes = $row['upvotes'] - $row['downvotes'];
                        $tr = '<tr><td><span class="glyphicon glyphicon-arrow-up text-success" aria-hidden="true" title="' . $row['text'] . '"> </span> <span class="glyphicon glyphicon-arrow-down text-danger" aria-hidden="true" title="' . $row['netVotes'] . '"></span> ' . $netVotes . ' points</td><td>' . $row['text'] . '</td></tr>';
                        echo $tr;
                    }
                }


                ?>
                </tbody>
            </table>
        </div>

    </div>
</div>


</body>
</html>
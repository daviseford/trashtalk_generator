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

    <!-- String -->
    <script src="js/libraries/string/string.min.js"></script>

    <link rel="stylesheet" type="text/css" href="css/shittalk.css">

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
        <p>Help us out by rating these binds:</p>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody id="jumbotron_tbody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix"></div>

    </div>

</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" role="form">

                <div class="form-group">
                    <h3><label for="create_shittalk_Text" class="col-sm-3 control-label">Create your own:</label></h3>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="create_shittalk_Text" placeholder=""
                               maxlength="128" aria-describedby="helpBlock">
                        <span id="helpBlock" class="help-block hidden">This insult already exists in our database</span>
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" id="create_shittalk_Btn" class="btn btn-primary" >Submit</button>

                    </div>
                </div>


            </form>
        </div>
    </div>
    <div class="row clearfix"></div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">

                <ul class="list-group" id="recent_listGroup">
                    <li class="list-group-item"><h3 class="text-center">Recent Insults</h3></li>
                    <?php
                    $sql = "SELECT *, `upvotes`-`downvotes` AS `netVotes` FROM shittalkDB ORDER by `date_created` DESC LIMIT 12;";
                    $result = mySqlQuery($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $li = '<li class="list-group-item" id="recentid_' . $row['id'] . '"><span class="badge">' . $row['netVotes'] . '</span><span class="glyphicon glyphicon-arrow-up text-success" aria-hidden="true"> </span> <span class="glyphicon glyphicon-arrow-down text-danger" aria-hidden="true"></span> ' . $row['text'] . '</li>';
                            echo $li;
                        }
                    }
                    ?>
                </ul>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">

                <ul class="list-group" id="top_listGroup">
                    <li class="list-group-item"><h3 class="text-center">Top Insults</h3></li>
                    <?php
                    $sql = "SELECT *, `upvotes`-`downvotes` AS `netVotes` FROM shittalkDB ORDER by `netVotes` DESC LIMIT 12;";
                    $result = mySqlQuery($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $li = '<li class="list-group-item" id="topid_' . $row['id'] . '"><span class="badge">' . $row['netVotes'] . '</span><span class="glyphicon glyphicon-arrow-up text-success" aria-hidden="true"> </span> <span class="glyphicon glyphicon-arrow-down text-danger" aria-hidden="true"></span> ' . $row['text'] . '</li>';
                            //<span class="badge">' . $row['netVotes'] . '</span>
                            echo $li;
                        }
                    }
                    ?>
                </ul>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <p><a href="php/build_cfg.php" class="btn btn-lg btn-block btn-success">
                            <span class="glyphicon glyphicon-cloud-download" title="generated shittalk.cfg"
                                  id="downloadBtn"></span> Download Current Build</a>
                        </p>
                        <p class="small text-center pull-right">Includes all upvoted insults</p>
                        <div class="row clearfix"></div>
                        <p></p>
                        <p>Download these binds to an easy-to-use Source script, which works in TF2,
                            CS:GO, CS:Source, DoTA2, and all other Source Engine games.</p>
                        <p><h4>Installation:</h4>
                        <ul>
                            <li>Drag shittalk.cfg to your game's cfg folder. For TF2: <code>\Steam\steamapps\common\Team
                                    Fortress 2\tf\cfg</code>
                            </li>
                            <li>Add <code>"exec shittalk.cfg"</code> to your autoexec.cfg.</li>
                            <li>Alternatively, add <code>+exec shittalk.cfg</code> to your game's launch options.</li>
                            <li>By default, <code>TAB</code> cycles through the insults, and <code>X</code> sends the
                                message to chat.
                            </li>
                            <li>You can modify these binds in the shittalk.cfg file.</li>
                            <li>The more keys you can bind <code>cycle_both</code> to, the better. The
                                <code>cycle_both</code> command is what
                                provides the psuedo-randomness of the script.
                            </li>
                        </ul>
                        </p>


                        <div class="row clearfix"></div>
                        <br/>
                        <p class="small">Looking for the original shittalk.cfg? <br/>
                            <a href="cfg/shittalkcfg.rar"
                               class="btn btn-primary btn-block"
                               title="shittalk.cfg by Davis Ford">
                                <span class="glyphicon glyphicon-download-alt"></span> Download Shittalk Classic</a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <legend>Rate Some More - <?php
                $sql = "SELECT COUNT(*) AS `total` FROM shittalkDB;";
                $result = mySqlQuery($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<small>' . $row['total'] . ' insults and counting</small>';
                    }
                }
                ?> </legend>
            <div class="table-responsive">
                <table class="table">

                    <tbody id="rate_more_tbody">


                    <?php

                    $sql = "SELECT *, `upvotes` - `downvotes` AS `netVotes` FROM shittalkDB ORDER BY rand() LIMIT 25;";
                    $result = mySqlQuery($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $netVotes = $row['upvotes'] - $row['downvotes'];
                            $tr = '<tr id="ratemoreid_' . $row['id'] . '"><td><span class="glyphicon glyphicon-arrow-up text-success" style="font-size:1.4em;" aria-hidden="true"> </span> <span class="glyphicon glyphicon-arrow-down text-danger" style="font-size:1.4em;" aria-hidden="true"></span></td><td>' . $row['text'] . '</td></tr>';
                            echo $tr;
                        }
                    }


                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="container content">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="testimonials">
                <div class="active item">
                    <blockquote><p>
                            He finally found solice in a little thing, so simple, yet so sweet. Being
                            mean to other individuals in the team fortress 2 community. This device
                            which he has created has made it possible for others to share in his
                            happiness. Laughter Is his Job, Tears Are his Game, creating this (I want to call it an
                            app?) is his profession.
                            This is who Davis is, this is the last thing that he wants from the TF2 community.
                            ... Davis 2016.</p></blockquote>
                    <div class="carousel-info">
                        <img alt="" src="img/avatar_2x.png" class="pull-left">
                        <div class="pull-left">
                            <span class="testimonials-name">Dave__AC</span>
                            <span class="testimonials-post">Professional Human</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>

<!-- Shittalk -->
<script src="js/shittalk.js"></script>
</html>
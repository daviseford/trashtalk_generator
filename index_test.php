<?php
require_once(__DIR__ . '/php/shittalk_functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
    <title>Shittalk Generator</title>
    <meta name="author" content="Davis Ford">
    <meta charset="UTF-8">
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="http://daviseford.com/shittalk/"/>
    <meta property="og:title" content="Shittalk Generator"/>
    <meta property="og:image" content="http://daviseford.com/shittalk/img/shittalk_yelling_man.jpg"/>
    <meta property="og:description"
          content="World-famous Insult Generator for TF2, DOTA2, CS:GO, and all Source Engine games. Crowd-sourced shittalk."/>

    <!-- jQuery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="css/shittalk.css">

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
                        <table class="table borderless">
                            <tbody id="jumbotron_tbody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" role="form">

                <div class="form-group">
                    <h3><label for="create_shittalk_Text" class="col-sm-3 col-xs-3 control-label">Create your
                            own:</label>
                    </h3>
                    <div class="col-sm-6 col-xs-6">
                        <input type="text" class="form-control" id="create_shittalk_Text" placeholder=""
                               maxlength="128" aria-describedby="helpBlock">
                        <span id="helpBlock" class="help-block hidden">This insult already exists in our database</span>
                        <span id="helpBlock2" class="help-block hidden">Please do not submit websites.</span>
                        <span id="helpBlock3" class="help-block hidden">Be cool.</span>
                    </div>
                    <div class="col-sm-3 col-xs-3">
                        <button type="submit" id="create_shittalk_Btn" class="btn btn-primary">Submit</button>

                    </div>
                </div>


            </form>
        </div>
    </div>

    <div class="row clearfix"></div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 hidden-xs">

                <li class="list-group-item"><h3 class="text-center">Recent Insults</h3></li>
                <ul class="list-group def-list-group-scroll" id="recent_listGroup">

                </ul>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

                <li class="list-group-item"><h3 class="text-center">Top Insults</h3></li>
                <ul class="list-group def-list-group-scroll" id="top_listGroup">

                </ul>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 hidden-xs">
                <li class="list-group-item"><h3 class="text-center">Random Insults</h3></li>
                <ul class="list-group def-list-group-scroll" id="random_listGroup">


                </ul>
            </div>

        </div>
    </div>

    <div class="row clearfix"></div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">

                        <a href="php/build_cfg.php"
                           class="btn btn-lg btn-success">
                            <span class="glyphicon glyphicon-cloud-download" title="generated shittalk.cfg"
                                  id="downloadBtn"></span> Download Current Build</a>
                        <p class="small" style="padding-top: 2px;">Includes
                            <strong><?php echo getIncludedBindCount(); ?></strong>
                            top-rated insults</p>
                    </div>

                    <div class="row clearfix"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <p>Download these binds to an easy-to-use Source script, which works in TF2,
                                CS:GO, CS:Source, DoTA2, and all other Source Engine games.</p>
                            <p><h4>Installation:</h4>

                            <p>
                                1.) Drag <code>shittalk.cfg</code> to your game's <code>cfg</code> folder. </p>
                            <p>

                                <strong>TF2 - </strong><code>\Steam\steamapps\common\Team Fortress 2\tf\cfg</code><br/>
                                <strong>DoTA2 - </strong><code>\Steam\steamapps\common\dota 2
                                    beta\game\dota\cfg</code><br/>
                                <strong>CS:GO - </strong><code>\Steam\steamapps\common\Counter-Strike Global
                                    Offensive\csgo\cfg</code>
                            </p>

                            <p>2.) Add <code>exec shittalk.cfg</code> to your <code>autoexec.cfg</code>.</p>
                            <p>3.) Alternatively, add <code>+exec shittalk.cfg</code> to your game's launch options.</p>
                            <p>4.) You can now launch your game. To ensure <code>shittalk.cfg</code> loaded correctly,
                                open
                                console and type <code>exec shittalk</code>.</p>
                            <p>5.) By default, <kbd>TAB</kbd> cycles through the insults, and <kbd>X</kbd> sends the
                                message
                                to
                                chat.
                            </p>
                            <p>You can modify these binds in the <code>shittalk.cfg</code> file.</p>
                            <p>The more keys you can bind <code>cycle_both</code> to, the better. The
                                <code>cycle_both</code> command is what
                                provides the psuedo-randomness of the script.

                            </p>
                        </div>
                    </div>


                    <div class="row clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p class="small">Looking for the original shittalk.cfg? <br/>
                                <a href="cfg/shittalkcfg.rar"
                                   class="btn btn-primary btn-md"
                                   title="shittalk.cfg by Davis Ford">
                                    <span class="glyphicon glyphicon-download-alt"></span> Download Shittalk Classic</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <legend>Rate Some More
                - <?php echo '<small>' . getTotalBindCount() . ' insults and counting</small>'; ?> </legend>
            <div class="table-responsive">
                <table class="table">

                    <tbody id="rate_more_tbody">


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
                            He finally found solace in a little thing, so simple, yet so sweet.</p>

                        <p> Being mean to other individuals in the Team Fortress 2 community. This device
                            which he has created has made it possible for others to share in his
                            happiness.</p>

                        <p>Laughter Is His Job, Tears Are His Game, creating this (I want to call it an
                            app?) is his profession.</p>
                        <p>This is who Davis is, this is the last thing that he wants from the TF2 community.
                        </p>
                        <p> Davis 2016.</p></blockquote>
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

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <small>Copyright Davis Ford 2016 | What is the odds?</small>
            <br/>
            <br/>
        </div>
    </div>
</div>


</body>

<!-- SweetAlert CSS and JS -->
<!--    <link rel="stylesheet" type="text/css" href="js/libraries/sweetalert/css/sweetalert.css">-->
<!--    <script src="js/libraries/sweetalert/js/sweetalert.min.js" type="text/javascript"></script>-->

<!-- Bootstrap Select CSS and JS -->
<!--    <link href='js/libraries/bootstrap-select/css/bootstrap-select.min.css' rel='stylesheet'/>-->
<!--    <script src="js/libraries/bootstrap-select/js/bootstrap-select.min.js"></script>-->

<!-- String -->
<script src="js/libraries/string/string.min.js"></script>


<!-- Shittalk -->
<script src="js/shittalk_test.js"></script>
<!-- What is the odds? -->

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

</html>
<?php
/* Credit: http://betterexplained.com/articles/how-to-optimize-your-site-with-gzip-compression/ */
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start('ob_gzhandler'); else ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Davis Ford">
    <meta name="description"
          content="World-famous Shittalk Generator for TF2, DOTA2, CS:GO, and all Source Engine games. Crowd-sourced insults compiled into one easy config."/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="http://daviseford.com/shittalk/"/>
    <meta property="og:title" content="Shittalk Generator"/>
    <meta property="og:image" content="http://daviseford.com/shittalk/img/shittalk_yelling_man.jpg"/>
    <meta property="og:description"
          content="World-famous Shittalk Generator for TF2, DOTA2, CS:GO, and all Source Engine games. Crowd-sourced insults compiled into one easy config."/>

    <title>Shittalk Generator</title>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="css/shittalk.min.css">

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

                        <div class="form-group col-md-6">
                            <a href="php/build_cfg.php"
                               class="btn btn-lg btn-success">
                            <span class="glyphicon glyphicon-cloud-download" title="Crowd-sourced Shittalk.cfg"
                                  id="downloadBtn"></span> Download Current Build</a>

                        <span class="help-block">Includes
                            <strong><span id="IncludedBindCount"></span></strong>
                            top-rated insults
                        </span>
                        </div>

                        <div class="form-group col-md-6">
                            <a href="php/build_cfg_dota2.php"
                               class="btn btn-lg btn-success">
                            <span class="glyphicon glyphicon-cloud-download" title="Shittalk.cfg for DoTA2"
                                  id="downloadBtn"></span> DoTA2 Build</a>
                            <span class="help-block">Includes
                            <strong>150</strong>
                            top-rated insults<a href="#dota2"><strong>*</strong></a>
                        </span>
                        </div>

                    </div>

                    <div class="row clearfix"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <p>Download these binds to an easy-to-use Source script, which works in TF2,
                                CS:GO, CS:Source, DoTA2, and all other Source Engine games.</p>
                            <h4>Installation:</h4>

                            <p>
                                1.) Drag <code>shittalk.cfg</code> to your game's <code>cfg</code> folder.
                            </p>
                            <p>
                                <strong>TF2 - </strong><code>\Steam\steamapps\common\Team Fortress 2\tf\cfg</code>
                                <br/>
                                <strong>DoTA2 - </strong><code>\Steam\steamapps\common\dota 2
                                    beta\game\dota\cfg</code>
                                <br/>
                                <strong>CS:GO - </strong><code>\Steam\steamapps\common\Counter-Strike Global
                                    Offensive\csgo\cfg</code>
                            </p>

                            <p>2.) Add <code>exec shittalk.cfg</code> to your <code>autoexec.cfg</code>.</p>
                            <p>3.) Alternatively, add <code>+exec shittalk.cfg</code> to your game's launch options.</p>
                            <p>4.) You can now launch your game. To ensure <code>shittalk.cfg</code> loaded correctly,
                                open
                                console and type <code>exec shittalk</code>.
                            </p>
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
                            <p id="dota2"><strong>DoTA2 will not load config files past a certain length. The DoTA2
                                    config is therefore limited to 150 binds.</strong></p>
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

            <legend>Rate Some More -
                <small><span id="TotalBindCount"></span> insults and counting</small>
            </legend>

            <div class="table-responsive">
                <table class="table">
                    <tbody id="rate_more_tbody">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="padding-top: 3%">
            <a href="mailto:shittalkgenerator+website@gmail.com" class="btn btn-default btn-lg">Contact Me   <span
                    class="glyphicon glyphicon-envelope"> </span></a>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="padding-top: 3%; padding-bottom: 2%;">
            <small>Copyright <a href="http://daviseford.com/" target="_blank">Davis Ford</a> 2016 |
                <a href="https://www.youtube.com/watch?v=HW_IH0jipeU" target="_blank">What is the odds?</a></small>
        </div>
    </div>
</div>

<!-- String -->
<script src="js/libraries/string/string.min.js"></script>


<!-- Shittalk -->
<script src="js/shittalk.min.js"></script>
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
    /*credit http://stackoverflow.com/questions/15901187/how-to-set-up-page-speed-logging-for-google-analytics-in-analytics-js
     * https://developers.google.com/analytics/devguides/collection/analyticsjs/field-reference */
    ga('create', 'UA-55820654-2', {'siteSpeedSampleRate': 75});

</script>
</body>


</html>
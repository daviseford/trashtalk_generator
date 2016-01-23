<?php
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
          content="Trash Talk Script for TF2, DOTA2, CS:GO, and all Source Engine games. Crowd-sourced insults compiled into one easy config"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="http://daviseford.com/shittalk/"/>
    <meta property="og:title" content="Shittalk Generator"/>
    <meta property="og:image" content="http://daviseford.com/shittalk/img/shittalk_yelling_man.jpg"/>
    <meta property="og:description"
          content="Trash Talk Script for TF2, DOTA2, CS:GO, and all Source Engine games. Crowd-sourced insults compiled into one easy config"/>
    <title>Shittalk Generator</title>
    <style>
        html {
            font-family: sans-serif;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        body {
            margin: 0;
        }

        a {
            background-color: transparent;
        }

        strong {
            font-weight: 700;
        }

        h1 {
            margin: .67em 0;
            font-size: 2em;
        }

        code,
        kbd {
            font-family: monospace, monospace;
            font-size: 1em;
        }

        button,
        input {
            margin: 0;
            font: inherit;
            color: inherit;
        }

        button {
            overflow: visible;
        }

        button {
            text-transform: none;
        }

        button {
            -webkit-appearance: button;
        }

        button::-moz-focus-inner,
        input::-moz-focus-inner {
            padding: 0;
            border: 0;
        }

        input {
            line-height: normal;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
        }

        @font-face {
            font-family: 'Glyphicons Halflings';
            src: url(../fonts/glyphicons-halflings-regular.eot);
            src: url(../fonts/glyphicons-halflings-regular.eot?#iefix) format('embedded-opentype'), url(../fonts/glyphicons-halflings-regular.woff2) format('woff2'), url(../fonts/glyphicons-halflings-regular.woff) format('woff'), url(../fonts/glyphicons-halflings-regular.ttf) format('truetype'), url(../fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular) format('svg');
        }

        .glyphicon {
            position: relative;
            top: 1px;
            display: inline-block;
            font-family: 'Glyphicons Halflings';
            font-style: normal;
            font-weight: 400;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .glyphicon-cloud-download:before {
            content: "\e197";
        }

        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        :after,
        :before {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        html {
            font-size: 10px;
        }

        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 1.42857143;
            color: #333;
            background-color: #fff;
        }

        button,
        input {
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
        }

        a {
            color: #337ab7;
            text-decoration: none;
        }

        h1,
        h3,
        h4 {
            font-family: inherit;
            font-weight: 500;
            line-height: 1.1;
            color: inherit;
        }

        h1,
        h3 {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        h4 {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        h1 {
            font-size: 36px;
        }

        h3 {
            font-size: 24px;
        }

        h4 {
            font-size: 18px;
        }

        p {
            margin: 0 0 10px;
        }

        .text-center {
            text-align: center;
        }

        ul {
            margin-top: 0;
            margin-bottom: 10px;
        }

        code,
        kbd {
            font-family: Menlo, Monaco, Consolas, "Courier New", monospace;
        }

        code {
            padding: 2px 4px;
            font-size: 90%;
            color: #c7254e;
            background-color: #f9f2f4;
            border-radius: 4px;
        }

        kbd {
            padding: 2px 4px;
            font-size: 90%;
            color: #fff;
            background-color: #333;
            border-radius: 3px;
            -webkit-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .25);
            box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .25);
        }

        .container {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        @media (min-width: 768px) {
            .container {
                width: 750px;
            }
        }

        @media (min-width: 992px) {
            .container {
                width: 970px;
            }
        }

        @media (min-width: 1200px) {
            .container {
                width: 1170px;
            }
        }

        .row {
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-lg-12,
        .col-lg-3,
        .col-lg-4,
        .col-md-12,
        .col-md-3,
        .col-md-4,
        .col-md-6,
        .col-md-8,
        .col-sm-12,
        .col-sm-3,
        .col-sm-6,
        .col-xs-12,
        .col-xs-4 {
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        .col-xs-12,
        .col-xs-4 {
            float: left;
        }

        .col-xs-12 {
            width: 100%;
        }

        .col-xs-4 {
            width: 33.33333333%;
        }

        .col-xs-offset-4 {
            margin-left: 33.33333333%;
        }

        @media (min-width: 768px) {
            .col-sm-12,
            .col-sm-3,
            .col-sm-6 {
                float: left;
            }

            .col-sm-12 {
                width: 100%;
            }

            .col-sm-6 {
                width: 50%;
            }

            .col-sm-3 {
                width: 25%;
            }

            .col-sm-offset-0 {
                margin-left: 0;
            }
        }

        @media (min-width: 992px) {
            .col-md-12,
            .col-md-3,
            .col-md-4,
            .col-md-6,
            .col-md-8 {
                float: left;
            }

            .col-md-12 {
                width: 100%;
            }

            .col-md-8 {
                width: 66.66666667%;
            }

            .col-md-6 {
                width: 50%;
            }

            .col-md-4 {
                width: 33.33333333%;
            }

            .col-md-3 {
                width: 25%;
            }

            .col-md-offset-2 {
                margin-left: 16.66666667%;
            }

            .col-md-offset-0 {
                margin-left: 0;
            }
        }

        @media (min-width: 1200px) {
            .col-lg-12,
            .col-lg-3,
            .col-lg-4 {
                float: left;
            }

            .col-lg-12 {
                width: 100%;
            }

            .col-lg-4 {
                width: 33.33333333%;
            }

            .col-lg-3 {
                width: 25%;
            }
        }

        table {
            background-color: transparent;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }

        .form-control {
            display: block;
            width: 100%;
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        }

        .form-control::-moz-placeholder {
            color: #999;
            opacity: 1;
        }

        .form-control:-ms-input-placeholder {
            color: #999;
        }

        .form-control::-webkit-input-placeholder {
            color: #999;
        }

        .form-control::-ms-expand {
            background-color: transparent;
            border: 0;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .help-block {
            display: block;
            margin-top: 5px;
            margin-bottom: 10px;
            color: #737373;
        }

        .form-horizontal .form-group {
            margin-right: -15px;
            margin-left: -15px;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .btn-primary {
            color: #fff;
            background-color: #337ab7;
            border-color: #2e6da4;
        }

        .btn-success {
            color: #fff;
            background-color: #5cb85c;
            border-color: #4cae4c;
        }

        .btn-lg {
            padding: 10px 16px;
            font-size: 18px;
            line-height: 1.3333333;
            border-radius: 6px;
        }

        .jumbotron {
            padding-top: 30px;
            padding-bottom: 30px;
            margin-bottom: 30px;
            color: inherit;
            background-color: #eee;
        }

        .jumbotron h1 {
            color: inherit;
        }

        .jumbotron p {
            margin-bottom: 15px;
            font-size: 21px;
            font-weight: 200;
        }

        .jumbotron .container {
            max-width: 100%;
        }

        @media screen and (min-width: 768px) {
            .jumbotron {
                padding-top: 48px;
                padding-bottom: 48px;
            }

            .jumbotron h1 {
                font-size: 63px;
            }
        }

        .list-group {
            padding-left: 0;
            margin-bottom: 20px;
        }

        .list-group-item {
            position: relative;
            display: block;
            padding: 10px 15px;
            margin-bottom: -1px;
            background-color: #fff;
            border: 1px solid #ddd;
        }

        .list-group-item:first-child {
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }

        .panel {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .panel-body {
            padding: 15px;
        }

        .panel-default {
            border-color: #ddd;
        }

        .clearfix:after,
        .clearfix:before,
        .container:after,
        .container:before,
        .form-horizontal .form-group:after,
        .form-horizontal .form-group:before,
        .panel-body:after,
        .panel-body:before,
        .row:after,
        .row:before {
            display: table;
            content: " ";
        }

        .clearfix:after,
        .container:after,
        .form-horizontal .form-group:after,
        .panel-body:after,
        .row:after {
            clear: both;
        }

        .hidden {
            display: none !important;
        }

        @-ms-viewport {
            width: device-width;
        }

        .visible-xs {
            display: none !important;
        }

        @media (max-width: 767px) {
            .visible-xs {
                display: block !important;
            }
        }

        @media (max-width: 767px) {
            .hidden-xs {
                display: none !important;
            }
        }

        .def-list-group-scroll {
            max-height: 800px;
            overflow-y: scroll;
        }

        .def-list-group-scroll::-webkit-scrollbar {
            -webkit-appearance: none;
            width: 4px;
        }

        .def-list-group-scroll::-webkit-scrollbar-thumb {
            border-radius: 3px;
            background-color: lightgray;
            -webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .75);
        }
    </style>
</head>
<body>
<div class="jumbotron">
    <div class="container"><h1>Welcome to the Shittalk Generator</h1>
        <p>Help us out by rating these binds:</p>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div>
                        <table class="table borderless">
                            <tbody id="jumbotron_tbody"></tbody>
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
                    <div class="col-sm-3 col-md-3 col-lg-3"></div>
                    <div class="col-md-6 col-sm-6 col-xs-12"><input type="text" class="form-control"
                                                                    id="create_shittalk_Text"
                                                                    placeholder="Submit your own" maxlength="128"
                                                                    aria-describedby="helpBlock"> <span id="helpBlock"
                                                                                                        class="help-block hidden">This insult already exists in our database.</span>
                        <span id="helpBlock2" class="help-block hidden">Please do not submit websites.</span> <span
                            id="helpBlock3" class="help-block hidden">Be cool.</span></div>
                    <div class="col-md-3 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-4 col-xs-offset-4">
                        <div class="visible-xs"><br/></div>
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
                <ul class="list-group def-list-group-scroll" id="recent_listGroup"></ul>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <li class="list-group-item"><h3 class="text-center">Top Insults</h3></li>
                <ul class="list-group def-list-group-scroll" id="top_listGroup"></ul>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 hidden-xs">
                <li class="list-group-item"><h3 class="text-center">Random Insults</h3></li>
                <ul class="list-group def-list-group-scroll" id="random_listGroup"></ul>
            </div>
        </div>
    </div>
    <div class="row clearfix"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <div class="form-group col-md-6"><a href="php/build_cfg.php" class="btn btn-lg btn-success"
                                                            onClick="ga('send', 'event',{eventCategory: 'download', eventAction: 'download_latest_config', eventLabel: 'clicked'});">
                                <span class="glyphicon glyphicon-cloud-download" title="Crowd-sourced Shittalk.cfg"
                                      id="downloadBtn"></span> Download Current Build</a> <span class="help-block">Includes <strong><span
                                        id="IncludedBindCount"></span></strong> top-rated insults </span></div>
                        <div class="form-group col-md-6"><a href="php/build_cfg_dota2.php"
                                                            class="btn btn-lg btn-success"
                                                            onClick="ga('send', 'event',{eventCategory: 'download', eventAction: 'download_dota2_config', eventLabel: 'clicked'});">
                                <span class="glyphicon glyphicon-cloud-download" title="Shittalk.cfg for DoTA2"
                                      id="downloadBtn"></span> DoTA2 Build</a> <span
                                class="help-block">Includes <strong>150</strong> top-rated insults<a
                                    href="#dota2"><strong>*</strong></a> </span></div>
                    </div>
                    <div class="row clearfix"></div>
                    <div class="row">
                        <div class="col-md-12"><p>Download these binds to an easy-to-use Source script, which works in
                                TF2, CS:GO, CS:Source, DoTA2, and all other Source Engine games.</p><h4>
                                Installation:</h4>
                            <p> 1.) Drag <code>shittalk.cfg</code> to your game's <code>cfg</code> folder. </p>
                            <p><strong>TF2 - </strong><code>\Steam\steamapps\common\Team Fortress 2\tf\cfg</code> <br/>
                                <strong>DoTA2 - </strong><code>\Steam\steamapps\common\dota 2 beta\game\dota\cfg</code>
                                <br/> <strong>CS:GO - </strong><code>\Steam\steamapps\common\Counter-Strike Global
                                    Offensive\csgo\cfg</code></p>
                            <p>2.) Add <code>exec shittalk.cfg</code> to your <code>autoexec.cfg</code>.</p>
                            <p>3.) Alternatively, add <code>+exec shittalk.cfg</code> to your game's launch options.</p>
                            <p>4.) You can now launch your game. To ensure <code>shittalk.cfg</code> loaded correctly,
                                open console and type <code>exec shittalk</code>. </p>
                            <p>5.) By default, <kbd>TAB</kbd> cycles through the insults, and <kbd>X</kbd> sends the
                                message to chat. </p>
                            <p>You can modify these binds in the <code>shittalk.cfg</code> file.</p>
                            <p>The more keys you can bind <code>cycle_both</code> to, the better. The
                                <code>cycle_both</code> command is what provides the psuedo-randomness of the script.
                            </p>
                            <p id="dota2"><strong>DoTA2 will not load config files past a certain length. The DoTA2
                                    config is therefore limited to 150 binds.</strong></p></div>
                    </div>
                    <div class="row clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 text-center"><p class="small">Looking for the original shittalk.cfg? <br/>
                                <a href="cfg/shittalkcfg.rar" class="btn btn-primary btn-md"
                                   title="shittalk.cfg by Davis Ford"
                                   onClick="ga('send', 'event',{eventCategory: 'download', eventAction: 'download_classic_config', eventLabel: 'clicked'});">
                                    <span class="glyphicon glyphicon-download-alt"></span> Download Shittalk Classic</a>
                            </p></div>
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
            <div>
                <table class="table">
                    <tbody id="rate_more_tbody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="padding-top: 3%"><a
                href="mailto:shittalkgenerator+website@gmail.com" class="btn btn-default btn-lg"
                onClick="ga('send', 'event',{eventCategory: 'contact', eventAction: 'contact_button', eventLabel: 'clicked'});">
                Contact Me <span class="glyphicon glyphicon-envelope"> </span></a></div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="padding-top: 3%; padding-bottom: 2%;">
            <small>Copyright <a href="http://daviseford.com/" target="_blank">Davis Ford</a> 2016 | <a
                    href="https://www.youtube.com/watch?v=HW_IH0jipeU" target="_blank"
                    onClick="ga('send', 'event',{eventCategory: 'footer_action', eventAction: 'youtube', eventLabel: 'clicked'});">
                    What is the odds?</a> | <a href="stats.php" target="_blank"
                                               onClick="ga('send', 'event',{eventCategory: 'footer_action', eventAction: 'stats', eventLabel: 'clicked'});">
                    Stats</a></small>
        </div>
    </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" async></script>
<script src="js/shittalk_v2.min.js" async></script>
<script>(function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
        a = s.createElement(o), m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-55820654-2', 'auto');
    ga('require', 'linkid', 'linkid.js');
    ga('send', 'pageview');
    ga('create', 'UA-55820654-2', {'siteSpeedSampleRate': 50});</script>
<script>/*! loadCSS: load a CSS file asynchronously. [c]2015 @scottjehl, Filament Group, Inc. Licensed MIT */
    (function (w) {
        "use strict";
        /* exported loadCSS */
        var loadCSS = function (href, before, media) {
            var doc = w.document;
            var ss = doc.createElement("link");
            var ref;
            if (before) {
                ref = before;
            } else {
                var refs = ( doc.body || doc.getElementsByTagName("head")[0] ).childNodes;
                ref = refs[refs.length - 1];
            }
            var sheets = doc.styleSheets;
            ss.rel = "stylesheet";
            ss.href = href;
            ss.media = "only x";
            ref.parentNode.insertBefore(ss, ( before ? ref : ref.nextSibling ));
            var onloadcssdefined = function (cb) {
                var resolvedHref = ss.href;
                var i = sheets.length;
                while (i--) {
                    if (sheets[i].href === resolvedHref) {
                        return cb();
                    }
                }
                setTimeout(function () {
                    onloadcssdefined(cb);
                });
            };
            ss.onloadcssdefined = onloadcssdefined;
            onloadcssdefined(function () {
                ss.media = media || "all";
            });
            return ss;
        };
        if (typeof module !== "undefined") {
            module.exports = loadCSS;
        } else {
            w.loadCSS = loadCSS;
        }
    }(typeof global !== "undefined" ? global : this));
    loadCSS("css/shittalk.min.css");
    loadCSS("css/bootstrap.min.css");
</script>

</body>
</html>
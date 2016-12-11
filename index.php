<?php
/* Credit: http://betterexplained.com/articles/how-to-optimize-your-site-with-gzip-compression/ */
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
    ob_start('ob_gzhandler');
} else {
    ob_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Davis Ford">
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="http://daviseford.com/shittalk/"/>
    <meta property="og:title" content="Shittalk Generator"/>
    <meta property="og:image" content="http://daviseford.com/shittalk/img/shittalk_yelling_man.jpg"/>
    <meta property="og:description"
          content="Trash Talk Script for TF2, DOTA2, CS:GO, and all Source Engine games. Crowd-sourced insults compiled into one easy config"/>

    <title>Shittalk Generator</title>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" media="screen"
          href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">

</head>
<body>

<div class="jumbotron">
    <div class="container">
        <h1>Welcome to the Shittalk Generator</h1>
        <p>Help us out by rating these binds:</p>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div>
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
                    <div class="col-sm-3 col-md-3 col-lg-3">

                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control" id="create_shittalk_Text" placeholder="Submit your own"
                               maxlength="128" aria-describedby="helpBlock">
                        <span id="helpBlock"
                              class="help-block hidden">This insult already exists in our database.</span>
                        <span id="helpBlock2" class="help-block hidden">Please do not submit websites.</span>
                        <span id="helpBlock3" class="help-block hidden">Be cool.</span>
                    </div>
                    <div class="col-md-3 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-4 col-xs-offset-4">
                        <div class="visible-xs">
                            <br/>
                        </div>
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
                               class="btn btn-lg btn-success disabled">
                            <span class="glyphicon glyphicon-cloud-download" title="Shittalk.cfg for DoTA2"
                                  id="downloadBtn"></span> DoTA2 Build</a>
                            <span class="help-block">Due to <a href="http://store.steampowered.com/news/22017/" target="_blank">Valve's recent changes</a>,
                                <br />the DoTA2 script no longer works :(
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

            <div>
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
            <a href="mailto:shittalkgenerator+website@gmail.com" class="btn btn-default btn-lg">
                Contact Me <span class="glyphicon glyphicon-envelope"> </span></a>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="padding-top: 3%; padding-bottom: 2%;">
            <small>Copyright <a href="http://daviseford.com/" target="_blank">Davis Ford</a> 2016 |
                <a href="https://www.youtube.com/watch?v=HW_IH0jipeU" target="_blank">
                    What is the odds?</a> | <a href="stats.php" target="_blank">
                    Stats</a></small>
        </div>
    </div>
</div>

<!-- Zepto (lightweight jQuery replacement -->
<script src="//cdnjs.cloudflare.com/ajax/libs/zepto/1.1.6/zepto.min.js"></script>

<!-- Shittalk JS -->
<script src="js/shittalk_v2.min.js" async></script>

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


<!-- Shittalk CSS -->
<script>
    /*!
     loadCSS: load a CSS file asynchronously.
     [c]2015 @scottjehl, Filament Group, Inc.
     Licensed MIT
     */
    (function (w) {
        "use strict";
        /* exported loadCSS */
        var loadCSS = function (href, before, media) {
            // Arguments explained:
            // `href` [REQUIRED] is the URL for your CSS file.
            // `before` [OPTIONAL] is the element the script should use as a reference for injecting our stylesheet <link> before
            // By default, loadCSS attempts to inject the link after the last stylesheet or script in the DOM. However, you might desire a more specific location in your document.
            // `media` [OPTIONAL] is the media type or query of the stylesheet. By default it will be 'all'
            var doc = w.document;
            var ss = doc.createElement("link");
            var ref;
            if (before) {
                ref = before;
            }
            else {
                var refs = ( doc.body || doc.getElementsByTagName("head")[0] ).childNodes;
                ref = refs[refs.length - 1];
            }

            var sheets = doc.styleSheets;
            ss.rel = "stylesheet";
            ss.href = href;
            // temporarily set media to something inapplicable to ensure it'll fetch without blocking render
            ss.media = "only x";

            // Inject link
            // Note: the ternary preserves the existing behavior of "before" argument, but we could choose to change the argument to "after" in a later release and standardize on ref.nextSibling for all refs
            // Note: `insertBefore` is used instead of `appendChild`, for safety re: http://www.paulirish.com/2011/surefire-dom-element-insertion/
            ref.parentNode.insertBefore(ss, ( before ? ref : ref.nextSibling ));
            // A method (exposed on return object for external use) that mimics onload by polling until document.styleSheets until it includes the new sheet.
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

            // once loaded, set link's media back to `all` so that the stylesheet applies once it loads
            ss.onloadcssdefined = onloadcssdefined;
            onloadcssdefined(function () {
                ss.media = media || "all";
            });
            return ss;
        };
        // commonjs
        if (typeof module !== "undefined") {
            module.exports = loadCSS;
        }
        else {
            w.loadCSS = loadCSS;
        }
    }(typeof global !== "undefined" ? global : this));
    loadCSS("css/shittalk.min.css");
</script>

</body>
</html>
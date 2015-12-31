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
        <p>Based on the popular shittalk.cfg - crowdsourced insults</p>
        <p>There may be additional features added, such as a rough imitation of machine learning to produce new insults.
            Let's get bayesian.
        </p>
    </div>
</div>

<div class="container">
    <form class="form-horizontal" role="form">
        <div class="form-group">
            <legend>Write your own</legend>
        </div>

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
        <?php
        require_once(__DIR__ . '/php/shittalk_functions.php');

        $sql = "SELECT * FROM shittalkDB;";
        $result = mySqlQuery($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo $row['text'] . '<span class="glyphicon glyphicon-arrow-up" aria-hidden="true" title="' . $row['text'] . '"> </span> <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> <br />';

            }
        }


        ?>
    </div>
</div>


</body>
</html>
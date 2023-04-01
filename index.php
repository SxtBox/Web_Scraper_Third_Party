<?php include('core/helper.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Website Scraper">
    <meta name="author" content="Vari Karin">
    <title>Web Scraper</title>
    <link rel="shortcut icon" href="favicon.ico">
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/app.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div class="header-line"></div>
    <nav class="navbar navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <img src="img/logo.png"> Web Scraper
            </div>
        </div>
    </nav>

	<?php include_once('core/views/content.php'); ?>

    <div style="height: 60px;"></div>
    <footer class="navbar">
	&copy; <?php echo date("Y") ?>  <strong>TRC4</strong> <a href="http://kodi.al" target="_blank"><strong>kodi.al</strong></a>
    </footer>

    <!-- jQuery Version 1.11.1 vulnerabilities detected --/>
    <script src="js/jquery.min.js"></script>
    <!-- jQuery Version 1.11.1 vulnerabilities detected -->
    <!-- minified --/>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <!-- minified -->
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"></script>

    <!-- Underscore -->
    <script src="js/underscore.js"></script>

	<!-- AngularJS v1.3.7 -->
	<script src="js/angular.js"></script>

	<!-- State-based routing for AngularJS -->
	<script src="js/angular-ui-router.js"></script>

    <!-- Custom JS -->
    <script type="text/javascript">
    window.Url     = '<?php echo url() ?>'
    window.Scraper = {}
    </script>

    <script src="js/app.js"></script>

</body>

</html>

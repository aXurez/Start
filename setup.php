<?php 
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

if (isset($_POST["DBHOST"])) {
	// Setup variables
	$DBHOST = $_POST['DBHOST'];
	$DBUSER = $_POST['DBUSER'];
	$DBPASS = $_POST['DBPASS'];
	$DBNAME = $_POST['DBNAME'];
	$email = $_POST['email'];
	$password = $_POST['password'];
    $date = date("Y-m-d H:i:s");

	// Test connection to database
	$con = mysqli_connect($DBHOST, $DBUSER, $DBPASS, $DBNAME);

    if(!$con) {
    	// Connection failed
    	$_POST = array();
        $sqlError = mysqli_connect_error();
        header("Location: setup.php?e=".$sqlError);
        die;
    } else {
    	// Connection succeed
    	echo "Connection succeed, setting tables";
    }

    $createAdminsTable = mysqli_query($con, "CREATE TABLE IF NOT EXISTS `administrators` (
	    `id` int(11) unsigned NOT NULL auto_increment,
	    `email` varchar(255) NOT NULL default '',
	    `password` varchar(255) NOT NULL default '',
	    `reset` varchar(255) NOT NULL default '',
	    `last_login` DATETIME NOT NULL,
	    PRIMARY KEY  (`id`)
	    )"
	);

	if($createAdminsTable) {
		// Successfly created the table
	    include_once("PasswordHash.php");
	    $hasher = new PasswordHash(8, false);

	    if (strlen($password) > 72) { die("Password must be 72 characters or less"); }
	    $hash = $hasher->HashPassword($password);

	    if (strlen($hash) >= 20) {
	        $insertAdmin = mysqli_query($con, "INSERT INTO `administrators` (`email`, `password`, `last_login`, `reset`) VALUES ('$email', '$hash', '$date', '')");
	        if($insertAdmin) {
		    	echo "Succesfully created an admin account";
		    } else {
		    	echo mysqli_error($con);
		    }
	    }
	}

	// Create config.php
    $file_handle = fopen("config.php", "w") or die("Error: Can't create config.php");
    $content_string = "
<?php
define('DBHOST', \"$DBHOST\");
define('DBUSER', \"$DBUSER\");
define('DBPASS', \"$DBPASS\");
define('DBNAME', \"$DBNAME\");

\$con = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

if(!\$con) {
    mysqli_error(\$con);
}
";
    fwrite($file_handle, $content_string);
    fclose($file_handle);
}

?>
<html lang="nl">
<head>
	<meta charset="utf-8">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="width=device-width, initial-scale=1 maximum-scale=1, user-scalable=0" name="viewport">
	<title>Database Settings</title><!-- Bootstrap -->
	<!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	<link href="css/style.css" rel="stylesheet">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js" type="text/javascript"></script>	
	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <style>
body.signin {
    background-color: #428bca;
}

.panel-signin,
.panel-signup {
    margin: 80px auto 0 auto;
}

.panel-signin {
    width: 400px;
}

.panel-signup {
    width: 600px;
}

.panel-signin .panel-body,
.panel-signup .panel-body {
    padding: 40px;
}

.panel-signin .panel-footer,
.panel-signup .panel-footer {
    padding-left: 40px;
    padding-right: 40px;
}
.mb5 { margin-bottom: 5px; }
.mb8 { margin-bottom: 8px; }
.mb9 { margin-bottom: 9px; }
.mb10 { margin-bottom: 10px; }
.mb15 { margin-bottom: 15px; }
.mb20 { margin-bottom: 20px; }
.mb30 { margin-bottom: 30px; }
</style>
</head>
<body class="signin">
        <div class="panel panel-signin">
            <div class="panel-body">
            <h4 class="text-center mb5">Connect To Database</h4>
                <div class="row">
                    <form action="setup.php" method="post">

                        <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input name="email" type="email" class="form-control" placeholder="Legit Email">
                        </div><!-- input-group -->

                        <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input name="password" type="password" class="form-control" placeholder="Password to login with">
                        </div><!-- input-group -->

                        <hr>

                        <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-star"></i></span>
                            <input name="DBHOST" type="text" class="form-control" placeholder="Database Host">
                        </div><!-- input-group -->

                        <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input name="DBUSER" type="text" class="form-control" placeholder="Database User">
                        </div><!-- input-group -->

                        <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input name="DBPASS" type="password" class="form-control" placeholder="Database Password">
                        </div><!-- input-group -->

                        <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                            <input name="DBNAME" type="text" class="form-control" placeholder="Database Name">
                        </div><!-- input-group -->

                        <div class="clearfix">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>                      
                    </form>
                </div>
            </div>
        </div>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script> 
</body>
</html>
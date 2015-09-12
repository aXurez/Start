<?php 
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$filename = 'config.php';
if (file_exists($filename)) {
    //header("Location: /");
//exit();
}   
if (isset($_POST["host"])) {
    $host = filter_input(INPUT_POST, "host");
    $username = filter_input(INPUT_POST, "username");
    $password = filter_input(INPUT_POST, "password");
    $db_name = filter_input(INPUT_POST, "db_name");

    $file_handle = fopen($filename, 'w') or die("Error: Can't open file");
    $content_string = "<?php\nini_set('display_errors',1);\nini_set('display_startup_errors',1);\nerror_reporting(-1);\n";
    fwrite($file_handle, $content_string);
    $content_string = "\$host = \"$host\";\n\$username = \"$username\";\n\$password = \"$password\";\n\$db_name = \"$db_name\";\n";
    fwrite($file_handle, $content_string);
    $content_string = "\$con = mysqli_connect(\$host, \$username, \$password, \$db_name);\n?>";
    fwrite($file_handle, $content_string);
    $content_string = "";
    fwrite($file_handle, $content_string);
    fclose($file_handle);

    // $xmltree = new DOMDocument('1.0', 'UTF-8');
    // $xmlRoot = $xmltree->createElement("db");
    // $xmlRoot = $xmltree->appendChild($xmlRoot);
    // $xmlRoot->appendChild($xmltree->createElement('host',$host));
    // $xmlRoot->appendChild($xmltree->createElement('username',$username));
    // $xmlRoot->appendChild($xmltree->createElement('password',$password));
    // $xmlRoot->appendChild($xmltree->createElement('db_name',$db_name));
    // $xmltree->save($filename);

    // $xmlprotect = "<Files ".$filename.">\nOrder Deny,Allow\nDeny From All\nAllow From ".$_SERVER['SERVER_NAME']."\n</Files>"
    // $xmlprotect = "RewriteRule ^".$filename."$ index.php\n";
    // if (file_exists('.htaccess')) {
    //     $htaccess = file_get_contents('.htaccess');
    //     if(strpos($htaccess, $xmlprotect)) {
    //         setcookie('debug' , 'has xmlprotect ' , time()+6 );
    //     }else{
    //         $htaccess .= $xmlprotect;
    //         file_put_contents('.htaccess', $htaccess);
    //     }
    // }else{
    //     setcookie('debug' , 'needed htacc ' , time()+6 );
    //     $create_name = ".htaccess";
    //     $file_handle = fopen($create_name, 'w') or die("Error: Can't open file");
    //     $content_string = "RewriteEngine On\n";
    //     fwrite($file_handle, $content_string);
    //     $content_string = "RewriteBase /\n";
    //     fwrite($file_handle, $content_string);
    //     $content_string = "RewriteCond %{REQUEST_FILENAME} !-f\n";
    //     fwrite($file_handle, $content_string);
    //     $content_string = "RewriteRule ^([^\.]+)$ $1.php [NC,L]\n";
    //     fwrite($file_handle, $content_string);
    //     $content_string = $xmlprotect;
    //     fwrite($file_handle, $content_string);
    //     fclose($file_handle);


//header("Location: /");
}

?>
<html lang="nl">
<head>
	<meta charset="utf-8">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="width=device-width, initial-scale=1 maximum-scale=1, user-scalable=0" name="viewport">
	<title>Database Settings</title><!-- Bootstrap -->
	<!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
	<link href="css/bootstrap.css" rel="stylesheet">
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
</head>
<body>
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">Connect To Database</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form action="setup.php" method="post">
                            <div class="input-group mb15">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-star"></i></span>
                                <input name="host" type="text" class="form-control" placeholder="Database Host">
                            </div><!-- input-group -->
                            <div class="input-group mb15">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input name="username" type="text" class="form-control" placeholder="Username">
                            </div><!-- input-group -->
                            <div class="input-group mb15">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input name="password" type="password" class="form-control" placeholder="Password">
                            </div><!-- input-group -->
                            <div class="input-group mb15">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                                <input name="db_name" type="text" class="form-control" placeholder="Database Name">
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
        </div>
    </div>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script> 
</body>
</html>

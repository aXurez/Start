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
    $content_string = "\$con = mysqli_connect(\$host, \$username, \$password, \$db_name);\n";
    fwrite($file_handle, $content_string);
    $content_string = "if(!\$con) {\n\t   mysqli_error(\$con);\n}";
    fwrite($file_handle, $content_string);
    $content_string = "\n";
    fwrite($file_handle, $content_string);
    $content_string = "\n?>";
    fwrite($file_handle, $content_string);
    fclose($file_handle);

    $file_handle = fopen('test.php', 'w') or die("Error: Can't open file");
    $content_string = "<?php\nsession_start();\ninclude \"config.php\";\n";
    fwrite($file_handle, $content_string);
    $content_string = "if (mysqli_connect_errno()) {\n";
    fwrite($file_handle, $content_string);
    $content_string = "\tprintf(\"Could not connect to MySQL databse: %s\", mysqli_connect_error());\n";
    fwrite($file_handle, $content_string);
    $content_string = "exit();\n";
    fwrite($file_handle, $content_string);
    $content_string = "}\n";
    fwrite($file_handle, $content_string);
    $content_string = "\$queryCreateUsersTable = \"CREATE TABLE IF NOT EXISTS `users`
    (`id` int(11) unsigned NOT NULL auto_increment,
    `email` varchar(255) NOT NULL default '',
    `password` varchar(255) NOT NULL default '',
    `last_login` DATETIME NOT NULL,
    PRIMARY KEY  (`id`))\";\n";
    fwrite($file_handle, $content_string);
    $content_string = "if(!\$con->query(\$queryCreateUsersTable)){\n";
    fwrite($file_handle, $content_string);
    $content_string = "\techo \"Table creation failed: (\" . \$con->errno . \") \" . \$con->error;\n";
    fwrite($file_handle, $content_string);
    $content_string = "}\n";
    fwrite($file_handle, $content_string);
    $content_string = "
    
    \$get_administrators = mysqli_query(\$con, \"SELECT * FROM `users`\");
    \$count_administrators = mysqli_num_rows(\$get_administrators);
    \$date = date(\"Y-m-d H:i:s\");
    \$md5admin = md5('admin');
    \$host = \$_SERVER['SERVER_NAME'];
    if (\$count_administrators == 0) {
        mysqli_query(\$con,\"INSERT INTO `users` (`email`, `password`, `last_login`) VALUES ('admin@\$host', '\$md5admin', '\$date')\");
    }
\n";
    fwrite($file_handle, $content_string);
    $content_string = "?>\n";
    fwrite($file_handle, $content_string);
    $content_string = "<html>\n<head>\t\n<meta charset=\"utf-8\">\n\t<meta content=\"IE=edge\" http-equiv=\"X-UA-Compatible\">\n\t<title>Database Tester</title>\n";
    fwrite($file_handle, $content_string);
    $content_string = "\t<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css\">\n";
    fwrite($file_handle, $content_string);
    $content_string = "\t<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js\" type=\"text/javascript\"></script>\n";
    fwrite($file_handle, $content_string);
    $content_string = "\t<script src=\"//code.jquery.com/jquery-1.11.2.min.js\" type=\"text/javascript\"></script>\n";
    fwrite($file_handle, $content_string);
    $content_string = "\t<script src=\"//code.jquery.com/jquery-migrate-1.2.1.min.js\" type=\"text/javascript\"></script>\n";
    fwrite($file_handle, $content_string);
    $content_string = "\t
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
\n";
    fwrite($file_handle, $content_string);
    $content_string = "\t</head>\n<body class=\"signin\">\n";
    fwrite($file_handle, $content_string);
    $content_string = "\t
        <section>
           <div class=\"panel panel-signin\">
                <div class=\"panel-body\">
                    <h4 class=\"text-center mb5\">Already a Member?</h4>
                    <p class=\"text-center\">Sign in to your account</p>
                    <?php if(isset(\$_SESSION['username'])){ echo \$_SESSION['username'];} ?>
                    <div class=\"mb30\"></div>
                    <?php if(isset(\$_SESSION['username'])){?>
                    <form action=\"logout\" method=\"post\">
                        <div class=\"\">
                            <input name=\"username\" type=\"text\" class=\"hidden\" value=\"\$_SESSION['username'];\" >
                        </div><!-- input-group -->
                        
                        <div class=\"clearfix\">
                            <div class=\"pull-right\">
                                <button type=\"submit\" class=\"btn btn-success\">Sign Out</button>
                            </div>
                        </div>                     
                    </form>
                    <?php }else{?>
                    <form action=\"login\" method=\"post\">
                        <div class=\"input-group mb15\">
                            <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>
                            <input name=\"username\" type=\"text\" class=\"form-control\" placeholder=\"Username\">
                        </div><!-- input-group -->
                        <div class=\"input-group mb15\">
                            <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>
                            <input name=\"password\" type=\"password\" class=\"form-control\" placeholder=\"Password\">
                        </div><!-- input-group -->
                        
                        <div class=\"clearfix\">
                            <div class=\"pull-right\">
                                <button type=\"submit\" class=\"btn btn-success\">Sign In</button>
                            </div>
                        </div>                      
                    </form>
                    <?php }?>
                </div><!-- panel-body -->
            </div><!-- panel -->
        </section>\n";
    fwrite($file_handle, $content_string);
    fclose($file_handle);

    $file_handle = fopen('login.php', 'w') or die("Error: Can't open file");
    $content_string = "<?php\nsession_start();\ninclude \"config.php\";\n";
    fwrite($file_handle, $content_string);
    $content_string = "
    if (isset(\$_POST['username'])) {
    \$username = filter_input(INPUT_POST, 'username');
    \$password = filter_input(INPUT_POST, 'password');
    
    \$username = mysqli_real_escape_string(\$con, \$username);
    \$password = mysqli_real_escape_string(\$con, \$password);
    \$md5Password = md5(\$password);
    
    \$get_administrators = mysqli_query(\$con, \"SELECT * FROM `users` WHERE `email`='\$username' AND `password`='\$md5Password'\");
    \$count_administrators = mysqli_num_rows(\$get_administrators);
    \$user = mysqli_fetch_assoc(\$get_administrators);
        if (\$count_administrators == 1) {
            \$curDate = date(\"Y-m-d H:i:s\");
            \$_SESSION['token'] = sha1(\$_SERVER['REMOTE_ADDR'] . date(\"Y-m-d H:i:s\"));
            \$_SESSION['username'] = \$username;
            \$_SESSION['id'] = \$user['id'];
            echo \$_SESSION['username'];
            mysqli_query(\$con,\"UPDATE `users` SET `last_login`='\$curDate',  WHERE `email`='\$username'\");
        } 
    }
    header('location:test.php');
\n";
    fwrite($file_handle, $content_string);
    fclose($file_handle);
    $file_handle = fopen('logout.php', 'w') or die("Error: Can't open file");
    $content_string = "<?php
    session_start();
    include(\"config.php\");

    if(isset(\$_SESSION['username'])){
        session_destroy();
        header('location:test.php');
    }";
    fwrite($file_handle, $content_string);
    $content_string = "?>";
    fwrite($file_handle, $content_string);
    fclose($file_handle);

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
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script> 
</body>
</html>

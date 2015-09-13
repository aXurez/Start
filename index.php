
<?php
session_start();
include "config.php";
?>

<html>
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <title>Proxin Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js" type="text/javascript"></script>
    <script src="//code.jquery.com/jquery-1.11.2.min.js" type="text/javascript"></script>

    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
    <style>
        body.signin {
            background-color: #428bca;
        }

        .panel-signin, .panel-signup {
            margin: 80px auto 0 auto;
        }

        .panel-signin {
            width: 400px;
        }

        .panel-signup {
            width: 600px;
        }

        .panel-signin .panel-body, .panel-signup .panel-body {
            padding: 40px;
        }

        .panel-signin .panel-footer, .panel-signup .panel-footer {
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
    <section>
       <div class="panel panel-signin">
            <div class="panel-body">
                <h4 class="text-center mb5">Already a Member?</h4>
                <p class="text-center">Sign in to your account</p>

                <?php if(isset($_SESSION['email'])) { 
                    echo $_SESSION['email'];
                ?>

                <form action="signout" method="post">
                    <div class="">
                        <input name="email" type="text" class="hidden" value="$_SESSION['email'];" >
                    </div><!-- input-group -->
                    
                    <div class="clearfix">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success">Sign Out</button>
                        </div>
                    </div>                     
                </form>

                <?php } else { ?>

                <form action="signin" method="post">
                    <div class="input-group mb15">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input name="email" type="text" class="form-control" placeholder="Email">
                    </div><!-- input-group -->
                    <div class="input-group mb15">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input name="password" type="password" class="form-control" placeholder="Password">
                    </div><!-- input-group -->
                    
                    <div class="clearfix">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success">Sign In</button>
                        </div>
                    </div>                      
                </form>

                <?php } ?>

            </div><!-- panel-body -->
        </div><!-- panel -->
    </section>
</body>

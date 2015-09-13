
<?php
define('DBHOST', "localhost");
define('DBUSER', "dennis_projname");
define('DBPASS', "1dennis2");
define('DBNAME', "dennis_projname");

$con = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

if(!$con) {
    mysqli_error($con);
}

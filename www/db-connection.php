<?
    echo "<p>Test connection to MySQL</p>";

    $dbuser = 'root';
    $dbpass = 'root';
    $dbhost = 'mysqlserver';

    $connect = mysqli_connect($dbhost, $dbuser, $dbpass) or die("Unable to Connect to '$dbhost'");

    echo "Connected to DB!";
?>
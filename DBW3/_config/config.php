<!-- configure to access database -->
<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'musibah';
    $conn = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($conn -> connect_error) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
    }
?>
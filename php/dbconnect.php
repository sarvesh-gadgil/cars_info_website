<?php
$host = "localhost";
$dbname = "classicmodels";
$username = "root";
$password = "";
?>

<?php
function getConnection()
{
    try {
        global $host, $dbname, $username, $password;
        // DB connection PDO reference: https://www.w3schools.com/php/php_mysql_connect.asp
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (Exception $e) {
        error_log($e->getMessage(), 1);
        handleError("Database connection failed.");
    }
}
?>

<?php
// Error handling code below
function handleError($message)
{
    header('Location: errorpage.php?message=' . $message);
    exit();
}

// PHP error handling reference: https://www.w3schools.com/php/php_error.asp
function errorHandler($errno, $errstr)
{
    handleError("[" . $errno . "] " . $errstr);
}

set_error_handler("errorHandler");

function noDataAvailable()
{
    return "<br><div class=\"noDataMessage\">No Data Available</div><br>";
}
?>
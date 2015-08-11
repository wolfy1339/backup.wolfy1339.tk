<?php
$host     = "localhost"; // Host name
$username = "root"; // Mysql username
$password = openssl_decrypt(file_get_contents("mysql_passwrd"), "sha512"); // Mysql password
$db_name  = "login"; // Database name
$tbl_name = "members"; // Table name

ob_start();
session_start();

// Connect to server and select databse.
try {
    $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
    $db                             = new PDO('mysql:host=' . $host . ';dbname=' . $db_name . ';charset=utf8', $username, $password);
}
catch (Exception $e) {
    die('Error : ' . $e->getMessage());
}
// Define $myusername and $mypassword 
$myusername = $_POST['username'];
$mypassword = $_POST['password'];
// To protect MySQL injection
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);

$stmt  = $db->query("SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'");
// rowCount() is counting table row
$count = $stmt->rowCount();
// If result matched $myusername and $mypassword, table row must be 1 row
if ($count == 1) {
    // Register $myusername, $mypassword and print "true"
    echo "true";
    $_SESSION['username'] = 'myusername';
    $_SESSION['password'] = 'mypassword';
    
} else {
    //return the error message
    echo "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Wrong Username or Password</div>";
}
ob_end_flush();
?>
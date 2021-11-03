<?php
require_once 'connection.php';
$conn = Connect();

if (!isset($_SESSION))
    session_start();

$user_check = $_SESSION['login_user2'];

// SQL Query To Fetch Complete Information Of User
$query = "SELECT username FROM CUSTOMER WHERE username = '$user_check'";
$ses_sql = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($ses_sql); 
$login_session = $row['username'];

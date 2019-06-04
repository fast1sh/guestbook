<?php
require_once('vars.php');

// Create connection
$conn = new mysqli($servername, $username);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Create database if it doesn't exist
if (empty ($conn->query("SHOW DATABASES LIKE 'guestbook'")->fetch_array())) 
{
    $db = "CREATE DATABASE guestbook";
    $conn->query($db);
}

// Select database
$conn->select_db('guestbook');

// Create table if it doesn`t exist
$checktable = $conn->query("SHOW TABLES LIKE 'comments'");

if ($checktable->num_rows <= 0) {
  $table = "CREATE TABLE comments (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  comment_text TEXT(2048) NOT NULL,
  avatar BLOB NOT NULL,
  ip VARCHAR(255) NOT NULL,
  browser VARCHAR(255) NOT NULL,
  comment_date TIMESTAMP
  )";

  $conn->query($table);
}

$conn->close();
?>
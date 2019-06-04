<?php

require_once('../config/database.php');
require_once('../config/vars.php');

function getVisitopIP() {
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
      $ip = $_SERVER['REMOTE_ADDR'];
  }

  return $ip;
}

function getVisitorBrowser() {
  $arr_browsers = ["Firefox", "Chrome", "Safari", "Opera", "MSIE", "Trident", "Edge"];
  $agent = $_SERVER['HTTP_USER_AGENT'];
  $user_browser = '';

  foreach ($arr_browsers as $browser) {
      if (strpos($agent, $browser) !== false) {
          $user_browser = $browser;
          break;
      }   
  }
 
  switch ($user_browser) {
      case 'MSIE':
          $user_browser = 'Internet Explorer';
          break;
  
      case 'Trident':
          $user_browser = 'Internet Explorer';
          break;
  
      case 'Edge':
          $user_browser = 'Internet Explorer';
          break;
  }
 
  return $user_browser;
}

// Write new comment to database
if ($_POST) {
  // Check image for correct sizes
  $filePath  = $_FILES['avatar']['tmp_name'];
  $image = getimagesize($filePath);

  if ($image[0] > 500 || $image[1] > 500) {
    die('Image sizes should not be more than 500x500px. <a href="../index.php" style="color: blue"">Back</a>');
  }

  // Create connection
  $conn = new mysqli($servername, $username, '', 'guestbook');

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  // Get values for database
  $username = $_POST["username"];
  $email = $_POST["email"];
  $comment_text = $_POST["text"];
  $avatar = $_FILES["avatar"]["tmp_name"];
  $ip = getVisitopIP();
  $browser = getVisitorBrowser();

  $sql = "INSERT INTO comments (username, email, comment_text, avatar, ip, browser, comment_date) 
  VALUES ('$username', '$email', '$comment_text', 'LOAD_FILE($avatar)', '$ip', '$browser', now())";

  $conn->query($sql);

  $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <p>Thanks for comment.</p>
  <a href="../index.php" style="color: blue">Back</a>
  <a href="../pages/comments.php" style="color: blue">All comments</a>
</body>
</html>
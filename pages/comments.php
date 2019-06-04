<?php
require_once('../config/vars.php');

// Create connection
$conn = new mysqli($servername, $username);
$conn->select_db('guestbook');

// Limit for comments per page
$limit = 5;

// Get number of all comments to count total pages number
$all_comments = $conn->query("SELECT * FROM comments;");
$all_comments_num = $all_comments->num_rows;
$total_pages = ceil($all_comments_num / $limit);

// Start page
$page = 1;
if (isset($_GET['page'])) {
  $page = $_GET['page'];

  if ($page > $total_pages || $page <= 0) {
    $page = 1;
  }
}

// Back link
echo '<a href="../index.php" style="color: blue">Back</a><br>';

// Current page
echo '<strong style="color: #df0000">Page № ' . $page . 
'</strong><br>';

// Count offset for sql
$offset = ($page - 1) * $limit;

// Get comments for current page
$comments = $conn->query("SELECT * FROM comments 
                          LIMIT $limit OFFSET $offset;");
$comments_num = $comments->num_rows;

// Echo comments
echo '<table border="1">' .
     '<tr style="border: 1px solid black">' .
     '<th>Name</th>' .
     '<th>Email</th>' .
     '<th>Text</th>' .
     '<th>Date</th>' .
     '</tr>';

for ($i = 0; $i < $comments_num; $i++) {
  $comment = $comments->fetch_array();
  
// $image = base64_encode($comment["avatar"]);

  echo '<tr>' .
//     '<td>' . '<img src="data:image/png;base64,'.$image.'" />' . '</td>' .
       '<td>' . $comment["username"] . '</td>' .
       '<td>' . $comment["email"] . '</td>' .
       '<td>' . $comment["comment_text"] . '</td>' .
       '<td>' . $comment["comment_date"] . '</td>' .
       '</tr>';
}

echo '</table>';

// Echo pages
echo 'Pages: ';
for ($j = 1; $j <= $total_pages; $j++) {

    echo '<a href="' . $_SERVER['SCRIPT_NAME'] . 
        '?page=' . $j . '"><strong style="color: #df0000">' . $j . 
        '</strong></a> &nbsp; ';
}

$conn-> close();
?>
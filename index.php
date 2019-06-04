<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Guest Book</title>
</head>
<body>

  <a href="pages/comments.php">All comments</a>

  <form action="pages/thanks.php" enctype="multipart/form-data" method="post">
    <label for="username">Name</label>
    <input type="text" name="username" required>

    <label for="email">E-mail</label>
    <input type="email" name="email" required>

    <label for="text">Text</label>
    <textarea id="text" cols="30" rows="10" name="text" required></textarea>

    <label for="avatar">Avatar</label>
    <input type="file" accept="image/" id="avatar" name="avatar" required>

    <button type="submit">Send</button>
  </form>
  <script src="scripts/main.js"></script>
</body>
</html>
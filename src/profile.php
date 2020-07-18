<?php
session_start();
include('functions.php');
$djInfo = getDjInfo($_SESSION['id'])->fetch(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html>
<head>
  <?php include('header.php'); ?>
  <title>DJ Profile Page</title>
</head>
<body>
  <div class="container">

    <h1><?php echo $djInfo['username']; ?></h1>

  </div>


  <?php include('footer.php'); ?>

</body>
</html>
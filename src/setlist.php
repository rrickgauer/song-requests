<?php
session_start();
include('functions.php');
$setlist = getSetlistData($_GET['id'])->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
  <?php include('header.php'); ?>
  <title><?php echo $setlist['name']; ?></title>
</head>
<body>
  <?php include('navbar.php'); ?>
  <div class="container">
    <h1 class="text-center mt-5"><?php echo $setlist['name']; ?></h1>
    
  </div>

  <?php include('footer.php'); ?>

</body>
</html>
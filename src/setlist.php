<?php 
include('functions.php'); 
$setlistInfo = getSetlistData($_GET['id'])->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <?php include('header.php'); ?>
  <title><?php echo $setlistInfo['name']; ?></title>
</head>
<body>
  <div class="container">

    <h1 class="text-center mt-5"><?php echo $setlistInfo['name']; ?></h1>
    <p class="text-center"><?php echo $setlistInfo['username']; ?></p>

  </div>


<?php include('footer.php'); ?>

</body>
</html>
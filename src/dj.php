<?php 
include('functions.php');
$djInfo = getDjInfo($_GET['id'])->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
  <?php include('header.php'); ?>
  <title><?php echo $djInfo['username']; ?></title>
</head>
<body>
  <?php include('navbar-user.php'); ?>

  <div class="container">
    <h1 class="text-center custom-font mt-5"><?php echo $djInfo['username']; ?></h1>
    <h5>Setlists</h5>

    <!-- dj setlist cards go here -->
    <div class="dj-setlists"></div>
    
  </div>

<?php include('footer.php'); ?>
<script src="js/dj-js.js"></script>
</body>
</html>
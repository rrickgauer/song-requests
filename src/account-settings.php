<?php

session_start();
include('functions.php');

// user updated their username
if (isset($_POST['new-username'], $_SESSION['id'])) {
  $result = updateUsername($_SESSION['id'], $_POST['new-username']);

  $isUsernameUpdated = false;
  if ($result->rowCount() == 1)
    $isUsernameUpdated = true;
}





$djInfo = getDjInfo($_SESSION['id'])->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <?php include('header.php'); ?>
  <title>Account settings</title>
</head>
<body>
  
  <?php include('navbar.php'); ?>

  <div class="container">
    
    <h1 class="text-center mt-5">Account settings</h1>

    <?php 
    // display alert saying we updated their username
    if (isset($isUsernameUpdated) && $isUsernameUpdated) 
      echo getAlert('Username updated.');
    ?>
      
      <!-- update username form -->
      <div class="card mt-4">
        <div class="card-header">
          <h5>Update username</h5>
        </div>
        <div class="card-body">

          <form id="form-change-username" class="needs-validation" method="post" novalidate>
            <!-- current username -->
            <div class="form-group">
              <label for="current-username">Current username:</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class='bx bx-user'></i></span>
                </div>
                <input type="text" class="form-control" id="current-username" name="current-username" value="<?php echo $djInfo['username']; ?>" disabled>
              </div>
            </div>

            <!-- new username -->
            <div class="form-group mt-4">
              <label for="new-username">New username:</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class='bx bx-user'></i></span>
                </div>
                <input type="text" class="form-control red-input" id="new-username" name="new-username" required>
                <div class="invalid-feedback invalid-feedback-username">
                  Username is already taken.
                </div>
              </div>
            </div>
            <input type="submit" value="Save" class="btn btn-primary float-right">
          </form>
        </div>
      </div>
      
  </div>


<?php include('footer.php'); ?>
<script src="js/account-settings-js.js"></script>
</body>
</html>
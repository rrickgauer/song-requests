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

// change password
if (isset($_POST['old-password'], $_POST['new-password-1'], $_POST['new-password-2'])) {
  $isPasswordUpdated = false;
  $djInfo = getDjInfo($_SESSION['id'])->fetch(PDO::FETCH_ASSOC);

  // check if old password matches the one in the db
  if (isValidUsernameAndPassword($djInfo['username'], $_POST['old-password'])) {
    $result = updatePassword($_SESSION['id'], $_POST['new-password-1']);

    if ($result->rowCount() == 1)
      $isPasswordUpdated = true;
  }
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
    
    <h1 class="text-center custom-font mt-5">Account settings</h1>

    <?php 
    // display alert saying we updated their username
    if (isset($isUsernameUpdated) && $isUsernameUpdated) 
      echo getAlert('Username updated.');

    else if (isset($isPasswordUpdated)) {
      if ($isPasswordUpdated)
        echo getAlert('Password updated.');
      else 
        echo getAlert('Error. Password was not updated.', 'danger');
    }

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
                <input type="text" class="form-control" id="new-username" name="new-username" required>
                <div class="invalid-feedback invalid-feedback-username">
                  Username is already taken.
                </div>
              </div>
            </div>
            <input type="submit" value="Save username" class="btn btn-primary float-right" disabled>
          </form>
        </div>
      </div>

      <!-- change password form -->
      <div class="card mt-5 mb-5">
        <div class="card-header">
          <h5>Update password</h5>
        </div>
        <div class="card-body">
          <form id="form-update-password" class="needs-validation" method="post">

            <!-- old password -->
            <div class="form-group">
              <label for="old-password">Old password:</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                </div>
                <input type="password" class="form-control" id="old-password" name="old-password" required>
                <div class="invalid-feedback"></div>
              </div>
            </div>

            <!-- new password 1 -->
            <div class="form-group">
              <label for="new-password-1">New password:</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                </div>
                <input type="password" class="form-control" id="new-password-1" name="new-password-1" required>
                <div class="invalid-feedback"></div>
              </div>
            </div>

            <!-- new password 2 -->
            <div class="form-group">
              <label for="new-password-2">Confirm new password:</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                </div>
                <input type="password" class="form-control" id="new-password-2" name="new-password-2" required>
                <div class="invalid-feedback"></div>
              </div>
            </div>

            <input type="submit" value="Update password" class="btn btn-primary float-right" disabled>
          </form>
        </div>
      </div>
      
  </div>


<?php include('footer.php'); ?>
<script src="js/account-settings-js.js"></script>
</body>
</html>
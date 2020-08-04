<?php 

include('functions.php'); 

// user attempted to create an account
if (isset($_POST['new-username'], $_POST['new-password'])) {
  $username = $_POST['new-username'];
  $password = $_POST['new-password'];
  $sqlResult = insertDj($username, $password);
  $isAccountCreated = true;

  // go to dj's new profile page
  if ($sqlResult->rowCount() == 1) {
    session_start();
    $_SESSION['id'] = getDjIdFromUsername($username);
    
    // go to profile
    header('Location: profile.php');
    exit;
  } else {
    $isAccountCreated = false;
  }
}

// user attempted to login
else if (isset($_POST['login-username'], $_POST['login-password'])) {
  $isValidLoginAttempt = true;

  if (isValidUsernameAndPassword($_POST['login-username'], $_POST['login-password'])) {
    // start the session and save session dj id
    session_start();
    $_SESSION['id'] = getDjIdFromUsername($_POST['login-username']);
    
    // go to profile
    header('Location: profile.php');
    exit;
  } else {
    $isValidLoginAttempt = false;
  }
}

?>


<!DOCTYPE html>
<html>
<head>
  <?php include('header.php'); ?>
  <title>Login</title>
</head>
<body>

  <?php include('navbar-user.php'); ?>
  
  <!-- main container -->
  <div class="container">

    <h1 class="text-center mt-5">Log in to your account</h1>

    <ul class="nav nav-pills justify-content-center mt-5">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" data-toggle="pill" href="#login" role="tab">Login</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" data-toggle="pill" href="#create-account" role="tab">Sign up</a>
      </li>
    </ul>

    <?php
      if (isset($isAccountCreated) && $isAccountCreated == false) {
        echo getAlert('There was an error when creating your account. Please try again.', 'danger');
      } else if (isset($isValidLoginAttempt) && $isValidLoginAttempt == false) {
        echo getAlert('Username and password do not match.', 'danger');
      }
    ?>

    <div class="tab-content mt-5">

      <!-- login form -->
      <div class="tab-pane fade show active" id="login">
        <div class="card card-login-form">
          <div class="card-header">
            <h6>Log in to your account</h6>
          </div>
          <div class="card-body">
            <form method="post" id="login-form">
              <!-- username -->
              <div class="form-group">
                <label for="login-username">Username:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                  </div>
                  <input type="text" class="form-control" id="login-username" name="login-username" required>
                </div>
              </div>

              <!-- password -->
              <div class="form-group">
                <label for="login-password">Password:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                  </div>
                  <input type="password" class="form-control" id="login-password" name="login-password" required>
                </div>
              </div>

              <input type="submit" class="btn btn-primary" value="Log in">
            </form>
          </div>
        </div>
      </div>
  
      <!-- create account form -->
      <div class="tab-pane fade" id="create-account">
        <div class="card card-login-form">
          <div class="card-header">
            <h6>Create a new account</h6>
          </div>
          <div class="card-body">
            <form method="post" id="new-account-form">
              <!-- new-username -->
              <div class="form-group">
                <label for="new-username">Username:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                  </div>
                  <input type="text" class="form-control" id="new-username" name="new-username" required>
                </div>
              </div>

              <!-- new password -->
              <div class="form-group">
                <label for="new-password">Password:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                  </div>
                  <input type="password" class="form-control" id="new-password" name="new-password" required>
                </div>
              </div>

              <input type="submit" class="btn btn-primary" value="Sign up">
            </form>
          </div>
        </div>
      </div>

    </div>

    <p class="text-center mt-4">Want to submit a song request? <a href="home.php">Search here</a></p>

  </div>


<?php include('footer.php'); ?>
</body>
</html>
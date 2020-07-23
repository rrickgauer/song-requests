<?php 

include('functions.php'); 

// user attempted to create an account
if (isset($_POST['new-username'], $_POST['new-password'])) {
  $sqlResult = insertDj($_POST['new-username'], $_POST['new-password']);
}

// user attempted to login
else if (isset($_POST['login-username'], $_POST['login-password'])) {
  if (isValidUsernameAndPassword($_POST['login-username'], $_POST['login-password'])) {
    // get the djid and go to their page
    // $result = getDjIdFromUsername()->fetch(PDO::FETCH_ASSOC);
    
    // start the session and save session dj id
    session_start();
    $_SESSION['id'] = getDjIdFromUsername($_POST['login-username']);
    
    // go to profile
    header('Location: profile.php');
    exit;
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
  
  <!-- main container -->
  <div class="container">

    <h1 class="text-center mt-5">Login DJ</h1>

    <ul class="nav nav-pills justify-content-center mt-5">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" data-toggle="pill" href="#login" role="tab">Login</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" data-toggle="pill" href="#create-account" role="tab">Sign up</a>
      </li>
    </ul>

    <div class="tab-content mt-5">
      <div class="tab-pane fade show active" id="login">
        <form method="post">
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


      <div class="tab-pane fade" id="create-account">
        <!-- create account -->
        <form method="post">
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


<?php include('footer.php'); ?>
</body>
</html>
<?php include('functions.php'); ?>

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
        <label for="new-username">Password:</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
          </div>
          <input type="password" class="form-control" id="new-username" name="new-username" required>
        </div>
      </div>

      <input type="submit" class="btn btn-primary" value="Sign up">
    </form>

  </div>


<?php include('footer.php'); ?>
</body>
</html>
<?php include('functions.php'); ?>
<!DOCTYPE html>
<html>
  <head>
    <?php include('header.php'); ?>
    <title>Song Requests</title>
  </head>
  <body>
    
    <?php include('navbar-user.php'); ?>
    <div class="container">
      <h1 class="text-center custom-font mt-5 mb-5">Find a setlist</h1>
      <!-- search filter options -->
      <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
        <label class="btn btn-secondary active">
          <input type="radio" name="filter-option" value="all" checked> All
        </label>
        <label class="btn btn-secondary">
          <input type="radio" name="filter-option" value="dj"> DJ
        </label>
        <label class="btn btn-secondary">
          <input type="radio" name="filter-option" value="setlist"> Setlist
        </label>
      </div>
      
      <!-- search bar input -->
      <input type="text" id="home-search-input" class="form-control form-control-lg" placeholder="Type here to search">
      <p class="text-center mt-3">Want to make your own setlist? <a href="login.php">Sign up</a></p>
      
      <!-- search results -->
      <div id="home-search-results">
        
        <!-- djs -->
        <div class="card card-search-results search-results-djs">
          <div class="card-header">
            <h5>DJs</h5>
          </div>
          <div class="card-body">
          <ul class="list-group list-group-flush"></ul>
        </div>
      </div>

      <!-- setlists -->
      <div class="card card-search-results search-results-setlists">
        <div class="card-header">
          <h5>Setlists</h5>
        </div>
        <div class="card-body">
        <ul class="list-group list-group-flush"></ul>
      </div>
    </div>
  </div>
  
</div>
<?php include('footer.php'); ?>
<script src="js/home-js.js"></script>
</body>
</html>
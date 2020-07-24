<?php include('functions.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <?php include('header.php'); ?>
  <title>Song Requests</title>
</head>
<body>
  <div class="container">

    <h1 class="text-center mt-5 mb-5">Song Requests</h1>

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
    <input type="text" class="form-control form-control-lg" placeholder="Type here to search">

    <p class="text-center mt-3">Want to make your own setlist? <a href="login.php">Sign up</a></p>
    
    <!-- search results -->
    <div id="home-search-results">

      <h4 class="mb-3">DJ's</h4>
      
      <!-- djs -->
      <div class="search-results-djs">
        
<!--         <div class="card card-dj">
          <div class="card-body">
            <h5 class="card-title">rrickgauer</h5>
          </div>
          <div class="card-footer">
            <a class="float-right" href="#">View</a>
          </div>
        </div> -->


      </div>
      
      <h4 class="mb-3 mt-5">Setlists</h4>
      <!-- setlists -->
      <div class="search-results-setlists">
        
<!--         <div class="card card-setlist">
          <div class="card-body">
            <h5 class="card-title">Graduation</h5>
          </div>
          <div class="card-footer">
            <a class="float-right" href="#">View</a>
          </div>
        </div> -->


       
      </div>

      
    </div>










    
  </div>

  <?php include('footer.php'); ?>
  <script src="js/home-js.js"></script>

</body>
</html>
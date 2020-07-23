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
    <h1 class="text-center mt-3 mb-5"><?php echo $setlist['name']; ?></h1>

    <h5 class="mb-3">Setlist data</h5>
    <!-- setlist info table -->
    <table class="table table-sm table-striped">
      <tbody>
        <tr>
          <th>setlist name</th>
          <td><?php echo $setlist['name']; ?></td>
        </tr>

        <tr>
          <th>dj</th>
          <td><?php echo $setlist['username']; ?></td>
        </tr>

        <tr>
          <th>status</th>
          <td><?php echo $setlist['status']; ?></td>
        </tr>

        <tr>
          <th>time_start</th>
          <td><?php echo $setlist['time_start']; ?></td>
        </tr>

        <tr>
          <th>time_start_display_date</th>
          <td><?php echo $setlist['time_start_display_date']; ?></td>
        </tr>

        <tr>
          <th>time_start_display_time</th>
          <td><?php echo $setlist['time_start_display_time']; ?></td>
        </tr>

        <tr>
          <th>time_end</th>
          <td><?php echo $setlist['time_end']; ?></td>
        </tr>

        <tr>
          <th>time_end_display_date</th>
          <td><?php echo $setlist['time_end_display_date']; ?></td>
        </tr>

        <tr>
          <th>time_end_display_time</th>
          <td><?php echo $setlist['time_end_display_time']; ?></td>
        </tr>

      </tbody>
    </table>
      

  </div>

  <?php include('footer.php'); ?>

</body>
</html>
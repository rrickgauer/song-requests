<?php

// constants
define("SQL_FORMAT_DATE", "%c/%d/%Y");
define("SQL_FORMAT_TIME", "%l:%i %p");


// return a pdo database object
function dbConnect() {
  include('db-info.php');

  try {
    // connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$dbName",$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;

  } catch(PDOexception $e) {
      return 0;
  }
}

// insert a new dj record into db
function insertDj($username, $password) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('INSERT INTO Djs (username, password) VALUES (:username, :password)');

  // sanitize and bind username
  $username = filter_var($username, FILTER_SANITIZE_STRING);
  $sql->bindParam(':username', $username, PDO::PARAM_STR);

  // sanitize, hash, and bind password
  $password = filter_var($password, FILTER_SANITIZE_STRING);
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $sql->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

  $sql->execute();

  return $sql;
}


// validate a users dj login attempt
function isValidUsernameAndPassword($username, $password) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT password FROM Djs WHERE username=:username LIMIT 1');

  // sanitize and bind username
  $username = filter_var($username, FILTER_SANITIZE_STRING);
  $sql->bindParam(':username', $username, PDO::PARAM_STR);

  $sql->execute();

  // username does not exist
  if ($sql->rowCount() != 1) {
    return false;
  }

  // username exists, now check if the passwords match
  else {
    $hash = $sql->fetch(PDO::FETCH_ASSOC);
    $hash = $hash['password'];

    return password_verify($password, $hash);
  }
}

// get dj id
function getDjIdFromUsername($username) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT id FROM Djs WHERE username=:username LIMIT 1');

  // sanitize and bind username
  $username = filter_var($username, FILTER_SANITIZE_STRING);
  $sql->bindParam(':username', $username, PDO::PARAM_STR);

  $sql->execute();

  $result = $sql->fetch(PDO::FETCH_ASSOC);

  return $result['id'];
}

// get dj info from id
function getDjInfo($id) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT id, username FROM Djs WHERE id=:id LIMIT 1');

  $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':id', $id, PDO::PARAM_INT);
  $sql->execute();

  return $sql;
}

// insert a new setlist into the db
function insertSetlist($djId, $name, $status, $timeStart, $timeEnd) {
  $stmt = "";
  $stmt .= "INSERT INTO Setlists ";
  $stmt .= "            (dj_id, ";
  $stmt .= "             name, ";
  $stmt .= "             status, ";
  $stmt .= "             time_start, ";
  $stmt .= "             time_end) ";
  $stmt .= "VALUES      (:djId, ";
  $stmt .= "             :name, ";
  $stmt .= "             :status, ";
  $stmt .= "             :timeStart, ";
  $stmt .= "             :timeEnd)" ;

  $sql = dbConnect()->prepare($stmt);
  // $sql = $pdo->prepare($stmt);

  // filter and bind dj_id
  $djId = filter_var($djId, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':djId', $djId, PDO::PARAM_INT);

  // name
  $name = filter_var($name, FILTER_SANITIZE_STRING);
  $sql->bindParam(':name', $name, PDO::PARAM_STR);

  // status
  $status = filter_var($status, FILTER_SANITIZE_STRING);
  $sql->bindParam(':status', $status, PDO::PARAM_STR);

  // time start
  $timeStart = filter_var($timeStart, FILTER_SANITIZE_STRING);
  $sql->bindParam(':timeStart', $timeStart, PDO::PARAM_STR);

  // time end
  $timeEnd = filter_var($timeEnd, FILTER_SANITIZE_STRING);
  $sql->bindParam(':timeEnd', $timeEnd, PDO::PARAM_STR);

  // execute statement
  $sql->execute();
  return $sql;
}


// return the dj's most recently created setlist id
function getRecentSetlistId($djId) {
  // create sql statement
  $stmt ='
    SELECT id 
    FROM   Setlists 
    WHERE  dj_id = :djId 
    ORDER  BY id DESC 
    LIMIT  1';

  // connect to database
  $sql = dbConnect()->prepare($stmt);

  // filter and bind dj_id
  $djId = filter_var($djId, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':djId', $djId, PDO::PARAM_INT);

  // execute and return sql statement
  $sql->execute();
  return $sql;
}

/**
 * Returns all data about a setlist:
 * 
 * dj_id
 * name
 * status
 * time_start
 * time_end
 * time_start_display_date
 * time_start_display_time
 * time_end_display_date
 * time_end_display_time
 * Djs.username
 * count_status_all
 * count_status_approved
 * count_status_denied
 * count_status_pending
 * 
 * @param int $id 
 * @return array
 */
function getSetlistData($id) {
  // create sql query
  $stmt = '
  SELECT    Setlists.id,
            Setlists.dj_id,
            Setlists.name,
            Setlists.status,
            Setlists.time_start,
            Setlists.time_end,
            DATE_FORMAT(Setlists.time_start, "%c/%d/%Y") AS time_start_display_date,
            DATE_FORMAT(Setlists.time_start, "%l:%i %p") AS time_start_display_time,
            DATE_FORMAT(Setlists.time_end, "%c/%d/%Y")   AS time_end_display_date,
            DATE_FORMAT(Setlists.time_end, "%l:%i %p")   AS time_end_display_time,
            Djs.username,
            (
                   SELECT COUNT(Requests.id)
                   FROM   Requests
                   WHERE  Requests.setlist_id=Setlists.id) AS count_status_all,
            (
                   SELECT COUNT(Requests.id)
                   FROM   Requests
                   WHERE  Requests.setlist_id=Setlists.id
                   AND    Requests.status="approved") AS count_status_approved,
            (
                   SELECT COUNT(Requests.id)
                   FROM   Requests
                   WHERE  Requests.setlist_id=Setlists.id
                   AND    Requests.status="denied") AS count_status_denied,
            (
                   SELECT COUNT(Requests.id)
                   FROM   Requests
                   WHERE  Requests.setlist_id=Setlists.id
                   AND    Requests.status="pending") AS count_status_pending
  FROM      Setlists
  LEFT JOIN Djs
  ON        Setlists.dj_id = Djs.id
  WHERE     Setlists.id = :id
  GROUP BY  Setlists.id
  LIMIT     1';

  // connect to database
  $sql = dbConnect()->prepare($stmt);

  // filter and bind id
  $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':id', $id, PDO::PARAM_INT);

  // return result
  $sql->execute();
  return $sql;
}

// return all setlists owned by a dj
function getDjSetlists($djId) {
  // create sql query
  $stmt = '
  SELECT Setlists.id,
         Setlists.dj_id,
         Setlists.name,
         Setlists.status,
         Setlists.time_start,
         Setlists.time_end,
         DATE_FORMAT(Setlists.time_start, "%c/%d/%Y") AS time_start_display_date,
         DATE_FORMAT(Setlists.time_start, "%l:%i %p") AS time_start_display_time,
         DATE_FORMAT(Setlists.time_end, "%c/%d/%Y")   AS time_end_display_date,
         DATE_FORMAT(Setlists.time_end, "%l:%i %p")   AS time_end_display_time
  FROM   Setlists
  WHERE  Setlists.dj_id = :djId
  GROUP  BY Setlists.id
  ORDER  BY Setlists.time_start DESC';

  // connect to database
  $sql = dbConnect()->prepare($stmt);

  // filter and bind id
  $djId = filter_var($djId, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':djId', $djId, PDO::PARAM_INT);

  // return result
  $sql->execute();
  return $sql;
}


/****************************************************
 * returns search results for the djs
 * 
 * id
 * username
*****************************************************/
function getDjsFromSearch($query) {
  // sql statement
  $stmt = '
  SELECT id,
         username
  FROM   Djs
  WHERE  username LIKE :username
  ORDER  BY username ASC
  LIMIT  5';

  $sql = dbConnect()->prepare($stmt);

  // filter and bind the username query
  $username = "%$query%";
  $username = filter_var($username, FILTER_SANITIZE_STRING);
  $sql->bindParam(':username', $username, PDO::PARAM_STR);

  // return result
  $sql->execute();
  return $sql;
}


/*****************************************************
 * returns the setlist search results from db
 * 
 * id
 * dj_id
 * name
 * status
 * time_start
 * time_end
 * username
*****************************************************/
function getSetlistsFromSearch($query) {
  // sql statement
  $stmt = '
  SELECT Setlists.id,
         Setlists.dj_id,
         Setlists.name,
         Setlists.status,
         Setlists.time_start,
         Setlists.time_end,
         Djs.username
  FROM   Setlists
         LEFT JOIN Djs
                ON Setlists.dj_id = Djs.id
  WHERE  Setlists.name LIKE :name
  GROUP  BY Setlists.id
  ORDER  BY Setlists.name ASC
  LIMIT  5';

  $sql = dbConnect()->prepare($stmt);

  // filter and bind the setlist name query
  $name = "%$query%";
  $name = filter_var($name, FILTER_SANITIZE_STRING);
  $sql->bindParam(':name', $name, PDO::PARAM_STR);

  // return result
  $sql->execute();
  return $sql;
}

/**
 * returns the song requests of a setlist
 * 
 * id
 * song_artist
 * song_title
 * status
 * votes_up
 * votes_down
 * date_submitted
 * votes_count
 */
function getRequests($id) {
  $stmt = '
  SELECT Requests.id,
         Requests.song_artist,
         Requests.song_title,
         Requests.status,
         Requests.votes,
         Requests.date_submitted,
         DATE_FORMAT(Requests.date_submitted, "%l:%i %p") as date_submitted_display_time,
         DATE_FORMAT(Requests.date_submitted, "%c/%d/%Y") as date_submitted_display_date,
         UNIX_TIMESTAMP(Requests.date_submitted)          as date_submitted_unix
  FROM   Requests
  WHERE  Requests.setlist_id = :id
  ORDER  BY Requests.date_submitted ASC';

  $sql = dbConnect()->prepare($stmt);

  // filter and bind id
  $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':id', $id, PDO::PARAM_INT);

  $sql->execute();
  return $sql;
}

// insert a new song request
function insertRequest($setlistID, $title, $artist = null) {

  // create sql statement
  $stmt = '
  INSERT INTO Requests
              (setlist_id,
               song_title,
               song_artist,
               date_submitted)
  VALUES      (:setlistID,
               :title,
               :artist,
               NOW())';


  $sql = dbConnect()->prepare($stmt);

  // filter and bind setlist id
  $setlistID = filter_var($setlistID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':setlistID', $setlistID, PDO::PARAM_INT);

  // filter and bind title
  $title = filter_var($title, FILTER_SANITIZE_STRING);
  $sql->bindParam(':title', $title, PDO::PARAM_STR);

  // filter and bind artist
  $artist = filter_var($artist, FILTER_SANITIZE_STRING);
  $sql->bindParam(':artist', $artist, PDO::PARAM_STR);

  $sql->execute();
  return $sql;
}

// prints out a bootstrap alert
function getAlert($message) {
  return "
  <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
    $message
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
      <span aria-hidden=\"true\">&times;</span>
    </button>
  </div>";
}


// increment a requests votes by 1
function incrementVotesUp($requestID) {
  // creaete sql statement
  $stmt = '
  UPDATE Requests
  SET    votes = votes + 1
  WHERE  id = :requestID';

  $sql = dbConnect()->prepare($stmt);

  // filter and bind request id
  $requestID = filter_var($requestID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':requestID', $requestID, PDO::PARAM_INT);

  $sql->execute();
  return $sql;
}

// decrement votes by 1
function decrementVotesDown($requestID) {
  // creaete sql statement
  $stmt = '
  UPDATE Requests
  SET    votes = votes - 1
  WHERE  id = :requestID';

  $sql = dbConnect()->prepare($stmt);

  // filter and bind request id
  $requestID = filter_var($requestID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':requestID', $requestID, PDO::PARAM_INT);

  $sql->execute();
  return $sql;
}


// update setlist info
function updateSetlist($setlistID, $name, $status, $timeStart, $timeEnd) {
  $stmt = '
  UPDATE Setlists 
  SET    name = :name, 
         status = :status, 
         time_start = :timeStart, 
         time_end = :timeEnd 
  WHERE  id = :setlistID';

  $sql = dbConnect()->prepare($stmt);

  // filter and bind setlist id
  $setlistID = filter_var($setlistID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':setlistID', $setlistID, PDO::PARAM_INT);

  // filter and bind name
  $name = filter_var($name, FILTER_SANITIZE_STRING);
  $sql->bindParam(':name', $name, PDO::PARAM_STR);

  // filter and bind title
  $status = filter_var($status, FILTER_SANITIZE_STRING);
  $sql->bindParam(':status', $status, PDO::PARAM_STR);

  // filter and bind artist
  $timeStart = filter_var($timeStart, FILTER_SANITIZE_STRING);
  $sql->bindParam(':timeStart', $timeStart, PDO::PARAM_STR);

  // filter and bind artist
  $timeEnd = filter_var($timeEnd, FILTER_SANITIZE_STRING);
  $sql->bindParam(':timeEnd', $timeEnd, PDO::PARAM_STR);

  $sql->execute();
  return $sql;
}


// update a request's status
function updateRequestStatus($requestID, $status) {
  $stmt = '
  UPDATE Requests
  SET    status = :status
  WHERE  id = :requestID';

  $sql = dbConnect()->prepare($stmt);

  // filter and bind id
  $requestID = filter_var($requestID, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':requestID', $requestID, PDO::PARAM_INT);


  // filter and bind status
  if ($status != 'approved' && $status && 'denied' && $status == 'pending') {
    $status = filter_var('pending', FILTER_SANITIZE_STRING);
  } else {
    $status = filter_var($status, FILTER_SANITIZE_STRING);
  }

  $sql->bindParam(':status', $status, PDO::PARAM_STR);

  $sql->execute();
  return $sql;
}



?>
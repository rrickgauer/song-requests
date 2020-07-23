<?php

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
  $sql = $pdo->prepare('SELECT * FROM Djs WHERE id=:id LIMIT 1');

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




?>
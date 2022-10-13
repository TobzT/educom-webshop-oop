<?php 

// I/O
function openConn() {
    $servername = "127.0.0.1";
    $username = "tobias_webshop";
    $password = "EducomCheeta";
    $dbname = "tobias_webshop";
    return mysqli_connect($servername, $username, $password, $dbname);
}

function checkConn($conn) {
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
}

function closeConn($conn) {
  mysqli_close($conn);
}

// USERS
// INSERT
function insert_users($conn, $useremail, $username, $userpw) {
    $sql = "INSERT INTO users (email, name, pw) VALUES ('$useremail', '$username', '$userpw')";
    
    try{
      mysqli_query($conn, $sql);
    } 
    catch(error $e){
        echo "Error: " . mysqli_error($conn) . "<br>" . $e;
      }
}




// FIND
function findByEmailInDb($conn, $email) {
  $sql = "SELECT * FROM users WHERE email = '$email'";

  try{
    $result = mysqli_query($conn, $sql);
    
    $result = mysqli_fetch_all($result);
    if (count($result) > 0) {
      return $result;
    } else {
      return array();
    }
    
  } 
  catch(error $e){
    echo "Error: " . mysqli_error($conn) . "<br>" . $e;
      return;
    }
}

function findByEmailInDbB($conn, $email) {
  $result = findByEmailInDb($conn, $email);
  if (count($result) > 0) {
    return true;
  }
  return false;
}

function findByNameInDb($conn, $name) {
  $sql = "SELECT * FROM users WHERE name = '$name'";

  try{
    $result = mysqli_query($conn, $sql);
    
    $result = mysqli_fetch_all($result);
    if (count($result) > 0) {
      return $result;
    } else {
      return array();
    }
    
  } 
  catch(error $e){
    echo "Error: " . mysqli_error($conn) . "<br>" . $e;
    return;
    }
}

// $conn = openConn();
// $result = findByEmailInDb($conn, "admin@test.nl");
// closeConn($conn);

// WEBSHOP
function insert_items($conn, $itemname, $itemprice, $itemdesc, $imagepath) {
  $sql = "INSERT INTO items (name, price, description, path) VALUES ('$itemname', '$itemprice', '$itemdesc', '$imagepath')";
    
    try{
      mysqli_query($conn, $sql);
    } 
    catch(error $e){
        echo "Error: " . mysqli_error($conn) . "<br>" . $e;
      }
}

function getAllItems($conn) {
  
  $sql = "SELECT * FROM items";
  try{
    $result = mysqli_query($conn, $sql);
    
    $result = mysqli_fetch_all($result);
    if (count($result) > 0) {
      return $result;
    } else {
      return array();
    }
    
  } 
  catch(error $e){
    echo "Error: " . mysqli_error($conn) . "<br>" . $e;
      return;
    }
}

function getItem($conn, $id) {
  $sql = "SELECT * FROM items WHERE id = $id";

  try{
    $result = mysqli_query($conn, $sql);
    
    $result = mysqli_fetch_all($result);
    if (count($result) > 0) {
      return $result;
    } else {
      return array();
    }
    
  } 
  catch(error $e){
    echo "Error: " . mysqli_error($conn) . "<br>" . $e;
      return;
    }
}


function getItems($conn, $idArray) {
  $items = '';
  for($i = 0; $i < count($idArray); $i++) {
    $id = $idArray[$i];
    $items .= " id = $id";

    if ($i < count($idArray) - 1) {
      $items .= " OR";
    }
  }
  $sql = "SELECT * FROM items WHERE $items";

  try{
    $result = mysqli_query($conn, $sql);
    
    $result = mysqli_fetch_all($result);
    if (count($result) > 0) {
      return $result;
    } else {
      return array();
    }
    
  } 
  catch(error $e){
    echo "Error: " . mysqli_error($conn) . "<br>" . $e;
      return;
    }
}


// $conn = openConn();
// insert_items($conn, "Sojabonen", 2.50, "Sojabonen voor in de salade.", "./Images/sojabonen.jpg");
// closeConn($conn);

// ORDERS
// INSERT
function insert_order($conn, $userId, $order, $totalPrice) {
  $sql = "INSERT INTO user_orders (userid, orderinfo, totalprice) VALUES('$userId','$order','$totalPrice')";

  try{
    mysqli_query($conn, $sql);
  } 
  catch(error $e){
      echo "Error: " . mysqli_error($conn) . "<br>" . $e;
  }
}
?>
<?php
session_start();
  // if(!isset($_SESSION['guest']) || isset($_SESSION['admin'])){
  //   header('Location: login.php');
  //   exit();
  // }
 include 'database.php';
 if($_SERVER['REQUEST_METHOD'] == 'POST' )
  {

	$id = $_SESSION['ID']; 
    $order =$_POST['ordername'] ;
    $price = $_POST['Price'];

    $stmt = $conn->prepare('INSERT INTO orders (ordername,price,gid)VALUES( ?, ? , ? );');
    $stmt->execute(array($order,$price, $id));
    header('Location: personal.php');


  }
  $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
  if($do == 'show'){
	$guest =isset($_GET['guest']) ? $_GET['guest']: 0;
	//var_dump($guest);
	$_SESSION['guest'] = 'guest';
    $_SESSION['ID'] = $guest; //Register Session ID
    header('Location: personal.php');
       
  }


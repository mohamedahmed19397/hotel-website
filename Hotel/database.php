<?php
	$dsn = 'mysql:host=localhost;dbname=hotel;';
	$user = 'root';
	$pass = 'root';
	$option = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	);
	try{
		$conn = new PDO($dsn, $user, $pass, $option);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo 'You Are Connected Welcome To Database';
	}
	catch(PDOException $e){
		echo 'Failed To Connect '. $e->getMessage();
	}
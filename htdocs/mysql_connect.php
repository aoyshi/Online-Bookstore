<?php
	//connect to mysql database
	$hostname = "localhost";
	$username="root";
	$password="root";
	$db="bookstore_test";
	$conn = @mysqli_connect($hostname,$username,$password,$db) 
			or die('Could not connect to MySQL DB -> ' . mysqli_connect_error()); 
?>

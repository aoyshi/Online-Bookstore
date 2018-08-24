<?php 
// define variables and set to empty values 
$CusID=$ItemID=$quantity="";
$CusID_error=$ItemID_error=$quantity_error="";
$cost=$show_cost="";

//when form is submitted with POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
 
  if (empty($_POST["CusID"])) {
    $CusID_error = "Customer ID is required";
  } else {
    $CusID = test_input($_POST["CusID"]);
    // check if cusID exists in db
    if (!existsInDB($CusID,"CusID","customer")) {
      $CusID_error = "This Customer ID does not exist"; 
    }	
  }

  if (empty($_POST["ItemID"])) {
    $ItemID_error = "Item ID is required";
  } else {
    $ItemID = test_input($_POST["ItemID"]);
    // check if ItemID exists in db
    if (!existsInDB($ItemID,"ItemID","item")) {
      $ItemID_error = "This Item ID does not exist";
	}
    else { //item exists but is it available
	  if(!isAvailable($ItemID)) {
	    $ItemID_error = "This Item is currently unavailable";
	  }
      else {
		$cost = floatval(getPrice($ItemID));
		$show_cost = "Cost: $" . $cost;
	  }		  
    }	
  }
 
    if (empty($_POST["quantity"])) {
    $quantity_error = "Quantity is required";
  } else {
    $quantity = test_input($_POST["quantity"]);
	if(!preg_match('/^\d+$/', $quantity)){
	   $quantity_error = "Invalid number (must be a positive integer)";
	}
  }

	//check if all error-free before inserting
   if ($CusID_error == '' and $ItemID_error == '' and $quantity_error == '')
	{			
		$hostname = "localhost";
		$dbuser="root";
		$dbpass="root";
		$db="bookstore_test";
		$conn = @mysqli_connect($hostname,$dbuser,$dbpass,$db)
				or 
				die('Could not connect to MySQL DB -> ' . mysqli_connect_error());
		
        //get order placement date (upon hitting submit)
        $Order_Date = date('Y-m-d');		

		$orderID = null; //auto_incremented by database
			
		$query = "INSERT INTO `orders` (`CusID`, `ItemID`, `Order_Date`,`Quantity`,`OrderID`) 
		          VALUES ('".$CusID."','".$ItemID."','".$Order_Date."','".$quantity."','".$orderID."');";    
				  
		$result = mysqli_query($conn, $query);
           if($result)
	       {
			   echo "Successfully placed order!<br>";
			   $totalPrice = $quantity * $cost;
			   echo "<h4>Total Price of this order is: $".$totalPrice."</h4><hr><br>";
		   }
           else
	           echo "Failed to place order: " . mysqli_error($conn);
		
	}	
}

//get total price of order
function getPrice($id) {
	$hostname = "localhost";
	$dbuser="root";
	$dbpass="root";
	$db="bookstore_test";
	$conn = @mysqli_connect($hostname,$dbuser,$dbpass,$db) 
			or die('Could not connect to MySQL DB -> ' . mysqli_connect_error());

    $price = "";
	$result = mysqli_query($conn, "SELECT Price FROM item WHERE ItemID='".$id."';");
    if (!$result)
      die('Error connecting to database: ' . mysqli_connect_error());
    
    if(mysqli_num_rows($result) > 0)
	{
	   $row = mysqli_fetch_array($result);
	   $price = $row['Price'];
	}
  
    mysqli_close($conn);
	return $price;
}



//check if value exist in DB or not
function existsInDB($value,$column,$table) {
    //connect to mysql database
	$hostname = "localhost";
	$dbuser="root";
	$dbpass="root";
	$db="bookstore_test";
	$conn = @mysqli_connect($hostname,$dbuser,$dbpass,$db) 
			or die('Could not connect to MySQL DB -> ' . mysqli_connect_error());
			
	$exists = false;
	$query = mysqli_query($conn, "SELECT * FROM ".$table." WHERE ".$column."='".$value."';");
    if (!$query)
      die('Error connecting to database: ' . mysqli_connect_error($conn));
    
    if(mysqli_num_rows($query) > 0)
	  $exists = true;
  
    mysqli_close($conn);
	return $exists;
}


//check if item is available
function isAvailable($id) {
    //connect to mysql database
	$hostname = "localhost";
	$dbuser="root";
	$dbpass="root";
	$db="bookstore_test";
	$conn = @mysqli_connect($hostname,$dbuser,$dbpass,$db) 
			or die('Could not connect to MySQL DB -> ' . mysqli_connect_error());
			
	$available = false;
	$result = mysqli_query($conn, "SELECT * FROM item WHERE ItemID='".$id."' and Availability='1';");
    if (!$result)
      die('Error connecting to database: ' . mysqli_connect_error($conn));
    
    if(mysqli_num_rows($result) > 0)
	  $available = true;
  
    mysqli_close($conn);
	return $available;
}


//trims and checks input for html injections
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
} 

?>
<?php 
// define variables and set to empty values 
$CusID=$CusID_error="";
$showRow="";


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

	//check if all error-free before inserting
   if ($CusID_error == '')
	{	
		$hostname = "localhost";
		$dbuser="root";
		$dbpass="root";
		$db="bookstore_test";
		$conn = @mysqli_connect($hostname,$dbuser,$dbpass,$db)
				or 
				die('Could not connect to MySQL DB -> ' . mysqli_connect_error());
		
		$query = "DELETE FROM `bkstr_user` WHERE Username='".$CusID."';";    		
		$result = mysqli_query($conn, $query);
           if($result)
	       {
			   echo "Successfully deleted customer with username: '".$CusID."'";
			   mysqli_close($conn);
		   }
           else
	       {
			   echo "Failed to delete customer: " . mysqli_error($conn);
			   mysqli_close($conn);
		   }		
	}	
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

//trims and checks input for html injections
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
} 

?>
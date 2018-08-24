<?php 
// define variables and set to empty values 
$name_error = $id_error = "";
$name = $id = "";

//when form is submitted with POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty($_POST["name"])) {
    $name_error = "Genre name is required";
  } else {
    $name = test_input($_POST["name"]);
	// check if name alrdy exists in db
    if (!isUnique($name,"Name")) {
      $name_error = "A genre with this name already exists"; 
    }
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $name_error = "Only letters and white space allowed"; 
    }
	if (strlen($name)>15) {
	  $name_error = "Genre name cannot exceed 15 characters";
	}	  
  }
  
    if (empty($_POST["id"])) {
    $id_error = "ID Number is required";
  } else {
    $id = test_input($_POST["id"]);
	if(!preg_match('/^\d+$/', $id)) {
	  $id_error = "Invalid ID (must be an integer)"; 
	}
    // check if id alrdy exists in db
    if (!isUnique($id,"ID")) {
      $id_error = "This ID No. already exists"; 
    }	
  }
  

	//check if all error-free before inserting
	if ($name_error == '' and $id_error == '')
	{
		
	$hostname = "localhost";
	$dbuser="root";
	$dbpass="root";
	$db="bookstore_test";
	$conn = @mysqli_connect($hostname,$dbuser,$dbpass,$db)
			or 
			die('Could not connect to MySQL DB -> ' . mysqli_connect_error());
			
		$query = "INSERT INTO `genre` (`Name`, `ID`) VALUES ('".$name."','".$id."');";	
		$result = mysqli_query($conn, $query);
		if($result)
		{
			echo 'Insertion in GENRE Successful!<br>';
			mysqli_close($conn);
		}
		else
		{
			echo 'Error Occured during Insert in GENRE: ' . mysqli_error($conn);
			mysqli_close($conn);
		}
	
	}
	
}
  

//checks if value already exists in database 
function isUnique($value,$column) {
    //connect to mysql database
	$hostname = "localhost";
	$dbuser="root";
	$dbpass="root";
	$db="bookstore_test";
	$conn = @mysqli_connect($hostname,$dbuser,$dbpass,$db) 
			or die('Could not connect to MySQL DB -> ' . mysqli_connect_error()); 
	
	//check if value exists
	$isUnique = true;
	$query = mysqli_query($conn, "SELECT * FROM genre WHERE ".$column."='".$value."';");
    if (!$query)
      die('Error connecting to database: ' . mysqli_connect_error($conn));
    
    if(mysqli_num_rows($query) > 0)
	  $isUnique = false;
  
    mysqli_close($conn);
	return $isUnique;
}


//checks if a date is valid yyyy-MM-dd
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}


//trims and checks input for html injections
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
} 

?>
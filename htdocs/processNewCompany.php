<?php 
// define variables and set to empty values 
$name_error = $id_error = $location_error = $ceo_error = "";
$name = $id = $location = $ceo = "";

//when form is submitted with POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty($_POST["name"])) {
    $name_error = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $name_error = "Only letters and white space allowed"; 
    }
	if (strlen($name)>50) {
	  $name_error = "Name cannot exceed 40 characters";
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
    if (!isUnique($id)) {
      $id_error = "This ID No. already exists"; 
    }	
  }
  
   if (empty($_POST["location"])) {
    $location_error = "Headquarter location is required";
  } else {
    $location = test_input($_POST["location"]);
	if (strlen($location)>256) {
	  $location_error = "Headquarter location cannot exceed 256 characters";
	}	  
  }

    if (empty($_POST["ceo"])) {
    $ceo_error = "CEO Name is required";
  } else {
    $ceo = test_input($_POST["ceo"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$ceo)) {
      $ceo_error = "Only letters and white space allowed"; 
    }
	if (strlen($ceo)>20) {
	  $ceo_error = "CEO Name cannot exceed 20 characters";
	}	  
  }

	//check if all error-free before inserting
	if ($name_error == '' and $id_error == '' and $location_error == '' and $ceo_error == '')
	{
		
	$hostname = "localhost";
	$dbuser="root";
	$dbpass="root";
	$db="bookstore_test";
	$conn = @mysqli_connect($hostname,$dbuser,$dbpass,$db)
			or 
			die('Could not connect to MySQL DB -> ' . mysqli_connect_error());
			
		$query = "INSERT INTO `creator` (`Name`, `ID`, `Classification`) VALUES ('".$name."','".$id."','Company');";	
		$result = mysqli_query($conn, $query);
		if($result)
		{
			echo 'Insertion in CREATOR Successful!<br>';
		}
		else
		{
			echo 'Error Occured during Insert in CREATOR: ' . mysqli_error($conn);
		}

		$query2 = "INSERT INTO `company` (`CompID`, `HQ_Location`, `CEO`) 
		          VALUES ('".$id."', '".$location."', '".$ceo."');";  
		$result2 = mysqli_query($conn, $query2);
		if($result2)
		{
			echo 'Insertion in COMPANY Successful!<br>';
			mysqli_close($conn);
		}
		else
		{
			echo 'Error Occured during Insert in COMPANY: ' . mysqli_error($conn);
			mysqli_close($conn);
		}
	
	}
	
}
  

//checks if value already exists in database 
function isUnique($value) {
    //connect to mysql database
	$hostname = "localhost";
	$dbuser="root";
	$dbpass="root";
	$db="bookstore_test";
	$conn = @mysqli_connect($hostname,$dbuser,$dbpass,$db) 
			or die('Could not connect to MySQL DB -> ' . mysqli_connect_error()); 
	
	//check if value exists
	$isUnique = true;
	$query = mysqli_query($conn, "SELECT * FROM creator WHERE creator.ID='".$value."';");
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
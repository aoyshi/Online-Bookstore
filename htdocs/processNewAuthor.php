<?php 
// define variables and set to empty values 
$name_error = $id_error = $nationality_error = $DOB_error = "";
$name = $id = $nationality = $DOB = $sex = "";

//when form is submitted with POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  

  if(isset($_POST['sex']))
  {
	$sex = $_POST['sex'];  
  }
 
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
  
   if (empty($_POST["nationality"])) {
    $nationality_error = "Nationality is required";
  } else {
    $nationality = test_input($_POST["nationality"]);
    // check if nat only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$nationality)) {
      $nationality_error = "Only letters and white space allowed"; 
    }
	if (strlen($nationality)>20) {
	  $nationality_error = "Nationality entry cannot exceed 20 characters";
	}	  
  }

  if (empty($_POST["DOB"])) {
    $DOB_error = "Birthdate is required";
  } else {
    $DOB = test_input($_POST["DOB"]);
	if(!validateDate($DOB)){
	   $DOB_error = "Invalid date format. Must be YYYY-MM-DD";
	}
  }

	//check if all error-free before inserting
	if ($name_error == '' and $id_error == '' and $nationality_error == '' and $DOB_error == '')
	{
		
	$hostname = "localhost";
	$dbuser="root";
	$dbpass="root";
	$db="bookstore_test";
	$conn = @mysqli_connect($hostname,$dbuser,$dbpass,$db)
			or 
			die('Could not connect to MySQL DB -> ' . mysqli_connect_error());
			
		$query = "INSERT INTO `creator` (`Name`, `ID`, `Classification`) VALUES ('".$name."','".$id."','Author');";	
		$result = mysqli_query($conn, $query);
		if($result)
		{
			echo 'Insertion in CREATOR Successful!<br>';
		}
		else
		{
			echo 'Error Occured during Insert in CREATOR: ' . mysqli_error($conn);
		}

		$query2 = "INSERT INTO `author` (`AuthorID`, `Sex`, `Nationality`,`DOB`) 
		          VALUES ('".$id."', '".$sex."', '".$nationality."', '".$DOB."');";  
		$result2 = mysqli_query($conn, $query2);
		if($result2)
		{
			echo 'Insertion in AUTHOR Successful!<br>';
			mysqli_close($conn);
		}
		else
		{
			echo 'Error Occured during Insert in AUTHOR: ' . mysqli_error($conn);
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
<?php 
// define variables and set to empty values 
$name_error = $email_error = $username_error = $password_error = $phone_error = $address_error = $DOB_error = "";
$name = $email = $username = $password = $phone = $address = $DOB = $sex = $joinDate = "";

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
	  $name_error = "Name cannot exceed 50 characters";
	}	  
  }

  if (empty($_POST["email"])) {
    $email_error = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is unique & well-formed
	if (!isUnique($email, "Email")) {
      $email_error = "Email already exists!"; 
    }
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_error = "Invalid email format"; 
    }
  }
 
  if (empty($_POST["username"])) {
    $username_error = "Username is required";
  } else {
    $username = test_input($_POST["username"]);
    // check if username is unique & 12 chars
    if (!isUnique($username,"Username")) {
      $username_error = "Username already exists!"; 
    }
    if (strlen($username)>12) {
	  $username_error = "Username cannot exceed 12 characters";
	}	
  }
      
  if (empty($_POST["password"])) {
    $password_error = "Password is required";
  } else {
    $password = test_input($_POST["password"]);
    // check if password is 12 chars
    if (strlen($password)>12) {
	  $password_error = "Password cannot exceed 12 characters";
	}	
  }
  
  if (empty($_POST["phone"])) {
    $phone_error = "";
  } else {
    $phone = test_input($_POST["phone"]);
    // check if phone number is valid, if any
    if (!preg_match("/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i",$phone)) {
      $phone_error = "Invalid phone number"; 
    }
	if (strlen($phone)>12) {
	  $phone_error = "Phone number cannot exceed 12 characters"; 
	}
  }

  if (empty($_POST["address"])) {
    $address_error = "Address is required";
  } else {
    $address = test_input($_POST["address"]);
    // check if address is below 256 chars
    if (strlen($address)>256) {
	  $password_error = "Address cannot exceed 256 characters";
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
	if ($name_error == '' and $email_error == '' and $username_error == '' and $password_error == ''
		 and $phone_error == '' and $address_error == '' and $DOB_error == '')
	{
		$joinDate = date('Y-m-d H:i:s');
		
	$hostname = "localhost";
	$dbuser="root";
	$dbpass="root";
	$db="bookstore_test";
	$conn = @mysqli_connect($hostname,$dbuser,$dbpass,$db)
			or 
			die('Could not connect to MySQL DB -> ' . mysqli_connect_error());
			
		$query = "INSERT INTO `bkstr_user` (`Username`, `Name`, `Phone`, `Address`, `Email`, 
		`Password`, `DOB`, `Sex`, `Role`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'CUSTOMER');";	
		$stmt = mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt,"ssssssss",$username,$name,$phone,$address,
		                       $email,$password,$DOB,$sex);
		mysqli_stmt_execute($stmt);
		
		$affected_rows = mysqli_stmt_affected_rows($stmt);
		if($affected_rows == 1)
		{
			echo 'Insertion in BKSTR_USER Successful!<br>';
			mysqli_stmt_close($stmt);
		}
		else
		{
			echo 'Error Occured during Insert in BKSTR_USER: ' . mysqli_error();
			mysqli_stmt_close($stmt);
		}

		$query = "INSERT INTO `customer` (`CusID`, `JoinDate`) VALUES (?, ?);";  
		$stmt = mysqli_prepare($conn, $query);	
		mysqli_stmt_bind_param($stmt,"ss",$username,$joinDate);	
		mysqli_stmt_execute($stmt);
		
		$affected_rows = mysqli_stmt_affected_rows($stmt);	
		if($affected_rows == 1)
		{
			echo 'Insertion Successful in CUSTOMER!<br>';
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
		}
		else
		{
			echo 'Error Occured during Insert in CUSTOMER: ' . mysqli_error();
			mysqli_stmt_close($stmt);
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
	$query = mysqli_query($conn, "SELECT * FROM bkstr_user WHERE ".$column."='".$value."';");
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
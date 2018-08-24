<?php 
// define variables and set to empty values 
$CusID=$CusID_error="";

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
		$hostname = "localhost"; $dbuser="root"; $dbpass="root"; $db="bookstore_test";
		$conn = @mysqli_connect($hostname,$dbuser,$dbpass,$db) or 
		            die('Could not connect to MySQL DB: ' . mysqli_connect_error());
		
		$query = "SELECT * 
		          FROM `item`,`orders`
				  WHERE orders.ItemID=item.ItemID AND CusID='".$CusID."';";    		
		$result = mysqli_query($conn, $query);
		
	    if($result) 
	    {
			echo "<h3>Order History For '".$CusID."'</h3>";
			$rowCount = mysqli_num_rows($result);  
			
			if($rowCount == 0)
			    echo "This customer has not placed any orders yet.";
			
			else {
				echo '<table cellspacing="5" cellpadding="5">
						 <tr><td><b>Order_Date</b></td>
							 <td><b>ItemID</b></td>
							 <td><b>Item_Name</b></td>
							 <td><b>Item_Price</b></td>
							 <td><b>Quantity</b></td>
							 <td><b>Total_Price</b></td>
						 </tr>';
				while($row = mysqli_fetch_array($result)) 
				{
				   $total_price = floatval($row['Quantity']) * floatval($row['Price']);		
				   echo '<tr><td>'.
					 $row['Order_Date'].'</td><td>'.
					 $row['ItemID'].'</td><td>'.
					 $row['Item_Name'].'</td><td>'.
					 $row['Price'].'</td><td>'.
					 $row['Quantity'].'</td><td>'.
					 $total_price.'</td><td>';		   
				   echo '</tr>';
				}
			}	echo '</table>';
		}
	    else 
	    {
		    echo "Could not query database: " . mysqli_error($conn);
	    }
	    mysqli_close($conn);
	
    }//end pass-all-checks-if	
}//end submit post


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
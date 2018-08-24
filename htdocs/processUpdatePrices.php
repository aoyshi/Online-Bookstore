<?php 
// define variables and set to empty values 
$date=$date_error=$type="";

//when form is submitted with POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if(isset($_POST['type']))
	$type = $_POST['type']; 
  
  if(isset($_POST['update']))
	$update = $_POST['update'];

  if (empty($_POST["amount"])) {
    $amount_error = "Amount is required";
  } else {
    $amount = test_input($_POST["amount"]);
	if (!preg_match("/^[0-9]*\.[0-9]+$/",$amount)) 
	  if(!preg_match('/^\d+$/', $amount))
        $amount_error = "Invalid amound (must be a positive integer or decimal number)";
    }

	//check if all error-free before inserting
	if ($amount_error=='')
	{	
		$hostname = "localhost";
		$dbuser="root";
		$dbpass="root";
		$db="bookstore_test";
		$conn = @mysqli_connect($hostname,$dbuser,$dbpass,$db)
				or 
				die('Could not connect to MySQL DB -> ' . mysqli_connect_error());
		
		$query = "SELECT * FROM item WHERE Category='".$type."';";
				  
		$result = @mysqli_query($conn,$query);
	    if($result) 			
	    {
			echo "<h3>Prices of ".mysqli_num_rows($result)." ".$type."s ".$update."d by ".$amount."%</h3>";
			echo '<table cellspacing="5" cellpadding="5">
				 <tr><td><b>ItemID</b></td>
				     <td><b>Item_Name</b></td>
				     <td><b>Category</b></td>
					 <td><b>Old_Price</b></td>
					 <td><b>New_Price</b></td>
			     </tr>';
			
			while($row = mysqli_fetch_array($result))
			{			
				//get current item id
				$currentItemID = $row['ItemID'];
				//get old price
				$old = floatval($row['Price']);
				//get percent update
				$percent = floatval($amount)/100;
				//calculate new price
				  //if inc
				  if(strcmp($update,"increase")==0)
				     $new = round(($old + ($old*$percent)),2);
				  //if dec
				  if(strcmp($update,"decrease")==0)
				     $new = round(($old - ($old*$percent)),2);

				//update statement
				$queryUpdate="UPDATE item SET Price='".$new."' WHERE ItemID='".$currentItemID."';";		
				$resultUpdate = @mysqli_query($conn,$queryUpdate);
				
				echo '<tr><td>'.
				 $row['ItemID'].'</td><td>'.
				 $row['Item_Name'].'</td><td>'.
				 $row['Category'].'</td><td>$'.
				 $row['Price'].'</td><td>$'.
				 $new.'</td><td>';					 
		        echo '</tr>';			
			}
			echo '</table>';
	    }
				
		else
		{
			echo "Could not query the database: " . mysqli_error($conn);
		}
	}
}

//trims and checks input for html injections
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
} 

?>
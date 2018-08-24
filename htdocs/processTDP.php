<?php 
// define variables and set to empty values 
$date=$date_error=$type="";

//when form is submitted with POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if(isset($_POST['type']))
  {
	$type = $_POST['type'];  
  }
 

  if (empty($_POST["date"])) {
    $date_error = "Order Date is required";
  } else {
    $date = test_input($_POST["date"]);
	if(!validateDate($date)){
	   $date_error = "Invalid date format. Must be YYYY-MM-DD";
	}
  }


	//check if all error-free before inserting
	if ($date_error=='' and strlen($type)>0)
	{	
		$hostname = "localhost";
		$dbuser="root";
		$dbpass="root";
		$db="bookstore_test";
		$conn = @mysqli_connect($hostname,$dbuser,$dbpass,$db)
				or 
				die('Could not connect to MySQL DB -> ' . mysqli_connect_error());
		
		$query = "SELECT * FROM orders,item WHERE orders.ItemID=item.ItemID 
			      AND Category='".$type."' AND Order_Date='".$date."';";
				  
		$result = @mysqli_query($conn,$query);
	    if($result) 
	    {
			$sum=0;
			echo '<h3>Total Purchase Amount For All '.$type.'s on '.$date.'</h4>';
		    echo '<table cellspacing="5" cellpadding="5">
				 <tr><td><b>Item_Name</b></td>
				     <td><b>Category</b></td>
					 <td><b>Item_Price</b></td>
					 <td><b>Quantity</b></td>
					 <td><b>Customer</b></td>
					 <td><b>Order_Price</b></td>
					 <td><b>Order_Date</b></td>
			     </tr>';
			while($row = mysqli_fetch_array($result))
			{
				$totalPrice = floatval($row['Price']) * intval($row['Quantity']);
			    $sum += $totalPrice;
				
				echo '<tr><td>'.
				 $row['Item_Name'].'</td><td>'.
				 $row['Category'].'</td><td>'.
				 $row['Price'].'</td><td>'.
				 $row['Quantity'].'</td><td>'.
				 $row['CusID'].'</td><td>'.
				 $totalPrice.'</td><td>'.
				 $row['Order_Date'].'</td><td>';		   
		        echo '</tr>';
				
			}
			echo '</table>';
			echo "<br><hr><b>Total Purchase Amount is: $" . $sum."</b><br>";
	    }
		
		
		else
		{
			echo "Could not query the database: " . mysqli_error($conn);
		}
	

	}
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
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
<style> .error{color:red;} </style>
</head>
<body>

<div id="mynav">
  <a href="index.html"><span id="home">Home</span></a>
  <div data-role="main" class="ui-content" style="font-size:12px;">
    <div data-role="collapsible">
      <h1>View Users</h1>
		  <a href="ViewAllUsers.php"><p>All Users</p></a>
		  <a href="ViewStaff.php"><p>Staff</p></a>
		  <a href="ViewCustomers.php"><p>Customers</p></a>
    </div>
	<div data-role="collapsible">
      <h1>View Items</h1>
		  <a href="ViewAllItems.php"><p>All Items</p></a>
		  <a href="ViewBooks.php"><p>Books</p></a>
		  <a href="ViewFilms.php"><p>Films</p></a>	
		  <a href="ViewPeriodicals.php"><p>Periodicals</p></a>	
          <a href="ViewGenres.php"><p>Genres</p></a>
          <a href="ViewEBooks.php"><p>eBooks</p></a>
		  <a href="ViewAudioBooks.php"><p>Audio Books</p></a>
		  <a href="ViewMovies.php"><p>Movies</p></a>
		  <a href="ViewTVShows.php"><p>TV Shows</p></a>			  
    </div>
	<div data-role="collapsible">
      <h1>View Creators</h1>
		  <a href="ViewAllCreators.php"><p>All Creators</p></a>
		  <a href="ViewAuthors.php"><p>Authors</p></a>
		  <a href="ViewPublishers.php"><p>Publishers</p></a>	
		  <a href="ViewCompanies.php"><p>Companies</p></a>	
    </div>
    <div data-role="collapsible">
      <h1>Add New Data</h1>
		  <a href="addNewStaff.php"><p>Add Staff</p></a>
		  <a href="addNewCustomer.php"><p>Add Customer</p></a>
		  <a href="addNewItem.php"><p>Add Item</p></a>	
		  <a href="placeNewOrder.php"><p>Place New Order</p></a>
		  <a href="addCreator.php"><p>Add Creator</p></a>
		  <a href="addGenre.php"><p>Add Genre</p></a>			  
    </div>
	<div data-role="collapsible">
      <h1>Queries</h1>
		  <a href="COH.php"><p>Customer Order History</p></a>
		  <a href="OID.php"><p>Ordered Item Details</p></a>
		  <a href="TDP.php"><p>Total Daily Purchase</p></a>	
    </div>
	<div data-role="collapsible">
      <h1>Updates</h1>
		  <a href="updatePrices.php"><p>Update Prices</p></a>
		  <a href="deleteCustomer.php"><p>Delete Customer</p></a>
    </div>
  </div>
</div>

<div class="myMain">
  <?php
	require_once('mysql_connect.php');
	$query = "select * from bkstr_user,staff where Username=StaffID";
	$response = @mysqli_query($conn,$query);
	if($response) 
	{
		echo '<h3>STAFF MEMBERS</h3>';
		echo '<table cellspacing="5" cellpadding="5">
				 <tr><td><b>Username</b></td>
				     <td><b>Name</b></td>
					 <td><b>Phone</b></td>
					 <td><b>Address</b></td>
					 <td><b>Email</b></td>
					 <td><b>Password</b></td>
					 <td><b>DOB</b></td>
					 <td><b>Sex</b></td>
					 <td><b>SSN</b></td>
					 <td><b>Salary</b></td>
			     </tr>';
		while($row = mysqli_fetch_array($response)) 
		{
		   echo '<tr><td>'.
			 $row['Username'].'</td><td>'.
			 $row['Name'].'</td><td>'.
			 $row['Phone'].'</td><td>'.
			 $row['Address'].'</td><td>'.
			 $row['Email'].'</td><td>'.
			 $row['Password'].'</td><td>'.
			 $row['DOB'].'</td><td>'.
			 $row['Sex'].'</td><td>'.
			 $row['SSN'].'</td><td>'.
			 $row['Salary'].'</td><td>'
			 ;		   
		   echo '</tr>';
		}
		echo '</table>';
	}
	else 
	{
		echo "Could not query database";
	}
	mysqli_close($conn);
?>
</div> 
    
</body>
</html> 



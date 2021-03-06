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
    </div>
	<div data-role="collapsible">
      <h1>View Creators</h1>
		  <a href="ViewAllCreators.php"><p>All Creators</p></a>
		  <a href="ViewAuthors.php"><p>Authors</p></a>
		  <a href="ViewPublishers.php"><p>Publishers</p></a>	
		  <a href="ViewCompanies.php"><p>Companies</p></a>	
		  <a href="ViewEBooks.php"><p>eBooks</p></a>
		  <a href="ViewAudioBooks.php"><p>Audio Books</p></a>
		  <a href="ViewMovies.php"><p>Movies</p></a>
		  <a href="ViewTVShows.php"><p>TV Shows</p></a>	
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
   <?php include('processNewStaff.php'); ?>
  <form id="contact" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
    <h2>Add New Staff Member</h2>
	<p>* required fields</p>
	
    <fieldset>
    Name: <input placeholder="First Last" type="text" name="name" value="<?= $name ?>" tabindex="1" autofocus>
      <span class="error">* <?= $name_error ?></span>
    </fieldset>
    <fieldset>
      Email: <input placeholder="abc@example.com" type="text" name="email" value="<?= $email ?>" tabindex="2">
      <span class="error">* <?= $email_error ?></span>
    </fieldset>
	<fieldset>
      Username: <input placeholder="Max 12 characters" type="text" name="username" value="<?= $username ?>" tabindex="3">
      <span class="error">* <?= $username_error ?></span>
    </fieldset>
    <fieldset>
      Password: <input placeholder="Max 12 characters" type="text" name="password" value="<?= $password ?>" tabindex="3">
      <span class="error">* <?= $password_error ?></span>
    </fieldset>
	<fieldset>
      Phone: <input placeholder="123-456-7890" type="text" name="phone" value="<?= $phone ?>" tabindex="5">
      <span class="error"><?= $phone_error ?></span>
    </fieldset>
	<fieldset>
      Sex:
        <input type="radio" name="sex" value="F" checked="checked"/> Female
		<input type="radio" name="sex" value="M"/> Male
    </fieldset>
	<fieldset>
      Address: <input placeholder="Max 256 characters" type="text" name="address" value="<?= $address ?>" tabindex="7" >
      <span class="error">* <?= $address_error ?></span>
    </fieldset>
	<fieldset>
      Birthdate: <input placeholder="YYYY-MM-DD" type="text" name="DOB" value="<?= $DOB ?>" tabindex="8" >
      <span class="error">* <?= $DOB_error ?></span>
    </fieldset>
	<fieldset>
      SSN: <input placeholder="123456789" type="text" name="ssn" value="<?= $ssn ?>" tabindex="8" >
      <span class="error">* <?= $ssn_error ?></span>
    </fieldset>
	<fieldset>
      Salary: <input placeholder="e.g. 35000" type="text" name="salary" value="<?= $salary ?>" tabindex="8" >
      <span class="error">* <?= $salary_error ?></span>
    </fieldset>
      <button name="submit" type="submit" id="form-submit" data-submit="...Sending">Submit</button>
  </form>

</div> 
    
</body>
</html> 

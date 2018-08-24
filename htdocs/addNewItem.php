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
  <?php include('processNewItem.php'); ?>
  <form id="contact" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
    <h2>Add New Item</h2>
	<p>* required fields</p>
	
    <fieldset>
      ID Number: <input placeholder="#" type="text" name="id" value="<?= $id ?>" tabindex="1" autofocus>
      <span class="error">* <?= $id_error ?></span>
    </fieldset>
    <fieldset>
      Title: <input placeholder="Max 40 characters" type="text" name="title" value="<?= $title ?>" tabindex="2">
      <span class="error">* <?= $title_error ?></span>
    </fieldset>
	<fieldset>
      Category: 
      <input type="radio" name="type" value="ebook" onChange="getValue(this)"/> eBook
	  <input type="radio" name="type" value="audio_book" onChange="getValue(this)"/> Audio Book
	  <input type="radio" name="type" value="movie" onChange="getValue(this)"/> Movie
	  <input type="radio" name="type" value="tv_show" onChange="getValue(this)"/> TV Show
	  <input type="radio" name="type" value="periodical" onChange="getValue(this)"/> Periodical
    <span class="error">* <?= $category_error ?></span>
	</fieldset>
	
<!-------Start Hidden Fields------------>
<!--for BOOK-->
<div id="bookHide">
    <div id="BOOK" style="display:none; color:red;"> 
      <fieldset>
		ISBN: <input placeholder="10-13 digits" type="text" name="isbn" value="<?= $isbn ?>">
		  <span class="error">* <?= $isbn_error ?></span>
	  </fieldset>
	  <fieldset>
		Edition: <input placeholder="#" type="text" name="edition" value="<?= $edition ?>">
		  <span class="error"><?= $edition_error ?></span>
	  </fieldset>
    </div>
	<!--for ebook-->
    <div id="EBOOK" style="display:none;color:orange;"> 
      <fieldset>
		Total Pages: <input placeholder="#" type="text" name="pages" value="<?= $pages ?>">
		  <span class="error">* <?= $pages_error ?></span>
	  </fieldset>
    </div>
	<!--for audio-->
    <div id="AUDIO_BOOK" style="display:none;color:orange;"> 
      <fieldset>
		Time Length: <input placeholder="hours" type="text" name="time" value="<?= $time ?>">
		  <span class="error">* <?= $time_error ?></span>
	  </fieldset>
	  <fieldset>
		Narrator: <input placeholder="First Last" type="text" name="narrator" value="<?= $narrator ?>">
		  <span class="error">* <?= $narrator_error ?></span>
	  </fieldset>
    </div>
</div>
	
<!--for FILM-->
<div id="filmHide">
    <div id="FILM" style="display:none; color:green;"> 
      <fieldset>
		Director: <input placeholder="First Last" type="text" name="director" value="<?= $director ?>">
		  <span class="error">* <?= $director_error ?></span>
	  </fieldset>
	  <fieldset>
		Producer: <input placeholder="First Last" type="text" name="producer" value="<?= $producer ?>">
		  <span class="error">* <?= $producer_error ?></span>
	  </fieldset>
	  <fieldset>
		Rating: <input placeholder="e.g. PG-13" type="text" name="rating" value="<?= $rating ?>">
		  <span class="error">* <?= $rating_error ?></span>
	  </fieldset>
    </div>
	<!--for movie-->
    <div id="MOVIE" style="display:none;color:blue;"> 
      <fieldset>
		  Run Time: <input placeholder="hours" type="text" name="runTime" value="<?= $runTime ?>">
		  <span class="error">* <?= $runTime_error ?></span>
	  </fieldset>
    </div>
	<!--for tv show-->
    <div id="TV_SHOW" style="display:none;color:blue;"> 
       <fieldset>
		Total Seasons: <input placeholder="#" type="text" name="seasons" value="<?= $seasons ?>">
		  <span class="error">* <?= $seasons_error ?></span>
	  </fieldset>
	  <fieldset>
		Total Episodes: <input placeholder="#" type="text" name="episodes" value="<?= $episodes ?>">
		  <span class="error">* <?= $episodes_error ?></span>
	  </fieldset>
	  <fieldset>
        Network: <input placeholder="e.g. BBC" type="text" name="network" value="<?= $network ?>">
      <span class="error"><?= $network_error ?></span>
      </fieldset>  
    </div>
</div>

<!--for PERIODICAL-->
    <div id="PERIODICAL" style="display:none;color:purple;"> 
       <fieldset>
		Volume Number: <input placeholder="#" type="text" name="volume" value="<?= $volume ?>">
		  <span class="error">* <?= $volume_error ?></span>
	  </fieldset>
	  <fieldset>
		Issue Number: <input placeholder="#" type="text" name="issue" value="<?= $issue ?>">
		  <span class="error">* <?= $issue_error ?></span>
	  </fieldset>
    </div>
<!-- End Hidden Fields -->
	
<!-- Resume Non Hidden Fields -->
    <fieldset>
      Genre ID: <input placeholder="#" type="text" name="genre" value="<?= $genre ?>" tabindex="3">
      <span class="error">* <?= $genre_error ?></span>
    </fieldset>
	<fieldset>
      Price:  $ <input placeholder="e.g 12.99" type="text" name="price" value="<?= $price ?>" tabindex="4">
      <span class="error">* <?= $price_error ?></span>
    </fieldset>
	<fieldset>
      Availability:
        <input type="radio" name="availability" value="1" checked="checked"/> Y
		<input type="radio" name="availability" value="0"/> N
    </fieldset>
	<fieldset>
      Language: <input placeholder="e.g. Croatian" type="text" name="language" value="<?= $language ?>" tabindex="5" >
      <span class="error">* <?= $language_error ?></span>
    </fieldset>
	<fieldset>
      Description: <input type="text" name="description" value="<?= $description ?>" tabindex="6" >
    </fieldset>
    <fieldset>
      Add Creator (Enter at least ONE): <span class="error">* <?= $creator_error ?></span>
	  <fieldset>
	  Author ID: <input type="text" name="author" value="<?= $author ?>" ><span class="error"><?= $author_error ?></span>
	  </fieldset>
	  <fieldset>
	  Publisher ID: <input type="text" name="publisher" value="<?= $publisher ?>" ><span class="error"><?= $publisher_error ?></span>
	  </fieldset>
	  <fieldset>
	  Company ID: <input type="text" name="company" value="<?= $company ?>" ><span class="error"><?= $company_error ?></span>
      </fieldset>
	  --Can't find your content creator?<br>--Add your new creator's profile under Add Creator in the left menu :)
	</fieldset>
    <button name="submit" type="submit" id="submit">Submit</button>
  </form>

</div> 
   
<script type="text/javascript">
	function getValue(x) {
		
	   document.getElementById("bookHide").style.display = 'block'; 
	   document.getElementById("filmHide").style.display = 'block'; 
		
	  if(x.value=='ebook' || x.value=='audio_book')
	  {
		document.getElementById("filmHide").style.display = 'none'; 
        document.getElementById("PERIODICAL").style.display = 'none'; 		
		  
		document.getElementById("BOOK").style.display = 'block'; 
		if(x.value=='ebook')
			document.getElementById("EBOOK").style.display = 'block';
        else
			document.getElementById("EBOOK").style.display = 'none';
		if(x.value=='audio_book')
			document.getElementById("AUDIO_BOOK").style.display = 'block'; 
		else
			document.getElementById("AUDIO_BOOK").style.display = 'none'; 
		
	  }
	  if(x.value=='movie' || x.value=='tv_show')
	  {
		document.getElementById("bookHide").style.display = 'none'; 
		document.getElementById("PERIODICAL").style.display = 'none'; 
		
		document.getElementById("FILM").style.display = 'block'; 
		if(x.value=='movie')
			document.getElementById("MOVIE").style.display = 'block'; 
		else
			document.getElementById("MOVIE").style.display = 'none'; 
		if(x.value=='tv_show')
			document.getElementById("TV_SHOW").style.display = 'block';
		else
			document.getElementById("TV_SHOW").style.display = 'none';
	  }
	 
	  if(x.value=='periodical') 
	  {			
        document.getElementById("bookHide").style.display = 'none';   
		document.getElementById("filmHide").style.display = 'none'; 	
		document.getElementById("PERIODICAL").style.display = 'block'; 
	  }
	  else 
	  {
	 	document.getElementById("PERIODICAL").style.display = 'none'; 
	  }
	}
</script> 
</body>
</html> 

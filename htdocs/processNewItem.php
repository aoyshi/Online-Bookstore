<?php 
// define variables and set to empty values 

#for all items
  $id=$title=$category=$genre=$price=$availability=$language=$description="";
  $id_error=$title_error=$category_error=$genre_error=$price_error=$language_error="";
  $type="";

#for books(e+audio)
  $isbn=$edition=$pages=$time=$narrator="";
  $isbn_error=$edition_error=$pages_error=$time_error=$narrator_error="";

#for films(movie+tv)
  $director=$producer=$rating=$runTime=$rating=$seasons=$episodes=$network="";
  $director_error=$producer_error=$rating_error=$runTime_error=$rating_error=$seasons_error=$episodes_error=$network_error="";

#for periodicals
  $volume=$issue="";
  $volume_error=$issue_error="";

#for creators
  $author=$publisher=$company="";
  $creator_error=$author_error=$publisher_error=$company_error="";
 

//when form is submitted with POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if(isset($_POST['availability']))
  {
	$availability = $_POST['availability'];
  }
 
  if (empty($_POST["title"])) {
    $title_error = "Title is required";
  } else {
    $title = test_input($_POST["title"]);
	if (strlen($title)>40) {
	  $title_error = "Title cannot exceed 40 characters";
	}	  
  }

  if (empty($_POST["id"])) {
    $id_error = "ID is required";
  } else {
    $id = test_input($_POST["id"]);
	if(!preg_match('/^\d+$/', $id)) {
	  $id_error = "Invalid ID (must be an integer)"; 
	}
	if (!isUnique($id, "ItemID", "item")) {
      $id_error = "Item ID already exists!"; 
    }
  }

  if (!(isset($_POST['type']))) {
    $category_error = "You must choose a Category";
  } else {
    $type = $_POST['type'];
    if ($type=='ebook' || $type=='audio_book')
      $category = "Book";
    else if ($type=='movie' || $type=='tv_show')
      $category = "Film";
    else if($type=='periodical')
      $category = "Periodical";  	 
  }
	  
  if (empty($_POST["genre"])) {
    $genre_error = "Genre ID is required";
  } else {
    $genre = test_input($_POST["genre"]);
    if (isUnique($genre, "ID", "genre")) {
      $genre_error = "Genre ID does not exist!"; 
    }	
  }
  
  if (empty($_POST["price"])) {
    $price_error = "Price is required";
  } else {
    $price = test_input($_POST["price"]);
    // check if valid double
    if (!preg_match("/^[0-9]*\.[0-9]+$/",$price)) {
	  if(!preg_match('/^\d+$/', $price))
        $price_error = "Invalid price"; 
    }
  }
  
  $description = test_input($_POST["description"]);

  if (empty($_POST["language"])) {
    $language_error = "Language is required";
  } else {
    $language = test_input($_POST["language"]);
	// check if language only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$language)) {
      $language_error = "Only letters and white space allowed"; 
    }
	if (strlen($language)>12) {
	  $language_error = "Language cannot exceed 12 characters";
	}
  }

//checks for BOOK, EBOOK, AUDIO
if(strcmp($category,"Book")==0)
{   
    if (empty($_POST["isbn"])) {
    $isbn_error = "ISBN is required";
    } else {
    $isbn = test_input($_POST["isbn"]);
	if (strlen($isbn)<10 || strlen($isbn)>13) {
      $isbn_error = "ISBN must be between 10 to 13 digits"; 
    }
	if(!preg_match('/^\d+$/', $isbn)) {
	  $isbn_error = "Invalid ISBN format (must only contain numbers)"; 
	}
	if (!isUnique($isbn, "ISBN", "book")) {
      $id_error = "This ISBN already exists!"; 
    }
	
  }
   if (!empty($_POST["edition"])) {
    $edition = test_input($_POST["edition"]);
	if (!preg_match("/^[0-9]*\.[0-9]+$/",$edition)) {
	  if(!preg_match('/^\d+$/', $edition))
        $edition_error = "Invalid edition (must be integer or decimal number)"; 
    }
  }	  
 //check for ebook
 if(strcmp($type,"ebook")==0) 
 {
    if (empty($_POST["pages"])) {
    $pages_error = "Total Pages is required";
    } else {
      $pages= test_input($_POST["pages"]);
	  if(!preg_match('/^\d+$/', $pages)) {
	    $pages_error = "Invalid number of pages"; 
	  }
    }
 }
 //check for audio
  if(strcmp($type,"audio_book")==0) 
 {
    if (empty($_POST["time"])) {
    $time_error = "Time Length is required";
    } else {
       $time= test_input($_POST["time"]);
	   if (!preg_match("/^[0-9]*\.[0-9]+$/",$time)) 
	     if(!preg_match('/^\d+$/', $time))
           $time_error = "Invalid time length (must be integer or decimal number of hours)";     
    }
	if (empty($_POST["narrator"])) {
    $narrator_error = "Narrator name is required";
    } else {
      $narrator= test_input($_POST["narrator"]);
      // check if name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z ]*$/",$narrator)) {
        $narrator_error = "Only letters and white space allowed"; 
      }
	  if (strlen($narrator)>30) {
	    $narrator_error = "Narrator name cannot exceed 30 characters";
	  }	  
    }
  }
}//end book check


//checks for FILM, MOVIE, TVSHOW
if(strcmp($category,"Film")==0)
{
  if (empty($_POST["director"])) {
    $director_error = "Director name is required";
  } else {
    $director = test_input($_POST["director"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$director)) {
      $director_error = "Only letters and white space allowed"; 
    }
	if (strlen($director)>30) {
	  $director_error = "Director name cannot exceed 30 characters";
	}	  
  }
  
  if (empty($_POST["producer"])) {
    $producer_error = "Producer name is required";
  } else {
    $producer = test_input($_POST["producer"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$producer)) {
      $producer_error = "Only letters and white space allowed"; 
    }
	if (strlen($producer)>30) {
	  $producer_error = "Producer name cannot exceed 30 characters";
	}	  
  }
  
  if (empty($_POST["rating"])) {
    $rating_error = "Rating is required";
  } else {
    $rating = test_input($_POST["rating"]);
	if (strlen($rating)>5) {
	  $rating_error = "Rating cannot exceed 5 characters";
	}	  
  }
 //check movie
 if(strcmp($type,"movie")==0) 
 {   if (empty($_POST["runTime"])) {
    $runTime_error = "Run Time is required";
    } else {
       $runTime= test_input($_POST["runTime"]);
	   if (!preg_match("/^[0-9]*\.[0-9]+$/",$runTime)) 
	     if(!preg_match('/^\d+$/', $runTime))
           $runTime_error = "Invalid Run Time(must be integer or decimal number of hours)";     
    }
 }

 //check tv show
 if(strcmp($type,"tv_show")==0) 
 {
	 if (empty($_POST["seasons"])) {
    $seasons_error = "Total number of seasons is required";
  } else {
    $seasons = test_input($_POST["seasons"]);
	if(!preg_match('/^\d+$/', $seasons)) {
	  $seasons_error = "Invalid number of seasons (must be an integer)"; 
	}
  }
    if (empty($_POST["episodes"])) {
    $episodes_error = "Total number of episodes is required";
  } else {
    $episodes = test_input($_POST["episodes"]);
	if(!preg_match('/^\d+$/', $episodes)) {
	  $episodes_error = "Invalid number of episodes (must be an integer)"; 
	}
  }
  
  if (!empty($_POST["network"]))
  {
	  $network = test_input($_POST["network"]);
	  if (strlen($network)>20) {
	  $network_error = "Network name cannot exceed 20 characters";
	}	  
  }
 }
 
}//end film check
  
//checks for PERIODICAL
if(strcmp($category,"Periodical")==0)
{
   if (empty($_POST["volume"])) {
    $volume_error = "Volume number is required";
  } else {
    $volume = test_input($_POST["volume"]);
	if(!preg_match('/^\d+$/', $volume)) {
	  $volume_error = "Invalid Volume number(must be an integer)"; 
	}
  }
  
  if (empty($_POST["issue"])) {
    $issue_error = "Issue number is required";
  } else {
    $issue = test_input($_POST["issue"]);
	if(!preg_match('/^\d+$/', $issue)) {
	  $issue_error = "Invalid Issue number(must be an integer)"; 
	}
  }
}//end periodical check
  
//creators
  if (empty($_POST["author"]) && empty($_POST["publisher"]) && empty($_POST["company"]))
    $creator_error = "At least ONE Creator ID is required";
  
    if (!empty($_POST["author"])) 
	{
		$author = test_input($_POST["author"]);
		if (isUnique($author, "AuthorID", "author"))
          $author_error = "Author ID does not exist! Add new Author profile first.";      
    }  
  
    if (!empty($_POST["publisher"])) 
	{
		$publisher = test_input($_POST["publisher"]);
		if (isUnique($publisher, "PubID", "publisher"))
          $publisher_error = "Publisher ID does not exist! Add new Publisher profile first.";      
    } 
    
    if (!empty($_POST["company"])) 
	{
		$company = test_input($_POST["company"]);
		if (isUnique($company, "CompID", "company"))
          $company_error = "Company ID does not exist! Add new Company profile first.";      
    } 
  
  
  
//check if all error-free before inserting
	if ($id_error=='' and $title_error=='' and $category_error=='' and $genre_error=='' and $price_error=='' and $language_error=='' and 
	$description_error=='' and $isbn_error=='' and $edition_error=='' and $pages_error=='' and $time_error=='' and $narrator_error=='' and   
	$director_error=='' and $producer_error=='' and $rating_error=='' and $runTime_error=='' and $seasons_error=='' and $episodes_error=='' and 
	$network_error=='' and $volume_error=='' and $issue_error=='' and $creator_error=='' and $author_error=='' and $publisher_error=='' and $company_error=='')
	{	
		$hostname = "localhost";
		$dbuser="root";
		$dbpass="root";
		$db="bookstore_test";
		$conn = @mysqli_connect($hostname,$dbuser,$dbpass,$db)
				or 
				die('Could not connect to MySQL DB -> ' . mysqli_connect_error());
		
		$availability = intval($_POST['availability']);

        //ALL ITEMS		
		$query = "INSERT INTO `item` (`ItemID`, `Item_Name`, `Category`, `Genre_ID`, 
		`Price`, `Availability`, `Description`, `Language`) VALUES ('".$id."','".$title."','"
		.$category."','".$genre."','".$price."','".$availability."','".$description."','".$language."');";	
		
		$result = mysqli_query($conn, $query);
        if($result)
	        echo "Successfully inserted in ITEM!<br>";
        else
	        echo "Failed to insert in ITEM: " . mysqli_error($conn) ."<br>";
		
		//BOOKS
		if(strcmp($category,"Book")==0)
		{
		   $query = "INSERT INTO `book` (`BookID`, `ISBN`, `Edition`, `Format`) VALUES ('".$id."','".$isbn."','".$edition."','".$type."');";  
           $result = mysqli_query($conn, $query);
           if($result)
	          echo "Successfully inserted in BOOK!<br>";
           else
	          echo "Failed to insert in BOOK: " . mysqli_error($conn) ."<br>";
		}
		//EBOOKS
		if(strcmp($type,"ebook")==0)
		{
		   $query = "INSERT INTO `ebook` (`eBookID`, `Total_Pages`) VALUES ('".$id."','".$pages."');";  
           $result = mysqli_query($conn, $query);
           if($result)
	          echo "Successfully inserted in EBOOK!<br>";
           else
	          echo "Failed to insert in EBOOK: " . mysqli_error($conn) ."<br>";
		}
		//AUDIO BOOKS
		if(strcmp($type,"audio_book")==0)
		{
		   $query = "INSERT INTO `audio_book` (`AudioID`, `Time_Length`, `Narrator`) VALUES ('".$id."','".$time."','".$narrator."');";  
           $result = mysqli_query($conn, $query);
           if($result)
	          echo "Successfully inserted in AUDIO_BOOK!<br>";
           else
	          echo "Failed to insert in AUDIO_BOOK: " . mysqli_error($conn) ."<br>";
		}
		//FILMS
		if(strcmp($category,"Film")==0)
		{
		   $query = "INSERT INTO `film` (`FilmID`, `Director`, `Producer`,`Rating`,`Type`) 
		             VALUES ('".$id."','".$director."','".$producer."','".$rating."','".$type."');";  
           $result = mysqli_query($conn, $query);
           if($result)
	          echo "Successfully inserted in FILM!<br>";
           else
	          echo "Failed to insert in FILM: " . mysqli_error($conn) ."<br>";
		}
		//MOVIE
		if(strcmp($type,"movie")==0)
		{
		   $query = "INSERT INTO `movie` (`MovieID`, `RunTime`) VALUES ('".$id."','".$runTime."');";  
           $result = mysqli_query($conn, $query);
           if($result)
	          echo "Successfully inserted in MOVIE!<br>";
           else
	          echo "Failed to insert in MOVIE: " . mysqli_error($conn) ."<br>";
		}
		//TV SHOW
		if(strcmp($type,"tv_show")==0)
		{
		   $query = "INSERT INTO `tv_show` (`TV_ID`, `No_of_Seasons`, `No_of_Episodes`,`Network`) VALUES ('".$id."','".$seasons."','".$episodes."','".$network."');";  
           $result = mysqli_query($conn, $query);
           if($result)
	          echo "Successfully inserted in TV_SHOW!<br>";
           else
	          echo "Failed to insert in TV_SHOW: " . mysqli_error($conn) ."<br>";
		}
		//PERIODICAL
		if(strcmp($category,"Periodical")==0)
		{
		   $query = "INSERT INTO `periodical` (`Peri_ID`, `Volume_No`, `Issue_No`) VALUES ('".$id."','".$volume."','".$issue."');";  
           $result = mysqli_query($conn, $query);
           if($result)
	          echo "Successfully inserted in PERIODICAL!<br>";
           else
	          echo "Failed to insert in PERIODICAL: " . mysqli_error($conn) ."<br>";	  
		}
		
		//Creator
		if(!empty($_POST["author"])) 
		{   
	       $query = "INSERT INTO `created_by` (`Creator_ID`, `Item_ID`) VALUES ('".$author."','".$id."');";  
           $result = mysqli_query($conn, $query);
           if($result)
	          echo "Successfully inserted AuthorID in CREATED_BY!<br>";
           else
	          echo "Failed to insert AuthorID in CREATED_BY: " . mysqli_error($conn) ."<br>";
		}
		if(!empty($_POST["publisher"])) 
		{   
	       $query = "INSERT INTO `created_by` (`Creator_ID`, `Item_ID`) VALUES ('".$publisher."','".$id."');";  
           $result = mysqli_query($conn, $query);
           if($result)
	          echo "Successfully inserted PublisherID in CREATED_BY!<br>";
           else
	          echo "Failed to insert PublisherID in CREATED_BY: " . mysqli_error($conn) ."<br>";
		}
		if(!empty($_POST["company"])) 
		{   
	       $query = "INSERT INTO `created_by` (`Creator_ID`, `Item_ID`) VALUES ('".$company."','".$id."');";  
           $result = mysqli_query($conn, $query);
           if($result)
	          echo "Successfully inserted CompanyID in CREATED_BY!<br>";
           else
	          echo "Failed to insert CompanyID in CREATED_BY: " . mysqli_error($conn) ."<br>";
		}
	
	}//end all-checks-pass if
}//end submit-post if



### AUXILIARY FUNCTIONS
//checks if value already exists in database 
function isUnique($value,$column,$table) {
    //connect to mysql database
	$hostname = "localhost";
	$dbuser="root";
	$dbpass="root";
	$db="bookstore_test";
	$conn = @mysqli_connect($hostname,$dbuser,$dbpass,$db) 
			or die('Could not connect to MySQL DB -> ' . mysqli_connect_error()); 
	
	//check if value exists
	$isUnique = true;
	$query = mysqli_query($conn, "SELECT * FROM ".$table." WHERE ".$column."='".$value."';");
    if (!$query)
      die('Error connecting to database: ' . mysqli_connect_error($conn));
    
    if(mysqli_num_rows($query) > 0)
	  $isUnique = false;
  
    mysqli_close($conn);
	return $isUnique;
}


//trims and checks input for html injections
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
} 

?>
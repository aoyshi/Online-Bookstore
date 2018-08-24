<?php 
// define variables and set to empty values 
$OrderID=$OrderID_error=$ItemID="";

//when form is submitted with POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
 
  if (empty($_POST["OrderID"])) {
    $OrderID_error = "Order ID is required";
  } else {
    $OrderID = test_input($_POST["OrderID"]);
    // check if OrderID exists in db
    if (!existsInDB($OrderID,"OrderID","orders")) {
      $OrderID_error = "This Order ID does not exist"; 
    }	
  }

  //check if all error-free before inserting
    if ($OrderID_error == '')
    {	
		$hostname = "localhost"; $dbuser="root"; $dbpass="root"; $db="bookstore_test";
		$conn = @mysqli_connect($hostname,$dbuser,$dbpass,$db) or 
		            die('Could not connect to MySQL DB: ' . mysqli_connect_error());
		
		$query = "SELECT * 
		          FROM `item`,`orders`,`genre`
				  WHERE genre.ID=item.Genre_ID AND orders.ItemID=item.ItemID AND OrderID='".$OrderID."';";    		
		$result = mysqli_query($conn, $query);
		
	    if($result) 
	    {
		  echo "<h4>Item Profile:</h4>";
          $row = mysqli_fetch_array($result);
		  $Category = $row['Category'];
		  $ItemID = $row['ItemID'];
		  $Genre = $row['Name'];

		  //if book
		  if(strcmp($Category,"Book")==0)
		  {
			$queryBook = "SELECT * FROM `book` WHERE BookID='".$ItemID."';";    		
		    $resultBook = mysqli_query($conn, $queryBook);
			$rowBook = mysqli_fetch_array($resultBook);
			$Format = $rowBook['Format'];
			//---if EBOOK
			if(strcmp($Format,"ebook")==0)
			{
			  $queryEBook = "SELECT * FROM `ebook` WHERE eBookID='".$ItemID."';";    		
		      $resultEBook = mysqli_query($conn, $queryEBook);
			  $rowEBook = mysqli_fetch_array($resultEBook);
					echo '<table cellspacing="5" cellpadding="5">
							 <tr><td><b>ItemID</b></td>
								 <td><b>Item_Name</b></td>
								 <td><b>Type</b></td>
								 <td><b>Genre</b></td>
								 <td><b>Price</b></td>
								 <td><b>Language</b></td>
								 <td><b>Description</b></td>
								 <td><b>Total_Pages</b></td>
							 </tr>';
					echo '<tr><td>'.
						 $row['ItemID'].'</td><td>'.
						 $row['Item_Name'].'</td><td>'.
						 $Format.'</td><td>'.
						 $Genre.'</td><td>'.
						 $row['Price'].'</td><td>'.
						 $row['Language'].'</td><td>'.
						 $row['Description'].'</td><td>'.
						 $rowEBook['Total_Pages'].'</td><td>';		   
					echo '</tr>';
					echo '</table>';
			}			 			  
			
			//----if audio book
			if(strcmp($Format,"audio_book")==0)
			{
			  $queryABook = "SELECT * FROM `audio_book` WHERE AudioID='".$ItemID."';";    		
		      $resultABook = mysqli_query($conn, $queryABook);
			  $rowABook = mysqli_fetch_array($resultABook);
					echo '<table cellspacing="5" cellpadding="5">
							 <tr><td><b>ItemID</b></td>
								 <td><b>Item_Name</b></td>
								 <td><b>Type</b></td>
								 <td><b>Genre</b></td>
								 <td><b>Price</b></td>
								 <td><b>Language</b></td>
								 <td><b>Description</b></td>
								 <td><b>Time_Length</b></td>
								 <td><b>Narrator</b></td>
							 </tr>';
					echo '<tr><td>'.
						 $row['ItemID'].'</td><td>'.
						 $row['Item_Name'].'</td><td>'.
						 $Format.'</td><td>'.
						 $Genre.'</td><td>'.
						 $row['Price'].'</td><td>'.
						 $row['Language'].'</td><td>'.
						 $row['Description'].'</td><td>'.
						 $rowABook['Time_Length'].'</td><td>'.
						 $rowABook['Narrator'].'</td><td>';		   
					echo '</tr>';
					echo '</table>';
			}			 			  
		  }//end book if
		
		//if film
		if(strcmp($Category,"Film")==0)
		{ 
	        $queryFilm = "SELECT * FROM `film` WHERE FilmID='".$ItemID."';";    		
		    $resultFilm = mysqli_query($conn, $queryFilm);
			$rowFilm = mysqli_fetch_array($resultFilm);
			$Type = $rowFilm['Type'];
			
		    if(strcmp($Type,"movie")==0)
			{
		      $queryMovie = "SELECT * FROM `movie` WHERE MovieID='".$ItemID."';";    		
		      $resultMovie = mysqli_query($conn, $queryMovie);
			  $rowMovie = mysqli_fetch_array($resultMovie);
					echo '<table cellspacing="5" cellpadding="5">
							 <tr><td><b>ItemID</b></td>
								 <td><b>Item_Name</b></td>
								 <td><b>Type</b></td>
								 <td><b>Genre</b></td>
								 <td><b>Price</b></td>
								 <td><b>Language</b></td>
								 <td><b>Description</b></td>
								 <td><b>Director</b></td>
								 <td><b>Producer</b></td>
								 <td><b>Rating</b></td>
								 <td><b>RunTime</b></td>
							 </tr>';
					echo '<tr><td>'.
						 $row['ItemID'].'</td><td>'.
						 $row['Item_Name'].'</td><td>'.
						 $Type.'</td><td>'.
						 $Genre.'</td><td>'.
						 $row['Price'].'</td><td>'.
						 $row['Language'].'</td><td>'.
						 $row['Description'].'</td><td>'.
						 $rowFilm['Director'].'</td><td>'.
						 $rowFilm['Producer'].'</td><td>'.
						 $rowFilm['Rating'].'</td><td>'.
						 $rowMovie['RunTime'].'</td><td>';		   
					echo '</tr>';
					echo '</table>';
			}
			//else if tv show
			if(strcmp($Type,"tv_show")==0)
			{
		      $queryTV = "SELECT * FROM `tv_show` WHERE TV_ID='".$ItemID."';"; 		  
		      $resultTV = mysqli_query($conn, $queryTV);
			  $rowTV = mysqli_fetch_array($resultTV);
					echo '<table cellspacing="5" cellpadding="5">
							 <tr><td><b>ItemID</b></td>
								 <td><b>Item_Name</b></td>
								 <td><b>Type</b></td>
								 <td><b>Genre</b></td>
								 <td><b>Price</b></td>
								 <td><b>Language</b></td>
								 <td><b>Description</b></td>
								 <td><b>Director</b></td>
								 <td><b>Producer</b></td>
								 <td><b>Rating</b></td>
								 <td><b>No_of_Seasons</b></td>
								 <td><b>No_of_Episodes</b></td>
								 <td><b>Network</b></td>
							 </tr>';
					echo '<tr><td>'.
						 $row['ItemID'].'</td><td>'.
						 $row['Item_Name'].'</td><td>'.
						 $Type.'</td><td>'.
						 $Genre.'</td><td>'.
						 $row['Price'].'</td><td>'.
						 $row['Language'].'</td><td>'.
						 $row['Description'].'</td><td>'.
						 $rowFilm['Director'].'</td><td>'.
						 $rowFilm['Producer'].'</td><td>'.
						 $rowFilm['Rating'].'</td><td>'.
						 $rowTV['No_of_Seasons'].'</td><td>'.
						 $rowTV['No_of_Episodes'].'</td><td>'.
						 $rowTV['Network'].'</td><td>';		   
					echo '</tr>';
					echo '</table>';
			}
        }//end film
		
		
	    //if periodical
		if(strcmp($Category,"Periodical")==0)
		{
			  $queryPeri = "SELECT * FROM `periodical` WHERE Peri_ID='".$ItemID."';";    		
		      $resultPeri = mysqli_query($conn, $queryPeri);
			  $rowPeri = mysqli_fetch_array($resultPeri);
					echo '<table cellspacing="5" cellpadding="5">
							 <tr><td><b>ItemID</b></td>
								 <td><b>Item_Name</b></td>
								 <td><b>Type</b></td>
								 <td><b>Genre</b></td>
								 <td><b>Price</b></td>
								 <td><b>Language</b></td>
								 <td><b>Description</b></td>
								 <td><b>Volume_No</b></td>
								 <td><b>Issue_No</b></td>
							 </tr>';
					echo '<tr><td>'.
						 $row['ItemID'].'</td><td>'.
						 $row['Item_Name'].'</td><td>'.
						 $Category.'</td><td>'.
						 $Genre.'</td><td>'.
						 $row['Price'].'</td><td>'.
						 $row['Language'].'</td><td>'.
						 $row['Description'].'</td><td>'.
						 $rowPeri['Volume_No'].'</td><td>'.
						 $rowPeri['Issue_No'].'</td><td>';		   
					echo '</tr>';
					echo '</table>';
		}//end peri

	  //show creators
	  		  $queryC = "SELECT * FROM `created_by`,`creator` WHERE Creator_ID=ID AND Item_ID='".$ItemID."';";    		
		      $resultC = mysqli_query($conn, $queryC);
					echo "<h4>Item Creators:</h4>";
					echo '<table cellspacing="5" cellpadding="5">
							 <tr><td><b>Classification</b></td>
								 <td><b>Creator_Name</b></td>
								 <td><b>Creator_ID</b></td>
							 </tr>';
				  while($rowC = mysqli_fetch_array($resultC)) 
				  {
					  echo '<tr><td>'.
						 $rowC['Classification'].'</td><td>'.
						 $rowC['Name'].'</td><td>'.
						 $rowC['ID'].'</td><td>';		   
					  echo '</tr>';
				  }
				  echo '</table>';
		
		
		
	  }//end all-results-if
      //else to if(result)
      else 
	  {
        echo "Could not query database: " . mysqli_error($conn);
	  }
	  mysqli_close($conn);
	  
 

    }//no errors if	
}//post submit


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
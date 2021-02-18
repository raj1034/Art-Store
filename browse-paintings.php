<?php
   require_once('includes/art-config.php');
   require('includes/header.php');
   require_once('includes/queries.php');

   //Following if statements determines how to filter the artstore, whether by all paintings or by artist ID as an example.

   if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['artist']) && !empty($_GET['artist'])) {
      $artworks = readSelectedArtWorksByArtistID($_GET['artist']); //Filters paintings by artist ID 
   }
   else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['museum']) && !empty($_GET['museum'])) {
      $artworks = readSelectedArtWorksByGalleryID($_GET['museum']); //Filters paintings by Gallery ID.  
   }
   else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['shape']) && !empty($_GET['shape']) ) {
      $artworks = readSelectedArtWorksByShapeID($_GET['shape']); //Filters paintings by shape ID.  
   }
   else {
      $artworks = readAllArtWorks(); //Displays top 20 artworks.    
   } 
			
?>


<!DOCTYPE html>
<html lang=en>
<head>
    <meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="css/semantic.js"></script>
        <script src="js/misc.js"></script>
    
    <link href="css/semantic.css" rel="stylesheet" >
    <link href="css/icon.css" rel="stylesheet" >
    <link href="css/styles.css" rel="stylesheet">
    
</head>
<body > 
    
<main class="ui segment doubling stackable grid container">

   <section class="five wide column">
      <form class="ui form" role="search" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
         <h4 class="ui dividing header">Filters</h4>

            <div class="field">
               <label>Artist</label>
               <select class="ui fluid dropdown" name = "artist">
                  <option value = "0">Select Artist</option>  


                  <?php
		     $painter = readSelectArtWorkByArtist(); //Shows each artist to filter by and their full name in the respective dropdown list.

	             foreach ($painter as $pt) {
		        echo '<option value = "'. $pt['ArtistID'] . '">' . $pt['FirstName'] . ' ' . $pt['LastName'] . '</option>';
	             }
		  ?>
               </select>
           </div>  
           <div class="field">
              <label>Museum</label>
              <select class="ui fluid dropdown" name = "museum">
                 <option value = "0">Select Museum</option>  
                 <?php
		    $museum = readSelectArtWorkByMuseum(); //Shows each museum name to filter by in the respective dropdown list.
		    foreach ($museum as $ms) {
		       echo '<option value = "' . $ms['GalleryID'] . '">' . $ms['GalleryName'] . '</option>'; //Outputs information described in comment above for each museum.
		   }

		?>

            </select>
          </div>   
          <div class="field">
            <label>Shape</label>
            <select class="ui fluid dropdown" name = "shape">
               <option value ="0">Select Shape</option>
	          <?php
		     $shapes = readSelectArtWorkByShape(); //Shows each shape name to filter by in the respective dropdown list.
		     foreach ($shapes as $sp) {
		        echo '<option value = "' . $sp['ShapeID'] . '">' . $sp['ShapeName'] . '</option>';
		     }

		  ?>

            </select>
          </div>   

          <button class="small ui orange button" type="submit">
             <i class="filter icon"></i> Filter 
          </button>    

        </form>
    </section>
    

    <section class="eleven wide column">
       <h1 class="ui header">Paintings</h1>
       <p><h5>ALL PAINTINGS [TOP 20]</h5></p>
       <ul class="ui divided items" id="paintingsList">
          <?php

             //Following for loop reads each painting and displays information about it
	     foreach ($artworks as $aw) {
	        echo '<li class="item">';
		echo '<a class="ui small image" href="single-painting.php?id=' . $aw['PaintingID'] . '"><img src="images/art/works/square-medium/' . $aw['ImageFileName'] . '.jpg"></a>';
		echo '<div class="content">';
		echo '<a class="header" href="single-painting.php?id=' . $aw['PaintingID'] . '">' . $aw['Title'] . '</a>';
		$artist = getSelectedPainter($aw['ArtistID']);

		foreach ($artist as $a) {
		   echo '<div class="meta"><span class="cinema">' . $a['LastName'] .'</span></div>';
		}

		echo '<div class="description">';
		echo '<p>' . $aw['Description'] . '</p>'; //Displays painting description
		echo '</div>';
		echo '<div class="meta">';
                echo '<strong>$'. intval($aw['MSRP']) . '</strong>'; //Displays how much the painting costs in dollars.
		echo '</div>';
		echo '<div class="extra">';
		echo '<a class="ui icon orange button" href="cart.php?id=' . $aw['PaintingID'] . '&file=' . $aw['ImageFileName'] . '&title=' . $aw['Title'] . '"><i class="add to cart                        icon"></i></a>';
		echo '<a class="ui icon button" href="addToFavorites.php?id=' . $aw['PaintingID'] . '&file=' . $aw['ImageFileName'] . '&title=' . $aw['Title'] . '"><i class="heart                           icon"></i></a>';
		echo '</div>';
		echo '</div>';
		echo '</li>';   

	     }
	  ?>  
       </ul>        
    </section>  
    
</main>    
    
  <footer class="ui black inverted segment">
     <div class="ui container">footer for later</div>
  </footer>
</body>
</html>
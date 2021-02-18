<?php
   require_once('includes/art-config.php');
   require('includes/header.php');
   require_once('includes/queries.php');

   if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && !empty($_GET['id']) ) {
      $artWorks = readArtWork($_GET['id']); //Display painting with provided id. 
   }

   else {
      $artWorks = readArtWork('5'); //If an id is missing, display a default painting as per assignment instructions. In this case, with id 5.     
   } 

   $aw = 0;
   foreach($artWorks as $art) {
      $aw = $art;
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
<main >

   <!-- Main section about painting -->
   <section class="ui segment grey100">
      <div class="ui doubling stackable grid container">
		
         <div class="nine wide column">
            <?php echo '<img src="images/art/works/medium/' . $aw['ImageFileName'] . '.jpg" alt="..." class="ui big image" id="artwork">'; ?>
            <div class="ui fullscreen modal">
               <div class="image content">
                  <?php echo '<img src="images/art/works/large/' .$aw['ImageFileName'] . '.jpg" alt="..." class="image" >'; ?>
                  <div class="description">

                     <p></p>
                  </div>
               </div>
            </div>                     
         </div>	<!-- END LEFT Picture Column --> 
	 <div class="seven wide column">
                
         <!-- Main Info -->
            <div class="item">
	       <?php 

	          echo '<h2 class="header">' . $aw['Title'] . '</h2>';
		  $artist = getSelectedPainter($aw['ArtistID']);
		  foreach ($artist as $a) {
		     echo '<h3 >' . $a['LastName'] . '</h3>'; //Show the lastname of the illustrated painting.
		  }	
						
	       ?>
	       <div class="meta">
	       <p>
	          <?php 

                     /* The following code segment takes care of reviews. It takes all of the reviews attributed to a specified painting, adds them to
                       an array, then determines the average of that array. From there, it enters a for loop between 0 and 5, since that is the range of reviews, 
                       and assigns each painting the weighted average of its reviews. If the average of the array is 0, the code segment will return 5 blank stars to
                       indicate 0 out of 5. I used the ceil function to round up any resultant decimal averages as per assignment instructions */


		     $review = readChosenReview($aw['PaintingID']);
		     $arr = array();
		     foreach($review as $r) {
		        array_push($arr, intval($r['Rating']));
                        //$i = 0;
	             }
		     $avg = 0;
		     if(count($arr) == 0){
                        $avg = 0;
		     }
		     else{
                        $avg = array_sum($arr)/count($arr);
                     }
                     if(!is_int($avg)) {
                        $avg = ceil($avg);
                     }
                     for($i = 0 ; $i < 5 ; $i ++) {
                        if($i < $avg) {
                           echo '<i class="orange star icon"></i>';
                        }
                        else {
                           echo '<i class="empty star icon"></i>';
                        }
                     }
                                                         
		  ?>
	       </p>
	       <?php echo '<p>' . $aw['Excerpt'] . '</p>' ;?>
	    </div>  
         </div>                          
                  
         <!-- Tabs For Details, Museum, Genre, Subjects -->
         <div class="ui top attached tabular menu ">
            <a class="active item" data-tab="details"><i class="image icon"></i>Details</a>
            <a class="item" data-tab="museum"><i class="university icon"></i>Museum</a>
            <a class="item" data-tab="genres"><i class="theme icon"></i>Genres</a>
            <a class="item" data-tab="subjects"><i class="cube icon"></i>Subjects</a>    
         </div>
                
         <div class="ui bottom attached active tab segment" data-tab="details">
            <table class="ui definition very basic collapsing celled table">
	       <tbody>
	          <tr>
		    <td>
		       Artist
		    </td>
		    <td>
		       <?php 

		          $artist = getSelectedPainter($aw['ArtistID']);
			  foreach ($artist as $a) {
			     echo '<a href="#">' . $a['LastName'] . '</h3>';

			  }

		       ?>

		    </td>                       
		 </tr>
		 <tr>                       
		    <td>
		       Year
		    </td>
		    <td>
		       <?php echo $aw['YearOfWork']; ?>
		    </td>
		 </tr>       
		 <tr>
		    <td>
		       Medium
		    </td>
		    <td>
		       <?php echo $aw['Medium']; ?>
		    </td>
		 </tr>  
		 <tr>
		    <td>
		       Dimensions
		    </td>
		    <td>
		       <?php echo $aw['Width'] . 'cm x ' . $aw['Height'] . 'cm'; ?>
		    </td>
		 </tr>        
	      </tbody>
	   </table>
        </div>
				
        <div class="ui bottom attached tab segment" data-tab="museum">
           <table class="ui definition very basic collapsing celled table">
                      <tbody>
                        <tr>
                          <td>
                              Museum
                          </td>
                          <td>

			     <?php
			        $museum = getSelectedMuseum($aw['GalleryID']);
				foreach ($museum as $m) {
				   echo $m['GalleryName']; //Shows the museum name of the selected painting.
				}

			     ?>

                          </td>
                       </tr>       
                       <tr>
                          <td>
                             Assession #
                          </td>
                          <td>
			     <?php echo $aw['AccessionNumber']; ?>
                          </td>
                       </tr>  
                       <tr>
                          <td>
                             Copyright
                          </td>
                          <td>
			     <?php echo $aw['CopyrightText']; ?>
                          </td>
                       </tr>       
                       <tr>
                          <td>
                             URL
                          </td>
                          <td>

                             <?php

			        $museum = getSelectedMuseum($aw['GalleryID']);
				foreach ($museum as $m) {
				   echo '<a href="' . $m['GalleryWebSite'] . '">View painting at museum site</a>'; 
				}

			    ?>

                          </td>
                       </tr>        
                    </tbody>
                 </table>    
              </div>     
              <div class="ui bottom attached tab segment" data-tab="genres">
                 <ul class="ui list">
		    <?php

		       $genres = getSelectedGenre($aw['PaintingID']);
		       foreach ($genres as $g) {
		          echo '<li class="item"><a href="#">' . $g['GenreName'] . '</a></li>'; //Shows the genres of the selected painting as a list.
		       }

		    ?>

                 </ul>
              </div>  
              <div class="ui bottom attached tab segment" data-tab="subjects">
                 <ul class="ui list">
		    <?php

		       $subjects = getChosenSubject($aw['PaintingID']);
		       foreach ($subjects as $s) {
		          echo '<li class="item"><a href="#">' . $s['SubjectName'] . '</a></li>'; //Shows the subjects of the selected painting as a list.
		       }

		    ?>

                 </ul>
              </div>  
                
              <!-- Cart and Price -->
              <div class="ui segment">
                 <div class="ui form">
                    <div class="ui tiny statistic">
                       <div class = "value">
                          <?php echo '$'. intval($aw['MSRP']); ?>
                       </div>
                    </div>
                    <div class="four fields">
                       <div class="three wide field">
                          <label>Quantity</label>
                          <input type="number">
                       </div>                               
                       <div class="four wide field">
                          <label>Frame</label>
                          <select id="frame" class="ui search dropdown">
                             <option>None</option>
                             <?php

			     $frame = getChosenTable('typesframes');
			     foreach ($frame as $frm) {
			        echo '<option>' . $frm['Title'] . '</option>'; //Displays the frame titles in the respective dropdown box.
			     }

			     ?>

                          </select>
                       </div>  
                       <div class="four wide field">
                          <label>Glass</label>
                          <select id="glass" class="ui search dropdown">
                             <option>None</option>
			     <?php

			        $glass = getChosenTable('typesglass');
				foreach ($glass as $gl) {
				   echo '<option>' . $gl['Title'] . '</option>'; //Displays the glass titles in the respective dropdown box.
				}

			     ?>

                          </select>
                       </div>  
                       <div class="four wide field">
                       <label>Matt</label>
                          <select id="matt" class="ui search dropdown">
                             <option>None</option>
			     <?php

			        $matt = getChosenTable('typesmatt');
				foreach ($matt as $m) {
				   echo '<option>' . $m['Title'] . '</option>'; //Displays the matt titles in the respective dropdown box.
				}

			     ?>

                          </select>
                       </div>           
                    </div>                     
                 </div>
                 <div class="ui divider"></div>
                    <button class="ui labeled icon orange button">
                       <i class="add to cart icon"></i>
                          Add to Cart
                    </button>

                    <?php echo '<button class="ui right labeled icon button"><a href="addToFavorites.php?id=' . $aw['PaintingID'] . '&file=' . $aw['ImageFileName'] . '&title=' . $aw                             ['Title'] . '">'; ?>
                    <i class="heart icon"></i>
                       Add to Favorites
                    </a></button>        
                </div>     <!-- END Cart -->                      
                          
             </div>	<!-- END RIGHT data Column --> 
          </div>		<!-- END Grid --> 
       </section>		<!-- END Main Section --> 
    
       <!-- Tabs for Description, On the Web, Reviews -->
       <section class="ui doubling stackable grid container">
          <div class="sixteen wide column">        
             <div class="ui top attached tabular menu ">
                <a class="active item" data-tab="first">Description</a>
                <a class="item" data-tab="second">On the Web</a>
                <a class="item" data-tab="third">Reviews</a>
             </div>
			
             <div class="ui bottom attached active tab segment" data-tab="first">
                <?php echo $aw['Description']; ?>
             </div>	<!-- END DescriptionTab --> 
			
             <div class="ui bottom attached tab segment" data-tab="second">
	        <table class="ui definition very basic collapsing celled table">
                   <tbody>
                      <tr>
                         <td>
                            Wikipedia Link
                         </td>
                         <td>
                            <?php echo '<a href="' . $aw['WikiLink'] . '">View painting on Wikipedia</a>'; ?>
                         </td>                       
                      </tr>                                            
                      <tr>
                         <td>
                            Google Link
                         </td>
                         <td>
			    <?php echo '<a href="' . $aw['GoogleLink'] . '">View painting on Google Art Project</a>'; ?>
                         </td>                       
                      </tr>                      
                      <tr>
                         <td>
                            Google Text
                         </td>
                         <td>
                           <?php echo $aw['GoogleDescription']; ?>
                         </td>                       
                      </tr>                                                      
                   </tbody>
                </table>
             </div>   <!-- END On the Web Tab --> 
			
             <div class="ui bottom attached tab segment" data-tab="third">                
	        <div class="ui feed">
		   <?php

                      //Following code segment reads each review under the review tab in the bottom of the page, with a correctly formatted date.

		      $reviewToRead = readChosenReview($aw['PaintingID']); //Selected review.
		      foreach($reviewToRead as $rd) {
		         echo '<div class="event">';
			 echo '<div class="content">';
			 $dateToFormat = $rd['ReviewDate'];
			 $dateList = explode(" ", $dateToFormat); //uses the explode fuction as explained in the course textbook.
			 echo '<div class="date">' . $dateList[0] . '</div>'; //Format date properly.
			 echo '<div class="meta">';
			 echo '<a class="like">';
			 echo '<i class="star icon"></i><i class="star icon"></i><i class="star icon"></i><i class="star icon"></i><i class="star icon"></i>';
			 echo '</a>';
			 echo '</div>';                    
			 echo '<div class="summary">';
			 echo $rd['Comment'];
			 echo '</div>';       
			 echo '</div>';
			 echo '</div>';
			 echo '<div class="ui divider"></div>';    
		      }

		   ?> 
 
		</div>                                
             </div>   <!-- END Reviews Tab -->                  
          </div>    
    
       </section> <!-- END Description, On the Web, Reviews Tabs -->    
       <!-- Related Images ... will implement this in assignment 2 -->    
       <section class="ui container">
          <h3 class="ui dividing header">Related Works</h3>  
          <ul>
             <li class="item">
                <a class="ui small image" href="single-painting.php?id=568"><img src="images/art/works/square-medium/137010.jpg"></a>
               <div class="content">
                 <a class="header" href="single-painting.php?id=568">Abbey among Oak Trees</a>
                 <div class="meta"><span class="cinema">Casper David Friedrich</span></div>        
                    <div class="description">
                       <p>Abbey among Oak Trees is the companion piece to Monk by the Sea. Friedrich showed both paintings in the Berlin Academy Exhibition of 1810.</p>
                    </div>
                    <div class="meta">     
                       <strong>$900</strong>        
                    </div>        
                    <div class="extra">
                       <a class="ui icon orange button" href="cart.php?id=568"><i class="add to cart icon"></i></a>
                       <a class="ui icon button" href="addToFavorites.php?id=568"><i class="heart icon"></i></a>          
                    </div>        
                 </div>      
              </li>    
           </ul>                
	</section>  
	
     </main>            
  <footer class="ui black inverted segment">
     <div class="ui container">footer</div>
  </footer>
</body>
</html>
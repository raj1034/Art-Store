<?php
  session_start(); //Starts the session.
	
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
      foreach($_SESSION['favoritePaintings'] as $i => $fp) {
        if($fp['id'] == $_GET['id']) {

          //unset, the specified painting to be removed.
	  unset($_SESSION['favoritePaintings'][$i]);
	  $_SESSION['numberOfFavoritePaintings'] --; //Decrements the number of paintings in the favorites list by 1.
	}
      }
    }

    else {

      //Assumes the remove all button has been clicked.

      unset($_SESSION['favoritePaintings']); //Unsets all the paintings in the list.
      $_SESSION['numberOfFavoritePaintings'] = 0; //Sets the number of paintings in the favorites list to zero.
    }

    header('Location: view-favorites.php'); //redirects back to view favorites page via the header function as per assignment instructions.
  }

?>
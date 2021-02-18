<?php
  //The following if statement checks if a session is started. If it is not started, then it gets started.

  if(!isset($_SESSION)) {
    session_start();
  }

  //Checks for the existence of the relavent or required query string fields

  if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['file']) && isset($_GET['title'])) {

    if(!isset($_SESSION['favoritePaintings'])) {
      $_SESSION['favoritePaintings'] = array(); //Create an array of favorite items if it does not yet exist.
      $_SESSION['numberOfFavoritePaintings'] = 0; // Currently no favorite paintings (since array is only just created in if statement).
    }

    $id = $_GET['id'];
    $idToSet = false;
    
    //Foreach loop iterates through the list of favorite paintings
    foreach($_SESSION['favoritePaintings'] as $fp) { 
      if($id == $fp['id']) {
        $idToSet = true;
      }
    }

    if($idToSet == false) {
      $_SESSION['favoritePaintings'][] = array('id' => $_GET['id'], 'file' => $_GET['file'], 'title' => $_GET['title']);
      //The above line of code is an array of arrays, representing the favorites list.

      $_SESSION['numberOfFavoritePaintings'] ++; //Increments the number of favorite paintings in the session.
    }

    header('Location: view-favorites.php'); //Redirects to view favorites using the header function as per assignment instructions.
  }
?>
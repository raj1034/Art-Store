<?php
  require('includes/header.php');


  if(!isset($_SESSION)) {
    session_start(); //Like add to favorites, checks if a session if started, and if it isn't, the session is started.
  }
?>

<!DOCTYPE html>
<html lang=en>
<head>

<style>
  th, td {
    border: 1px solid black;
    text-align: center;
  }
</style>


<style>
  table {
    margin-left: auto;
    margin-right: auto;
  }

</style>
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

  <table style = "width:1000px; border: 1px solid black">
    <thead>
      <th>Image</th>
      <th>Title</th>
      <th>Remove Image</th>
    </thead>
		
    <tbody>
			
      <?php
                          
        if(isset($_SESSION['favoritePaintings'])) {
	  foreach($_SESSION['favoritePaintings'] as $fp) {
	    echo '<tr>';
	    echo '<td><img src="images/art/works/square-small/' . $fp['file'] . '.jpg"/></td>'; // small version of each version in favorites list.
	    echo '<td><a href="single-painting.php?id=' . $fp['id'] . '">' . $fp['title'] . '</td>'; //title of painting as a link to the single painting page.
	    echo '<td><a href="remove-favorites.php?id=' . $fp['id'] . '"><button class="ui right labeled icon button">Remove Painting</button></a></td>'; //Remove button.
	    echo '</tr>';
	   }
	 }
       ?>


    </tbody>
  </table>
  <a href="remove-favorites.php"><button class="ui right labeled icon button">Remove all Images</button></a>
</main>

<footer class="ui black inverted segment">
  <div class="ui container">footer</div>
</footer>
</body>
</html>
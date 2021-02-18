<?php

/* The following query file is loosely based off the lab five solutions, where the run query function, and all query filter functions are made in a
   specific file, and called when needed in browse paintings and single paintings respectively. */

//Function that is the be called when a query needs to be run or executed. Again based off lab 5.

function runQuery($pdo, $sql, $parameters=array()) {
    $statement = $pdo->prepare($sql); //Prepared statement is used to protect against SQL injection attacks as disscussed in class.
    if (sizeof($parameters) != 0) {
        $statement->bindValue(1, $parameters[0]);
    }
    $statement->execute();
    return $statement;
}

//Made all query functions one liners for cleanliness and readability.

function readAllArtWorks() {
    return runQuery(new PDO(DBCONNECTION, DBUSER, DBPASS), "select * from paintings order by TITLE LIMIT 20");
}

function readSelectArtWorkByArtist() {
    return runQuery(new PDO(DBCONNECTION, DBUSER, DBPASS), "select * from Artists ORDER BY LastName");
}

function readSelectArtWorkByMuseum() {
    return runQuery(new PDO(DBCONNECTION, DBUSER, DBPASS), "select * from Galleries ORDER BY GalleryName");
}

function readSelectArtWorkByShape() {
    return runQuery(new PDO(DBCONNECTION, DBUSER, DBPASS), "select * from Shapes ORDER BY ShapeName");
}

function getSelectedGenre($PaintingID) {
    return runQuery(new PDO(DBCONNECTION, DBUSER, DBPASS), "select * from genres inner join paintinggenres on genres.GenreID = paintinggenres.GenreID where PaintingID = ?", array                ($PaintingID));
}

function getSelectedMuseum($GalleryID) {
    return runQuery(new PDO(DBCONNECTION, DBUSER, DBPASS), "select * from galleries where GalleryID = ?", array($GalleryID));
}

function getSelectedPainter($ArtistID) {
    return runQuery(new PDO(DBCONNECTION, DBUSER, DBPASS), "select * from Artists where ArtistID = ?", array($ArtistID));
}

function getChosenSubject($PaintingID) {
    return runQuery(new PDO(DBCONNECTION, DBUSER, DBPASS), "select * from subjects inner join paintingsubjects on subjects.SubjectID = paintingsubjects.SubjectID where PaintingID = ?",          array($PaintingID));
}


function readSelectedArtWorksByArtistID($ArtistID) {
    return runQuery(new PDO(DBCONNECTION, DBUSER, DBPASS), "select * from paintings where ArtistID = ? LIMIT 20", array($ArtistID));
}

function readSelectedArtWorksByGalleryID($GalleryID) {
    return runQuery(new PDO(DBCONNECTION, DBUSER, DBPASS), "select * from paintings where GalleryID = ? LIMIT 20", array($GalleryID));
}

function readChosenReview($PaintingID) {
    return runQuery(new PDO(DBCONNECTION, DBUSER, DBPASS), "select * from reviews where PaintingID = ?", array($PaintingID));
}

function readSelectedArtWorksByShapeID($ShapeID) {
    return runQuery(new PDO(DBCONNECTION, DBUSER, DBPASS), "select * from paintings where ShapeID = ? LIMIT 20", array($ShapeID));
}

function readArtWork($PaintingID) {
    return runQuery(new PDO(DBCONNECTION, DBUSER, DBPASS), "select * from paintings where PaintingID = ?", array($PaintingID));
}

function getChosenTable($tableName) {
    return runQuery(new PDO(DBCONNECTION, DBUSER, DBPASS), "select * from " . $tableName);
}

?>
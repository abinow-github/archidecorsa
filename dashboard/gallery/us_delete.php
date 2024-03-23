<?php
include("../root/db.php");

$id = $_GET['sa'];

// Fetch the image filename before deleting the record
$fetchImageQuery = "SELECT image FROM gallery WHERE id = '$id'";
$result = $mysqli->query($fetchImageQuery);

if ($result->num_rows > 0) {
    $imageFilename = $result->fetch_assoc()['image'];

    // Delete the image file
    unlink("../images/gallery/" . $imageFilename);

    // Delete the record from the database
    $deleteQuery = "DELETE FROM gallery WHERE id = '$id'";

    if (mysqli_query($mysqli, $deleteQuery)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($mysqli);
    }
} else {
    echo "Error fetching image filename.";
}

// Redirect to the index page
header('location: index.php');
?>

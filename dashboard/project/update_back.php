<?php
session_start();
include("../root/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imageId = mysqli_real_escape_string($mysqli, $_POST['image_id']);

    // Get other form data
    $title = mysqli_real_escape_string($mysqli, $_POST["title"]);
    $subtitle = mysqli_real_escape_string($mysqli, $_POST["subtitle"]);
    $url = mysqli_real_escape_string($mysqli, $_POST["url"]);
    $txt = mysqli_real_escape_string($mysqli, $_POST["txt"]);

    // If the URL is empty, default to the title or project name
    if (!empty($url)) {
        // Check if the URL already exists, if so, append a letter or number
        $url = makeUrlUnique($mysqli, $url);
    }

    $updateCaptionQuery = "UPDATE project SET
    title = '$title',
    subtitle = '$subtitle',
    txt = '$txt'";

    // Only add URL to the update query if it's not empty
    if (!empty($url)) {
        $updateCaptionQuery .= ", url = '$url'";
    }

    $updateCaptionQuery .= " WHERE id = '$imageId'";
    
    if (!mysqli_query($mysqli, $updateCaptionQuery)) {
        die('Error updating caption: ' . mysqli_error($mysqli));
    }

    // Check if new images are provided
    if (!empty($_FILES['new_images']['tmp_name'][0])) {
        // Your existing image upload and update logic here
    }

    // Redirect back to the edit page
    header("Location: index.php");
    exit();
}

// If form is not submitted or if there's an issue, redirect to the index page or any other desired location
header("Location: index.php");
exit();

// Function to make URL unique by appending a letter or number
function makeUrlUnique($mysqli, $url) {
    $originalUrl = $url;
    $counter = 1;
    while (true) {
        $query = "SELECT * FROM project WHERE url = '$url'";
        $result = $mysqli->query($query);
            return $url;
    }
}
?>

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

    // Delete old images
    $deleteOldImagesQuery = "SELECT images FROM project WHERE id = '$imageId'";
    $oldImagesResult = mysqli_query($mysqli, $deleteOldImagesQuery);
    $oldImages = mysqli_fetch_assoc($oldImagesResult)['images'];

    // Explode the string to get individual image names
    $oldImageNames = explode(',', $oldImages);
    foreach ($oldImageNames as $imageName) {
        $imagePath = "../images/project/" . $imageName;
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete the old image file
        }
    }

    // Check if new images are provided
    if (!empty($_FILES['new_images']['tmp_name'][0])) {
        // Your existing image upload and update logic here
        $imageNames = uploadImages($mysqli, $_FILES['new_images'], $imageId);
        // Update the database with the new image names
        $imageNamesString = implode(',', $imageNames);
        $updateImagesQuery = "UPDATE project SET images = '$imageNamesString' WHERE id = '$imageId'";
        if (!mysqli_query($mysqli, $updateImagesQuery)) {
            die('Error updating images: ' . mysqli_error($mysqli));
        }
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

// Function to upload images and return their names
function uploadImages($mysqli, $files, $imageId) {
    $imageNames = array();
    foreach ($files['tmp_name'] as $key => $tmp_name) {
        $target_dir = "../images/project/";
        $imageFileType = strtolower(pathinfo($files["name"][$key], PATHINFO_EXTENSION));
        $newImageName = 'image_' . $imageId . '_' . uniqid() . '.' . $imageFileType; // Append unique identifier to image name
        $target_file = $target_dir . $newImageName;

        if (move_uploaded_file($tmp_name, $target_file)) {
            $imageNames[] = $newImageName;
        } else {
            // Handle file upload errors here
        }
    }
    return $imageNames;
}
?>

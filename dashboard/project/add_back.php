<?php
session_start();

// Include the file with the database connection
include("../root/db.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if at least one image is uploaded
    if (empty($_FILES["images"]["name"][0])) {
        $_SESSION['upload_error'] = "Please upload at least one image.";
        header("Location: index.php"); // Redirect back to index page
        exit();
    }

    // Get other form data
    $project = mysqli_real_escape_string($mysqli, $_POST["project"]);
    $projectcat = mysqli_real_escape_string($mysqli, $_POST["project-cat"]);
    $url = mysqli_real_escape_string($mysqli, $_POST["url"]);
    $txt = mysqli_real_escape_string($mysqli, $_POST["txt"]);

    // Generate unique URL if empty
    if (empty($url)) {
        $url = generateUniqueUrl($mysqli, $project);
    } else {
        // Check if the URL already exists, if so, append a letter or number
        $url = makeUrlUnique($mysqli, $url);
    }

    $uploadDirectory = "../images/project/";
    // Handle multiple file uploads
    $uploadedFiles = [];

    foreach ($_FILES["images"]["tmp_name"] as $key => $tmp_name) {
        $fileName = $_FILES["images"]["name"][$key];
        $fileSize = $_FILES["images"]["size"][$key];
        $fileType = $_FILES["images"]["type"][$key];
        $fileTmpName = $_FILES["images"]["tmp_name"][$key];

        // Check file size (1MB limit)
        $maxFileSize = 1 * 1024 * 1024; // 1MB in bytes
        if ($fileSize > $maxFileSize) { 
            $_SESSION['upload_error'] = " File '{$fileName}'  exceeds the maximum allowed size (1MB).";
            header("Location: index.php"); // Redirect back to index page
            exit();
        }

        // Generate a unique name for the file
        $uniqueFileName = generateUniqueFileName($uploadDirectory, $fileName);

        $targetFilePath = $uploadDirectory . $uniqueFileName;

        // Move the file to the upload directory
        if (move_uploaded_file($fileTmpName, $targetFilePath)) {
            $uploadedFiles[] = $uniqueFileName;
        } else {
            echo "Error uploading file {$fileName}. Please try again.";
        }
    }

    // Combine the image paths into a comma-separated string
    $imagePaths = implode(',', $uploadedFiles);

    // Insert data into the news table
    $insertQuery = "INSERT INTO project (images, title, subtitle,txt,url)
                      VALUES ('$imagePaths','$project', '$projectcat','$txt','$url')";
    $result = $mysqli->query($insertQuery);

    if ($result) {
        // Redirect or display success message
        header("Location: index.php");
        exit();
    } else {
        echo "Error inserting data into the news table: " . $mysqli->error;
    }
}

// Function to generate a unique file name
function generateUniqueFileName($directory, $originalFileName) {
    $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $uniqueFileName = md5(uniqid()) . '.' . $extension;
    return $uniqueFileName;
}

// Function to generate a unique URL
function generateUniqueUrl($mysqli, $project) {
    $url = strtolower(str_replace(' ', '-', $project));
    $originalUrl = $url;
    $counter = 1;
    while (true) {
        $query = "SELECT * FROM project WHERE url = '$url'";
        $result = $mysqli->query($query);
        if ($result && $result->num_rows == 0) {
            return $url;
        } else {
            $url = $originalUrl . '-' . $counter;
            $counter++;
        }
    }
}

// Function to make URL unique by appending a letter or number
function makeUrlUnique($mysqli, $url) {
    $originalUrl = $url;
    $counter = 1;
    while (true) {
        $query = "SELECT * FROM project WHERE url = '$url'";
        $result = $mysqli->query($query);
        if ($result && $result->num_rows == 0) {
            return $url;
        } else {
            $url = $originalUrl . '-' . $counter;
            $counter++;
        }
    }
}
?>

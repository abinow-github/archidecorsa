<?php
session_start();

// Include the file with the database connection
include("../root/db.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get other form data
    $caption = $_POST["Caption"];

    // Handle multiple file uploads
    $uploadDirectory = "../images/gallery/"; // Change this to your desired upload directory
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
            $uploadedFiles[] = $uniqueFileName; // Store only the filename
        } else {
            echo "Error uploading file {$fileName}. Please try again.";
        }
    }

    // Insert data into the gallery table
    $insertQuery = "INSERT INTO gallery (image, caption) VALUES ";

    foreach ($uploadedFiles as $file) {
        $insertQuery .= "('$file', '$caption'), ";
    }

    // Remove the trailing comma and execute the query
    $insertQuery = rtrim($insertQuery, ", ");
    
    $result = $mysqli->query($insertQuery); // Use $mysqli instead of $connection

    if ($result) {
        // Redirect or display success message
        header("Location: index.php");
        exit();
    } else {
        echo "Error inserting data into the gallery table: " . $mysqli->error;
    }
}

// Function to generate a unique file name
function generateUniqueFileName($directory, $originalFileName) {
    $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $uniqueFileName = md5(uniqid()) . '.' . $extension;
    return $uniqueFileName;
}
?>

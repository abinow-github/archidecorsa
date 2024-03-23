<?php
// Include database configuration file
include("../root/db.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $imageId = mysqli_real_escape_string($mysqli, $_POST['image_id']);

    // Fetch old image filename from the database
    $fetchImageQuery = "SELECT image FROM gallery WHERE id = '$imageId'";
    $result = $mysqli->query($fetchImageQuery);

    if ($result->num_rows > 0) {
        $oldImage = $result->fetch_assoc()['image'];

        // Check if a new image is provided
        if (!empty($_FILES['new_image']['tmp_name'])) {
            // Check the file size (1MB limit)
            $maxFileSize = 1 * 1024 * 1024; // 1MB in bytes
            $fileSize = $_FILES['new_image']['size'];

            if ($fileSize > $maxFileSize) {
                // File size exceeds the limit
                $_SESSION['upload_error'] = "Error: File size exceeds the maximum allowed size (1MB).";
                header("Location: index.php");
                exit();
            }

            // Continue with the image upload if the size is within the limit
            $temp1 = explode(".", $_FILES["new_image"]["name"]);
            $newfilename1 = rand() . "_" . date('m-d-Y_hia') . '.' . end($temp1);
            move_uploaded_file($_FILES['new_image']['tmp_name'], "../images/gallery/" . $newfilename1);

            // Delete the old image file
            unlink("../images/gallery/" . $oldImage);

            // Update image in the database
            $updateImageQuery = "UPDATE gallery SET image = '$newfilename1' WHERE id = '$imageId'";
            if (!mysqli_query($mysqli, $updateImageQuery)) {
                die('Error updating image: ' . mysqli_error($mysqli));
            }
        }
    }

    // Update caption
    $caption = mysqli_real_escape_string($mysqli, $_POST['caption']);
    $updateCaptionQuery = "UPDATE gallery SET caption = '$caption' WHERE id = '$imageId'";
    if (!mysqli_query($mysqli, $updateCaptionQuery)) {
        die('Error updating caption: ' . mysqli_error($mysqli));
    }

    // Redirect back to the edit page
    header("Location: index.php");
    exit();
}

// If form is not submitted, redirect to the index page or any other desired location
header("Location: index.php");
exit();
?>

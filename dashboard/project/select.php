<br><br><br>

<div class="container-fluid bg-clr-1" style="color:white;padding:10px"><h4> Edit/Delete</h4></div>

<div class="blog-content">
<div class="container">
<?php
$sql = "SELECT * FROM project";

$result = $mysqli->query($sql);

?>
<table class="w-100">
  <tr>
    <th>No.</th>
    <th>Property Name</th>
    <th>Image</th>
    <th>Edit</th>
    <th>Delete</th>
  </tr>
  <?php
if ($result->num_rows > 0) {
    $counter = 1;
    while ($row = $result->fetch_assoc()) {
        $imageFilenames = explode(',', $row['images']);
        $firstImage = trim($imageFilenames[0]);
        $imagePath = "../images/project/" . $firstImage;
?>
        <tr>
            <td><?php echo $counter; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><img src="<?php echo $imagePath; ?>" class="card__image" style="width: 60px;height:60px;object-fit:contain"></td>
            <td><a href="update.php?sa=<?php echo $row["id"]; ?>" class="edit">Edit</a></td>
            <td><a href="delete.php?sa=<?php echo $row["id"]; ?>" class="delete">Delete</a></td>
        </tr>
<?php
        $counter++; // Increment the counter for the next iteration
    }
}
?>
</table>

				
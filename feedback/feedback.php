<?php include 'inc/header.php'; ?>
<?php
$sql = 'SELECT * FROM feedback';
$result = mysqli_query($conn, $sql);
$feedback = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<?php
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM feedback WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header('location:feedback.php');
    } else {
        echo "error";
    }
}
?>



<h2>Feedback</h2>
<?php if (empty($feedback)) : ?>
    <p class="lead mt3">There is no feedback</p>
<?php endif; ?>
<?php foreach ($feedback as $item) : ?>
    <div class="card my-3 w-75">
        <div class="card-body text-center">
            <?php echo $item['body'] ?>
            <div class="text-secondary mt-2">
                by <?php echo $item['name']; ?> on <?php echo $item['date'] ?>
            </div>
            <div class="text-secondary mt-2">
                <img src="<?php echo 'img/' . $item['img']; ?>" width="60px" height="60px" alt="">
            </div>
        </div>
        <a href="feedback.php?delete=<?php echo $item['id']; ?>" class="btn btn-danger">Delete</a>
        <a href="edit.php?edit=<?php echo $item['id']; ?>" class="btn btn-info">edit</a>
    </div>
<?php endforeach; ?>
<?php include 'inc/footer.php'; ?>
<?php include 'inc/header.php'; ?>

<?php

$name = $email = $body = '';
$nameErr = $emailErr = $bodyErr = $imgErr = '';

if (isset($_POST['submit'])) {
    $targetDir = "img/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    if (empty($_POST['name'])) {
        $nameErr = 'Name is required';
    } else {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    }

    if (empty($_POST['email'])) {
        $emailErr = 'email is required';
    } else {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
    }

    if (empty($_POST['body'])) {
        $bodyErr = 'body is required';
    } else {
        $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_SPECIAL_CHARS);
    }

    if (!empty($_FILES["file"]["name"])) {
        move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath);
    } else {
        $imgErr = 'image is required';
    }

    if (empty($nameErr) && empty($emailErr) && empty($bodyErr) && empty($imgErr)) {
        $sql = "INSERT INTO feedback (name, email, body, img)VALUES ('$name','$email','$body','$fileName') ";
        if (mysqli_query($conn, $sql)) {
            header('Location:feedback.php');
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
    }
}
?>

<img src="/php-basics/feedback/img/logo.png" class="w-25 mb-3" alt="" />
<h2>Feedback</h2>
<p class="lead text-center">Leave feedback for Traversy Media</p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" class="mt-4 w-75">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control <?php echo $nameErr ? 'is-invalid' : null ?>" id="name" name="name" placeholder="Enter your name" />
        <div class="invalid-feedback">
            <?php echo $nameErr; ?>
        </div>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control <?php echo $emailErr ? 'is-invalid' : null ?>" id="email" name="email" placeholder="Enter your email" />
        <div class="invalid-feedback">
            <?php echo $emailErr; ?>
        </div>
    </div>
    <div class="mb-3">
        <label for="body" class="form-label">Feedback</label>
        <textarea class="form-control <?php echo $bodyErr ? 'is-invalid' : null ?>" id="body" name="body" placeholder="Enter your feedback"></textarea>
        <div class="invalid-feedback">
            <?php echo $bodyErr; ?>
        </div>
    </div>
    <div class="mb-3">
        <input type="file" name="file" class="form-control <?php echo $imgErr ? 'is-invalid' : null ?>" />
        <div class="invalid-feedback">
            <?php echo $imgErr; ?>
        </div>
    </div>
    <div class="mb-3">
        <input type="submit" name="submit" value="Send" class="btn btn-dark w-100" />
    </div>
</form>
<?php include 'inc/footer.php'; ?>
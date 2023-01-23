<?php include 'inc/header.php'; ?>
<?php
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM feedback WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    $n = mysqli_fetch_array($result);
    $name = $n['name'];
    $email = $n['email'];
    $body = $n['body'];
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
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
        $img = move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath);
    } else {
        $imgErr = 'image is required';
    }

    if (empty($nameErr) && empty($emailErr) && empty($bodyErr) && empty($imgErr)) {
        $sql = "UPDATE feedback SET name='$name', email='$email', body='$body', img='$fileName' WHERE id=$id ";
        if (mysqli_query($conn, $sql)) {
            header('Location:feedback.php');
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
    }
}
?>


<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" class="mt-4 w-75">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="mb-3">
        <label for="name" class="form-label">Edit Name</label>
        <input type="text" class="form-control <?php echo $nameErr ? 'is-invalid' : null ?>" id="name" value="<?php echo $name; ?>" name="name" placeholder="Enter your name" />
        <div class="invalid-feedback">
            <?php echo $nameErr; ?>
        </div>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Edit Email</label>
        <input type="email" class="form-control <?php echo $emailErr ? 'is-invalid' : null ?>" id="email" name="email" value="<?php echo $email; ?>" placeholder=" Enter your email" />
        <div class="invalid-feedback">
            <?php echo $emailErr; ?>
        </div>
    </div>
    <div class="mb-3">
        <label for="body" class="form-label">Edit Feedback</label>
        <textarea class="form-control <?php echo $bodyErr ? 'is-invalid' : null ?>" id="body" name="body" placeholder="Enter your feedback"><?php echo $body; ?></textarea>
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
        <input type="submit" name="update" value="Update" class="btn btn-dark w-100" />
    </div>
</form>
<?php include 'inc/footer.php'; ?>
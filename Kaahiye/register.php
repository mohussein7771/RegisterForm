<?php
// establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_form";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = test_input($_POST["first_name"]);
    $lname = test_input($_POST["last_name"]);
    $sex = test_input($_POST["sex"]);
    $dob = test_input($_POST["dob"]);
    $phone = test_input($_POST["phone_number"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);

    // file upload functionality
    $target_dir = "profile_images/";
    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            echo "File is not an image.";
        }
    }

    // check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
        echo "Sorry, file already exists.";
    }

    // check file size
    if ($_FILES["profile_picture"]["size"] > 100000000) {
        $uploadOk = 0;
        echo "Sorry, your file is too large.";
    }

    // allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $uploadOk = 0;
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }

    // if everything is ok, try to upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture = $target_file;
        } else {
            $uploadOk = 0;
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // insert data into database
    if ($uploadOk == 1) {
        $sql = "INSERT INTO users (first_name, last_name, sex, dob, phone_number, email, password, profile_picture)
                VALUES ('$fname', '$lname', '$sex', '$dob', '$phone', '$email', '$password', '$profile_picture')";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>Registration successful!</div>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// function to test and sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// close database connection
$conn->close();
?>

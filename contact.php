<?php
// Include the database connection file
include('db.php');

// Your form processing code here
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = trim($_POST['Username']);
    $email = trim($_POST['Email']);
    $comment = trim($_POST['Comment']);
    
    // Validate data
    $errors = [];

    if (empty($username)) {
        $errors[] = "Name is required.";
    }

    if (empty($email)) {
        $errors[] = "Email or phone number is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^\d{10}$/", $email)) {
        $errors[] = "Please enter a valid email address or phone number.";
    }

    if (empty($comment)) {
        $errors[] = "Comment is required.";
    }

    if (empty($errors)) {
        // Insert into database
        $stmt = $con->prepare("INSERT INTO contact (name, Email, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $comment);

        if ($stmt->execute()) {
            echo "<script>
                alert('Your message has been sent successfully!');
                window.location.href = 'INDEX.html';
            </script>";
        } else {
            echo "<script>
                alert('Error saving your message. Please try again later.');
                window.history.back();
            </script>";
        }
    } else {
        $errorMessage = implode("\n", $errors);
        echo "<script>
            alert('Error: \n$errorMessage');
            window.history.back();
        </script>";
    }
}
?>

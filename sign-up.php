<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data safely
    $username = $_POST['Username'] ?? '';
    $number = $_POST['Number'] ?? '';
    $email = $_POST['Email'] ?? '';
    $password = $_POST['Password'] ?? '';
    $confirmPassword = $_POST['Confirm_Password'] ?? '';

    // Validate password confirmation
    if ($password !== $confirmPassword) {
        echo "<script>
            alert('Passwords do not match. Please try again.');
            window.history.back();
        </script>";
        exit();
    }

    // Basic email and password validation
    if (!empty($email) && !empty($password) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Use prepared statement to insert data securely
        $stmt = $con->prepare("INSERT INTO user (`Username`, `Mobile Number`, `Email`, `Password`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $number, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "<script> 
                alert('Registration successful! You can now sign in.');
                window.location.href = 'Sign-in.html';
            </script>";
        } else {
            echo "<script>
                alert('Error during registration. Please try again.');
                window.history.back();
            </script>";
        }

        $stmt->close();
    } else {
        echo "<script>
            alert('Please enter a valid email and password.');
            window.history.back();
        </script>";
    }
}
?>

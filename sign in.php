<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['Username'] ?? '');
    $password = trim($_POST['Password'] ?? '');

    if (!empty($username) && !empty($password)) {
        $stmt = $con->prepare("SELECT * FROM user WHERE Username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user_data = $result->fetch_assoc();

            if ($password === $user_data['Password']) {
                $_SESSION['user_id'] = $user_data['Id'];
                header("Location: index.html");
                exit();
            } else {
                echo "<script>alert('Wrong username or password'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Wrong username or password'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Please enter username and password'); window.history.back();</script>";
    }
}
?>

<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['recipe_name'] ?? '';
    $ingredients = $_POST['ingredients'] ?? '';
    $instructions = $_POST['instructions'] ?? '';
    $category = $_POST['Category'] ?? '';
    $sharing = $_POST['sharing'] ?? '';
    $imagePath = '';

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['image']['tmp_name'];
        $originalName = $_FILES['image']['name'];
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($extension, $allowed)) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $newName = uniqid('img_', true) . '.' . $extension;
            $imagePath = $uploadDir . $newName;

            if (!move_uploaded_file($tmpName, $imagePath)) {
                echo "<script>alert('Failed to upload image.'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Invalid image format. Only JPG, JPEG, PNG, GIF allowed.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Please upload an image.'); window.history.back();</script>";
        exit;
    }

    // Validate required fields
    if (!empty($username) && !empty($ingredients) && !empty($instructions) && !empty($category) && !empty($imagePath)) {
        $stmt = $con->prepare("INSERT INTO categories (`name`, `Ingredients`, `Instructions`, `image`, `Category`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $ingredients, $instructions, $imagePath, $category);

        if ($stmt->execute()) {
            // Get the last inserted recipe ID
            $recipeId = $stmt->insert_id;

            // Show alert and redirect to recipe_details.php with the recipe ID
            echo "<script>
                alert('Recipe created successfully!');
                window.location.href = 'recipe_details.php?id=" . $recipeId . "';
            </script>";
            exit;
        } else {
            echo "<script>
                alert('Database error. Please try again.');
                window.history.back();
            </script>";
            exit;
        }
    } else {
        echo "<script>
            alert('Please fill in all required fields.');
            window.history.back();
        </script>";
        exit;
    }
}
?>

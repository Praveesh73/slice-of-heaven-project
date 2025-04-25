<?php
session_start();
include("db.php");

if (isset($_GET['id'])) {
    $recipeId = $_GET['id'];

    // Fetch the recipe details from the database using the ID
    $stmt = $con->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->bind_param("i", $recipeId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $recipe = $result->fetch_assoc();
?>
       
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe['name']); ?> - Recipe Details</title>
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="assets/css/search.css">
    
    <!-- Fallback Inline Style (if external CSS isn't working) -->
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            padding: 20px;
        }

        .content h3 {
            font-size: 2em;
            margin: 0 0 10px;
        }

        .content h5 {
            font-size: 1.2em;
            color: #888;
        }

        .introduction {
            margin-top: 20px;
        }

        .ingredients, .instructions {
            margin-bottom: 20px;
        }

        .ingredients h4, .instructions h4 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .ingredients p, .instructions p {
            font-size: 1.1em;
            line-height: 1.6;
        }

        .btn-back {
            display: inline-block;
            text-align: center;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: rgb(4, 124, 8);
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .btn-back:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="content">
            <h3><?php echo htmlspecialchars($recipe['name']); ?></h3> 
            <h5>Category: <?php echo htmlspecialchars($recipe['Category']); ?></h5>
        </div>
        <img src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="Recipe Image">
        <div class="introduction">
            <div class="ingredients">
                <h4>Ingredients</h4>
                <p><?php echo nl2br(htmlspecialchars($recipe['Ingredients'])); ?></p>
            </div>

            <div class="instructions">
                <h4>Instructions</h4>
                <p><?php echo nl2br(htmlspecialchars($recipe['Instructions'])); ?></p>
            </div>
        </div>
    </div>
</div>

<a href="index.html" class="btn-back">Back to Home</a>

</body>
</html>

<?php
    } else {
        echo "<p>Recipe not found.</p>";
    }
} else {
    echo "<p>No recipe ID provided.</p>";
}
?>

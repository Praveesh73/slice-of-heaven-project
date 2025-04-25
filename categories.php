<?php
include 'db.php';

// Sanitize and escape the input
$query = isset($_GET['query']) ? trim($con->real_escape_string($_GET['query'])) : '';

// Prevent empty search from returning everything
if (empty($query)) {
    echo "<p>Please enter a search term.</p>";
    exit();
}

// SQL query: match only if search term appears in name, category, ingredients, or instructions
$sql = "SELECT * FROM categories 
        WHERE LOWER(name) LIKE LOWER('%$query%') 
           OR LOWER(Category) LIKE LOWER('%$query%') 
           OR LOWER(Ingredients) LIKE LOWER('%$query%') 
           OR LOWER(Instructions) LIKE LOWER('%$query%')";

$result = $con->query($sql);

// Handle SQL errors
$searchTermDisplay = htmlspecialchars($query);
if (!$result) {
    die("<p>Query Error: " . $con->error . "</p>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="assets/css/search.css">
</head>
<body>
    <header>
        <h4>Search Term: <?= $searchTermDisplay ?></h4>
        
    </header>

    <main>
        <?php
        $found = false;
        while ($row = $result->fetch_assoc()):
            // Check if the exact term exists in any of the fields
            if (
                stripos($row['name'], $query) !== false ||
                stripos($row['Category'], $query) !== false ||
                stripos($row['Ingredients'], $query) !== false ||
                stripos($row['Instructions'], $query) !== false
            ):
                $found = true;
        ?>
            <div class="container">
                <div class="card">
                    <div class="content">
                        <h3><?= htmlspecialchars($row['Category']) ?></h3>
                        <h4><?= htmlspecialchars($row['name']) ?></h4>
                    </div>
                    <div class="card-image" style="background-image: url('<?= htmlspecialchars($row['image']) ?>');"></div>
                    <div class="introduction">
                        <div class="ingredients">
                            <h4>Ingredients</h4>
                            <p><?= nl2br(htmlspecialchars($row['Ingredients'])) ?></p><br>
                        </div>
                        <div class="instructions">
                            <h4>Instructions</h4>
                            <p><?= nl2br(htmlspecialchars($row['Instructions'])) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
            endif;
        endwhile;

        if (!$found): ?>
            <p>No results found for "<strong><?= $searchTermDisplay ?></strong>".</p>
        <?php endif; ?>

        <a href="recipes.html" class="btn-back">Back to Home</a>
    </main>
</body>
</html>

<?php $con->close(); ?>

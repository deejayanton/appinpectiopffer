<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<!-- Container for the logo -->
<div id="logo-container">
    <img src="troido-logo.png" width="300px" alt="Troido Logo">
</div>

<h2>Selected Blocks in Invoice</h2>

<div id="invoice-blocks">
    <?php
    // Check if the selectedBlocks cookie is set
    if (isset($_COOKIE['selectedBlocks'])) {
        // Decode the JSON data from the cookie
        $selectedBlocks = json_decode($_COOKIE['selectedBlocks']);
        if (!empty($selectedBlocks)) {
            // Display the selected blocks
            echo '<ul>';
            foreach ($selectedBlocks as $selectedBlock) {
                echo '<li>' . htmlspecialchars($selectedBlock) . '</li>';
            }
            echo '</ul>';
        } else {
            // Handle the case when no blocks are selected
            echo '<p>No blocks are selected in the invoice.</p>';
        }
    } else {
        // Handle the case when the cookie is not set
        echo '<p>No blocks are selected in the invoice.</p>';
    }
    ?>
</div>

<!-- Add styling for the selected blocks -->
<style>
    #invoice-blocks ul {
        list-style: none;
        padding: 0;
    }

    #invoice-blocks li {
        background-color: #f2f2f2;
        border: 1px solid #ccc;
        margin: 5px 0;
        padding: 5px;
    }
</style>
</body>
</html>

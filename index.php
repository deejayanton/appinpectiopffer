<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JSON Cards</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php
// Read JSON data from data.json
$jsonData = file_get_contents('data.json');
$data = json_decode($jsonData, true);

// Loop through the data and create elements for each item
foreach ($data as $item) {
    echo '<div class="card" onclick="toggleSelected(this)" style="box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);">';
    echo '<img src="' . $item['icon'] . '" alt="' . $item['title'] . '" style="float: left; width: 20%;">';
    echo '<div style="float: left; width: 80%;">';

    // Add the blue line before the title
    echo '<h4><span class="blue-line">' . $item['title'] . '</span></h4>';

    echo '<p>' . $item['description'] . '</p>';
    echo '<ul>';
    foreach ($item['bulletpoints'] as $point) {
        echo '<li>' . $point . '</li>';
    }
    echo '</ul>';
    echo '</div>'; // Close float: left; width: 80%
    echo '</div>'; // Close card
}
?>

<script>
    // Create an array to store selected card IDs
    let selectedCards = [];

    // Function to toggle selected class and update selected cards
    function toggleSelected(element) {
        element.classList.toggle('selected');

        // Get the unique ID of the card from the element's ID
        const cardID = element.id.replace('card-', '');

        // Check if the card is already in the selectedCards array
        const index = selectedCards.indexOf(cardID);
        if (index === -1) {
            // Card is not in the array, add it
            selectedCards.push(cardID);
        } else {
            // Card is in the array, remove it
            selectedCards.splice(index, 1);
        }

        // Call a function to update the selected cards display
        updateSelectedCardsDisplay();
    }

    // Function to update the selected cards display
    function updateSelectedCardsDisplay() {
        const selectedCardsContainer = document.getElementById('selected-cards');

        // Clear the container
        selectedCardsContainer.innerHTML = '';

        // Loop through selected card IDs and display their titles
        selectedCards.forEach(cardID => {
            // Find the corresponding card data in your JSON data
            const selectedCardData = data.find(item => item.id === parseInt(cardID));

            // Create a new element to display the selected card title
            const selectedCardTitle = document.createElement('p');
            selectedCardTitle.textContent = selectedCardData.title;

            // Append the title to the selected cards container
            selectedCardsContainer.appendChild(selectedCardTitle);
        });
    }

    // Your existing toggleSelected function
    function toggleSelected(element) {
        element.classList.toggle('selected');
    }

</script>
<div id="selected-cards">
    <h2>Selected Cards</h2>
    <!-- Selected cards will be displayed here -->
</div>

</body>
</html>

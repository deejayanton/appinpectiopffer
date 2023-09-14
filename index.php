<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Inspection Offer</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        const selectedItemsDiv = document.getElementById('selected-blocks');
        const makeOfferButton = document.getElementById('make-offer-button');
        const noBlocksSelectedMessage = document.getElementById('no-blocks-selected');

        function toggleSelected(item) {
            const selectedItemsDiv = document.getElementById('selected-blocks');

            // Check if the element exists before accessing its properties
            if (selectedItemsDiv) {
                if (item.classList.contains('selected')) {
                    item.classList.remove('selected');
                    selectedItemsDiv.removeChild(item);

                    // Check if there are any selected blocks
                    if (selectedItemsDiv.childElementCount === 0) {
                        makeOfferButton.style.display = 'none';
                        noBlocksSelectedMessage.style.display = 'block';
                    }
                } else {
                    item.classList.add('selected');
                    selectedItemsDiv.appendChild(item.cloneNode(true));

                    // Show the "Make Offer" button and hide the message
                    makeOfferButton.style.display = 'block';
                    noBlocksSelectedMessage.style.display = 'none';
                }
            } else {
                // Handle the case when the element does not exist
                console.log('Element with ID "selected-blocks" not found.');
            }
        }

        function redirectToInvoice() {
            const selectedItemsDiv = document.getElementById('selected-blocks');

            // Check if the element exists before accessing its properties
            if (selectedItemsDiv) {
                if (selectedItemsDiv.childElementCount === 0) {
                    // Handle the case when no blocks are selected
                    console.log('No blocks are selected.');
                } else {
                    // Redirect to invoice.php when blocks are selected
                    window.location.href = 'invoice.php';
                }
            } else {
                // Handle the case when the element does not exist
                console.log('Element with ID "selected-blocks" not found.');
            }
        }

    </script>
</head>
<body>
<!-- Container for the logo -->
<div id="logo-container">
    <img src="troido-logo.png" width="300px" alt="Troido Logo">
</div>

<?php
// Read JSON data from data.json
$jsonData = file_get_contents('data.json');
$data = json_decode($jsonData, true);

// Variable to keep track of block count
$blockCount = 0;

// Loop through the data and create elements for each item
foreach ($data as $item) {
    $blockCount++;

    // Determine the top margin based on block count
    $marginTop = ($blockCount === 1) ? '100px' : '50px';

    echo '<div class="block" onclick="toggleSelected(this)" style="margin-top: ' . $marginTop . ';">';

    // Icon container
    echo '<div class="icon">';
    echo '<img src="' . $item['icon'] . '" alt="' . $item['title'] . '">';
    echo '</div>'; // Close icon container

    // Text container
    echo '<div class="info">';
    // Add the blue line before the title
    echo '<h2><span class="blue-line">' . $item['title'] . '</span></h2>';

    echo '<p>' . $item['description'] . '</p>';
    echo '<ul>';
    foreach ($item['bulletpoints'] as $point) {
        echo '<li>' . $point . '</li>';
    }
    echo '</ul>';
    echo '</div>'; // Close text container

    echo '</div>'; // Close block
}
?>

<script>
    function getPDF() {
        html2canvas(document.body, {
            onrendered: function (canvas) {
                var img = canvas.toDataURL("Image/jpeg");
                //window.open(img);
                var doc = new jsPDF({
                    unit: 'px',
                    format: 'a4'
                });
                doc.addImage(img, 'JPEG', 0, 0, 440, 627);
                doc.save("download");

            }
        });
    }

    function toggleSelected(item) {
        const selectedItemsDiv = document.getElementById('selected-blocks');
        if (item.classList.contains('selected')) {
            item.classList.remove('selected');
            selectedItemsDiv.removeChild(item);
        } else {
            item.classList.add('selected');
            selectedItemsDiv.appendChild(item.cloneNode(true));
        }
    }
</script>

<div id="selected-blocks">
    <h2>Selected Offer</h2>
    <!-- Selected blocks will be displayed here -->
</div>

<!-- Add a message for when no blocks are selected -->
<p id="no-blocks-selected" style="display: none;">No blocks are selected.</p>

<div id="offer-container">
    <?php
    if (isset($_POST['selectedBlocks']) && count($_POST['selectedBlocks']) > 0) {
        echo '<form action="invoice.php" method="post">';
        foreach ($_POST['selectedBlocks'] as $selectedBlock) {
            // Include hidden input fields for selected blocks
            echo '<input type="hidden" name="selectedBlocks[]" value="' . htmlspecialchars($selectedBlock) . '">';
        }
        echo '<button type="submit" name="makeOffer">Make Offer</button>';
        echo '</form>';
    }
    ?>
</div>

<!-- Button to navigate to invoice.php -->
<div>
    <button class="button" onclick="redirectToInvoice()">Make an Offer</button>
</div>

<!-- Clone of selected blocks -->
<div id="cloned-selected-blocks" style="display: none;"></div>

<script>
    function redirectToInvoice() {
        const selectedItemsDiv = document.getElementById('selected-blocks');
        const clonedBlocksDiv = document.getElementById('cloned-selected-blocks');

        // Check if there are any selected blocks
        if (selectedItemsDiv.childElementCount === 0) {
            // Handle the case when no blocks are selected
            console.log('No blocks are selected.');
        } else {
            // Clone the selected blocks and append them to the cloned blocks div
            clonedBlocksDiv.innerHTML = selectedItemsDiv.innerHTML;
            // Redirect to invoice.php when blocks are selected
            window.location.href = 'invoice.php';
        }
    }
</script>
</body>
</html>

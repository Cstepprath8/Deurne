<?php
include('db_connect.php');



if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];

    // Escape the input to prevent SQL injection
    $searchQuery = $conn->real_escape_string($searchQuery);

    // Query the database to find products matching the search term
    $sql = "SELECT ID, `Bedrijfsnaam`, `Voornaam`, `Tussenvoegsel`, `Achternaam`, `Functie`, `Email`, `Telefoonnummer`, `Adres` 
    FROM klanten_db 
    WHERE ID LIKE '%$searchQuery%' 
    OR `Bedrijfsnaam` LIKE '%$searchQuery%' 
    OR `Voornaam` LIKE '%$searchQuery%' 
    OR `Achternaam` LIKE '%$searchQuery%' 
    OR `Functie` LIKE '%$searchQuery%' 
    OR `Email` LIKE '%$searchQuery%' 
    OR `Telefoonnummer` LIKE '%$searchQuery%' 
    OR `Adres` LIKE '%$searchQuery%'";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display search results
        echo "<h2>Zoek resultaten:</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='search-result'>";
            echo "<h3>" . $row['Bedrijfsnaam'] . "</h3>"; // Toon de bedrijfsnaam
            echo "<p><strong>ID:</strong> " . $row['ID'] . "</p>";
            echo "<p><strong>Naam:</strong> " . $row['Voornaam'] . " " . $row['Tussenvoegsel'] . " " . $row['Achternaam'] . "</p>";
            echo "<p><strong>Functie:</strong> " . $row['Functie'] . "</p>";
            echo "<p><strong>Email:</strong> " . $row['Email'] . "</p>";
            echo "<p><strong>Telefoonnummer:</strong> " . $row['Telefoonnummer'] . "</p>";
            echo "<p><strong>Adres:</strong> " . $row['Adres'] . "</p>";
            echo "</div><hr>";
        }
    } else {
        echo "No results found for '$searchQuery'.";
    }
} else {
    echo "Please enter a search term.";
}

$conn->close(); // Close the database connection
?>

<html>

<head> 
<link rel="stylesheet" href="zoekoptie.css" />    
</head>

<body>
        
<ul>
        <li><a href="klanten.html">Terug</a></li>
      </ul>
</body> 





</html>


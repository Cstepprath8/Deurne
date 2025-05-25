<?php
include('db_connect.php');

if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];

    // Escape the input to prevent SQL injection
    $searchQuery = $conn->real_escape_string($searchQuery);

    // Query the database to find employees matching the search term
    $sql = "SELECT ID, `Voornaam`, `Tussenvoegsels`, `Achternaam`, `GeboorteDatum`, `Functie`, `Werkmail`, `KantoorRuimte`
    FROM werknemers_db 
    WHERE ID LIKE '%$searchQuery%' 
    OR `Voornaam` LIKE '%$searchQuery%' 
    OR `Tussenvoegsels` LIKE '%$searchQuery%' 
    OR `Achternaam` LIKE '%$searchQuery%' 
    OR `Functie` LIKE '%$searchQuery%' 
    OR `Werkmail` LIKE '%$searchQuery%' 
    OR `KantoorRuimte` LIKE '%$searchQuery%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display search results
        echo "<h2>Zoek resultaten:</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='search-result'>";
            echo "<h3>" . $row['Voornaam'] . " " . $row['Tussenvoegsels'] . " " . $row['Achternaam'] . "</h3>"; // Toon de naam van de medewerker
            echo "<p><strong>ID:</strong> " . $row['ID'] . "</p>";
            echo "<p><strong>Naam:</strong> " . $row['Voornaam'] . " " . $row['Tussenvoegsels'] . " " . $row['Achternaam'] . "</p>";
            echo "<p><strong>Geboortedatum:</strong> " . $row['GeboorteDatum'] . "</p>";
            echo "<p><strong>Functie:</strong> " . $row['Functie'] . "</p>";
            echo "<p><strong>Werkmail:</strong> " . $row['Werkmail'] . "</p>";
            echo "<p><strong>Kantoorruimte:</strong> " . $row['KantoorRuimte'] . "</p>";
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
        <li><a href="Medewerkers.html">Terug</a></li>
      </ul>
</body> 





</html>
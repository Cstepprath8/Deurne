<?php
include('db_connect.php');

if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];

    // Escape the input to prevent SQL injection
    $searchQuery = $conn->real_escape_string($searchQuery);

    // Query the database to find assignments matching the search term
    $sql = "SELECT id, `titel`, `omschrijving`, `aanvraagdatum`, `benodigdekennis`
            FROM opdrachten
            WHERE id LIKE '%$searchQuery%' 
            OR `titel` LIKE '%$searchQuery%' 
            OR `omschrijving` LIKE '%$searchQuery%' 
            OR `benodigdekennis` LIKE '%$searchQuery%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display search results
        echo "<h2>Zoek resultaten:</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='search-result'>";
            echo "<h3>" . $row['titel'] . "</h3>"; // Toon de titel van de opdracht
            echo "<p><strong>ID:</strong> " . $row['id'] . "</p>";
            echo "<p><strong>Omschrijving:</strong> " . $row['omschrijving'] . "</p>";
            echo "<p><strong>Aanvraagdatum:</strong> " . $row['aanvraagdatum'] . "</p>";
            echo "<p><strong>Benodigde kennis:</strong> " . $row['benodigdekennis'] . "</p>";
            echo "</div><hr>";
        }
    } else {
        echo "Geen resultaten gevonden voor '$searchQuery'.";
    }
} else {
    echo "Vul alstublieft een zoekterm in.";
}

$conn->close(); // Close the database connection
?>

<html>

<head> 
<link rel="stylesheet" href="zoekoptie.css" />    
</head>

<body>
        
<ul>
        <li><a href="Opdrachten.html">Terug</a></li>
      </ul>
</body> 





</html>
<?php
include('db_connect.php');

if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];

    // Escape the input to prevent SQL injection
    $searchQuery = $conn->real_escape_string($searchQuery);

    // Query the database to find tasks matching the search term
    $sql = "SELECT ID, `Week`, `VoornaamMedewerker`, `TussenVoegselMedewerker`, `AchternaamMedewerker`, 
            `Omschrijvingwerkzaamheden`, `Projectnaam`, `Aantaluren`
            FROM werkzaamheden
            WHERE ID LIKE '%$searchQuery%' 
            OR `Week` LIKE '%$searchQuery%' 
            OR `VoornaamMedewerker` LIKE '%$searchQuery%' 
            OR `TussenVoegselMedewerker` LIKE '%$searchQuery%' 
            OR `AchternaamMedewerker` LIKE '%$searchQuery%' 
            OR `Omschrijvingwerkzaamheden` LIKE '%$searchQuery%' 
            OR `Projectnaam` LIKE '%$searchQuery%' 
            OR `Aantaluren` LIKE '%$searchQuery%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display search results
        echo "<h2>Zoek resultaten:</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='search-result'>";
            echo "<h3>" . $row['Projectnaam'] . "</h3>"; // Toon de projectnaam
            echo "<p><strong>ID:</strong> " . $row['ID'] . "</p>";
            echo "<p><strong>Week:</strong> " . $row['Week'] . "</p>";
            echo "<p><strong>Naam Medewerker:</strong> " . $row['VoornaamMedewerker'] . " " . $row['TussenVoegselMedewerker'] . " " . $row['AchternaamMedewerker'] . "</p>";
            echo "<p><strong>Omschrijving Werkzaamheden:</strong> " . $row['Omschrijvingwerkzaamheden'] . "</p>";
            echo "<p><strong>Aantal Uren:</strong> " . $row['Aantaluren'] . "</p>";
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
        <li><a href="klanten.html">Terug</a></li>
      </ul>
</body> 





</html>
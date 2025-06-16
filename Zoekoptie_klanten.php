<?php
include('db_connect.php');

$bodyClass = isset($_GET['search']) && !empty(trim($_GET['search'])) ? 'zoek-gestart' : '';
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Zoekresultaten Klanten</title>
    <link rel="stylesheet" href="zoekoptie.css" />
</head>
<body class="<?= $bodyClass ?>">

<ul>
    <li><a href="klanten.html">Terug</a></li>
</ul>

<?php
if (isset($_GET['search'])) {
    $searchQuery = $conn->real_escape_string($_GET['search']);

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

    if ($result && $result->num_rows > 0) {
        echo "<h2>Zoek resultaten:</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='search-result'>";
            echo "<h3>" . htmlspecialchars($row['Bedrijfsnaam']) . "</h3>";
            echo "<p><strong>ID:</strong> " . htmlspecialchars($row['ID'] ?? '') . "</p>";
            echo "<p><strong>Naam:</strong> " . htmlspecialchars($row['Voornaam'] . " " . $row['Tussenvoegsel'] . " " . $row['Achternaam']) . "</p>";
            echo "<p><strong>Functie:</strong> " . htmlspecialchars($row['Functie']) . "</p>";
            echo "<p><strong>Email:</strong> " . htmlspecialchars($row['Email']) . "</p>";
            echo "<p><strong>Telefoonnummer:</strong> " . htmlspecialchars($row['Telefoonnummer']) . "</p>";
            echo "<p><strong>Adres:</strong> " . htmlspecialchars($row['Adres']) . "</p>";
            echo "</div><hr>";
        }
    } else {
        echo "<p>No results found for '" . htmlspecialchars($searchQuery) . "'.</p>";
    }
} else {
    echo "<p>Please enter a search term.</p>";
}

$conn->close();
?>

</body>
</html>

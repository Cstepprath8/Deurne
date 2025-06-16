<?php
include('db_connect.php');

$bodyClass = isset($_GET['search']) && !empty(trim($_GET['search'])) ? 'zoek-gestart' : '';
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Zoekresultaten Medewerkers</title>
    <link rel="stylesheet" href="zoekoptie.css" />
</head>
<body class="<?= $bodyClass ?>">

<ul>
    <li><a href="Medewerkers.html">Terug</a></li>
</ul>

<?php
if (isset($_GET['search'])) {
    $searchQuery = $conn->real_escape_string($_GET['search']);

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

    if ($result && $result->num_rows > 0) {
        echo "<h2>Zoek resultaten:</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='search-result'>";
            echo "<h3>" . htmlspecialchars($row['Voornaam'] . " " . $row['Tussenvoegsels'] . " " . $row['Achternaam']) . "</h3>";
            echo "<p><strong>ID:</strong> " . htmlspecialchars($row['ID']) . "</p>";
            echo "<p><strong>Naam:</strong> " . htmlspecialchars($row['Voornaam'] . " " . $row['Tussenvoegsels'] . " " . $row['Achternaam']) . "</p>";
            echo "<p><strong>Geboortedatum:</strong> " . htmlspecialchars($row['GeboorteDatum']) . "</p>";
            echo "<p><strong>Functie:</strong> " . htmlspecialchars($row['Functie']) . "</p>";
            echo "<p><strong>Werkmail:</strong> " . htmlspecialchars($row['Werkmail']) . "</p>";
            echo "<p><strong>Kantoorruimte:</strong> " . htmlspecialchars($row['KantoorRuimte']) . "</p>";
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

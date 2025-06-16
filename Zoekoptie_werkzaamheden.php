<?php
include('db_connect.php');

$bodyClass = isset($_GET['search']) && !empty(trim($_GET['search'])) ? 'zoek-gestart' : '';
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Zoekresultaten Werkzaamheden</title>
    <link rel="stylesheet" href="zoekoptie.css" />
</head>
<body class="<?= $bodyClass ?>">

<ul>
    <li><a href="Werkzaamheden.html">Terug</a></li>
</ul>

<?php
if (isset($_GET['search'])) {
    $searchQuery = $conn->real_escape_string($_GET['search']);

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

    if ($result && $result->num_rows > 0) {
        echo "<h2>Zoek resultaten:</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='search-result'>";
            echo "<h3>" . htmlspecialchars($row['Projectnaam']) . "</h3>";
            echo "<p><strong>ID:</strong> " . htmlspecialchars($row['ID'] ?? '') . "</p>";
            echo "<p><strong>Week:</strong> " . htmlspecialchars($row['Week']) . "</p>";
            echo "<p><strong>Naam Medewerker:</strong> " 
                 . htmlspecialchars($row['VoornaamMedewerker']) . " " 
                 . htmlspecialchars($row['TussenVoegselMedewerker']) . " " 
                 . htmlspecialchars($row['AchternaamMedewerker']) . "</p>";
            echo "<p><strong>Omschrijving Werkzaamheden:</strong> " . htmlspecialchars($row['Omschrijvingwerkzaamheden']) . "</p>";
            echo "<p><strong>Aantal Uren:</strong> " . htmlspecialchars($row['Aantaluren']) . "</p>";
            echo "</div><hr>";
        }
    } else {
        echo "<p>Geen resultaten gevonden voor '" . htmlspecialchars($searchQuery) . "'.</p>";
    }
} else {
    echo "<p>Vul alstublieft een zoekterm in.</p>";
}

$conn->close();
?>

</body>
</html>

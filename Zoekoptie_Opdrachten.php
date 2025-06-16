<?php
include('db_connect.php');

$bodyClass = isset($_GET['search']) && !empty(trim($_GET['search'])) ? 'zoek-gestart' : '';
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Zoekresultaten Opdrachten</title>
    <link rel="stylesheet" href="zoekoptie.css" />
</head>
<body class="<?= $bodyClass ?>">

<ul>
    <li><a href="Opdrachten.html">Terug</a></li>
</ul>

<?php
if (isset($_GET['search'])) {
    $searchQuery = $conn->real_escape_string($_GET['search']);

    $sql = "SELECT id, `titel`, `omschrijving`, `aanvraagdatum`, `benodigdekennis`
            FROM opdrachten
            WHERE id LIKE '%$searchQuery%' 
               OR `titel` LIKE '%$searchQuery%' 
               OR `omschrijving` LIKE '%$searchQuery%' 
               OR `benodigdekennis` LIKE '%$searchQuery%'";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<h2>Zoek resultaten:</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='search-result'>";
            echo "<h3>" . htmlspecialchars($row['titel']) . "</h3>";
            echo "<p><strong>ID:</strong> " . htmlspecialchars($row['ID'] ?? '') . "</p>";
            echo "<p><strong>Omschrijving:</strong> " . htmlspecialchars($row['omschrijving']) . "</p>";
            echo "<p><strong>Aanvraagdatum:</strong> " . htmlspecialchars($row['aanvraagdatum']) . "</p>";
            echo "<p><strong>Benodigde kennis:</strong> " . htmlspecialchars($row['benodigdekennis']) . "</p>";
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

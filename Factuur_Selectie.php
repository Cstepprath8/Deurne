<?php
// Database verbinding info
$host = 'localhost';
$dbname = 'deurne';
$username = 'root';
$password = 'Wachtwoord';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Haal alle klanten op uit klanten_db en gebruik juiste kolomnamen
    $stmt = $pdo->query("SELECT ID, Bedrijfsnaam FROM klanten_db ORDER BY Bedrijfsnaam");
    $klanten = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Fout bij verbinden met database: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <link rel="stylesheet" href="factuur_Selectie.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Factuur Selectie</title>
</head>

<body>

    <ul>
        <li><a href="Index.html">Terug</a></li>
    </ul>

    <h2>Kies een klant voor een factuur te genereren</h2>

    <form action="factuur.php" method="GET">
        <label for="id">Selecteer klant:</label>
        <select name="id" id="id" required>
            <option value="" disabled selected>-- Kies een klant --</option>
            <?php foreach ($klanten as $klant): ?>
                <option value="<?= htmlspecialchars($klant['ID']) ?>">
                    <?= htmlspecialchars($klant['Bedrijfsnaam']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Factuur genereren</button>
    </form>

</body>

</html>
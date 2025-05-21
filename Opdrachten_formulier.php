<?php
// Verbinding maken met de database
$host = 'localhost';
$dbname = 'deurne';
$username = 'root';
$password = 'Wachtwoord';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Alle klanten ophalen voor dropdown
    $stmtKlanten = $pdo->query("SELECT ID, Bedrijfsnaam FROM klanten_db ORDER BY Bedrijfsnaam");
    $klanten = $stmtKlanten->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Fout bij databaseverbinding: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // klant_id komt uit formulier na submit
        $klant_id = $_POST['klant_id'] ?? null;

        if (!$klant_id) {
            throw new Exception("Klant-ID ontbreekt.");
        }

        // Haal formulierdata op
        $titel = $_POST['titel'];
        $omschrijving = $_POST['omschrijving'];
        $aanvraagdatum = $_POST['aanvraagdatum'];
        $benodigdekennis = $_POST['benodigdekennis'];

        // Voer INSERT uit
        $sql = "INSERT INTO Opdrachten (titel, omschrijving, aanvraagdatum, benodigdekennis, klant_id)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titel, $omschrijving, $aanvraagdatum, $benodigdekennis, $klant_id]);

        echo "<p style='color:green;'>✅ Opdracht succesvol toegevoegd voor klant_id $klant_id.</p>";

    } catch (Exception $e) {
        echo "<p style='color:red;'>❌ Fout: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="Formulier.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
</head>
<body>

<ul>
    <li><a href="Opdrachten.html">Opdrachten</a></li>
</ul>

<div class="brief-container">
    <h2>Opdrachtformulier</h2>
    <form action="#" method="post">

        <div class="form-group">
            <label for="klant_id">Kies een klant:</label>
            <select id="klant_id" name="klant_id" required>
                <option value="" disabled selected>-- Selecteer een klant --</option>
                <?php foreach ($klanten as $klant): ?>
                    <option value="<?= htmlspecialchars($klant['ID']) ?>">
                        <?= htmlspecialchars($klant['Bedrijfsnaam']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="titel">Titel:</label>
            <input type="text" id="titel" name="titel" placeholder="Voer titel in" required>
        </div>

        <div class="form-group">
            <label for="omschrijving">Omschrijving:</label>
            <textarea id="omschrijving" name="omschrijving" placeholder="Voer omschrijving in" required></textarea>
        </div>

        <div class="form-group">
            <label for="aanvraagdatum">Aanvraagdatum:</label>
            <input type="date" id="aanvraagdatum" name="aanvraagdatum" required>
        </div>

        <div class="form-group">
            <label for="benodigdekennis">Benodigde kennis:</label>
            <input type="text" id="benodigdekennis" name="benodigdekennis" placeholder="Voer benodigde kennis in" required>
        </div>

        <div class="form-group">
            <button type="submit">Verzend</button>
        </div>
    </form>
</div>

</body>
</html>

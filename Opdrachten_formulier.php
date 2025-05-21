<?php
// Verbinding maken met de database
$host = 'localhost';
$dbname = 'deurne';
$username = 'root';
$password = 'Wachtwoord';

// Verbinding maken met de database en formulier verwerken
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Haal formuliergegevens op
        $titel = $_POST['titel'];
        $omschrijving = $_POST['omschrijving'];
        $aanvraagdatum = $_POST['aanvraagdatum'];
        $benodigdekennis = $_POST['benodigdekennis'];

        // Haal hoogste klant_id uit de DB
        $stmt = $pdo->query("SELECT MAX(klant_id) AS max_klant_id FROM Opdrachten");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $max_klant_id = $result['max_klant_id'] ?? 0;

        // Bepaal nieuwe klant_id automatisch
        $klant_id = $max_klant_id + 1;

        // Voer insert uit met de nieuwe klant_id
        $sql = "INSERT INTO Opdrachten (titel, omschrijving, aanvraagdatum, benodigdekennis, klant_id)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titel, $omschrijving, $aanvraagdatum, $benodigdekennis, $klant_id]);

        echo "Opdracht succesvol toegevoegd met klant_id $klant_id.";

    } catch (PDOException $e) {
        echo "Database fout: " . $e->getMessage();
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

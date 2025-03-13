<?php
// Verbinding maken met de database
$host = 'localhost'; // database host
$dbname = 'csv_db 5'; // naam van de database
$username = 'root'; // je database gebruikersnaam
$password = 'Wachtwoord'; // je database wachtwoord

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        // Maak een PDO verbinding
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Haal de formuliergegevens op
        $titel = $_POST['titel'];
        $omschrijving = $_POST['omschrijving'];
        $aanvraagdatum = $_POST['aanvraagdatum'];// Dit is al in jjjj-mm-dd formaat
        $benodigdekennis = $_POST['benodigdekennis'];

        // Optioneel: als je de datum wilt omzetten naar een ander formaat
        // Zet de datum om naar een ander formaat (bijv. dd-mm-jjjj)
        $date = DateTime::createFromFormat('Y-m-d', $aanvraagdatum);
        $formatted_date = $date->format('d-m-Y');  // Converteer naar dd-mm-jjjj

        // SQL-query om de gegevens in de database in te voegen
        $sql = "INSERT INTO Opdrachten (titel, omschrijving, aanvraagdatum, benodigdekennis) 
                VALUES (?, ?, ?, ?)";

        // Bereid de statement voor
        $stmt = $pdo->prepare($sql);

        // Voer de gegevens in de query uit
        $stmt->execute([$titel, $omschrijving, $aanvraagdatum, $benodigdekennis]);

    } catch (PDOException $e) {
        // Foutafhandelingscode
        echo "Fout bij de databaseverbinding: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opdrachtformulier</title>
    <link rel="stylesheet" href="Formulier.css">
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

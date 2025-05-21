<?php
// Verbinding maken met de database
$host = 'localhost'; // database host
$dbname = 'deurne'; // naam van de database
$username = 'root'; // je database gebruikersnaam
$password = 'Wachtwoord'; // je database wachtwoord

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        // Maak een PDO verbinding
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Haal de formuliergegevens op
        $bedrijfsnaam = $_POST['bedrijfsnaam'];
        $voornaam = $_POST['voornaam'];
        $tussenvoegsel = $_POST['tussenvoegsel'];
        $achternaam = $_POST['achternaam'];
        $functie = $_POST['functie'];
        $email = $_POST['email'];
        $telefoonnummer = $_POST['telefoonnummer'];
        $adres = $_POST['adres'];

        // SQL-query om de gegevens in de database in te voegen
        $sql = "INSERT INTO klanten_db (Bedrijfsnaam, Voornaam, Tussenvoegsel, Achternaam, Functie, Email, Telefoonnummer, Adres) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Bereid de statement voor
        $stmt = $pdo->prepare($sql);

        // Voer de gegevens in de query uit
        $stmt->execute([$bedrijfsnaam, $voornaam, $tussenvoegsel, $achternaam, $functie, $email, $telefoonnummer, $adres]);

        // Pak het ID van de zojuist toegevoegde klant
        $nieuw_klant_id = $pdo->lastInsertId();

        // Redirect naar opdrachtenformulier met klant_id in URL

        

    } catch (PDOException $e) {
        echo "Fout bij de databaseverbinding: " . $e->getMessage();
    }
}
?>
<!-- Rest van je HTML blijft hetzelfde -->
<!DOCTYPE html>
<html lang="nl">
<head>
    
          <link rel="stylesheet" href="Formulier.css">
          
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

            <ul>
        <li><a href="klanten.html">Klanten</a></li>
            </ul>


    <div class="brief-container">
        <h2>Invulformulier Brief</h2>
        <form action="#" method="post">
            <div class="form-group">
                <label for="bedrijfsnaam">Bedrijfsnaam:</label>
                <input type="text" id="bedrijfsnaam" name="bedrijfsnaam" placeholder="Voer bedrijfsnaam in" required>
            </div>

            <div class="form-group">
                <label for="voornaam">Voornaam:</label>
                <input type="text" id="voornaam" name="voornaam" placeholder="Voer voornaam in" required>
            </div>

            <div class="form-group">
                <label for="tussenvoegsel">Tussenvoegsel:</label>
                <input type="text" id="tussenvoegsel" name="tussenvoegsel" placeholder="Voer tussenvoegsel in">
            </div>

            <div class="form-group">
                <label for="achternaam">Achternaam:</label>
                <input type="text" id="achternaam" name="achternaam" placeholder="Voer achternaam in" required>
            </div>

            <div class="form-group">
                <label for="functie">Functie:</label>
                <input type="text" id="functie" name="functie" placeholder="Voer functie in" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Voer email in" required>
            </div>

            <div class="form-group">
              <label for="telefoonnummer">Telefoonnummer:</label>
                  <input 
                    type="tel" 
                    id="telefoonnummer" 
                    name="telefoonnummer" 
                    placeholder="Voer telefoonnummer in" 
                    required
                    pattern="^\+?\d{1,4}[\s\-]?\(?\d+\)?[\s\-]?\d+[\s\-]?\d+$"
                    title="Voer een geldig telefoonnummer in (bijv. +31 6 12345678)" >
            </div>

            <div class="form-group">
                <label for="adres">Adres:</label>
                <textarea id="adres" name="adres" placeholder="Voer adres in" required></textarea>
            </div>

            <div class="form-group">
                <button type="submit">Verzend</button>
            </div>
        </form>
    </div>


</body>
</html>

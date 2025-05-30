<?php
// Verbinding maken met de database
$host = 'localhost'; // database host
$dbname = 'deurne'; // naam van de database
$username = 'root'; // je database gebruikersnaam
$password = 'Wachtwoord'; // je database wachtwoord

// echo '<PRE>';
// print_r($_POST);
// echo '</PRE>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   

    try {
        // Maak een PDO verbinding
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Haal de formuliergegevens op
        $voornaam = $_POST['voornaam'];
        $tussenvoegsel = $_POST['tussenvoegsels'];
        $achternaam = $_POST['achternaam'];
        $geboortedatum = $_POST['geboortedatum'];
        $functie = $_POST['functie'];
        $werkmail = $_POST['werkmail'];
        $kantoorruimte = $_POST['kantoorruimte'];

        // SQL-query om de gegevens in de database in te voegen
        $sql = "INSERT INTO werknemers_db (voornaam, tussenvoegsels, achternaam, geboortedatum, functie, werkmail, kantoorRuimte) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Bereid de statement voor
        $stmt = $pdo->prepare($sql);

        // Voer de gegevens in de query uit
        $stmt->execute([ $voornaam, $tussenvoegsel, $achternaam, $geboortedatum, $functie, $werkmail, $kantoorruimte]);
 
    
    echo "<script>alert('✅ Medewerker succesvol toegevoegd!');</script>";
        
    } catch (PDOException $e) {

    // Foutafhandelingscode
    echo "Fout bij de databaseverbinding: " . $e->getMessage();
    $bedrijfsnaam = $array['bedrijfsnaam'] ?? 'Standaardwaarde';
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    
          <link rel="stylesheet" href="formulier.css">
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

            <ul>
        <li><a href="medewerkers.html">Medewerkers</a></li>
            </ul>

    <div class="brief-container">
        <h2>Invulformulier Brief</h2>

        <form action="#" method="post">

        <div class="form-group">
        <label for="voornaam">Voornaam:</label>
        <input type="text" id="voornaam" name="voornaam" placeholder="Voer voornaam in" required>
    </div>

    <div class="form-group">
        <label for="tussenvoegsel">Tussenvoegsel:</label>
        <input type="text" id="tussenvoegsel" name="tussenvoegsels" placeholder="Voer tussenvoegsel in">
    </div>

    <div class="form-group">
        <label for="achternaam">Achternaam:</label>
        <input type="text" id="achternaam" name="achternaam" placeholder="Voer achternaam in" required>
    </div>

    <div class="form-group">
        <label for="geboortedatum">Geboortedatum:</label>
        <input type="date" id="geboortedatum" name="geboortedatum" placeholder="Voer geboortedatum in" required>
    </div>

    <div class="form-group">
        <label for="functie">Functie:</label>
        <input type="text" id="functie" name="functie" placeholder="Voer functie in" required>
    </div>

    <div class="form-group">
        <label for="werkmail">Werkmail:</label>
        <input type="email" id="email" name="werkmail" placeholder="Voer werkmail in" required>
    </div>


    <div class="form-group">
        <label for="kantoorruimte">Kantoorruimte:</label>
        <textarea id="text" name="kantoorruimte" placeholder="Voer kantoorruimte in" required></textarea>
    </div>

    <div class="form-group">
        <button type="submit">Verzend</button>
    </div>
</form>
        </form>
    </div>


</body>
</html>
<?php
// Verbinding maken met de database
$host = 'localhost'; // database host
$dbname = 'csv_db 5'; // naam van de database
$username = 'root'; // je database gebruikersnaam
$password = 'Wachtwoord'; // je database wachtwoord

echo '<PRE>';
print_r($_POST);
echo '</PRE>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   

    try {
        // Maak een PDO verbinding
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Haal de formuliergegevens op
        $id = $_POST['id'];
        $week = $_POST['week'];
        $voornaammedewerker = $_POST['voornaammedewerker'];
        $tussenvoegselmedewerker = $_POST['tussenvoegselmedewerker'];
        $achternaammedewerker = $_POST['achternaammedewerker'];
        $omschrijvingwerkzaamheden = $_POST['omschrijvingwerkzaamheden'];
        $projectnaam = $_POST['projectnaam'];
        $aantaluren = $_POST['aantaluren'];

        // SQL-query om de gegevens in de database in te voegen
        $sql = "INSERT INTO werkzaamheden ( id, week, voornaammedewerker, tussenvoegselmedewerker, achternaammedewerker, omschrijvingwerkzaamheden, projectnaam, aantaluren) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ? )";

        // Bereid de statement voor
        $stmt = $pdo->prepare($sql);

        // Voer de gegevens in de query uit
        $stmt->execute([$id, $week, $voornaammedewerker, $tussenvoegselmedewerker, $achternaammedewerker, $omschrijvingwerkzaamheden, $projectnaam, $aantaluren]);
 
    
    
        
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
        <li><a href="werkzaamheden.html">Werkzaamheden</a></li>
            </ul>

    <div class="brief-container">
        <h2>Invulformulier Brief</h2>

        <form action="#" method="post">

        <div class="form-group">
        <label for="id">id:</label>
        <input type="number" id="id" name="id" min="1" max="100" placeholder="Voer IDin" required>
    </div>

        <div class="form-group">
        <label for="week">week:</label>
        <input type="number" id="week" name="week" min="1" max="52" placeholder="Voer de week in" required>
    </div>

    <div class="form-group">
        <label for="voornaammedewerker">Voornaam Medewerker:</label>
        <input type="text" id="voornaammedewerker" name="voornaammedewerker" placeholder="Voer voornaam in">
    </div>

    <div class="form-group">
        <label for="tussenvoegselmedewerker">tussenvoegsel Medewerker:</label>
        <input type="text" id="tussenvoegselmedewerker" name="tussenvoegselmedewerker" placeholder="Voer tussenvoegsel in " >
    </div>

    <div class="form-group">
        <label for="achternaammedewerker">Achternaam Medewerker:</label>
        <input type="text" id="achternaammedewerker" name="achternaammedewerker" placeholder="Voer achternaam in" required>
    </div>

    <div class="form-group">
        <label for="omschrijvingwerkzaamheden">Omschrijving Werkzaamheden:</label>
        <input type="text" id="omschrijvingwerkzaamheden" name="omschrijvingwerkzaamheden" placeholder="Voer omschrijving werkzaamheden in" required>
    </div>

    <div class="form-group">
      <label for="projectnaam">Projectnaam:</label>
      <select id="projectnaam" name="projectnaam" required>
        <option value="" disabled selected>Kies een projectnaam</option>
        <option value="US1">US1</option>
        <option value="US2">US2</option>
        <option value="US3">US3</option>
        <option value="US4">US4</option>
        <option value="US5">US5</option>
        <option value="US6">US6</option>
        <option value="US7">US7</option>
        <option value="US8">US8</option>
        <option value="US9">US9</option>
        <option value="US10">US10</option>
        <option value="Training">Training</option>
      </select>
    </div>


    <div class="form-group">
        <label for="aantaluren">Aantal Uren:</label>
        <input type="text" id="aantaluren" name="aantaluren" placeholder="00:00" required pattern="^\d{2}:\d{2}$" title="Gebruik het formaat HH:MM">
    </div>

    <div class="form-group">
        <button type="submit">Verzend</button>
    </div>
</form>
        </form>
    </div>


</body>
</html>
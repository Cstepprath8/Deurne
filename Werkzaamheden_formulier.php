<?php
// --- DATABASE GEGEVENS ---
$host = 'localhost';
$dbname = 'deurne';
$username = 'root';
$password = 'Wachtwoord';

try {
    // Maak verbinding
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Haal opdrachten met klantnaam op
    $sql = "SELECT o.id, o.titel, k.bedrijfsnaam 
            FROM Opdrachten o 
            JOIN Klanten_DB k ON o.klant_id = k.id";
    $opdrachten = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    // Verwerk formulier
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $opdracht_id = $_POST['opdracht_id'];
        $week = $_POST['week'];
        $voornaammedewerker = $_POST['voornaammedewerker'];
        $tussenvoegselmedewerker = $_POST['tussenvoegselmedewerker'];
        $achternaammedewerker = $_POST['achternaammedewerker'];
        $omschrijvingwerkzaamheden = $_POST['omschrijvingwerkzaamheden'];
        $projectnaam = $_POST['projectnaam'];
        $aantaluren = $_POST['aantaluren'];
        $jaar = date("Y");

        // Voeg toe aan database
     $jaar = date("Y");

        $sql = "INSERT INTO werkzaamheden 
        (opdracht_id, week, voornaammedewerker, tussenvoegselmedewerker, achternaammedewerker, omschrijvingwerkzaamheden, projectnaam, aantaluren, jaar)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
    $opdracht_id, $week, $voornaammedewerker, $tussenvoegselmedewerker,
    $achternaammedewerker, $omschrijvingwerkzaamheden, $projectnaam, $aantaluren, $jaar
]);

        echo "<p style='color:green;'>✅ Werkzaamheid toegevoegd!</p>";
    }
} catch (PDOException $e) {
    echo "<p style='color:red;'>❌ Databasefout: " . $e->getMessage() . "</p>";
    $opdrachten = [];
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Werkzaamheden Formulier</title>
    <link rel="stylesheet" href="formulier.css">
</head>
<body>

<ul>
    <li><a href="werkzaamheden.html">Werkzaamheden</a></li>
</ul>

<div class="brief-container">
    <h2>Invulformulier Werkzaamheden</h2>

    <form action="#" method="post">

        <div class="form-group">
            <label for="opdracht_id">Kies een opdracht:</label>
            <select id="opdracht_id" name="opdracht_id" required>
                <option value="" disabled selected>Kies een opdracht</option>
                <?php foreach ($opdrachten as $opdracht): ?>
                    <option value="<?= htmlspecialchars($opdracht['id']) ?>">
                        <?= htmlspecialchars($opdracht['titel']) ?> (<?= htmlspecialchars($opdracht['bedrijfsnaam']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="week">Week:</label>
            <input type="number" id="week" name="week" min="1" max="52" required>
        </div>

        <div class="form-group">
            <label for="voornaammedewerker">Voornaam Medewerker:</label>
            <input type="text" id="voornaammedewerker" name="voornaammedewerker" required>
        </div>

        <div class="form-group">
            <label for="tussenvoegselmedewerker">Tussenvoegsel Medewerker:</label>
            <input type="text" id="tussenvoegselmedewerker" name="tussenvoegselmedewerker">
        </div>

        <div class="form-group">
            <label for="achternaammedewerker">Achternaam Medewerker:</label>
            <input type="text" id="achternaammedewerker" name="achternaammedewerker" required>
        </div>

        <div class="form-group">
            <label for="omschrijvingwerkzaamheden">Omschrijving Werkzaamheden:</label>
            <input type="text" id="omschrijvingwerkzaamheden" name="omschrijvingwerkzaamheden" required>
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
                <option value="Training">Training</option>
            </select>
        </div>

        <div class="form-group">
            <label for="aantaluren">Aantal Uren (HH:MM):</label>
            <input type="text" id="aantaluren" name="aantaluren" placeholder="00:00" required pattern="^\d{2}:\d{2}$">
        </div>

        <div class="form-group">
            <button type="submit">Verzend</button>
        </div>
    </form>
</div>

</body>
</html>

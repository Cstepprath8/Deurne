<?php
session_start();
include('db_connect.php');

// Sessiecontrole
if (!isset($_SESSION['loggedin'])) {
    header("Location: login2.php");
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

try {
    $pdo = new PDO("mysql:host=localhost;dbname=deurne;charset=utf8mb4", "root", "Wachtwoord");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbindingsfout: " . $e->getMessage());
}

// Alleen medewerkergegevens ophalen als rol medewerker is
$medewerker = null;
if ($role === 'medewerker') {
    $stmt = $pdo->prepare("SELECT ID, Voornaam, Tussenvoegsels, Achternaam FROM werknemers_db WHERE Voornaam = ?");
    $stmt->execute([$username]);
    $medewerker = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$medewerker) {
        die('Medewerker niet gevonden. Controleer of de gebruikersnaam correct is.');
    }
}

// Opdrachten ophalen voor dropdown (kan altijd)
$opdrachtStmt = $pdo->query("
    SELECT o.id, o.titel, k.bedrijfsnaam 
    FROM opdrachten o
    JOIN klanten_db k ON o.klant_id = k.id
");
$opdrachten = $opdrachtStmt->fetchAll(PDO::FETCH_ASSOC);

// Werkzaamheden ophalen op basis van rol
if ($role === 'afdelingshoofd') {
    // Afdelingshoofd ziet alle werkzaamheden
    $werkzaamhedenStmt = $pdo->query("SELECT * FROM werkzaamheden ORDER BY jaar DESC, week DESC");
    $werkzaamheden = $werkzaamhedenStmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($role === 'medewerker') {
    // Medewerker ziet alleen eigen werkzaamheden dit jaar
    $jaar = date('Y');
    $werkzaamhedenStmt = $pdo->prepare("SELECT * FROM werkzaamheden WHERE medewerker_id = ? AND jaar = ? ORDER BY week DESC");
    $werkzaamhedenStmt->execute([$medewerker['ID'], $jaar]);
    $werkzaamheden = $werkzaamhedenStmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Onbekende rol geen werkzaamheden
    $werkzaamheden = [];
}

// Verwerken formulier — alleen medewerkers mogen invoeren
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $role === 'medewerker') {
    $opdracht_id = $_POST['opdracht_id'] ?? null;
    $week = $_POST['week'] ?? null;
    $omschrijvingwerkzaamheden = $_POST['omschrijvingwerkzaamheden'] ?? null;
    $projectnaam = $_POST['projectnaam'] ?? null;
    $aantaluren = $_POST['aantaluren'] ?? null;

    // Eenvoudige validatie
    if ($opdracht_id && $week && $omschrijvingwerkzaamheden && $projectnaam && $aantaluren) {
        $voornaam = $medewerker['Voornaam'];
        $tussenvoegsel = $medewerker['Tussenvoegsels'];
        $achternaam = $medewerker['Achternaam'];
        $medewerker_id = $medewerker['ID'];
        $jaar = date('Y');

        $stmt = $pdo->prepare("INSERT INTO werkzaamheden (
            opdracht_id, week, voornaammedewerker, tussenvoegselmedewerker, achternaammedewerker,
            omschrijvingwerkzaamheden, projectnaam, aantaluren, medewerker_id, jaar
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $opdracht_id,
            $week,
            $voornaam,
            $tussenvoegsel,
            $achternaam,
            $omschrijvingwerkzaamheden,
            $projectnaam,
            $aantaluren,
            $medewerker_id,
            $jaar
        ]);

        // Na succesvol invoer doorverwijzen om dubbele POST te voorkomen
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error = "Vul alle velden correct in.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <title>Uren Registratie</title>
    <link rel="stylesheet" href="table.css" />
</head>
<body>

     <div class="ButtonTerug geen-print">
            <a href="Formulier_Overzicht.html" target="_self" ><button><strong>Terug</strong></button></a>
     </div>
 
    <h2>Welkom, <?= htmlspecialchars($username) ?>!</h2>
    <p><strong>Ingelogde medewerker:</strong>
        <?= $role === 'medewerker' 
            ? htmlspecialchars($medewerker['Voornaam'] . ' ' . $medewerker['Tussenvoegsels'] . ' ' . $medewerker['Achternaam']) 
            : htmlspecialchars($username) 
        ?> (Rol: <?= htmlspecialchars($role) ?>)
    </p>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($role === 'medewerker'): ?>
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
                <input type="number" id="week" name="week" min="1" max="52" required />
            </div>

            <div class="form-group">
                <label for="omschrijvingwerkzaamheden">Omschrijving Werkzaamheden:</label>
                <input type="text" id="omschrijvingwerkzaamheden" name="omschrijvingwerkzaamheden" required />
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
                <input type="text" id="aantaluren" name="aantaluren" placeholder="00:00" required pattern="^\d{2}:\d{2}$" />
            </div>

            <div class="form-group">
                <button type="submit">Verzend</button>
            </div>
        </form>
    <?php else: ?>
        <p>U kunt geen uren invoeren.</p>
    <?php endif; ?>

    <h3>Overzicht werkzaamheden</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
              
                <th>Week</th>
                <th>Omschrijving</th>
                <th>Projectnaam</th>
                <th>Aantal Uren</th>
                <th>Jaar</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($werkzaamheden)): ?>
                <tr><td colspan="6">Geen werkzaamheden gevonden.</td></tr>
            <?php else: ?>
                <?php foreach ($werkzaamheden as $werk): ?>
                    <tr>
                     
                        <td><?= htmlspecialchars($werk['Week']) ?></td>
                        <td><?= htmlspecialchars($werk['Omschrijvingwerkzaamheden']) ?></td>
                        <td><?= htmlspecialchars($werk['Projectnaam']) ?></td>
                        <td><?= htmlspecialchars($werk['Aantaluren']) ?></td>
                        <td><?= htmlspecialchars($werk['Jaar']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

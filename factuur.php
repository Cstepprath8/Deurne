<?php
include('db_connect.php');

// Klant-ID ophalen
$klant_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// === 1. KLANTGEGEVENS OPHALEN ===
$sql = "SELECT * FROM klanten_db WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $klant_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Klant niet gevonden.");
}
$klant = $result->fetch_assoc();

// === 2. FACTUURGEGEVENS OPHALEN ===
// Hier gaan we ervan uit dat 1 uur = €75
$tarief_per_uur = 75.00;

$sqlFactuur = "
    SELECT 
        o.titel AS omschrijving,
        SUM(w.aantaluren) AS totaal_uren,
        SUM(w.aantaluren) * ? AS subtotaal
    FROM werkzaamheden w
    JOIN opdrachten o ON w.opdracht_id = o.id
    WHERE o.klant_id = ?
    GROUP BY o.titel
";
$stmt = $conn->prepare($sqlFactuur);
$stmt->bind_param("di", $tarief_per_uur, $klant_id);
$stmt->execute();
$factuurResult = $stmt->get_result();

$regels = [];
$totaal = 0;
while ($row = $factuurResult->fetch_assoc()) {
    $regels[] = $row;
    $totaal += $row['subtotaal'];
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Factuur - <?= htmlspecialchars($klant['Bedrijfsnaam']) ?></title>
    <style>
        body { font-family: Arial; margin: 40px; }
        h1 { color: #333; }
        .gegevens { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #f0f0f0; }
        .totaal { font-weight: bold; }
        .geen-print { margin-bottom: 20px; }
        @media print {
            .geen-print { display: none; }
        }
    </style>
</head>
<body>

<div class="geen-print">
    <button onclick="window.print()">Download / Print Factuur</button>
</div>

<h1>Factuur</h1>
<div class="gegevens">
    <p><strong>Bedrijfsnaam:</strong> <?= htmlspecialchars($klant['Bedrijfsnaam']) ?></p>
    <p><strong>Contactpersoon:</strong> <?= htmlspecialchars(trim($klant['Voornaam'] . ' ' . $klant['Tussenvoegsel'] . ' ' . $klant['Achternaam'])) ?></p>
    <p><strong>Functie:</strong> <?= htmlspecialchars($klant['Functie']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($klant['Email']) ?></p>
    <p><strong>Telefoon:</strong> <?= htmlspecialchars($klant['Telefoonnummer']) ?></p>
    <p><strong>Adres:</strong> <?= htmlspecialchars($klant['Adres']) ?></p>
    <p><strong>Datum:</strong> <?= date("d-m-Y") ?></p>
</div>

<table>
    <tr>
        <th>Omschrijving (Project)</th>
        <th>Uren</th>
        <th>Tarief (€)</th>
        <th>Subtotaal (€)</th>
    </tr>
    <?php foreach ($regels as $regel): ?>
        <tr>
            <td><?= htmlspecialchars($regel['omschrijving']) ?></td>
            <td><?= $regel['totaal_uren'] ?></td>
            <td><?= number_format($tarief_per_uur, 2, ',', '.') ?></td>
            <td><?= number_format($regel['subtotaal'], 2, ',', '.') ?></td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="3" class="totaal">Totaal</td>
        <td class="totaal"><?= number_format($totaal, 2, ',', '.') ?></td>
    </tr>
</table>

</body>
</html>

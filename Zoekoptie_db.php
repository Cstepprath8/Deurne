<?php
$servername = "localhost";  
$username = "root";         
$password = "Wachtwoord";   
$dbname = "csv_db 6";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}


$search = isset($_GET['search']) ? trim($_GET['search']) : "";

$sql = "SELECT * FROM werknemersdb";


if (!empty($search)) {
    $sql = "SELECT * FROM werknemersdb WHERE 
    id LIKE ? OR
    Voornaam LIKE ? OR 
    Tussenvoegsels LIKE ? OR 
    Achternaam LIKE ? OR 
    GeboorteDatum LIKE ? OR 
    Functie LIKE ? OR 
    Werkmail LIKE ? OR 
    KantoorRuimte LIKE ?";
}

// Bereid de query voor
$stmt = $conn->prepare($sql);

if (!empty($search)) {
    $searchParam = "%" . $search . "%";
    $stmt->bind_param("ss", $searchParam, $searchParam);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!-- Zoekformulier -->
<form method="GET" action="Medewerkers.html">
    <input type="text" name="search" placeholder="Zoek een medewerker..." value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit">Zoeken</button>
</form>

<?php
// Sluit de databaseverbinding
$stmt->close();
$conn->close();
?>

<?php
include('db_connect.php'); 

echo '<link rel="stylesheet" type="text/css" href="medewerkersTabel.css">';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

$sql = "SELECT * FROM opdrachten"; 
$result = $conn->query($sql);

echo "<table border='1'>";

if ($result->num_rows > 0) {
    $columns = $result->fetch_fields();

    // Tabelkoppen (verberg 'ID' en 'klant_id')
    echo "<tr>";
    foreach ($columns as $column) {
        if ($column->name === 'id' || $column->name === 'klant_id') continue;
        echo "<th>" . $column->name . "</th>";
    }
    echo "</tr>";

    // Tabelrijen
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $kolom => $value) {
            if ($kolom === 'id' || $kolom === 'klant_id') continue;
            echo "<td>" . htmlspecialchars($value ?? '') . "</td>";
        }
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='100%'>Geen gegevens gevonden</td></tr>";
}
echo "</table>";

$conn->close();
?>

<?php
$servername = "localhost";  
$username = "root";         
$password = "Wachtwoord";             
$dbname = "csv_db 5";  

echo '<link rel="stylesheet" type="text/css" href="medewerkersTabel.css">';

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}



$sql = "SELECT * FROM Klanten_DB"; 
$result = $conn->query($sql);


echo "<table border='1'>";
echo "<tr>";


if ($result->num_rows > 0) {
    $columns = $result->fetch_fields();
    foreach ($columns as $column) {
        echo "<th>" . $column->name . "</th>";
    }
    echo "</tr>";

   
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='100%'>Geen gegevens gevonden</td></tr>";
}
echo "</table>";


$conn->close();
?>

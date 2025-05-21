<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'deurne';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Overzicht</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f2f5f9;
            color: #333;
        }

        header {
            background-color: #1f2e46;
            padding: 20px 40px;
            color: white;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h1 {
            margin: 0;
            font-size: 28px;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
        }

        section {
            background: white;
            padding: 25px;
            margin-bottom: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }

        h2 {
            margin-top: 0;
            font-size: 22px;
            color: #1f2e46;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background-color: #f6f8fb;
            color: #444;
        }

        tr:hover {
            background-color: #f0f4f8;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            table, thead, tbody, th, td, tr {
                display: block;
            }

            th {
                display: none;
            }

            td {
                position: relative;
                padding-left: 50%;
                border: none;
                border-bottom: 1px solid #e0e0e0;
            }

            td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                font-weight: bold;
                color: #555;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>Dashboard Overzicht</h1>
</header>

<div class="container">

    <!-- Section 1 -->
    <section>
        <h2>Aantal gewerkte uren per jaar</h2>
        <table>
            <thead>
                <tr><th>Jaar</th><th>Gewerkte uren</th></tr>
            </thead>
            <tbody>
            <?php
        $query = "
            SELECT 
                ID,
                Week,
                VoornaamMedewerker,
                TussenVoegselMedewerker,
                AchternaamMedewerker,
                Omschrijvingwerkzaamheden,
                Projectnaam,
                Aantaluren,
                opdracht_id,
                medewerker_id,
                YEAR(STR_TO_DATE(Week, '%Y-%m-%d')) AS jaar
            FROM werkzaamheden
            ORDER BY jaar, ID
        ";

        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['VoornaamMedewerker']}</td>
                    <td>{$row['TussenVoegselMedewerker']}</td>
                    <td>{$row['AchternaamMedewerker']}</td>
                    <td>{$row['Aantaluren']}</td>
                    <td>{$row['jaar']}</td>
                </tr>";
                
                
            }
        } else {
            echo "<tr><td colspan='11'>Geen gegevens gevonden of fout in query: " . $conn->error . "</td></tr>";
        }
        ?>
        </tbody>
    </table>
</section>

            ?>
            </tbody>
        </table>
    </section>

    <!-- Section 2 -->
    <section>
        <h2>Aantal binnengekomen opdrachten per klant</h2>
        <table>
            <thead>
                <tr><th>Klantnaam</th><th>2022</th><th>2023</th><th>2024</th><th>Totaal</th></tr>
            </thead>
             <tbody>
            <?php
            $result = $conn->query("
            SELECT 
            CONCAT(k.voornaam, ' ', IFNULL(k.tussenvoegsel, ''), ' ', k.achternaam) AS klantnaam,
            YEAR(o.opdracht_datum) AS jaar,
            SUM(o.prijs) AS opbrengst,
            SEC_TO_TIME(SUM(TIME_TO_SEC(u.tijd))) AS totaal_uren
            FROM klanten k
            LEFT JOIN opdrachten o ON k.ID = o.klant_id
            LEFT JOIN urenregistratie u ON o.ID = u.opdracht_id
            GROUP BY klantnaam, jaar
            ORDER BY klantnaam, jaar

                
            ");

            $klantenData = [];
            while ($row = $result->fetch_assoc()) 
                $klant = trim(preg_replace('/\s+/', ' ', $row['klantnaam']));
               $klantenData[$klant][$jaar] = [
               'opbrengst' => $row['opbrengst'],
               'totaal_uren' => $row['totaal_uren']
               ];


            foreach ($klantenData as $klant => $jaren) {
                $j2022 = $jaren[2022] ?? 0;
                $j2023 = $jaren[2023] ?? 0;
                $j2024 = $jaren[2024] ?? 0;
                $totaal = $j2022 + $j2023 + $j2024;
                echo "<tr>
                    <td>$klant</td>
                    <td>$j2022</td>
                    <td>$j2023</td>
                    <td>$j2024</td>
                    <td>$totaal</td>
                </tr>";
            }
            ?>
            </tbody>
        </table>
    </section>

    <!-- Section 3 -->
    <section>
        <h2>Jaaropbrengst</h2>
        <table>
            <thead>
                <tr><th>Jaar</th><th>Opbrengst (€)</th></tr>
            </thead>
            <tbody>
            <?php
            $query = "SELECT jaar, SUM(opbrengst) AS jaaropbrengst, COUNT(opdracht_id) AS aantal_opdrachten
                   FROM opdrachten
                   GROUP BY  JAAR
                   ORDER BY JAAR";
                   
                   $result = MYSQLI_QUERY($conn, $query);
                   
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "Jaar:" . $row['jaar'] . " - opbrengst: " . $row['jaaropbrengst'] . " - Aantal_opbrengst: " . $row['aantal_opdrachten'] . "<br>";
                }
                ?>
            </tbody>
        </table>
    </section>

</div>

</body>
</html>
<?php $conn->close(); ?>

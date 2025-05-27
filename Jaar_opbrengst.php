<?php
$host = 'localhost';
$user = 'root';
$password = 'Wachtwoord';
$database = 'deurne';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

$query = "
    SELECT 
        VoornaamMedewerker,
        Jaar AS jaar,
        SUM(Aantaluren) AS totaal_uren,
        GROUP_CONCAT(DISTINCT Omschrijvingwerkzaamheden SEPARATOR ', ') AS taken
    FROM werkzaamheden
    GROUP BY VoornaamMedewerker, jaar
    ORDER BY VoornaamMedewerker, jaar
";

$result = $conn->query($query);
$data = [];

while ($row = $result->fetch_assoc()) {
    $naam = $row['VoornaamMedewerker'];

    if (!isset($data[$naam])) {
        $data[$naam] = [
            'jaren' => [],
            'uren' => [],
            'info' => $row['taken']
        ];
    }

    $data[$naam]['jaren'][] = $row['jaar'];
    $data[$naam]['uren'][] = (float) $row['totaal_uren'];
    if (!str_contains($data[$naam]['info'], $row['taken'])) {
        $data[$naam]['info'] .= ", " . $row['taken'];
    }
}

$omschrijving_query = "
    SELECT Omschrijving, COUNT(*) AS aantal
    FROM opdrachten
    GROUP BY Omschrijving
    ORDER BY aantal DESC
    LIMIT 10
";

$omschrijving_result = $conn->query($omschrijving_query);
$omschrijving_data = [];
while ($row = $omschrijving_result->fetch_assoc()) {
    $omschrijving_data[] = $row;
}

$omschrijvingen_query = "
    SELECT VoornaamMedewerker, Omschrijvingwerkzaamheden, COUNT(*) AS aantal
    FROM werkzaamheden
    GROUP BY VoornaamMedewerker, Omschrijvingwerkzaamheden
    ORDER BY VoornaamMedewerker, aantal DESC
";

$omschrijving_per_medewerker = [];
$result = $conn->query($omschrijvingen_query);
while ($row = $result->fetch_assoc()) {
    $naam = $row['VoornaamMedewerker'];
    if (!isset($omschrijving_per_medewerker[$naam])) {
        $omschrijving_per_medewerker[$naam] = [];
    }
    if (count($omschrijving_per_medewerker[$naam]) < 10) {
        $omschrijving_per_medewerker[$naam][] = [
            'Omschrijvingwerkzaamheden' => $row['Omschrijvingwerkzaamheden'],
            'aantal' => (int) $row['aantal']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Overzicht Medewerkers & Opdrachten</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f5f9;
            padding: 20px;
            color: #fff;
            text-align: center;
            background-image: url("Foto/WebsiteAchtergrond 3.png");
            background-size: cover;

        }

        h1, h2 {
            color: #1f2e46;
        }

        ul#medewerker-lijst {
            list-style: none;
            padding: 0;
            margin: 0 0 20px 0;
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        ul#medewerker-lijst li button {
            background-color: #1f2e46;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        ul#medewerker-lijst li button:hover {
            background-color: #344966;
        }

        .layout {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 40px;
            margin-top: 30px;
        }

        #grafiek,
        #omschrijvingGrafiek {
            width: 80% !important;
            max-width: 800px;
            height: 400px !important;
            margin: 0 auto;
        }

        #medewerker-info {
            max-width: 600px;
            margin: 20px auto;
            text-align: left;
        }

        button.active {
            background-color: rgba(29, 78, 118, 0.44) !important;
            color: red;
        }

        .ButtonTerug {
            display: flex;
            justify-content: flex-end;
            left: 90%;

        }

        .geen-print {
            text-align: right;
            margin-top: 20px;
        }

        .geen-print button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .geen-print button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <div class="ButtonTerug geen-print">
        <a href="index.html" target="_self"><button><strong>Terug</strong></button></a>
    </div>

    <h1>Medewerker Uren per jaar Overzicht</h1>

    <ul id="medewerker-lijst">
        <?php foreach ($data as $naam => $gegevens): ?>
            <li><button onclick="toonGrafiek('<?php echo $naam; ?>')"><?php echo htmlspecialchars($naam); ?></button></li>
        <?php endforeach; ?>
    </ul>

    <div class="layout">
        <div class="grafiek-container">
            <canvas id="grafiek"></canvas>
        </div>
        <div class="omschrijving-container">
            <h2>Top 10 Opdrachtsoorten</h2>
            <canvas id="omschrijvingGrafiek"></canvas>
        </div>
        <div id="medewerker-info">
        </div>
    </div>

    <script>
        const dataPerNaam = <?php echo json_encode($data); ?>;
        const omschrijvingData = <?php echo json_encode($omschrijving_data); ?>;
        const omschrijvingenPerMedewerker = <?php echo json_encode($omschrijving_per_medewerker); ?>;

        let grafiekObject = null;

        // Lege grafiek tonen bij pagina-lading
        const ctxInit = document.getElementById('grafiek').getContext('2d');
        grafiekObject = new Chart(ctxInit, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Gewerkte uren',
                        data: [],
                        backgroundColor: 'rgba(0, 34, 255, 0.6)',
                        yAxisID: 'y'
                    },
                    {
                        label: 'Opdrachten',
                        data: [],
                        backgroundColor: 'rgba(254, 119, 0, 0.6)',
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Aantal uren' }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        grid: { drawOnChartArea: false },
                        title: { display: true, text: 'Aantal opdrachten' }
                    }
                }
            }
        });


        function toonGrafiek(naam) {
            const buttons = document.querySelectorAll('#medewerker-lijst button');
            buttons.forEach(btn => btn.classList.remove('active'));

            const actieveKnop = Array.from(buttons).find(btn => btn.textContent.trim() === naam);
            if (actieveKnop) {
                actieveKnop.classList.add('active');
            }

            const gegevens = dataPerNaam[naam];
            const omschrijvingen = omschrijvingenPerMedewerker[naam] || [];

            const jaren = gegevens.jaren;
            const uren = gegevens.uren;

            const omschrijvingLabels = omschrijvingen.map(item => item.Omschrijvingwerkzaamheden);
            const omschrijvingWaarden = omschrijvingen.map(item => item.aantal);

            const gecombineerdeLabels = jaren.concat(omschrijvingLabels);
            const urenData = uren.concat(Array(omschrijvingLabels.length).fill(null));
            const opdrachtData = Array(jaren.length).fill(null).concat(omschrijvingWaarden);

            const ctx = document.getElementById('grafiek').getContext('2d');
            if (grafiekObject) grafiekObject.destroy();

            grafiekObject = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: gecombineerdeLabels,
                    datasets: [
                        {
                            label: `Gewerkte uren - ${naam}`,
                            data: urenData,
                            backgroundColor: 'rgba(0, 34, 255, 0.6)',
                            yAxisID: 'y'
                        },
                        {
                            label: `Opdrachten - ${naam}`,
                            data: opdrachtData,
                            backgroundColor: 'rgba(254, 119, 0, 0.6)',
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Aantal uren' }
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            title: { display: true, text: 'Aantal opdrachten' }
                        }
                    }
                }
            });

            document.getElementById("medewerker-info").innerHTML = `
        `;
        }

        // === Initieer omschrijving-grafiek bij laden ===
        const omschrijvingen = omschrijvingData.map(item => item.Omschrijving);
        const aantallen = omschrijvingData.map(item => item.aantal);

        const omschrijvingCtx = document.getElementById('omschrijvingGrafiek').getContext('2d');
        new Chart(omschrijvingCtx, {
            type: 'bar',
            data: {
                labels: omschrijvingen,
                datasets: [{
                    label: 'Aantal opdrachten per omschrijving',
                    data: aantallen,
                    backgroundColor: 'rgba(255, 0, 55, 0.6)'
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>
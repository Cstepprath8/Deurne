<?php 
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: login2.php");
    exit();
}
?> 



<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> Index </title>
    <link rel="stylesheet" href="Index.css" />

</head>

<body>
    <ul>
        <li><a href="Index.php">Index</a></li>
    </ul>

    <div class="container">
        <a href="Klanten.html" target="_self"><button><strong>Klanten</strong></button></a>
        <a href="Medewerkers.html" target="_self"><button><strong>Medewerkers</strong></button> </a>
        <a href="Opdrachten.html" target="_self"><button><strong>Opdrachten </strong></button> </a>
        <a href="Werkzaamheden.html" target="_self"><button><strong>Werkzaamheden</strong></button> </a>
    </div>


    <div class="schuine-balk links"></div>
    <div class="schuine-balk rechts"></div>


    <div class="Formulier">
        <a href="Formulier_Overzicht.html" target="_self"><button><strong>Invul Formulier Overzicht</strong></button></a>
    </div>

    <div class="Grafiek">
        <a href="Jaar_opbrengst.php" target="_self"><button><strong>Uren / Opdrachten overzicht</strong></button></a>
    </div>

    <div class="Factuur">
        <a href="Factuur_Selectie.php" target="_self"><button><strong>Factuur Genereren</strong></button></a>
    </div>

     <div class="Logout">
        <a href="logout.php" target="_self"><button><strong>Uitloggen</strong></button></a>
    </div>

    <footer>
        <img src="Foto/GildeDevOps.png" alt="DevOps foto">
    </footer>





</body>

</html>
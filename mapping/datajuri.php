<?php



$Connexion;
$DB_HOST = 'localhost';
$DB_NAME = 'juridique';
$DB_USER = 'root';
$DB_PASS = '';

$connexion = new \mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME)
    or die("Erreur de connexion : " . mysqli_error($Connexion));

$sql = 'SELECT `IDJURIS`,`DATEJURIS` FROM `jurisprudence`';


$result = $connexion->query($sql);

$mois = [
    'janvier' => 'January',
    'février' => 'February',
    'mars' => 'March',
    'avril' => 'April',
    'mai' => 'May',
    'juin' => 'June',
    'juillet' => 'July',
    'août' => 'August',
    'septembre' => 'September',
    'octobre' => 'October',
    'novembre' => 'November',
    'décembre' => 'December'
];




while ($row = $result->fetch_array()) {


    $dateStr = $row[1];




    // Remplace le mois français par sa version anglaise
    foreach ($mois as $fr => $en) {
        $dateStr = str_ireplace($fr, $en, $dateStr);
    }

    // Maintenant PHP peut parser la date
    $date = new DateTime($dateStr);


    $s = "update jurisprudence set dateJuri = '{$date->format('Y-m-d')}' where IDJURIS = '{$row[0]}'";
    echo "<br>" . $s . "<br>";


    $r = $connexion->query($s);
}

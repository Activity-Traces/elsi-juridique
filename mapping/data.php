<?php



$Connexion;
$DB_HOST = 'localhost';
$DB_NAME = 'juridique';
$DB_USER = 'root';
$DB_PASS = '';

$connexion = new \mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME)
    or die("Erreur de connexion : " . mysqli_error($Connexion));

$sql = 'SELECT `idversion`,`nomloiabrej` FROM `version` ORDER BY `version`.`idversion` ASC';


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


    $dateStr = explode(' du ', $row[1])[1];




    // Remplace le mois français par sa version anglaise
    foreach ($mois as $fr => $en) {
        $dateStr = str_ireplace($fr, $en, $dateStr);
    }

    // Maintenant PHP peut parser la date
    $date = new DateTime($dateStr);

    $s = "update version set dateloi = '{$date->format('Y-m-d')}' where idversion = '{$row[0]}'";
    echo "<br>" . $s . "<br>";


    $r = $connexion->query($s);
}

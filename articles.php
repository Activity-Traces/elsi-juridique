<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <link href="https://cdn.datatables.net/v/bm/dt-2.3.2/datatables.min.css" rel="stylesheet" integrity="sha384-lcweTT34BgF7atop9guP1YvuCYIKE0lwW7SxEeU6ml1bdTVKAWr10LtDW1q9/tsY" crossorigin="anonymous">

    <script src="https://cdn.datatables.net/v/bm/dt-2.3.2/datatables.min.js" integrity="sha384-KHxoFaaE7/r07SLDWdYBPAX1ChTSOPJd/CC0JIflFbCiGujNq7zrUlTx7HLM8Kih" crossorigin="anonymous"></script>


</head>

<body>


    <?php


    // Fonction pour garder la sélection
    function selectedOption($name, $value)
    {
        return (isset($_GET[$name]) && $_GET[$name] === $value) ? 'selected' : '';
    }


    $Connexion;
    $DB_HOST = 'localhost';
    $DB_NAME = 'juridique';
    $DB_USER = 'root';
    $DB_PASS = '';

    $connexion = new \mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME)
        or die("Erreur de connexion : " . mysqli_error($Connexion));

    if (!empty($_GET['sujet']))
        $sql  = "SELECT * FROM article where sujet = '" . $_GET['sujet'] . "'";

    else
        $sql  = "SELECT * FROM article";




    $result = $connexion->query($sql);
    ?>

</body>


<div class="container" style="background-color: #f8fbfd;">


    <?php include "nav.php" ?>


    <form method="GET">
        <label for="sujet">Sujet :</label>
        <select name="sujet" id="sujet">
            <option value="">-- Choisissez un sujet --</option>
            <?php
            $result2 = $connexion->query("SELECT DISTINCT sujet FROM article ORDER BY sujet ASC");
            while ($row1 = $result2->fetch_assoc()):
            ?>
                <option value="<?= htmlspecialchars($row1['sujet']) ?>" <?= selectedOption('sujet', $row1['sujet']) ?>>
                    <?= htmlspecialchars($row1['sujet']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="submit" value="Rechercher">
    </form>

    <table class="table table-striped">
        <table id="mytable" class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">idarticle </th>
                    <th scope="col">sujet</th>
                    <th scope="col">theme</th>
                    <th scope="col">textinitital</th>
                    <th scope="col">nomloi</th>
                    <th scope="col">nomloiabrej</th>
                    <th scope="col"> annee</th>
                </tr>
            </thead>
            <tbody>


                <?php

                while ($row = $result->fetch_array()) {


                    echo '      
                <tr>
                <td>' . $row[0] . '</td>
                <td>' . $row[1] . '</td>
                <td>' . $row[2] . '</td>
                <td>' . $row[3] . '</td>
                <td>' . $row[4] . '</td>
                <td>' . $row[5] . '</td>
                <td>' . $row[6] . '</td>
                
               
              
        
                </tr>';
                }

                ?>

            </tbody>
        </table>

</div>
<script>
    $(document).ready(function() {
        $('#mytable').DataTable(

            {
                "info": false,
                "searching": true,
                "paging": false,

                "language": {
                    search: "Rechercher :"

                }



            }

        );
    });
</script>


</html>
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
    $Connexion;
    $DB_HOST = 'localhost';
    $DB_NAME = 'juridique';
    $DB_USER = 'root';
    $DB_PASS = '';

    $connexion = new \mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME)
        or die("Erreur de connexion : " . mysqli_error($Connexion));

    $sql  = "SELECT * FROM version";

    $result = $connexion->query($sql);
    ?>

</body>


<div class="container" style="background-color: #f8fbfd;">
    <?php include "nav.php" ?>

    <table class="table table-striped">
        <table id="mytable" class="table table-hover">
            <thead>

                <tr>
                    <th scope="col">idarticle </th>
                    <th scope="col">idversion</th>
                    <th scope="col">text</th>
                    <th scope="col">nomloi</th>
                    <th scope="col">nomloiabrej</th>
                    <th scope="col">dateloi</th>
                </tr>
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
<?php

/*********************************************************************************************************************************************** */

$host = 'localhost';       // Modifie si besoin
$user = 'root';        // Ton utilisateur MySQL
$pass = '';         // Ton mot de passe MySQL
$dbname = 'juridique';

$mysqli = new mysqli($host, $user, $pass, $dbname);


$sql = "SELECT idarticle, idversion, text, nomloi, nomloiabrej, dateloi FROM version where idarticle  ='" . $_GET['idarticle'] . "' ORDER BY dateloi ASC";

if ($result = $mysqli->query($sql)) {
    $rows = [];

    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }



    $result->free();
    $data = $rows;
} else {
    echo json_encode(['error' => "Erreur SQL : " . $mysqli->error]);
}



$sqlarticle = 'SELECT * FROM `article`where  idarticle = "' . $_GET['idarticle'] . '"';
$result2 = $mysqli->query($sqlarticle);
$row2 = $result2->fetch_assoc();

/*********************************************************************************************************************************************** */

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Liste des versions</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
</head>

<body>
    <div class="container mt-4">

        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Détails de l'article
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample" style="">
                    <div class="accordion-body">
                        <?php



                        echo " <b>Identifiant Article : </b>" . $row2["idarticle"] . "<br>";
                        echo " <b> Sujet : </b> " . $row2["sujet"] . "<br>";
                        echo " <b>Thème : </b> " . $row2["theme"] . "<br>";
                        echo " <b>Text Initital : </b> " . $row2["textinitital"] . "<br>";
                        echo " <b>Nom de la loi :  </b>" . $row2["nomloi"] . "<br>";
                        echo " <b>Nom de la Loi abregé :  </b>" . $row2["nomloiabrej"] . "<br>";
                        echo " <b>Année : </b> " . $row2["annee"] . "<br>";
                        echo " <b>Localisation : </b> " . $row2["localisation"] . "<br>";
                        ?>
                    </div>
                </div>
            </div>

        </div>


        <br>
        <h2>les versions de l'article no <?php echo $_GET['idarticle'] ?></h2>




        <canvas id="myChart" width="600" height="150"></canvas>
        <a class="btn btn-light" href="index.php" role="button">Retour à l'acceuil</a>
    </div>

    <!-- Modale Bootstrap -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Détails du point</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body" id="modalBodyContent">
                    <!-- Le contenu sera injecté ici -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (inclut Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        async function fetchData() {
            try {

                const data = <?php echo json_encode($data); ?>;;

                if (data.error) {
                    alert('Erreur serveur: ' + data.error);
                    return [];
                }

                return data;
            } catch (err) {
                alert('Erreur de récupération des données: ' + err);
                return [];
            }
        }

        async function createChart() {
            const data = await fetchData();

            const points = data.map(item => ({
                x: item.dateloi,
                y: 10,
                custom: item
            }));

            const ctx = document.getElementById('myChart').getContext('2d');

            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: [{
                        label: 'Liste des versions',
                        data: points,
                        borderColor: '#a2d9ce',
                        backgroundColor: 'rgba(0, 128, 0, 0.2)',
                        fill: false,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        tension: 0.2
                    }]
                },
                options: {
                    onClick: (event, elements) => {
                        if (elements.length > 0) {
                            const point = elements[0];
                            const dataset = chart.data.datasets[point.datasetIndex];
                            const dataPoint = dataset.data[point.index];
                            const infos = dataPoint.custom;

                            // Crée le contenu HTML de la modale
                            const modalHtml = `
                                    <ul class="list-unstyled mb-0">
                                    <li><strong>Identifiant Article :</strong> ${infos.idarticle}</li>
                                    <li><strong>Identifiant Version :</strong> ${infos.idversion}</li>
                                    <li><strong>Texte :</strong> ${infos.text}</li>
                                    <li><strong>Nom de la loi :</strong> ${infos.nomloi}</li>
                                    <li><strong>Abrébviation :</strong> ${infos.nomloiabrej}</li>
                                    <li><strong>Date de la loi :</strong> ${new Date(infos.dateloi).toLocaleDateString()}</li>
                                    </ul>
              `;

                            document.getElementById('modalBodyContent').innerHTML = modalHtml;

                            // Ouvre la modale Bootstrap
                            const bsModal = new bootstrap.Modal(document.getElementById('detailsModal'));
                            bsModal.show();
                        }
                    },
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'year',
                                displayFormats: {
                                    day: 'yyyy'
                                }
                            },
                            title: {
                                display: true,
                                text: 'Date de la version'
                            }
                        },
                        y: {
                            min: 8,
                            max: 12,
                            title: {
                                display: true,
                                text: ''
                            }
                        }
                    }
                }
            });
        }

        createChart();
    </script>
</body>

</html>
<?php
//Incluye la configuración de sesión
include('config.php');
$login_button = '';
//Token
if (isset($_GET["code"])) {

  $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
  if (!isset($token['error'])) {

    $google_client->setAccessToken($token['access_token']);

    $_SESSION['access_token'] = $token['access_token'];

    $google_service = new Google_Service_Oauth2($google_client);

    $data = $google_service->userinfo->get();

    if (!empty($data['given_name'])) {
      $_SESSION['user_first_name'] = $data['given_name'];
    }

    if (!empty($data['family_name'])) {
      $_SESSION['user_last_name'] = $data['family_name'];
    }

    if (!empty($data['email'])) {
      $_SESSION['user_email_address'] = $data['email'];
    }

    if (!empty($data['gender'])) {
      $_SESSION['user_gender'] = $data['gender'];
    }

    if (!empty($data['picture'])) {
      $_SESSION['user_image'] = $data['picture'];
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- JQUERY-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <!-- ESTILOS CSS -->
  <link rel="stylesheet" href="dashdash.css">

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- FAVICON WEB-->
  <link rel="icon" type="image/png" href="./favicon.png" />
  <!-- FUENTES GOOGLE IDIOMAS -->
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500&display=swap" rel="stylesheet">
  <!-- FONT AWESOME -->
  <script src="https://kit.fontawesome.com/f80991af51.js" crossorigin="anonymous"></script>
  <!-- POR DEFECTO -->
  <script type="text/javascript" src="Chart.js"></script>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UTN FRD</title>
</head>
<body>
  <section class="home">
    <!-- Sección total-->
    <sidebar class="wrapper">
      <!-- Sección Perfil-->
      <div class="sidebar" id="sidebar" style="display:none; max-height:650px; max-width:650px; min-height:1550px">
        <div class="table-responsive" id="folder_table">
        </div>
        <div id="filelistModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
              </div>
              <div class="modal-body" id="file_list">
                <!--Lista de Archivos-->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="display:none">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <div id="ih">
        </div>
      </div>
</sidebar>
    <div class="sidebarT">
      <h2><i class="fas fa-folder-open" onclick="closeIt()" style="-webkit-appearance: none;border-radius: 10px;border:none; box-shadow:1px 2px 3px black; cursor:pointer; background-color: azure; border:1px solid #000000; color:#000000; position:static; padding: 10px;"></i>
      </h2>
    </div>
    <section class="home">
      <div class="flexible" id="flexiblef">
        <!-- Selección Principal-->
        <div class="flexible11">
          <b><a href="https://podat.herokuapp.com/import.php"> Importe de:<br> Archivos <i class="far fa-paper-plane"></i></a></b>
        </div>
        <br>
        <div class="flexible11">
          <b><a href="students.php"> Ingreso de:<br> Datos de Alumno <i class="fas fa-graduation-cap"></i></a></b>
        </div>
        <br>
        <div class="flexible11">
          <b><a href="roles.php"> Asignaciòn de:<br> Rol <i class="fas fa-hand-sparkles"></i></a></b>
        </div>
        <div class="flexible111">
          <h1> Topicos relevantes</h1>
        </div>
        <div class="topics">
          <div class="box0"> <a href="#"> Inscripto </a></div>
          <div class="box1"> <a href="#"> Regular </a></div>
          <div class="box2"> <a href="#"> Totales </a></div>
        </div>
        <div class="flexible2" style="display:block">

          <h2> VISITAS RECIENTES:</h2> <br>
          <!-- Graficos en linea-->
          <div class="inLine" style="display:block">
            <canvas id="charting" class="chartos1">
            </canvas>
            <script>
            chartIt();
            const ytemps = [];
            const xlabels = [];
            async function chartIt() {
                await getData();
                const ctxx = document.getElementById('charting').getContext('2d');
                const myChartx = new Chart(ctxx, {
                    type: 'line',
                    data: {
                        labels: xlabels,
                        datasets: [{
                            label: 'Ingresos este año',
                            data: ytemps,
                            backgroundColor: '#fff',
                            borderColor: [
                                'rgba(10, 40, 180)',
                            ],

                            borderWidth: 3
                        }],
                        options: {
                            responsive: true,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    },
                });
            }
            getData();

            async function getData() {
                const response = await fetch('datasheet0.csv');
                const data = await response.text();

                const table = data.split('\n').slice(1);
                table.forEach(row => {
                    const columns = row.split(',');
                    const year = columns[0];
                    xlabels.push(year);
                    const temp = columns[1];
                    ytemps.push(temp);
                    //console.log(year, temp);
                });
            }
        </script>
          <br>
            <div class="categories0" style="display:none">
              <a class="hideDisplay">Materias<i class="fas fa-chevron-right"></i>
              <span class="showDisplayOnHover">
                <div class="chart-container" style="position: relative; height: 50vh; width: 25vw">
                  <canvas id="charto" class="chartos">
                  </canvas>
                </div>
                <span class="showBodyOfDisplayOnHover">
                </span>
              </span>
            </a>
            <a class="hideDisplay">Materias<i class="fas fa-chevron-right"></i>
              <span class="showDisplayOnHover">
                <div class="chart-container" style="position: relative; height: 50vh; width: 25vw">
                  <canvas id="charto1" class="chartos">
                  </canvas>
                </div>
                <span class="showBodyOfDisplayOnHover">
                  </canvas>
                </span>
              </span>
            </a>

            <a class="hideDisplay1">Materias<i class="fas fa-chevron-right"></i>
              <span class="showDisplayOnHover">
                <div class="chart-container" style="position: relative; height: 38vh; width: 35vw">
                  <canvas id="charto2" class="chartos">
                  </canvas>
                </div>
                <span class="showBodyOfDisplayOnHover">
                  </canvas>
                </span>
              </span>
            </a>
            <a class="hideDisplay">Materias<i class="fas fa-chevron-right"></i>
              <span class="showDisplayOnHover">
                <div class="chart-container" style="position: relative; height: 50vh; width: 25vw">
                  <canvas id="charto3" class="chartos">
                  </canvas>
                </div>
                <span class="showBodyOfDisplayOnHover">
                </span>
              </span>
            </a>
            <br>
          </div>
        </div>
      </div>
    </section>
    <section class="home1" style="display:block">
      <div id="userD" class="profileCard">
        <!-- Aca va el usuario -->
        <?php
        if ($login_button == '') {
          echo '<div class="card-header">';
          echo '</br>';
          echo '<a href="logout.php" style="color:#ffffff; cursor:pointer"> <h1>&nbsp;<i id="logoutpls" class="fas fa-sign-out-alt"></h1></i></a>';
          echo '<img style="margin-left:27%; border-radius:50%; border: 2px solid rgb(20, 50, 100);" src="' . $_SESSION["user_image"] . '" class="rounded-circle container"/>';
          echo '<h3 style="color:white; margin-left:10%;"><b>Name :</b> ' . $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] . '</h3>';
          echo '<h3 style="color:white; margin-left:10%;"><b>Email :</b> ' . $_SESSION['user_email_address'];
        }
        ?>
      </div>
      <!-- Section Quick View-->
      <div class="inLine1" style="display:block">
        <div class="flexible12" onclick="toggleGraph()">
          <b><a href="#"> Enero a Mayo</i></a></b>
        </div>
        <div class="inLineCanvas">
          <canvas id="charting1" class="chartosR" style="width: 380px">
          </canvas>
          <script>
            function toggleGraph() {
              var x = document.getElementById("charting1");
              if (x.style.display === "none") {
                x.style.display = "block";
              } else {
                x.style.display = "none";
              }
            }
            chartIt();
            const ytemps1 = [];
            const xlabels1 = [];
            async function chartIt() {
              await getData();
              const ctx1 = document.getElementById('charting1').getContext('2d');
              const myChart1 = new Chart(ctx1, {
                type: 'pie',
                data: {
                  labels: xlabels1,
                  datasets: [{
                    label: 'Ingresos',
                    data: ytemps1,
                    backgroundColor: [
                      'rgba(50, 50, 100)',
                      'rgba(45, 50, 150)',
                      'rgba(10, 40, 200)',
                      'rgba(0, 50, 250)',
                      'rgba(255, 0, 0)',
                      'rgba(200, 49, 41)',
                      'rgba(150, 50, 20)',
                      'rgba(59, 31, 12)',
                    ],
                    hoverOffset: 20,
                    borderColor: [
                      '#cacaca',
                    ],
                    borderWidth: 2
                  }],
                  options: {
                    scales: {
                      yAxes: [{
                        ticks: {
                          beginAtZero: true
                        }
                      }]
                    }
                  }
                },
              });
            }
            async function getData() {
              const response = await fetch('datasheet1.csv');
              const data = await response.text();

              const table = data.split('\n').slice(1);
              table.forEach(row => {
                const columns1 = row.split(',');
                const year1 = columns1[0];
                xlabels1.push(year1);
                const temp = columns1[1];
                ytemps1.push(temp);
              });
            }
          </script>
        </div>

      </div>
      <div class="inLine1" style="display:block">
        <div class="flexible12" onclick="toggleGraph1()">
          <b><a href="#"> Junio a Agosto</i></a></b>
        </div>
        <div class="inLineCanvas">
          <canvas id="charting2" class="chartosR" style="width: 380px">
          </canvas>
          <script>
          function toggleGraph1() {
            var x1 = document.getElementById("charting2");
            if (x1.style.display === "none") {
              x1.style.display = "block";
            } else {
              x1.style.display = "none";
            }
          }
          chartIt2();
          const ytemps2 = [];
          const xlabels2 = [];
          async function chartIt2() {
            await getData2();
            const ctx2 = document.getElementById('charting2').getContext('2d');
            const myChart2 = new Chart(ctx2, {
              type: 'polarArea',
              data: {
                labels: xlabels2,
                datasets: [{
                  label: 'Varones',
                  data: ytemps2,
                  backgroundColor: [
                    'rgba(75, 134, 171)',
                    'rgba(75, 101, 171)',
                    'rgba(32, 40, 92)',
                    'rgba(75, 0, 171)',
                    'rgba(117, 49, 41)',
                    'rgba(237, 47, 26)',
                    'rgba(59, 31, 12)',
                  ],
                  borderColor: [
                    '#b0b0b0',
                  ],
                  hoverOffset: 40,
                  borderWidth: 2
                }],
                options: {
                  scales: {
                    yAxes: [{
                      ticks: {
                        beginAtZero: true
                      }
                    }]
                  }
                }
              },
            });
          }
          async function getData2() {
            const response = await fetch('datasheet2.csv');
            const data = await response.text();

            const table = data.split('\n').slice(1);
            table.forEach(row => {
              const columns2 = row.split(',');
              const year2 = columns2[0];
              xlabels2.push(year2);
              const temp = columns2[1];
              ytemps2.push(temp);
            });
          }
        </script>
        </div>
      </div>
      <div class="inLine1" style="display:block">
        <div class="flexible12" onclick="toggleGraph2()">
          <b><a href="#"> Septiembre a Diciembre</i></a></b>
        </div>
        <div class="inLineCanvas">
          <canvas id="charting3" class="chartosR" style="width: 380px">
          </canvas>
          <script>
          function toggleGraph2() {
            var x2 = document.getElementById("charting3");
            if (x2.style.display === "none") {
              x2.style.display = "block";
            } else {
              x2.style.display = "none";
            }
          }
          chartIt3();
          const ytemps3 = [];
          const xlabels3 = [];
          async function chartIt3() {
            await getData3();
            const ctx3 = document.getElementById('charting3').getContext('2d');
            const myChart3 = new Chart(ctx3, {
              type: 'doughnut',
              data: {
                labels: xlabels3,
                datasets: [{
                  label: 'Varones',
                  data: ytemps3,
                  backgroundColor: [
                    'rgba(255, 234, 0)',
                    'rgba(202, 252, 0)',
                    'rgba(157, 179, 68)',
                    'rgba(76, 105, 29)',
                    'rgba(36, 80, 97)',
                    'rgba(62, 134, 135)',
                    'rgba(79, 168, 134)',
                    'rgba(112, 255, 200)',
                  ],
                  borderColor: [
                    '#b0b0b0',
                  ],
                  hoverOffset: 20,
                  borderWidth: 2
                }],
                options: {
                  scales: {
                    yAxes: [{
                      ticks: {
                        beginAtZero: true
                      }
                    }]
                  }
                }
              },
            });
          }
          async function getData3() {
            const response3 = await fetch('datasheet3.csv');
            const data3 = await response3.text();
            const table3 = data3.split('\n').slice(1);
            table3.forEach(row => {
              const columns3 = row.split(',');
              const year3 = columns3[0];
              xlabels3.push(year3);
              const temp3 = columns3[1];
              ytemps3.push(temp3);
            });
          }
        </script>
        </div>
      </div>
    </section>
    <div>
      <!-- Scripts aqui -->
      <!-- firebase base-->
      <!-- Scripts usados-->
      <script src="chart.js"></script>
      <script src="mychart0.js"></script>
      <!-- Config Defecto Chart.js-->
      <script>
        Chart.defaults.font.family = "Calibri";
        Chart.defaults.color = "#ffffff";
      </script>
      <!-- Datos a Chartjs por codigo HARD CODE <script src="./mychart0.js"></script>-->

      <script type="module">
      </script>
      <script>
        $(document).ready(function() {

          load_folder_list();

          function load_folder_list() {
            var action = "fetch";
            $.ajax({
              url: "action.php",
              method: "POST",
              data: {
                action: action
              },
              success: function(data) {
                $('#folder_table').html(data);
              }
            });
          }

          $(document).on('click', '.view_files', function() {
            var folder_name = $(this).data("name");
            var action = "fetch_files";
            $.ajax({
              url: "action.php",
              method: "POST",
              data: {
                action: action,
                folder_name: folder_name
              },
              success: function(data) {
                $('#file_list').html(data);
                $('#filelistModal').modal('show');
              }
            });
          });

          $(document).on('click', '.remove_file', function() {
            var path = $(this).attr("id");
            var action = "remove_file";
            if (confirm("Estas seguro de querer eliminarlo?, ...PERMANENTE...")) {
              $.ajax({
                url: "action.php",
                method: "POST",
                data: {
                  path: path,
                  action: action
                },
                success: function(data) {
                  alert(data);
                  $('#filelistModal').modal('hide');
                  load_folder_list();
                }
              });
            }
          });
          // Utilizar .$file. de los archivos para mostrar graficos automaticamente.
        });
      </script>
      <script>
        function logout() {
          location.replace("./index.php");
        }

        function closeIt() {
          var x = document.getElementById("sidebar");
          if (x.style.display === "none") {
            x.style.display = "block";
          } else {
            x.style.display = "none";
          }
        }
      </script>
    </div>
</body>

</html>
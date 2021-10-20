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

<body >
  <section class="home">
    <!-- Sección total-->
    <div class="wrapper">
      <!-- Sección Perfil-->
      <div class="sidebar" id="sidebar" style="display:block">
        <h1 style="color:#ffffff; cursor:pointer"> &nbsp;<i id="logoutpls" class="fas fa-sign-out-alt"></i></h1>
        <div id="userD">
          <!-- Aca va el usuario -->
        </div>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <div id="ih">
        </div>
      </div>
    </div>
    <div class="sidebarT">
      <h2><i class="fas fa-user" onclick="closeIt()" style="-webkit-appearance: none;border-radius: 10px;border:none; box-shadow:1px 2px 3px black; cursor:pointer; background-color: azure; border:1px solid #000000; color:#000000; position:static; padding: 10px;"></i>
      </h2>
    </div>
    <section class="home">
      <div class="flexible" id="flexiblef">
        <!-- Selección Principal-->
        <div class="flexible11">
          <b><a href="import.html"> Importe de:<br> Archivos <i class="far fa-paper-plane"></i></a></b>
        </div>
        <br>
        <div class="flexible11">
          <b><a href="students.html"> Ingreso de:<br> Datos de Alumno <i class="fas fa-graduation-cap"></i></a></b>
        </div>
        <br>
        <div class="flexible11">
          <b><a href="roles.html"> Asignaciòn de:<br> Rol <i class="fas fa-hand-sparkles"></i></a></b>
        </div>
        <div class="flexible111">
          <h1> Topicos relevantes</h1>
        </div>
        <div class="topics">
          <div class="box0"> <a href="#"> Inscripto </a></div>
          <div class="box1"> <a href="#"> Regular </a></div>
          <div class="box2"> <a href="#"> Totales </a></div>
        </div>
        <div class="flexible2" style="display:none">

          <h2> VISITAS RECIENTES:</h2> <br>
          <!-- Graficos en linea-->
          <div class="inLine">
            <canvas id="charting" class="chartos1">
            </canvas>
            <!-- Grafico Principal #########################################-->
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
                      label: 'Ingresos totales por fecha',
                      data: ytemps,
                      backgroundColor: '#cacaca',
                      borderColor: [
                        'rgba(50, 100, 150, 1)',
                      ],
                      borderWidth: 3
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
              getData();

              async function getData() {
                const response = await fetch('./datasheets in csv/total.csv');
                const data = await response.text();

                const table = data.split('\n').slice(1);
                table.forEach(row => {
                  const columns = row.split(',');
                  const year = columns[0];
                  xlabels.push(year);
                  const temp = columns[1];
                  ytemps.push(temp);
                });
              }
            </script>
            <!--       #########################################-->
          </div>
          <br>
          <!-- Materias-->
          <!-- Añadir Materias luego, y reemplazar sus datos por un Archivo CSV Modificable
            <div class="categories0">
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
            
            -->
        </div>
      </div>
    </section>
    <section class="home1" style="display:none">
      <!-- Section Quick View-->
      <div class="inLine1">
        <div class="flexible12" onclick="toggleGraph()">
          <b><a href="#"> Enero a Mayo</i></a></b>
        </div>
        <div class="inLineCanvas">
          <canvas id="charting1" class="chartosR" style="height: 100px">
          </canvas>

        </div>

      </div>
      <div class="inLine1">
        <div class="flexible12" onclick="toggleGraph1()">
          <b><a href="#"> Junio a Agosto</i></a></b>
        </div>
        <div class="inLineCanvas">
          <canvas id="charting2" class="chartosR">
          </canvas>
        </div>
      </div>
      <div class="inLine1">
        <div class="flexible12" onclick="toggleGraph2()">
          <b><a href="#"> Septiembre a Diciembre</i></a></b>
        </div>
        <div class="inLineCanvas">
          <canvas id="charting3" class="chartosR">
          </canvas>
        </div>
      </div>
    </section>
    <div>
      <!-- Scripts aqui -->
      <!-- firebase base-->
      <!-- Scripts usados-->
      <script src="chart.js"></script>
      <!-- Config Defecto Chart.js-->
      <script>
        Chart.defaults.font.family = "Calibri";
        Chart.defaults.color = "#ffffff";
      </script>
      <!-- Datos a Chartjs por codigo HARD CODE <script src="./mychart0.js"></script>-->

      <script type="module">
        //Datos de Firebase
        document.getElementById('userD').addEventListener('click', goog)
        import {
          initializeApp
        } from "https://www.gstatic.com/firebasejs/9.0.2/firebase-app.js";
        import {
          getAnalytics
        } from "https://www.gstatic.com/firebasejs/9.0.2/firebase-analytics.js";
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries

        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
          apiKey: "AIzaSyDNLW7ZztWhvGeIF9Zx5a9x4aXaGyUpjtQ",
          authDomain: "dashboardhehe.firebaseapp.com",
          projectId: "dashboardhehe",
          storageBucket: "dashboardhehe.appspot.com",
          messagingSenderId: "307725797015",
          appId: "1:307725797015:web:47da37b235452eada58bd2",
          measurementId: "G-MS3VBLKH9G"
        }
        window.onload = showUserDetails;

        function showUserDetails(user) {
          var element = document.getElementById('ih'); // will return element
          document.getElementById('userD').innerHTML = `
          <div id="ih"class="sidebarTitle" >
            <img src="${user.photoURL}" style ="border-radius: 100px; border: 1px solid rgba(60,100,150,1);">
            <p>Usuario: <br > <p style="background-color: rgba(60,100,150,1); "> ${user.displayName} </p></p> 
            <p>Tu email: <br><p style="background-color: rgba(60,100,150,1); ">${user.email} </p></p>
            </div>
            `
        }
        firebase.initializeApp(firebaseConfig);
        let provider = new firebase.auth.GoogleAuthProvider()

        function goog() {
          console.log('Login btn call')
          firebase.auth().signInWithPopup(provider).then(res => {
            showUserDetails(res.user)
          })
        }
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

          $(document).on('click', '#create_folder', function() {
            $('#action').val("create");
            $('#folder_name').val('');
            $('#folder_button').val('Crear');
            $('#folderModal').modal('show');
            $('#old_name').val('');
            $('#change_title').text("Crear Carpeta");
          });

          $(document).on('click', '#folder_button', function() {
            var folder_name = $('#folder_name').val();
            var old_name = $('#old_name').val();
            var action = $('#action').val();
            if (folder_name != '') {
              $.ajax({
                url: "action.php",
                method: "POST",
                data: {
                  folder_name: folder_name,
                  old_name: old_name,
                  action: action
                },
                success: function(data) {
                  $('#folderModal').modal('hide');
                  load_folder_list();
                  alert(data);
                }
              });
            } else {
              alert("Enter Folder Name");
            }
          });

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
          location.replace("./logindex.html");
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
      <script src="https://www.gstatic.com/firebasejs/8.0.1/firebase-app.js"></script>
      <script src="https://www.gstatic.com/firebasejs/8.0.1/firebase-auth.js"></script>
      <script src="https://www.gstatic.com/firebasejs/8.0.1/firebase-firestore.js"></script>
    </div>
</body>

</html>
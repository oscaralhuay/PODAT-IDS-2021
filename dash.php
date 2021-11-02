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
      <div class="sidebar" id="sidebar" style="display:block; max-height:650px; max-width:650px; min-height:1350px">
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

        </div>

      </div>
      <div class="inLine1" style="display:block">
        <div class="flexible12" onclick="toggleGraph1()">
          <b><a href="#"> Junio a Agosto</i></a></b>
        </div>
        <div class="inLineCanvas">
          <canvas id="charting2" class="chartosR" style="width: 380px">
          </canvas>
        </div>
      </div>
      <div class="inLine1" style="display:block">
        <div class="flexible12" onclick="toggleGraph2()">
          <b><a href="#"> Septiembre a Diciembre</i></a></b>
        </div>
        <div class="inLineCanvas">
          <canvas id="charting3" class="chartosR" style="width: 380px">
          </canvas>

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
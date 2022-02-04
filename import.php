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
<?php
//Opciones sacadas de la base de datos
$mysqli = new mysqli("us-cdbr-east-04.cleardb.com", "b188eecadd532c", "16c6ecba", "heroku_4a600d13a514713");
$connect = mysqli_connect("us-cdbr-east-04.cleardb.com", "b188eecadd532c", "16c6ecba", "heroku_4a600d13a514713");
$connect->set_charset("utf8");
$query = "SELECT * FROM `materias`";
$query1 = "SELECT * FROM `año`";
$query2 = "SELECT * FROM `comision`";
$options = mysqli_query($connect, $query);
$options1 = mysqli_query($connect, $query1);
$options2 = mysqli_query($connect, $query2);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- FAVICON WEB-->
    <link rel="icon" type="image/png" href="./favicon.png" />
    <!-- FUENTES GOOGLE IDIOMAS -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500&display=swap" rel="stylesheet">
    <!-- FONT AWESOME -->
    <script src="https://kit.fontawesome.com/f80991af51.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="students.css">
    <title>Importe </title>
</head>

<body>
    <form action="./importdata.php" class="form-register" method="POST" enctype="multipart/form-data">
        <!-- Al tener listo la BdD añadir method="POST" enctype="multipart/form-data"-->
        <h1 class="form__title">Importar archivos <a style=" cursor:pointer" onclick="location.href = 'dash.php';"><i class="fas fa-sign-out-alt"></i></a></h1>
        <div class="container--flex">
            <label for="" class="form__label">Materia &nbsp; <i class="far fa-calendar-alt"></i></label>
            <select id="list" class="form__labelb" onchange="getSelectValue();" name="txt" required>
                <option></option>
                <?php while ($row1 = mysqli_fetch_array($options)) :; ?>
                    <option value="<?php echo $row1[1]; ?>"><?php echo $row1[1];?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="container--flex">
            <label for="" class="form__label">Año &nbsp; <i class="fas fa-clipboard-list"></i> &nbsp;<i class="fas fa-clipboard-check"></i></label>
            <select id="list" class="form__labelb" name="txtAño" required>
                <option></option>
                <?php while ($row1 = mysqli_fetch_array($options1)) :; ?>
                    <option value="<?php echo $row1[1]; ?>"><?php echo $row1[1];?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="container--flex">
            <label for="" class="form__label">Comisión &nbsp; <i class="fas fa-clipboard-list"></i> &nbsp;<i class="fas fa-clipboard-check"></i></label>
            <select id="list" class="form__labelb" onchange="getSelectValue();" name="txtCom" required>
                <option></option>
                <?php while ($row1 = mysqli_fetch_array($options2)) :; ?>
                    <option value="<?php echo $row1[1]; ?>"><?php echo $row1[1];?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="container--flex">
            <label for="" class="form__label">Fecha de ingreso</label>
            <input id="date" type="date" class="form__input" name="fecha" required>
            <script type="text/javascript">
                Date.prototype.toDateInputValue = (function() {
                    var local = new Date(this);
                    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
                    return local.toJSON().slice(0, 10);
                });
                document.getElementById('date').value = new Date().toDateInputValue();
            </script>
        </div>
        <br>
        <div>
            <br>
            <input type="file" id="fileUpload" name="archivo">
            <span id="customButton">Seleccionar Archivo</span>
            <br>
            <br>
            <span id="fileName" style="font-weight:bold; border-block: 1px rgba(0, 0, 0, 0.200) solid;"></span>
            <!-- Seleccion de archivo-->
            <script>
                document.getElementById("customButton").addEventListener("click", function() {
                    document.getElementById("fileUpload").click();
                });
                document.getElementById("fileUpload").addEventListener("change", function() {
                    var fullPath = this.value;
                    var fileName = fullPath.split(/(\\|\/)/g).pop();
                    document.getElementById("fileName").innerHTML = fileName; // display the file name
                }, false);
            </script>
        </div>
        <div class="container--flexb">
            <label for="" class="form__labelbb">Observación&nbsp;&nbsp;</label>
            <textarea name="comentario" id="Observación" cols="30" rows="5" style="font-family:sans-serif;font-size:1.2em; position: relative;"></textarea>
        </div>
        <div class="container--flex">
            <input type="submit" class="form__submitf" name="submit" onclick="">
        </div>
    </form>
    <script>
        function getSelectValue() {
            var selectedValue = document.getElementById("list").value;
            console.log(selectedValue);
        }
    </script>
</body>

</html>


<!--             <script>
                let form = document.getElementsByTagName("form")[0];
                form.addEventListener("submit", (e) => {
                    e.preventDefault();
                    alert("Carga Exitosa!");
                    setTimeout(() => {
                        location.replace('./dash.html');
                    }, 200);
                });
            </script>
-->
<!-- https://www.youtube.com/watch?v=5g0uqXIARFs&ab_channel=J%26GProyectosWeb -->
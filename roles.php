<?php
//Incluye la configuración de sesión
include('config.php');
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

$mysqli = new mysqli("us-cdbr-east-04.cleardb.com", "b188eecadd532c", "16c6ecba", "heroku_4a600d13a514713");
$connect = mysqli_connect("us-cdbr-east-04.cleardb.com", "b188eecadd532c", "16c6ecba", "heroku_4a600d13a514713");
$connect->set_charset("utf8");

$query = "SELECT * FROM `usuarios`";
$query1 = "SELECT * FROM `roles`";
$options = mysqli_query($connect, $query);
$options1 = mysqli_query($connect, $query1);

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
    <link rel="stylesheet" href="roles.css">
    <title>Roles</title>
</head>
<body>
    <form action="importroles.php" class="form-register" method="POST" enctype="multipart/form-data"> <!-- Al tener listo la BdD añadir method="POST" enctype="multipart/form-data"-->
        <h1 class="form__title"> Asignación de rol  <a style=" cursor:pointer" onclick="location.href = 'dash.php';"><i class="fas fa-sign-out-alt"></i></a></h1>
        <div class="container--flex">
            <label for="" class="form__label"> Seleccione Usuario &nbsp; <i class="fas fa-user"></i></label>
            <select id="list" class="form__labelb" name="user"onchange="getSelectValue();" required>
                <option></option>
                <?php while($row1 = mysqli_fetch_array($options)):;?>
                    <option value="<?php echo $row1[1];?>"><?php echo $row1[1];?></option>
                    <?php endwhile;?>
            </select>
        </div>
        <br>
        <div class="container--flex">
            <label for="" class="form__label"> Seleccione su Rol &nbsp; <i class="fas fa-hand-sparkles"></i></label>
            <select id="list" class="form__labelb" name="token" onchange="getSelectValue();" required>
                <option></option>
                    <?php while($row1 = mysqli_fetch_array($options1)):;?>
                    <option value="<?php echo $row1[1];?>"><?php echo $row1[1];?></option>
                    <?php endwhile;?>
            </select>
        </div>
        <br><br><br><br><br>
        <div class="container--flex">
            <input type="submit" class="form__submitf">
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


<!-- https://www.youtube.com/watch?v=5g0uqXIARFs&ab_channel=J%26GProyectosWeb -->
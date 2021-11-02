<?php
//b188eecadd532c:16c6ecba@us-cdbr-east-04.cleardb.com/heroku_4a600d13a514713?reconnect=true
$mysqli = new mysqli("us-cdbr-east-04.cleardb.com", "b188eecadd532c", "16c6ecba", "heroku_4a600d13a514713");
$connect = mysqli_connect("us-cdbr-east-04.cleardb.com", "b188eecadd532c", "16c6ecba", "heroku_4a600d13a514713");
$connect->set_charset("utf8");
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

        if (!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
        }

    }

}
//···Ingresos de Datos··· 
if (isset($_POST['submit']) Or $_SESSION['user_email_address'] != '' ) {
    $user = trim($_POST['user']);
    $token = trim($_POST['token']);
    $consulta = "INSERT INTO asignacion_roles(rol,correo) VALUES('$user','$token')";
    if (mysqli_query($mysqli, $consulta)) {
        echo '<script language="javascript">';
        echo 'alert("Archivo cargado de forma EXITOSA");';  //not showing an alert box.
        echo '</script>';
        header("Location:https://podat.herokuapp.com/roles.php");
    } else {
        echo "Error";
        echo 'alert("SESION NO ENCONTRADA PORFAVOR DE VOLVER A INICIAR SESION.")';
        header("Location:https://podat.herokuapp.com/index.php");
    }
} else {
    echo "ISSET POST SUBMIT ES FALSO.";
}
?>
<?php
$mysqli = new mysqli("us-cdbr-east-04.cleardb.com", "b188eecadd532c", "16c6ecba", "heroku_4a600d13a514713");
$mysqli->set_charset("utf8");
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

        if (!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
        }
    }
}
//···Ingresos de Datos··· 
if (isset($_POST['submit']) && $_SESSION['user_email_address'] != '' ) {
    #file name with a random number so that similar dont get replaced
     $pname = rand(10,1000)."-".$_FILES["archivo"]["name"];
    #temporary file name to store file
    $tname = $_FILES["archivo"]["tmp_name"];
     #upload directory path
     $uploads_dir = 'bandejadearchivos/'.$_SESSION['user_email_address'];
    #TO move the uploaded file to specific location
    move_uploaded_file($tname, $uploads_dir.'/'.$pname);
   $mat = trim($_POST['txt']);
   $año = trim($_POST['txtAño']);
   $com = trim($_POST['txtCom']);
   $fecha = trim($_POST['fecha']);
   $obs = trim($_POST['comentario']);
   $token = trim($_SESSION['user_email_address']);
   $consulta = "INSERT INTO importe_archivos(materia,año,comision,fecha_ing,nom_archivo,observacion,correo) VALUES ('$mat','$año','$com','$fecha','$pname','$obs','$token')";
   if (mysqli_query($mysqli, $consulta)) {
       echo '<script language="javascript">';
       echo 'alert("Archivo cargado de forma EXITOSA");';  //not showing an alert box.
       echo '</script>';
       header("Location:import.php");
   } else {
       echo "Error";
       header("Location:logindex.php");
}
}
?>
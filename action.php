<?php
//Session
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

        if (!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
        }

        if (!empty($data['gender'])) {
            $_SESSION['user_gender'] = $data['gender'];
        }
    }
}
$token1 = trim($_SESSION['user_email_address']);
//Size Folder Comparator and Selector
if(isset($_POST["action"]))
{
 if($_POST["action"] == "fetch")
 {
  $folder = array_filter(glob('bandejadearchivos/'.$token1), 'is_dir');
  $output = '';
  if(count($folder) > 0)
  {
   foreach($folder as $name)
   {
    $output .= '
     <tr><!--Lista de Archivos-->
      <td><button type="button" name="view_files" data-name="'.$name.'" class="view_files btn btn-default btn-xs">Ver archivos</button></td>
     </tr>';
   }
  }
  else
  {
   $output .= '
    <tr>
     <td colspan="6">No se encuentran archivos</td>
    </tr>
   ';
  }
  $output .= '</table>';
  echo $output;
 }
 
 if($_POST["action"] == "fetch_files")
 {
  $file_data = scandir($_POST["folder_name"]);
  $output = '
  <table class="table table-bordered table-striped">
   <tr>
    <th>Archivo</th>
    <th><i class="fas fa-file-signature"></i> Nombre</th>
    <th>Eliminar</th>
   </tr>
  ';
  
  foreach($file_data as $file)
  {
   if($file === '.' or $file === '..')
   {
    continue;
   }
   else
   {
    $path = $_POST["folder_name"] . '/' . $file;
    $output .= '
    <tr >
     <td><h1>&nbsp&nbsp<i class="fas fa-chart-bar" style="color:#ffffff;"></i> </h1> </td>
     <td style ="color:white; max-width:200px; padding:10px" draggable="true" data-file_name = "'.$file.'" class="change_file_name">'.$file.'</td>
     <td><button name="remove_file" class="remove_file btn btn-danger btn-xs" id="'.$path.'">Eliminar fichero</button> </td>
    </tr>
    ';
   }
  }
  $output .='</table>';
  echo $output;
 }
 
 if($_POST["action"] == "remove_file")
 {
  if(file_exists($_POST["path"]))
  {
   unlink($_POST["path"]);
   echo 'Archivo ELIMINADO';
  }
 }
 //Cambiar Nombre
 if($_POST["action"] == "change_file_name")
 {
  $old_name = $_POST["folder_name"] . '/' . $_POST["old_file_name"];
  $new_name = $_POST["folder_name"] . '/' . $_POST["new_file_name"];
  if(rename($old_name, $new_name))
  {
   echo 'Cambio de nombre exitoso!';
  }
  else
  {
   echo 'Hubo un error';
  }
 }
}
?>
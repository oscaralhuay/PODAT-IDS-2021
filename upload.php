<?php
if($_FILES["upload_file"]["name"] != '')
{
 $data = explode(".", $_FILES["upload_file"]["name"]);
 $extension = $data[1];
 $allowed_extension = array("csv", "json", "html", "js");
 if(in_array($extension, $allowed_extension))
 {
  $new_file_name = rand() . '.' . $extension;
  $path = $_POST["hidden_folder_name"] . '/' . $new_file_name;
  if(move_uploaded_file($_FILES["upload_file"]["tmp_name"], $path))
  {
   echo 'Carga de archivo exitosa!!!';
  }
  else
  {
   echo 'Hubo un error';
  }
 }
 else
 {
  echo 'Extension INVALIDA';
 }
}
else
{
 echo 'Porfavor eliga su ARCHIVO.';
}
?>
<?php
$mysqli = new mysqli("localhost", "root", "", "conexion_php");
if (mysqli_connect_errno()) {
    echo '<script>alert("Error fatal de conexión a Servidor, Base de datos fuera de alcance")</script>';
    printf( "<br> <p style='color:red'> Error fatal de conexión a Servidor, Base de datos fuera de alcance </p> <br>", mysqli_connect_error());
} else {
    echo '<b> <a style="color:white; background-color:#000000">#####CONEXION A MYSQLI EXITOSA#####</a></b> <br>';
}
$ruta = "archivos_recibidos/" . $_FILES['archivo']['name'];
if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta)) {
    echo "Exito! <br>";
} else {
    echo "<p style='color:crimson; background-color:#cacaca'>No alarmarse pero Error! Archivo no seleccionado o perdido :( </p> <br>";
}

echo "<b> Identificación del archivo: </b> <br>";
echo $_FILES['archivo']['name'];
echo "<br>";
echo $_FILES['archivo']['type'];
echo "<br>";
echo $_FILES['archivo']['size'];
echo " bytes <br>";
echo $_FILES['archivo']['tmp_name'];
echo "<br> <br>";

echo '<b> Identificación del Formulario: </b> <br>';

if (isset($_POST['submit'])) {
    if (!empty($_POST['txt'])) {
        $selected = $_POST['txt'];
        echo 'You have chosen: ' . $selected;
    } else {
        echo 'Please select the value.';
    }
}
if (isset($_POST['submit'])) {
    if (!empty($_POST['txtAño'])) {
        $selected = $_POST['txtAño'];
        echo ' <br>You have chosen: ' . $selected;
    } else {
        echo 'Please select the value.';
    }
}
if (isset($_POST['submit'])) {
    if (!empty($_POST['txtCom'])) {
        $selected = $_POST['txtCom'];
        echo ' <br>You have chosen: ' . $selected;
    } else {
        echo 'Please select the value.';
    }
}
if (isset($_POST['submit'])) {
    if (!empty($_POST['fecha'])) {
        $selected = $_POST['fecha'];
        echo ' <br>You have chosen: ' . $selected;
    } else {
        echo 'Please select the value.';
    }
}

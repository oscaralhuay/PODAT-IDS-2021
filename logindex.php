<?php
//Include Configuration File
include('config.php');

$login_button = '';

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

//Ancla para iniciar sesión
if (!isset($_SESSION['access_token'])) {
  $login_button = '<a href="' . $google_client->createAuthUrl() . '" style=" background: #dd4b39; border-radius: 5px; color: white; display: block; font-weight: bold; padding: 20px; text-align: center; text-decoration: none; width: 200px;">Login With Google</a>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" type="image/png" href="./favicon.png" />
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="logstyle.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <title>Login</title>
</head>

<body>
  <div class="login-container">
    <div class="login-info-container">
      <div id="freeSpace">
        <br><br><br><br><br><br><br><br><br>
      </div>
      <h1 class="title">PODAT SISTEMA</h1>
      <div class="social-login">
          <?php
          if ($login_button == '') {
            echo '<div class="card-header">Welcome User</div><div class="card-body">';
            echo '<img src="' . $_SESSION["user_image"] . '" class="rounded-circle container"/>';
            echo '<h3><b>Name :</b> ' . $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] . '</h3>';
            echo '<h3><b>Email :</b> ' . $_SESSION['user_email_address'] . '</h3>';
            echo '<h3><a href="logout.php">Logout</h3></div>';
          } else {
            echo '<div id="login" class="social-login-element"> <img src="images/google.svg" alt="google-image"> <span>Conectar con Google</span>' . $login_button . '</div>';
          }
          ?>
        <div id="getOut" class="social-getOut-element" style="display:none;">
          <span id="logout">Desconectar!</span>
        </div>
      </div>
      <br>
      <br>
      <br>
      <div id="userD">
      </div>
    </div>
    <img class="image-container" src="./favicon.png" alt="">
  </div>


  <script src="https://www.gstatic.com/firebasejs/8.0.1/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.0.1/firebase-auth.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.0.1/firebase-firestore.js"></script>

</body>

</html>
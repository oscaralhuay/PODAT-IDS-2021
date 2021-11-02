<?php

//start session on web page
session_start();

//config.php

//Include Google Client Library for PHP autoload file
require_once '.vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID | Copiar "ID DE CLIENTE"
$google_client->setClientId('453834731928-aadfm3ppbopb4sppsgm3nd76pi18r8np.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('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');

//Set the OAuth 2.0 Redirect URI | URL AUTORIZADO
$google_client->setRedirectUri('https://podat.herokuapp.com/dash.php');

// to get the email and profile 
$google_client->addScope('email');

$google_client->addScope('profile');

?>
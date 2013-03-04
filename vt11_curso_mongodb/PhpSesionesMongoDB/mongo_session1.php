<?php
//La sesión se inicia requiriendo el scritp
require('session.php');

//Genera un número aleatorio
$random_number = rand();

//Pone el número en una sesión
$_SESSION['random_number'] = $random_number;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="style.css" /> 
        <title>Usando el SessionManager...Página 1</title>
    </head>

    <body>
        <div id="contentarea">
            <div id="innercontentarea">
                <h2>Usando el SessionManager...Página 1</h2>
                <p>Número aleatorio generado <span style="font-weight:bold;"><?php echo $_SESSION['random_number']; ?></span></p>
                <p>PHP session id <span style="text-decoration:underline;"><?php echo session_id(); ?></span></p>
                <a href="mongo_session2.php">Ir a la siguiente página</a>
            </div>
        </div>
    </body>
</html>
<?php
require('session.php');
require('user.php');

$user = new User();

if (!$user->isLoggedIn()){
    header('location: login.php');
    exit;
}
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="style.css" /> 
        <title>Bienvenido <?php echo $user->nombreusuario; ?></title>
    </head>

    <body>
        <div id="contentarea">
            <div id="innercontentarea">
                <a style="float:right;" href="logout.php">Log out</a>
                <h1>Hola <?php echo $user->nombreusuario; ?></h1>
                <ul class="profile-list">
                	<li> 
                    	<span class="field">Usuario</span>
                        <span class="value"><?php echo $user->nombreusuario; ?></span>
                        <div class="clear"> </div>
                    </li>
                	<li> 
                    	<span class="field">Nombre</span>
                        <span class="value"><?php echo $user->nombre; ?></span>
                        <div class="clear"> </div>
                    </li>
                	<li>
                    	<span class="field">Nacimiento</span>
                        <span class="value"><?php echo date('j F, Y',$user->nacimiento->sec); ?></span>
                        <div class="clear"> </div>
                    </li>
                    <li>
                    	<span class="field">Dirección</span>
                        <span class="value"><?php echo $user->direccion; ?></span>
                        <div class="clear"> </div>
                    </li>
                </ul>
            </div>
        </div>
    </body>
</html>
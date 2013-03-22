<?php
require('dbconnection.php');

$mongo = DBConnection::instantiate();
//obtener una instancia del objeto MongoDB
$db = $mongo->database;

$result = $db->command(array('distinct' => 'ejemplo_articulos', 'key' => 'categoria'));
// echo '<pre>';
// print_r($result);
?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
        <head>
            <meta charset="utf-8">
            <title>Categories</title> 
            <link rel="stylesheet" href="style.css"/>

        </head>
        <body>
            <div id="contentarea">
                <div id="innercontentarea">
                    <h1>Índice de Categorías</h1>
                    <ul>
                    <?php foreach($result['values'] as $value): ?>
                    <li><?php echo $value; ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </body>
    </html>
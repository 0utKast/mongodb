<?php
$id = $_GET['id'];
try {
    $mongodb = new Mongo();
    $articleCollection = $mongodb->miblog->articles;
} catch (MongoConnectionException $e) {
    die('No se ha podido conectar a MongoDB ' . $e->getMessage());
}
$articleCollection->remove(array('_id' => new MongoId($id)));
/*borrar documento(s) de la coleccion peliculas en la que el genero es drama
 * $peliculas->remove(array('genero' => 'drama') );
 */
/* Argumento opcional safe, configurado a true el control del programa espera por una respuesta de la base de datos.
 * $collection->remove(array(‘nombreusuario' => 'juan'), array('safe' => True))
 */

/*Argumento opcional timeout. Configurar un tiempo de espera máximo para la acción de borrado
 * $collection->remove(array('userid' => 267), array('safe' => True, 'timeout' => 200)); 
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="style.css"/>
        <title>Blog Post Creator</title>
    </head>
    <body>
        <div id="contentarea">
            <div id="innercontentarea">
                <h1>Creador Post Blog</h1>
                <p>Artículo Borrado. _id: <?php echo $id; ?>.
                    <a href="dashboard.php">¿Volver a Panel de Control?</a>
                </p>
            </div>
        </div>
    </body>
</html>

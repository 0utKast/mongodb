<?php
$action = (!empty($_POST['btn_submit']) && ($_POST['btn_submit'] === 'Salvar')) ? 'save_article' : 'show_form';
switch ($action) {
    case 'save_article':
        try {
            $connection = new Mongo();
            $database = $connection->selectDB('miblog');
            $collection = $database->selectCollection('articles');
             /* método alternativo de selección base datos colección:
             * $connection = new Mongo();
             * $collection = $connection->miblog->articles;
             */
            $article = array();
            $article['title'] = $_POST['title'];
            $article['content'] = $_POST['content'];
            $article['saved_at'] = new MongoDate();
            $collection->insert($article);
        } catch (MongoConnectionException $e) {
            die("No se ha podido conectar a la base de datos " . $e->getMessage());
        } catch (MongoException $e) {
            die('No se han podido insertar los datos ' . $e->getMessage());
        }
        /*código alternativo si queremos que el método insert espere resputesta de MongoDB:
         * try {
         * $status = $collection->insert($article, array('safe' => True));
         * echo "Operación de inserción completada";
         * } catch (MongoCursorException $e) {
         * die("Insert ha fallado ".$e->getMessage());
         * }
         */
        
         /* Cuando hacemos un insert 'safe' podemos utilizar un parámetro timeout opcional:
         * try {
         * $collection->insert($document, array('safe' => True, 'timeout' => True));
         * } catch (MongoCursorTimeoutException $e) {
         * die('El tiempo de espera para Insert ha finalizado '.$e->getMessage());
         */
        
         /* Podemos añadir un _id personalizado con un insert:
          * $username = 'Juan';
          * try{
          * $document = array('_id' => hash('sha1', $username.time()),
          * 'user' => $username, 'visited' => 'homepage.php');
          * $collection->insert($document, array('safe' => True));
          * } catch(MongoCursorException $e) {
          * die('Failed to insert '.$e->getMessage());
          * }
          */
        break;
    case 'show_form':
    default:
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="style.css"/>
        <title>Creador de Posts</title>
    </head>
    <body>
        <div id="contentarea">
            <div id="innercontentarea">
                <h1>Creador de Posts</h1>
                <?php if ($action === 'show_form'): ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <h3>T&iacute;tulo</h3>
                        <p>
                            <input type="text" name="title" id="title">
                        </p>
                        <h3>Contenido</h3>
                        <textarea name="content" rows="20"></textarea>
                        <p>
                            <input type="submit" name="btn_submit" value="Salvar"/>
                        </p>
                    </form>
                <?php else: ?>
                    <p>
                        Art&iacute;culo salvado. _id:<?php echo $article['_id']; ?>.
                        <a href="blogpost.php"> &iquest;Escribir otro?</a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </body>
</html>


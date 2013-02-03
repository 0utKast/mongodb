<?php
$action = (!empty($_POST['btn_submit']) && ($_POST['btn_submit'] === 'Save')) ? 'save_article' : 'show_form';
$id = $_REQUEST['id'];
try {
    $mongodb = new Mongo();
    $articleCollection = $mongodb->miblog->articles;
} catch (MongoConnectionException $e) {
    die('Failed to connect to MongoDB ' . $e->getMessage());
}
switch ($action) {
    case 'save_article':
        $article = array();
        $article['title'] = $_POST['title'];
        $article['content'] = $_POST['content'];
        $article['saved_at'] = new MongoDate();
        $articleCollection->update(array('_id' => new MongoId($id)), $article);
        /* argumentos opcionales:
         * $collection->update($criteria, $newobj, array('safe' => True));
         * $collection->update($criteria, $newobj, array('multiple' => True));
         * $collection->update($criteria, $newobj, array('safe => True, 'timeout' => 100));
         */
        
        /*Uso del flag upsert
         * $users->update(array('email' => 'jesus@illasaron.com'), 
         * array('nombre' => 'Jesus', 'apellidos'=> 'Conde'),
         * array('upsert' => True));
         */
        
        /*$document = array('nombre' => 'Alberto Calero', 'edad' => 27);
          $collection->save($document); //inserta el objeto
          $document['edad'] = 31;
          $collection->save($document); //actualiza el objeto       
         */
        
        /*uso del modificador $set para modificar un campo específico del documento
         * $articles->update(array('_id' => MongoId('4dcd2abe5981')), 
         * array('$set' => array('title' => 'Nuevo Title')));
         */
        
        /* uso del modificador $inc para guardar la información sobre el número de veces que un documentos ha sido modificado
         * $articles->update(array('_id' => MongoId('4dcd2abe5981')), 
         * array('$set' => array('content' => 'Nuevo Contenido'),
         * '$inc' => array('update_count' => 1)));
         */

        break;
    case 'show_form':
    default:
        $article = $articleCollection->findOne(array('_id' => new MongoId($id)));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="style.css" />
        <title>Blog Post Editor</title>
    </head>
    <body>
        <div id="contentarea">
            <div id="innercontentarea">
                <h1>Blog Post Creator</h1>
                <?php if ($action === 'show_form'): ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <h3>Título</h3>
                        <p><input type="text" name="title" id="title" value="<?php echo $article['title']; ?>"/></p>
                        <h3>Contenido</h3>
                        <textarea name="content" rows="20">
                            <?php echo $article['content']; ?>
                        </textarea>
                        <input type="hidden" name="id" value="<?php echo $article['_id']; ?>" />
                        <p>
                            <input type="submit" name="btn_submit" value="Salvar"/>
                        </p>
                    </form>
                <?php else: ?>
                    <p>
                        Articulo salvado. _id: <?php echo $id; ?>.
                        <a href="blog.php?id=<?php echo $id; ?>">
                            Read it.
                        </a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </body>
</html>
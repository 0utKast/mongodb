<?php

$id = $_POST['article_id'];

try{
    
    $mongodb = new Mongo();
    $articleCollection = $mongodb->miblog->articles;

} catch (MongoConnectionException $e) {
    
    die('Failed to connect to MongoDB '.$e->getMessage());
}

$article = $articleCollection->findOne(array('_id' => new MongoId($id)));

$comments = (isset($article['comments'])) ? $article['comments'] : array();

$comment = array(
                    'name' => $_POST['commenter_name'], 
                    'email' => $_POST['commenter_email'],
                    'comment' => $_POST['comment'],
                    'posted_at' => new MongoDate()
                );
                
array_push($comments, $comment);

$articleCollection->update(array('_id' => new MongoId($id)), array('$set' => array('comments' => $comments)));

header('Location: blog.php?id='.$id);

/* Consultar documento embebido por el método de subobjetos.
 * $usuarios->find(array('direccion' => array('ciudad' => 'Alcamuz', 'provincia' => 'Murcia'))) ;
 */

/*
 * Consultar documento embebido mediante notación dot
 * $usuarios->find(array(‘direccion.provincia' => ‘Murcia'));
 */
<?php

$id = $_GET['id'];

require 'dbconnection.php';

$mongo = DBConnection::instantiate();
$gridFS = $mongo->database->getGridFS();

$object = $gridFS->findOne(array('_id' => new MongoId($id)));

//encontrar el chunk para ese archivo
$chunks = $mongo->database->fs->chunks->find(array('files_id' => $object->file['_id']))
                                       ->sort(array('n' => 1));

header('Content-type: '.$object->file['filetype']);
//producir los datos en chunks
foreach($chunks as $chunk){
    echo $chunk['data']->bin;
}
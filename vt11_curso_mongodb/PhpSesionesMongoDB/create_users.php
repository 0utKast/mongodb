<?php

require('dbconnection.php');

$mongo = DBConnection::instantiate();
$collection = $mongo->getCollection('users');

$users = array(
                array(  
                        'nombre' => 'Jaime Blanco', 
                        'nombreusuario' => 'jaime', 
                        'password' => md5('jaime2013'),
                        'nacimiento'  => new MongoDate(strtotime('30-09-1983 00:00:00')),
                        'direccion' => array('ciudad' => 'Alborada', 'provincia' => 'Tarragona')
                    ),
                
                array(  
                        'nombre' => 'Rosa Olvido', 
                        'nombreusuario' => 'rosa', 
                        'password' => md5('rosa2013'),
                        'nacimiento'  => new MongoDate(strtotime('21-10-1957 00:00:00')),
                        'direccion' => array('ciudad' => 'Aldera', 'provincia' => 'Murcia')
                    ),
                
                array(  
                        'nombre' => 'Andrés Bretaña', 
                        'nombreusuario' => 'andres', 
                        'password' => md5('andres2013'), 
                        'nacimiento'  => new MongoDate(strtotime('19-05-1957 00:00:00')),
                        'direccion' => array('ciudad' => 'Monfero', 'provincia' => 'Badajoz')
                    )
        );
        
foreach($users as $user)
{
    try{
        $collection->insert($user);
    } catch (MongoCursorException $e)
    {
        die($e->getMessage());
    }
}

echo 'Usuarios creados correctamente';
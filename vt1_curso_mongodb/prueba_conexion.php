<?php
try{
$mongo = new Mongo(); //crear una conexión a MongoDB
/* Por defecto PHP se conectará al servidor MongoDB que se ejecuta en localhost, en el puerto 27107. 
   Puedes cambiar esos valores en el PHP.INI, especificándolo en: mongo.default_host y mongo.default_port
   En el propio código, podemos utilizar el parámetro $server como un string en el objeto mongo, para indicar el host y el puerto específico mongodb://<nombrehost>:<númeropuerto>
   por ejemplo, para conectar a un servidor Mongo que escucha en el puerto 4554, sería el siguiente comando:
   $mongo = new Mongo($server="mongodb://localhost:4554");*/
$databases = $mongo->listDBs(); //Listar todas las bases de datos
echo '<pre>';
print_r($databases);
$mongo->close();
} catch(MongoConnectionException $e) {
//manejar error conexión
die($e->getMessage());
}
/*Podemos especificar un tiempo límite, en milisegundos, para que el script intente conectarse al servidro MongoDB:
try {
$mongo = new Mongo($options=array('timeout'=> 100))
} catch(MongoConnectionException $e) {
die("Error al conectar a la base de datos ".$e->getMessage());
}*/
<?php
require('dbconnection.php');

$mongo = DBConnection::instantiate();
$collection = $mongo->getCollection('ejemplo_articulos');

$key = array('autor' => 1);
$initial = array('count' => 0, 'total_rating' => 0);
$reduce = "function(obj, counter) { counter.count++; counter.total_rating += obj.rating;}";
$finalize = "function(counter) { counter.avg_rating = Math.round(counter.total_rating / counter.count); }";
$condition = array('publicado_el' => array('$gte' => new MongoDate(strtotime('1'))));

$result = $collection->group($key, $initial, new MongoCode($reduce),
                             array(
                                    'finalize' => new MongoCode($finalize),
                                    'condition' => $condition
                                  )
                             );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
    <head>
        <meta charset="utf-8">
        <title>Author Rating</title> 
        <link rel="stylesheet" href="style.css"/>

    </head>
    <body>
        <div id="contentarea">
            <div id="innercontentarea">
                <h1>Clasificación de autores</h1>
                <table class="table-list" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th width="50%">Autor</th>
                            <th width="24%">Artículos</th>
                            <th width="*">Valoración Promedio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($result['retval'] as $obj): ?>
                        <tr>
                            <td><?php echo $obj['autor']; ?></td>
                            <td><?php echo $obj['count']; ?></td>
                            <td><?php echo $obj['avg_rating']; ?></td>
                        <tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
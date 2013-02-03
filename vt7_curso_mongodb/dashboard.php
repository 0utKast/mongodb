<?php
try {
    $mongodb = new Mongo();
    $articleCollection = $mongodb->miblog->articles;
} catch (MongoConnectionException $e) {
    die('No se ha podido conectar a la base de datos ' . $e->getMessage());
}
$currentPage = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
$articlesPerPage = 5;
$skip = ($currentPage - 1) * $articlesPerPage;
$cursor = $articleCollection->find(array(), array('title', 'saved_at'));
    /*Ejemplo de consulta que devuelve el nombre de usuario y email de un usuario con user_id =1:
    * SELECT username, email FROM users WHERE user_id = 1; SQL
    $users->find(array('user_id' => 1), array('username', 'id')); MongoDB */
$totalArticles = $cursor->count();
$totalPages = (int) ceil($totalArticles / $articlesPerPage);
$cursor->sort(array('saved_at' => -1))->skip($skip)->limit($articlesPerPage);
/*$cursor->sort(array('saved_at' => 1)) //1 significa orden ascendente*/
/*/*presentar el campo 'x' en orden ascendente y el campo 'y' en orden descendente
$cursor->sort(array('x' = > 1, 'y' => -1));*/

/*obtener todos los artículos
$cursor = $articleCollection->find();
//saltarse los cinco primeros artículos en el cursor
$cursor->skip(5);
//empezar iterándose desde el sexto artículo en el conjunto de resultados
while($cursor->hasNext()) {
$cursor->getNext();………………………………………………………
}*/

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Panel de Control</title>
        <link rel="stylesheet" href="style.css"/>
        <style type="text/css" media="screen">
            body { font-size: 13px; }
            div#contentarea { width : 650px; }
        </style>
    </head>
    <body>
        <div id="contentarea">
            <div id="innercontentarea">
                <h1>Panel de Control</h1>
                <table class="articles" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th width="55%">Título</th>
                            <th width="27%">Creado en</th>
                            <th width="*">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($cursor->hasNext()): $article = $cursor->getNext(); ?>
                            <tr>
                                <td>
                                    <?php echo substr($article['title'], 0, 35) . '...'; ?>
                                </td>
                                <td>
                                    <?php print date('g:i a, F j', $article['saved_at']->sec); ?>
                                </td>
                                <td class="url">
                                    <a href="blog.php?id=<?php echo $article['_id'];?>">Ver</a>
                                  | <a href="edit.php?id=<?php echo $article['_id'];?>">Editar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div id="navigation">
                <div class="prev">
                    <?php if ($currentPage !== 1): ?>
                        <a href="<?php echo $_SERVER['PHP_SELF'] . '?page=' . ($currentPage - 1); ?>">Anterior </a>
                    <?php endif; ?>
                </div>
                <div class="page-number">
                    <?php echo $currentPage; ?>
                </div>
                <div class="next">
                    <?php if ($currentPage !== $totalPages): ?>
                        <a href="<?php echo $_SERVER['PHP_SELF'] . '?page=' . ($currentPage + 1); ?>">Siguiente</a>
                    <?php endif; ?>
                </div>
                <br class="clear"/>
            </div>
        </div>
    </body>
</html>
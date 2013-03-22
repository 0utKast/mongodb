<?php
require('dbconnection.php');
$titulos  = array(
                    'Libro de fundamentales programación.',
                    'Ingeniería de software.',
                    'Administración de Sistemas.',
                    'Estructura Bases de Datos.',
                    'Usos de Inteligencia Artificial.',
                    'Sistemas de Control de Versiones.',
                    'Trabajar en Red.',
                    'Herramientas Opensource.',
                    'Funcionamiento de Algoritmos.',
                    'Fundamentos Seguridad.',
                );

$autores = array('Juan Arteaga', 'Rosa Orgaz', 'Juan Calvero', 'Daniel Valero', 'Espardan Malen', 'Jaime Ractor', 'Herminio Menéndez', 'Noemi Gálvez');

$descripcion = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ".
               "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ".
               "Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ".
               "Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

$categorias = array('Electronica', 'Matemáticas', 'Programación', 'Estructuras de Datos', 
                    'Algoritmos', 'Sistema Operativo', 'Administración Bases de Datos', 
                    'Inteligencia Artificial', 
                    'Redes');
                    
$tags = array('programación', 'testeo', 'diseñoweb', 'tutorial', 'howto', 'version-control', 'nosql', 
              'algoritmos', 'ingeniería', 'software', 'hardware', 'seguridad', 'consultores', 
              'presentación', 'hacking', 'taller', 'optimización', 'código', 'opensource', 'productividad');

function getRandomArrayItem($array)
{
    $length = count($array);
    $randomIndex = mt_rand(0, $length - 1);
    
    return $array[$randomIndex];
}

function getRandomTimestamp()
{
    $randomDigit = mt_rand(0, 6) * -1;
    return strtotime($randomDigit . ' día');
}


function createDoc()
{
    global $titulos, $autores, $categorias, $tags;
    $titulo    = getRandomArrayItem($titulos);
    $autor   = getRandomArrayItem($autores);
    $categoria = getRandomArrayItem($categorias);
    
    $articleTags = array();
    $numOfTags   = rand(1,5);
    
    for ($j = 0; $j < $numOfTags; $j++){
        
        $tag = getRandomArrayItem($tags);
        
        if(!in_array($tag, $articleTags)){
            array_push($articleTags, $tag);
        }
        
    }
    
    $publishedAt = new MongoDate(getRandomTimestamp());
    $rating      = mt_rand(1, 10);
    
    return array('titulo' => $titulo, 'autor' => $autor, 'categoria' => $categoria,
                 'tags' => $articleTags, 'publicado_el' => $publishedAt, 
                 'rating' => $rating);
}

$mongo = DBConnection::instantiate();
$collection = $mongo->getCollection('ejemplo_articulos');

echo "Generando datos ejemplo...";
for ($i = 0; $i < 1000; $i++)
{
    $document = createDoc();
    $collection->insert($document);    
}
echo "Terminado";
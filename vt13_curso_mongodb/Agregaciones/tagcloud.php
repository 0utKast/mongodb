<?php

require('dbconnection.php');

$mongo = DBConnection::instantiate();

//get an instance of MongoDB object
$db = $mongo->database;

$map = new MongoCode("function() {".
            "for (i = 0; i < this.tags.length; i++) {".
                "emit(this.tags[i], 1);".
            "}".
        "}");

$reduce = new MongoCode("function(key, values) {".
                "var count = 0;".
                "for (var i = 0; i < values.length; i++){".
                    "count += values[i];".
                "}".
                "return count;".
          "}");

$command = array(   
                    'mapreduce' => 'ejemplo_articulos', 
                    'map' => $map,
                    'reduce' => $reduce,
                    'out' => 'tagcount'
                );

$db->command($command);

$tags = iterator_to_array($db->selectCollection('tagcount')->find()
                                                           ->sort(array('value' => -1)));

function getBiggestTag($tags)
{
    reset($tags);
    $firstKey = key($tags);
    return (int)$tags[$firstKey]['value'];
}

$biggestTag = getBiggestTag($tags);

foreach($tags as &$tag) {
    
    $weight = floor(($tag['value'] / $biggestTag) * 100);
    switch($weight){
        case ($weight < 10):
            $tag['class'] = 'class1';
            break;
        case (10 <= $weight && $weight < 20):
            $tag['class'] = 'class2';
            break;
        case (20 <= $weight && $weight < 30):
            $tag['class'] = 'class3';
            break;
        case (30 <= $weight && $weight < 40):
            $tag['class'] = 'class4';
            break;
        case (40 <= $weight && $weight < 50):
            $tag['class'] = 'class5';
            break;
        case (50 <= $weight && $weight < 60):
            $tag['class'] = 'class6';
            break;
        case (70 <= $weight && $weight < 80):
            $tag['class'] = 'class7';
            break;
        case (80 <= $weight && $weight < 90):
            $tag['class'] = 'class8';
            break;
        case ($weight >= 90):
            $tag['class'] = 'class9';
            break;
    }
}
?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <link rel="stylesheet" href="style.css" /> 
            <title>Tag Cloud</title>
        </head>

        <body>
            <div id="contentarea">
                <div id="innercontentarea">
                    <h1>Tag Cloud</h1>
                    <ul id="tagcloud">
                    <?php foreach($tags as $tag):  ?>
                        <li>
                            <a href="#" class="<?php echo $tag['class'];?>"><?php echo $tag['_id']; ?></a>
                        </li>
                    <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </body>
    </html>
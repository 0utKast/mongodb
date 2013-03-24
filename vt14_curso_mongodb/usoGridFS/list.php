<?php
require 'dbconnection.php';

$mongo = DBConnection::instantiate();

$gridFS = $mongo->database->getGridFS();

$objects = $gridFS->find();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <title>Uploaded Images</title> 
        <link rel="stylesheet" href="styles.css"/>
    </head>
    <body>
        <div id="contentarea">
            <div id="innercontentarea">
                <h1>Uploaded Images</h1>
                <table class="table-list" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th width="40%">Caption</th>
                            <th width="30%">Filename</th>
                            <th width="*">Size</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($object = $objects->getNext()): ?>
                        <tr>
                            <td><?php echo $object->file['caption']; ?></td>
                            <td>
                                <a href="image.php?id=<?php echo $object->file['_id'];?>">
                                    <?php echo $object->file['filename']; ?>
                                </a>
                            </td>
                            <td ><?php echo ceil($object->file['length'] / 1024).' KB'; ?></td>
                        </tr>
                        <?php endwhile;?>
                    </tbody> 
              </table>
            </div>
        </div>
    </body>
</html>
<?php

$filesInFolder = new DirectoryIterator("../../"); 
$numItemsInFolder = 0; 
while ( $filesInFolder->valid() ) 
{
        $numItemsInFolder = $numItemsInFolder + 1;
        $filesInFolder->next();
    }
    echo "found $numItemsInFolder items in folder named 'images'";

?>
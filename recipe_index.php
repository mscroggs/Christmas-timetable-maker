<?php

include("recipe_intro.php");

echo("<ul>");
foreach(scandir("recipes/") as $file){
    if(substr($file,-5,5) == ".html"){
        $fc = file_get_contents("recipes/".$file);
        echo("<li><a href='/recipe.php?what=".substr($file,0,-5)."'>".between_tags($fc,"h")."</a></li>");
    }
}
echo("</ul>");

?>

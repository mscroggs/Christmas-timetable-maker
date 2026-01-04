<?php

include("recipe_intro.php");

$recipes = Array();

foreach(scandir($recipe_dir."/") as $file){
    if(substr($file,-5,5) == ".html"){
        $fc = file_get_contents($recipe_dir."/".$file);
        $type = between_tags($fc,"type");
        if(!array_key_exists($type, $recipes)){
            $recipes[$type] = Array();
        }
        $r = "<a href='/recipe.php?what=".substr($file,0,-5)."'>".between_tags($fc,"h")."</a>";
        $tags = explode(",", between_tags($fc,"labels"));
        if(in_array("vegetarian", $tags)){
            $r.=" <span style='color:#00A300' title='vegetarian'>v</span>";
        }
        if(in_array("vegan", $tags)){
            $r.=" <span style='color:#00A300' title='vegan'>vg</span>";
        }
        if(in_array("alcohol", $tags)){
            $r.=" <span style='color:#FF0000' title='contains alcohol'>18</span>";
        }
        $recipes[$type][] = $r;
    }
}

if(count($recipes["main"]) > 0) {
    echo("<$h2>Main courses</$h2>");
    echo("<ul>");
    foreach($recipes["main"] as $r) {
        echo("<li>".$r."</li>");
    }
    echo("</ul>");
}

if(count($recipes["pudding"]) > 0) {
    echo("<$h2>Puddings</$h2>");
    echo("<ul>");
    foreach($recipes["pudding"] as $r) {
        echo("<li>".$r."</li>");
    }
    echo("</ul>");
}
?>

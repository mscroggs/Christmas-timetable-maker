<?php

if(!isset($recipe_dir)) {
    $recipe_dir = "recipes";
}
if(!isset($h1)) {
    $h1 = "h1";
}
if(!isset($h2)) {
    $h2 = "h2";
}

function between_tags($text, $tag){
    $out = explode("<".$tag.">",$text);
    if(count($out)==1){return "";}
    $out = explode("</".$tag.">",$out[1])[0];
    return $out;
}

function parse_ml($ml){
    $out = Array();
    $msp = explode("<",$ml);
    foreach($msp as $bit){
        if(substr($bit,0,1) != "/"){
            $tag = explode(">",$bit)[0];
            $out[$tag] = between_tags($ml,$tag);
        }
    }
    return $out;
}

?>

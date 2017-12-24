<?php

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

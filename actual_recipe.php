<?php

include("recipe_intro.php");

function g($n){
    return $n[1]."g";
}
function oz($n){
    return ($n[1]*28)."g";
}
function C($n){
    return $n[1]."&deg;C";
}

function add_units($txt){
    $txt = preg_replace_callback("/<g>([0-9]+)<\/g>/","g",$txt);
    $txt = preg_replace_callback("/<oz>([0-9]+)<\/oz>/","oz",$txt);
    $txt = preg_replace_callback("/<C>([0-9]+)<\/C>/","C",$txt);
    return $txt;
}

function list_markup($ls,$tag="ul"){
    global $h1;
    global $h2;
    $ls = "<$tag>".$ls."</$tag>";
    $ls = str_replace("<subtitle>","</$tag><div style='font-weight:bold'>",$ls);
    $ls = str_replace("</subtitle>","</div><$tag>",$ls);
    $ls = str_replace("<$tag></$tag>","",$ls);
    return $ls;
}
function markup_recipe($recipe){
    global $h1;
    global $h2;
    $recipe = add_units($recipe);
    $out = "";
    $img = between_tags($recipe,"img");
    if($img!=""){
        $out.="<img src='/recipes/pictures/".$img."' style='float:right;margin-right:15px'>";
    }
    $out .= "<$h1>".between_tags($recipe,"h")."</$h1>";
    $source = between_tags($recipe,"source");
    if($source!=""){
        $book = between_tags($source,"book");
        if($book!=""){
            $book = parse_ml($book);
            $out .= "<small>Adapted from ";
            if(isset($book["url"])){$out.="<a href='".$book["url"]."' target='new'>";}
            $out.="<em>".$book["title"]."</em>";
            if(isset($book["author"])){$out.=" by ".$book["author"];}
            if(isset($book["year"])){$out.=" (".$book["year"].")";}
            if(isset($book["url"])){$out.="</a>";}
            $out .= "</em></small>";
        }
    }
    $ingred = between_tags($recipe,"ingredients");
    if($ingred!=""){
        $out .= "<$h2>You will need</$h2>";
        $out .= list_markup($ingred);
    }
    $method = between_tags($recipe,"method");
    if($method!=""){
        $out .= "<$h2>Method</$h2>";
        $out .= list_markup($method,"ol");
    }
    return $out;
}

if(isset($_GET['what']) && file_exists("recipes/".$_GET['what'].".html")){
    $recipe = file_get_contents("recipes/".$_GET['what'].".html");
    echo(markup_recipe($recipe));
} else {
    echo("Recipe not found");
}

?>

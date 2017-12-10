<?php

$times = Array();

function _add($a, $n){
    global $times;
    if(!isset($times[$a])){$times[$a]=Array();}
    $times[$a][] = $n;
}

function pad2($n){
    $n = "".$n;
    while(strlen($n)<2){$n="0".$n;}
    return $n;
}

function format_time($t){
    $out = pad2(floor($t));
    $out .= ":";
    $out .= pad2(floor(60*($t-floor($t))));
    return $out;
}

function format_time_mins_before($t,$m){
    return format_time($t-$m/60);
}

if(isset($_POST['make'])){

    print_r($_POST);

    $eat = $_POST['eat-time'];

    echo("<br /><br />");

    _add(format_time($eat),"Eat Christmas dinner");

    for($i=1;isset($_POST['meatt'.$i]);$i++){
        $t = $_POST['meatt'.$i];
        $w = $_POST['meatw'.$i];
        $u = $_POST['meatu'.$i];
        if($u=="oz"){$w *= 28.35;}
        if($u=="kg"){$w *= 1000;}
        echo($w."g of ".$t);
        echo(": ");
        if($t=="pork"){
            _add(format_time_mins_before($eat,35/450 * $w),"Turn pork down to 190&deg;C");
            _add(format_time_mins_before($eat,20+35/450 * $w),"Put pork in oven at 245&deg;C");
            echo("into the oven at ".format_time_mins_before($eat,20+35/450*$w));
        }
        if($t=="pork2"){
            _add(format_time_mins_before($eat,45/450 * $w),"Turn pork down to 180&deg;C");
            _add(format_time_mins_before($eat,20+45/450 * $w),"Put pork in oven at 245&deg;C");
            echo("into the oven at ".format_time_mins_before($eat,20+35/450*$w));
        }
        echo("<br />");
    }
    $k = array_keys($times);
    sort($k);
    echo("<table>");
    echo("<thead><td>Time</td><td>Activity</td></thead>");
    foreach($k as $i){
        echo("<tr><td>".$i."</td><td>".join("<br />",$times[$i])."</td></tr>");

    }
    print_r($times);

} else {

    echo("<form method='post'>");

    echo("<h2>Meat</h2>");
    echo("<span id='meatinputs'></span>");

    echo("<h2>Vegetables</h2>");
    echo("<span id='veginputs'></span>");

    echo("<h2>Options</h2>");
    echo("Eating time:<input type='time' name='eat-time'>");
    echo("<br /><br /><input name='make' value='Make timetable' type='submit'>");
    echo("</form>");

    echo("<script type='text/javascript' src='planner.js'></script>");
}
?>

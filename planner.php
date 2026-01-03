<style type='text/css'>

table.xmas-timetable,
table.xmas-timetable td,
table.xmas-timetable thead,
table.xmas-timetable tr {border:none;vertical-align:top;border-collapse:collapse}
table.xmas-timetable td {border-bottom:2px solid gray;padding:10px}

#xmas-timetable-area {
    margin-top:50px;
}

table.xmas-input-table {
    margin: auto;
}
table.xmas-input-table,
table.xmas-input-table tr,
table.xmas-input-table td {
    border: 0px;
}
table.xmas-input-table tr td {
    text-align:left;
    width:50%;
    padding:4px;
}
table.xmas-input-table tr td:first-of-type {
    text-align:right;
}

label {
  display: inline-block;
}

</style>

<?php

    echo("
<div id='xmas-edit'>
    <$h2>Options</$h2>
    <table class='xmas-input-table'>
    <tr><td>Eating time:</td><td><input type='time' id='xmas-eat-time' value='13:00' onchange='updateTimetable()'></td></tr>
    <tr><td>Oven type:</td><td><select id='xmas-oven-type' onchange='updateTimetable()'>
    <option value='C' selected>&deg;C</option>
    <option value='Cfan'>&deg;C fan oven</option>
    <option value='F'>&deg;F</option>
    <option value='gas'>gas oven</option>
    <option value='desc'>a descriptive oven</option>
    </select></td></tr>
    <tr><td>Format:</td><td><select id='xmas-format' onchange='updateTimetable()'>
    <option value='table' selected>table</option>
    <option value='gantt'>Gantt chart</option>
    </select></td></tr>
    <tr><td>Event name:</td><td><input id='xmas-event' value='Christmas' onchange='updateTimetable()'></td></tr>
    </table>

    <$h2>Meat</$h2>
    <span id='meatinputs1'></span>
    <button onclick='return addMeat()' type='button'>+</button>
    <br /><span id='meatticks'></span>

    <$h2>Vegetarian</$h2>
    <span id='nonmeatinputs1'></span>
    <button onclick='return addNonMeat()' type='button'>+</button>

    <$h2>Vegetables</$h2>
    <span id='veginputs'></span>

    <$h2>Other</$h2>
    <span id='otherinputs'></span>
</div>

");
?>

<div id='xmas-timetable-area'>
</div>

<script type='text/javascript' src='planner.js'></script>

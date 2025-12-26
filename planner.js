function rarity(v, id){
    if(v=="beef"){
        document.getElementById(id).style.display = "inline-block"
    } else {
        document.getElementById(id).style.display = "none"
    }
}

function makeMeat(n){
    out = "<select id='xmas-meatt"+n+"' onchange=\"rarity(this.value, 'xmas-meatr"+n+"');updateTimetable()\">"
    out += "<option value='' selected></option>"
    out += "<option value='turkey'>Turkey</option>"
    out += "<option value='chicken'>Chicken</option>"
    out += "<option value='pork'>Pork (leg or loin)</option>"
    out += "<option value='pork2'>Pork (other)</option>"
    out += "<option value='ham'>Ham</option>"
    out += "<option value='lamb'>Lamb</option>"
    out += "<option value='beef'>Beef</option>"
    out += "</select>"
    out += "<select id='xmas-meatr"+n+"' style='display:none' onchange='updateTimetable()'>"
    out += "<option value='rare'>rare</option>"
    out += "<option value='medium' selected>medium</option>"
    out += "<option value='well-done'>well done</option>"
    out += "</select>"
    out += "&nbsp;Weight:<input id='xmas-meatw"+n+"' size=4 onchange='updateTimetable()'>"
    out += "<select id='xmas-meatu"+n+"' onchange='updateTimetable()'>"
    out += "<option value='kg' selected>kg</option>"
    out += "<option value='g'>g</option>"
    out += "<option value='oz'>oz</option>"
    out += "</select>"
    return out
}

function show_non_info(n){
    v = document.getElementById("nonmeatt"+n).value
    if(v == "bread"){
        document.getElementById("nonmeatinfo"+n).innerHTML = "<a href='http://oxmas.eu/recipe.php?what=koulibiaca' target='new'>click here for recipe</a>"
    }
}

function makeNonMeat(n){
    out = "<select id='xmas-nonmeatt"+n+"' onchange='show_non_info("+n+");updateTimetable()'>"
    out += "<option value='' selected></option>"
    out += "<option value='bread'>Christmas Koulibiaca</option>"
    out += "</select><span id='nonmeatinfo"+n+"' style='margin-left:5px'></span>"
    return out
}

function makeVeg(){
    join = " &nbsp; "
    out = ""
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-roast-potatoes'>Roast potatoes</label>"
    out += join
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-new-potatoes'>New potatoes</label>"
    out += join
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-parsnips'>Parsnips</label>"
    out += join
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-peas'>Peas</label>"
    out += join
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-broccoli'>Broccoli</label>"
    out += join
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-cauliflower'>Cauliflower</label>"
    out += join
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-carrots'>Carrots</label>"
    out += join
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-leeks'>Leeks</label>"
    out += join
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-mushrooms'>Mushrooms</label>"
    out += join
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-brussels'>Brussels sprouts</label>"
    return out
}

function makeOther(){
    join = " &nbsp; "
    out = ""
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-gravy'>Gravy</label>"
    return out
}

function makeMeatTicks(){
    join = " &nbsp; "
    out = ""
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-pigs'>Pigs in blankets</label>"
    return out
}


meatN = 0
nonmeatN = 0


function addMeat(){
    meatN += 1
    document.getElementById("meatinputs"+meatN).innerHTML += makeMeat(meatN) + "<br />"+"<span id='meatinputs"+(meatN+1)+"'></span>"
    return false
}
function addNonMeat(){
    nonmeatN += 1
    document.getElementById("nonmeatinputs"+nonmeatN).innerHTML += makeNonMeat(nonmeatN) + "<br />"+"<span id='nonmeatinputs"+(nonmeatN+1)+"'></span>"
    return False
}
function showVeg(){
    document.getElementById("veginputs").innerHTML = makeVeg()
}
function showOther(){
    document.getElementById("otherinputs").innerHTML = makeOther()
}
function showMeat(){
    document.getElementById("meatticks").innerHTML = makeMeatTicks()
}

var aim_hours = -1
var aim_minutes = -1

function pad2(n) {
    n = Math.floor(n + 0.5);
    if (n < 10) {
        return "0" + n
    } else {
        return n
    }
}

function xmas_time(minutes_before) {
    var m = aim_minutes - minutes_before;
    var h = aim_hours;
    if (m <= 0) {
        n = -Math.floor(m / 60);
        h -= n;
        m += 60 * n;
    }
    return pad2(h) + ":" + pad2(m);
}

function temp(n){
    var ot = document.getElementById("xmas-oven-type").value;
    if(ot == "C"){
        return n + "&deg;C";
    }
    if(ot == "Cfan"){
        return (n-20) + "&deg;C";
    }
    if(ot == "F"){
        return (Math.floor((n*9/5+32)/5)*5) + "&deg;F";
    }
    if(ot == "gas"){
        if(n>=240){mark=9;}
        else if(n>=230){mark=8;}
        else if(n>=220){mark=7;}
        else if(n>=200){mark=6;}
        else if(n>=190){mark=5;}
        else if(n>=180){mark=4;}
        else if(n>=170){mark=3;}
        else if(n>=150){mark=2;}
        else if(n>=140){mark=1;}
        else {mark=0;}
        return "gas mark " + mark;
    }
    if(ot == "desc"){
        if(n>=240){return "very hot";}
        else if(n>=220){return "hot";}
        else if(n>=190){return "moderately hot";}
        else if(n>=170){return "moderate";}
        else if(n>=140){return "slow";}
        else {return "very slow";}
    }
    return n + "&deg;C";
}


function generate_times() {
    var times = [];
    times[times.length] = [true, 0, "Eat " + document.getElementById("xmas-event").value + " dinner"];

    // Meat
    for (var i = 1; document.getElementById("xmas-meatt" + i) != null; i++) {
        console.log(i)
        var t = document.getElementById("xmas-meatt" + i).value;
        var w = document.getElementById("xmas-meatw" + i).value;
        var u = document.getElementById("xmas-meatu" + i).value;
        var r = document.getElementById("xmas-meatr" + i).value;
        var name = w + u + " ";
        if (t=="pork2"){ name+="pork";} else {name+=t;}
        if(u=="oz"){w *= 28.35;}
        if(u=="kg"){w *= 1000;}
        if(t=="pork"){
            times[times.length] = [true,20 + 35/450 * w,"Turn " + name + " down to " + temp(190)];
            times[times.length] = [true,20 + 20 + 35/450 * w,"Put " + name + " in oven at " + temp(245)];
            times[times.length] = [false,20,"Check the " + name + ". If cooked, take it out and rest it"];
        }
        if(t=="pork2"){
            times[times.length] = [true,20 + 45/450 * w,"Turn " + name + " down to " + temp(180)];
            times[times.length] = [true,20 + 20 + 45/450 * w,"Put " + name + " in oven at " + temp(245)];
            times[times.length] = [false,20,"Check the " + name + ". If cooked, take it out and rest it"];
        }
        if(t=="chicken"){
            times[times.length] = [false,20 + 20 + 20/450 * w,"Stuff the " + name];
            times[times.length] = [true,20 + 20/450 * w,"Put " + name + " in oven at " + temp(190)];
            times[times.length] = [false,20,"Check the " + name + ". If cooked, take it out and rest it"];
        }
        if(t=="turkey"){
            var cook = w/1000 * 20 + 70;
            if(w>=4000){cook += 20;}
            times[times.length] = [false,cook+40,"Stuff the " + name];
            times[times.length] = [true,cook+20,"Put " + name + " in oven at " + temp(190)];
            times[times.length] = [false,20,"Check the " + name + ". If cooked, take it out and rest it"];
        }
        if(t=="ham"){
            times[times.length] = [true,90 + 20/450 * w,"Put " + name + " on to boil"];
            times[times.length] = [true,90,"Turn " + name + " off and leave in water to cool"];
            times[times.length] = [true,30,"Put " + name + " in oven to warm"];
        }
        if(t=="lamb"){
            times[times.length] = [true, 30 + 30/450 * w, "Put " + name + " in the oven at " + temp(230)];
            times[times.length] = [true, 30/450 * w, "Turn " + name + " down to " + temp(190)];
        }
        if(t=="beef"){
            var cook = 0;
            if(r=="rare"){cook = 15/450 * w;}
            if(r=="medium"){cook = 30/450 * w;}
            if(r=="well-done"){cook = 45/450 * w;}
            times[times.length] = [true, 20 + cook, "Put " + name + " in the oven at " + temp(230)];
            times[times.length] = [true, cook, "Turn " + name + " down to " + temp(190)];
        }
    }

    times.sort((a, b) => b[1] - a[1]);
    return times
}

function updateTimetable() {
    var aim = document.getElementById("xmas-eat-time").value
    aim_hours = aim.split(":")[0] / 1;
    aim_minutes = aim.split(":")[1] / 1;
    var times = generate_times();
    var timetable = "<h2>Timetable</h2>";
    timetable += "<table class='xmas-timetable'>";
    timetable += "<thead><td>Time</td><td>Activity</td></thead>";
    var prev = -1;
    for(var t in times) {
        var important = times[t][0];
        var minutes = times[t][1];
        var desc = times[t][2];
        if (prev != minutes) {
            if (t != 0) {
                timetable += "</td></tr>";
            }
            timetable += "<tr><td><b>" + xmas_time(minutes) + "</b></td><td>";
        } else {
            timetable += "<br />";
        }
        prev = minutes;
        if (important) {
            timetable += "<b>" + desc + "</b>";
        } else {
            timetable += desc;
        }
    }
    timetable += "</td></tr></table>";
    document.getElementById("xmas-timetable-area").innerHTML = timetable;
}

addMeat()

showVeg()
showOther()
showMeat()

updateTimetable();

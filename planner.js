function rarity(v, id){
    if(v=="beef"){
        document.getElementById(id).style.display = "inline-block"
    } else {
        document.getElementById(id).style.display = "none"
    }
}

function makeMeat(n){
    out = "<select id='meatt"+n+"' name='meatt"+n+"' onchange=\"rarity(this.value, 'meatr"+n+"')\">"
    out += "<option value='' selected></option>"
    out += "<option value='turkey'>Turkey</option>"
    out += "<option value='chicken'>Chicken</option>"
    out += "<option value='pork'>Pork (leg or loin)</option>"
    out += "<option value='pork2'>Pork (other)</option>"
    out += "<option value='ham'>Ham</option>"
    out += "<option value='lamb'>Lamb</option>"
    out += "<option value='beef'>Beef</option>"
    out += "</select>"
    out += "<select id='meatr"+n+"' name='meatr"+n+"' style='display:none'>"
    out += "<option value='rare'>rare</option>"
    out += "<option value='medium' selected>medium</option>"
    out += "<option value='well-done'>well done</option>"
    out += "</select>"
    out += "&nbsp;Weight:<input id='meatw"+n+"' name='meatw"+n+"' size=4>"
    out += "<select id='meatu"+n+"' name='meatu"+n+"'>"
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
    out = "<select id='nonmeatt"+n+"' name='nonmeatt"+n+"' onchange='show_non_info("+n+")'>"
    out += "<option value='' selected></option>"
    out += "<option value='bread'>Christmas Koulibiaca</option>"
    out += "</select><span id='nonmeatinfo"+n+"' style='margin-left:5px'></span>"
    return out
}

function makeVeg(){
    join = " &nbsp; "
    out = ""
    out += "<label><input type='checkbox' id='roast-potatoes' name='roast-potatoes'>Roast potatoes</label>"
    out += join
    out += "<label><input type='checkbox' id='new-potatoes' name='new-potatoes'>New potatoes</label>"
    out += join
    out += "<label><input type='checkbox' id='parsnips' name='parsnips'>Parsnips</label>"
    out += join
    out += "<label><input type='checkbox' id='peas' name='peas'>Peas</label>"
    out += join
    out += "<label><input type='checkbox' id='broccoli' name='broccoli'>Broccoli</label>"
    out += join
    out += "<label><input type='checkbox' id='cauliflower' name='cauliflower'>Cauliflower</label>"
    out += join
    out += "<label><input type='checkbox' id='carrots' name='carrots'>Carrots</label>"
    out += join
    out += "<label><input type='checkbox' id='leeks' name='leeks'>Leeks</label>"
    out += join
    out += "<label><input type='checkbox' id='mushrooms' name='mushrooms'>Mushrooms</label>"
    out += join
    out += "<label><input type='checkbox' id='brussels' name='brussels'>Brussels sprouts</label>"
    return out
}

function makeOther(){
    join = " &nbsp; "
    out = ""
    out += "<label><input type='checkbox' id='gravy' name='gravy'>Gravy</label>"
    return out
}

function makeMeatTicks(){
    join = " &nbsp; "
    out = ""
    out += "<label><input type='checkbox' id='pigs' name='pigs'>Pigs in blankets</label>"
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


addMeat()

showVeg()
showOther()
showMeat()

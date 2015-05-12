/* Copyright (c) 2012  <craft@ckdevelop.org>

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 2 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public
License along with this library; if not, write to the
Free Software Foundation, Inc., 59 Temple Place - Suite 330,
Boston, MA 02111-1307, USA. */

// Initialisation XMLHttpRequest pour AJAX
function GetXmlHttp() {
    var xmlhttp=null;
    if (window.XMLHttpRequest) { // code pour Firefox, Chrome, Opera, Safari, IE7+,
        try {xmlhttp=new XMLHttpRequest();} catch(e) {}
    } else if (window.ActiveXObject) { // code pour IE6, IE5
        try {xmlhttp=new ActiveXObject("msxml2.XMLHTTP");} catch(e) {
            try {xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");} catch(e) {}
         }
    }
    return xmlhttp
}

/* 
Script = script Python/Php/Perl
Type = POST/GET
States[0-4] = actions à évaluer
Items = ID d'éléments choisis
Params = paramètres POST/GET (ex: text=salut le monde&act=test)
*/
function sendWithAjaxEval(Script, TYPE, States, Items, Params) {
    var xh=GetXmlHttp();
    xh.onreadystatechange=function() {
        if (xh.readyState==0) { // Status 0 "non initialisé"
            if (States[0]) {eval(States[0]);}
        }
        if (xh.readyState==1) { // Status 1 "chargement"
            if (States[1]) {eval(States[1]);}
        }
        if (xh.readyState==2) { // Status 2 "chrrger"
            if (States[2]) {eval(States[2]);}
        }
        if (xh.readyState==3) { // Status 3 "en attente"
            if (States[3]) {eval(States[3]);}
        }
        if (xh.readyState==4 && xh.status==200) { // Status 4 "terminé"
            if (States[4]) {eval(States[4]);}
        }
    }
    xh.open(TYPE,Script,true);
    xh.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xh.send(Params); 
    return false;
}

/* 
Script = script Python/Php/Perl
Type = POST/GET
State = l'action à évaluer
Items = ID d'éléments choisis
Params = paramètres POST/GET (ex: text=salut le monde&act=test)
*/
function sendWithAjaxE4(Script, TYPE, State, Items, Params) {
    var xh=GetXmlHttp();
    xh.onreadystatechange=function() {
        if (xh.readyState==4 && xh.status==200) {
            // Status 4 "terminé"
            eval(State);
        }
    }
    xh.open(TYPE,Script,true);
    xh.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xh.send(Params); 
    return false;
}

//Functions d'affichage HTML/CSS
function idInnerHTML(ID,VAL) {
    document.getElementById(ID).innerHTML = VAL;
}
function idAppend(ID, NEW, VAL) {
    newTag = document.createElement(NEW); 
    newTag.innerHTML=VAL; 
    document.getElementById(ID).appendChild(newTag); 
}
function idDisplay(ID,VAL) {
    document.getElementById(ID).style.display = VAL;
}
function idStyle(ID,VAL) {
    document.getElementById(ID).setAttribute('style', VAL);
}

function XY(obj){
    var x=0,y=0;
    while (obj!=null){
        x+=obj.offsetLeft-obj.scrollLeft;
        y+=obj.offsetTop-obj.scrollTop;
        obj=obj.offsetParent;
    }
    return {x:x,y:y};
}

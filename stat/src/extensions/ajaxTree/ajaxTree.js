/*
Diese Datei ist Teil einer Extension für:

>>>>>> CrazyStat <<<<<<
A convenient, comprehensive and free PHP statistic-Script with optional counter.

Copyright (C) 2004-2011  Christopher Kramer

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

E-Mail: webmaster AT christosoft DOT de
Web: http://www.christosoft.de
Version: 1.70

*** ajaxTree.js ***
Funktion:    JavaScript-Teil von ajaxTree
Aufrufbar:   nein
Eingebunden: von show_stat.php
*/

function prozent(teil, gesamt)  // Prozent-Funktion
 {
 if(gesamt<=0) return 0;
 return Math.round(teil/gesamt*100);
 }

var ajaxObj=ajax();    // XMLHttpRequest-Objekt
var id;                // ID (des Parents das geoeffnet/geschlossen werden soll).
var expand=false;      // soll der ganze Baum momentan expanded werden?
var js_data;           // von PHP übergebene Werte
var zeit=new Date(); // Zeit wird angehängt um Browser-Caching zu verhinern

// js_data['parents']: Array, in dem Zustand der Elternzeilen steht (0/undefined=collapsed & nicht geladen, 1=collapsed & geladen, 2=expanded und geladen)



function menuclick(id) // Beim Klick auf ein Parent
 {
 var bild, i; // bild: Welches plus/minus-gif wird verwendet? i: Zähler
 if(id==1 && js_data['host_anz']==1 && js_data['parents'][id]==2) bild=5;
 else if(id==1) bild=1;
 else if(id==js_data['host_anz'] && js_data['parents'][id]==2) bild=3;
 else bild=2;

 var row;

 if(!expand && js_data['parents'][id]==2) // geladen und expanded => collapse
  {
  document.getElementById('pic'+id).src='extensions/ajaxTree/plus'+bild+'.gif';
  js_data['parents'][id]=1;
  for(i=1; i<=js_data['childs'][id]; i++) if(row=document.getElementById('row'+id+'_'+i)) row.style.display='none';
  }
 else if(js_data['parents'][id]==1) // geladen und collapse=> expand
  {
  document.getElementById('pic'+id).src='extensions/ajaxTree/minus'+bild+'.gif';
  js_data['parents'][id]=2;
  for(i=1; i<=js_data['childs'][id]; i++) document.getElementById('row'+id+'_'+i).style.display='';
  if(expand && id<js_data['host_anz']) menuclick(id+1);
  else
   {
   expand=false;
   hide_waitbox();
   }
  }
 else if(js_data['parents'][id]!=2) // nicht geladen => nachladen
  {
  js_data['parents'][id]=2;
  document.getElementById('pic'+id).src='extensions/ajaxTree/minus'+bild+'.gif';
  nachladen(id);
  }
 }

function nachladen(pid)  // nachladen von Kindelementen
 {
 if(!expand) 
  {
  waitmessage();
  }
 ajaxObj.open('get','extensions/ajaxTree/refpages.php?'+js_data['sid']+'&id='+(pid-1)+'&stamp='+zeit.getTime(),true);
 id=pid; // uebergebe id und childs an addRows per globalen Variablen
 ajaxObj.onreadystatechange=addRows;
 ajaxObj.send(null);
 }


function addRows()  // nachgeladene Daten empfangen, erweitere Tabelle um Kind-Zeilen
 {
 if(ajaxObj.readyState==4)
  {
  var child,zeile,spalte1,spalte2,spalte3,spalte4,bild1,link2,gekuerzt,text2,text3,bild4b,bild4b,text4,proz,proz2;
  var children=ajaxObj.responseText.split("\n"); // Splitte Kinder auf
  
  if(id==js_data['host_anz']) var ziel_zeile=document.getElementById('row'+id).nextSibling;
  else var ziel_zeile=document.getElementById('row'+(id+1));

  for(var i=1; i<=js_data['childs'][id]; i++)
   {
   child=children[i-1].split('@'); // Splitte Daten des Kindes
   
   // Erstelle neue Elemente
   zeile=document.createElement('tr');
   spalte1=document.createElement('td');
   spalte2=document.createElement('td');
   spalte3=document.createElement('td');
   spalte4=document.createElement('td');
   bild1=document.createElement('img');
   link2=document.createElement('a');
   if(child[0].length>100) gekuertzt=child[0].substring(0,100)+'[...]';
   else  gekuertzt=child[0];
   text2=document.createTextNode(gekuertzt);
   text3=document.createTextNode(child[1]);
   bild4a=document.createElement('img');
   bild4b=document.createElement('img');
   
   text4=document.createTextNode(prozent(child[1],js_data['gesamt']));
   zeile.id='row'+id+'_'+i;
   if(((js_data['childs'][id]-i+id)%2)==1) zeile.style.backgroundColor='#DFE2FF';
   // Generiere Spalten-Inhalte
   if(i==1 && id==js_data['host_anz']) bild1.src='extensions/ajaxTree/line2.gif';
   else bild1.src='extensions/ajaxTree/line.gif';
   link2.href='anonymous_redirect.php?go_anonym=http://'+js_data["hosts"][id]+child[0].replace(/&/g,'%26');
   link2.target='_blank';
   link2.className='ajaxTreeLink';
   link2.appendChild(text2);
   proz=prozent(child[2],js_data['gesamt']);
   proz2=Math.round(prozent(child[1],js_data['gesamt2'])/100*js_data['laenge']);
   bild4a.width=proz2;
   bild4a.height=10;
   bild4a.title=proz+'%';
   bild4b.width=js_data['laenge']-proz2;
   bild4b.height=10;
   bild4b.title=proz+'%';
   bild4a.src='img/bar1.gif';   
   bild4b.src='img/bar0.gif';
   // Fuege Inhalte in Spalten
   spalte1.appendChild(bild1);
   spalte2.appendChild(link2);
   spalte3.appendChild(text3);
   spalte4.appendChild(bild4a);
   spalte4.appendChild(bild4b);
   // Fuege Spalten in Zeile ein
   zeile.appendChild(spalte1);
   zeile.appendChild(spalte2);
   zeile.appendChild(spalte3);
   zeile.appendChild(spalte4);
   document.getElementById('tabelle').insertBefore(zeile,ziel_zeile);
   }

  if(expand && id<js_data['host_anz']) menuclick(id+1);
  else
   {
   expand=false;
   hide_waitbox();
   }
  }
 }

function expandTree(id)
 {
 if(js_data['host_anz']<20 || confirm('Loading all referers can take a lot of time depending on the number of referers and your browser.\nContinue?'))
  {
  waitmessage();
  expand=true;
  menuclick(1);
  } 
 }
 
function collapseTree()
 {
 var id=1;
 while(id<=js_data['host_anz'])
  {
  if(js_data['parents'][id]==2)
   {
   menuclick(id);
   }
  id++;
  }
 }

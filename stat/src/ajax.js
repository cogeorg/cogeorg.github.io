/*

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

*** src/ajax.js ***
Funktion:    Ajax-Funktion
Aufrufbar:   nein
Eingebunden: von src/show_stat.php
*/

var noAjax=false;

function ajax()   // Erzeuge ein XMLHttpRequest-Objekt
 {
 var ajaxObj=null;
 try
  {
  ajaxObj=new ActiveXObject("Microsoft.XMLHTTP");
  }
 catch(Error)
  {
  try
   {
   ajaxObj=new ActiveXObject("MSXML2.XMLHTTP");
   }
  catch(Error)
   {
   try
    {
    ajaxObj=new XMLHttpRequest();
    }
   catch(Error)
    {
    noAjax=true;
    }
   }
  }
 return ajaxObj;
 }
 
function checkAjax()
 {
 var ajaxObj=ajax();    // XMLHttpRequest-Objekt
 if(noAjax==false) document.getElementById('ajaxInput').value='1';
 }
$(document).foundation();


var icon = document.getElementById("icon");

if(localStorage.getItem("tema") == null){ //daca inca nu s-a setat o tema
   localStorage.setItem("tema", "luminoasa"); //stocam datele pentru browser
}


let localData = localStorage.getItem("tema"); //va primi valoarea temei

if(localData == "luminoasa"){  
   icon.src = "img/moon.png";
   document.body.classList.remove("tema-intunecata");
}else if(localData == "intunecata"){
   icon.src = "img/sun.png";
   document.body.classList.add("tema-intunecata");
}

icon.onclick = function(){
   document.body.classList.toggle("tema-intunecata");
   if(document.body.classList.contains("tema-intunecata")){
       icon.src = "img/sun.png";                   //schimbam imaginea
       localStorage.setItem("tema", "intunecata"); //schimbam valorile stocate in browser in functie de tema
   } else{
       icon.src = "img/moon.png";
       localStorage.setItem("tema", "luminoasa");
   }
}


       
 
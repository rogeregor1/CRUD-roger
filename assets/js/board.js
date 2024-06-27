let mostrador = document.getElementById("mostrador");
let idSeleccionada = document.getElementById("id");
let imgSeleccionada = document.getElementById("img");
let nombreSeleccionado = document.getElementById("user");
let categorySeleccionado = document.getElementById("cate");
let descripSeleccionada = document.getElementById("serv");
let precioSeleccionado = document.getElementById("precio");
let stockSeleccionada = document.getElementById("stat");
let seleccion = document.getElementById("seleccion");

function cargar(item){
    quitarBordes();
    mostrador.style.width = "0%";
    seleccion.style.width = "100%";
    seleccion.style.opacity = "5";
    item.style.border = "2px solid red";

    imgSeleccionada.src = item.getElementsByTagName("img")[0].src;

    nombreSeleccionado.innerHTML =  item.getElementsByClassName("user")[0].innerHTML;

    categorySeleccionado.innerHTML =  item.getElementsByClassName("category")[0].innerHTML;

    descripSeleccionada.innerHTML =  item.getElementsByClassName("service")[0].innerHTML;

    precioSeleccionado.innerHTML =  item.getElementsByClassName("precio")[0].innerHTML;

    stockSeleccionada.innerHTML =  item.getElementsByClassName("estado")[0].innerHTML;


}
function cerrar(){
    mostrador.style.width = "100%";
    seleccion.style.width = "0%";
    seleccion.style.opacity = "0";
    quitarBordes();
}
function quitarBordes(){
    var items = document.getElementsByClassName("item");
    for(i=0;i <items.length; i++){
        items[i].style.border = "none";
    }
}
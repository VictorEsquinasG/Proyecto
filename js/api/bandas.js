window.addEventListener("load", function () {

    var nuevo = document.getElementById("annadir");

    nuevo.onclick = function (ev) {
        // Evitamos que nos redireccione
        ev.preventDefault();
        ////Crear el objeto formulario, titulo, input y boton
        let formulario=document.createElement("form");
        let nombre=document.createElement("input");
        let dist=document.createElement("input");
        let min=document.createElement("input");
        let max=document.createElement("input");
        let boton=document.createElement("input");
 
        ////Asignamos atributos al objeto formulario
            formulario.setAttribute('method', "post");
            formulario.setAttribute('action', "");
            // formulario.setAttribute('class', "styled-table");
 
            ////Asignamos atributos al input del nombre
            nombre.setAttribute('type', "text");
            nombre.setAttribute('id', "nombre");
            nombre.setAttribute('name', "nombre");
            nombre.setAttribute('placeholder', "Nombre");
            nombre.setAttribute('style', "width:100%;margin: 10px 0px;padding: 5px");
 
            ////Asignamos atributos al input de la distancia
            dist.setAttribute('type', "text");
            dist.setAttribute('id', "distancia");
            dist.setAttribute('name', "distancia");
            dist.setAttribute('placeholder', "Distancia");
            dist.setAttribute('style', "width:100%;margin: 10px 0px;padding: 5px");
 
            ////Asignamos atributos al input del mínimo
            min.setAttribute('type', "text");
            min.setAttribute('name', "minimo");
            min.setAttribute('id', "minimo");
            min.setAttribute('placeholder', "Mínimo");
            min.setAttribute('style', "width:100%;margin: 10px 0px;padding: 5px");
 
            ////Asignamos atributos al input del máximo
            max.setAttribute('type', "text");
            max.setAttribute('id', "maximo");
            max.setAttribute('name', "maximo");
            max.setAttribute('placeholder', "Máximo");
            max.setAttribute('style', "width:100%;margin: 10px 0px;padding: 5px");
        
            ////Asignar atributos al boton
            boton.setAttribute('type', "submit");	
            boton.setAttribute('value', "Enviar");
            boton.setAttribute('class', "c-card__btn c-btn--primary");
            boton.setAttribute('onclick', "location.reload()"); // Recargamos la página
            boton.setAttribute('style', "margin: 15px 10px;");
            //boton.setAttribute('onclick', "alert('Se ha añadido un nuevo bandas')");
 
            formulario.appendChild(nombre);
            formulario.appendChild(dist);
            formulario.appendChild(min);
            formulario.appendChild(max);
            formulario.appendChild(boton);
            document.getElementById('cuerpo').appendChild(formulario);//Agregar el formulario a la etiqueta con el ID		
            

                //debugger;
            formulario.onsubmit = function(e){
                    e.preventDefault();
                    //alert("hola");
                    guardar();
                }
                async function guardar(){
                   try{
                       const data = new FormData(formulario);
                       //
                       var respuesta = await fetch("http://localhost/Proyecto/API/bandasApi.php",{
                           method: 'POST',
                           mode: 'cors',
                           cache: 'no-cache',
                           body: data,
                           headers: new Headers()
                  
                       })
                       /*.then(respuesta=>respuesta.json()).then(datos=>{
                        console.log("hola");


                       })*/
                       console.log(respuesta);
                       alert ("Nuevo bandas creado");

                   } catch(err){
                       console.log("Ocurrio un error: "+err);
                   }
                }
        modal(formulario);
    }

})
function modal(div) {
    var modal = this.document.createElement("div");
    modal.style.position = "fixed";
    modal.style.background = "grey";
    modal.style.opacity = 0.5;
    modal.style.top = 0;
    modal.style.left = 0;
    modal.style.width = "100%";
    modal.style.height = "100%";
    modal.style.zIndex = 100;
    document.body.appendChild(modal,titulo);

    var caja = document.createElement("div");
    // Calculamos el tamaño de la pantalla para centrarlo
    var left = parseInt((window.innerWidth - 400) / 2) + "px";
    var top = parseInt((window.innerHeight - 300) / 2) + "px";

    caja.style.position = "fixed";
    caja.style.background = "white";
    caja.style.top = top;
    caja.style.left = left;
    caja.style.width = "600px";
    caja.style.height = "345px";
    caja.style.borderRadius = "10px";
    caja.style.zIndex = 101;
    document.body.appendChild(caja);

    var titulo = document.createElement("div");
    titulo.style.position = "absolute";
    titulo.style.background = "#FF8F35";
    titulo.style.fontFamily = '-apple-system, BlinkMacSystemFont, Roboto, Helvetica, Arial, sans-serif';
    titulo.style.color = "white";
    titulo.style.height = "40px";
    titulo.style.width = "100%";
    titulo.style.padding= "10px";
    titulo.innerHTML="Nueva Banda";
    caja.appendChild(titulo);

    var cerrar = document.createElement("span");
    cerrar.innerHTML="X";
    cerrar.style.backgroundColor = "red";
    cerrar.style.cursor = "pointer";
    cerrar.style.borderRadius = "35px";
    cerrar.style.color = "white";
    cerrar.style.fontWeight = "bold";
    cerrar.style.position="absolute";
    cerrar.style.width="20px";
    cerrar.style.top=0;
    cerrar.style.right="20px";
    cerrar.style.margin="5px";
    cerrar.style.padding="5px";
    caja.style.overflow="hidden";
    cerrar.onclick=function(){
        var caja =this.parentElement.parentElement;
        caja.parentElement.removeChild(caja);
        modal.parentElement.removeChild(modal);
        location.reload();
    }
    titulo.appendChild(cerrar);

    var contenido = document.createElement("div");
    contenido.style.top="40px";
    contenido.style.position="absolute";
    contenido.style.height="370px";
    contenido.style.width="100% ";
    // contenido.style.width="fit-content";
    contenido.style.padding ="15px";
    contenido.style.overflowY="scroll";
    caja.appendChild(contenido);
    contenido.appendChild(div)
}
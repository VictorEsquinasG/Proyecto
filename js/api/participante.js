window.addEventListener("load", function () {

    var nuevo = document.getElementById("annadir");

    nuevo.onclick = function (ev) {
        // Evitamos que nos redireccione
        ev.preventDefault();
        ////Crear el objeto formulario, titulo, input y boton
        let formulario=document.createElement("form");
        let titulo=document.createElement("label");
        let nombre=document.createElement("input");
        let contrasena=document.createElement("input");
        let mail=document.createElement("input");
        let indicativo=document.createElement("input");
        let ubi =document.createElement("input");
        let imagen =document.createElement("input");
        let cajaTextRol=document.createElement("input");
        let boton=document.createElement("input");
 
        ////Asignamos atributos al objeto formulario
            formulario.setAttribute('method', "post");
            formulario.setAttribute('action', "");
            formulario.setAttribute('class', "styled-table");
 
            ////Asignamos atributos al input del nombres
            nombre.setAttribute('type', "text");
            nombre.setAttribute('id', "nombre");
            nombre.setAttribute('name', "nombre");
            nombre.setAttribute('placeholder', "Nombre");
            nombre.setAttribute('style', "width:100%;margin: 10px 0px;padding: 5px");
 
            ////Asignamos atributos al input de la contraseña
            contrasena.setAttribute('type', "text");
            contrasena.setAttribute('id', "contrasena");
            contrasena.setAttribute('name', "contrasena");
            contrasena.setAttribute('placeholder', "Contraseña");
            contrasena.setAttribute('style', "width:100%;margin: 10px 0px;padding: 5px");
 
            ////Asignamos atributos al input del correo
            mail.setAttribute('type', "text");
            mail.setAttribute('name', "email");
            mail.setAttribute('id', "email");
            mail.setAttribute('placeholder', "Email");
            mail.setAttribute('style', "width:100%;margin: 10px 0px;padding: 5px");
 
            ////Asignamos atributos al input del INDICATIVO
            indicativo.setAttribute('type', "text");
            indicativo.setAttribute('id', "indicativo");
            indicativo.setAttribute('name', "indicativo");
            indicativo.setAttribute('placeholder', "Indicativo");
            indicativo.setAttribute('style', "width:100%;margin: 10px 0px;padding: 5px");

            ////Asignar atributos al input de la ubicación
            ubi .setAttribute('type', "text");
            ubi .setAttribute('id', "localizacion");
            ubi .setAttribute('name', "localizacion");
            ubi .setAttribute('placeholder', "Localiacion");
            ubi .setAttribute('style', "width:100%;margin: 10px 0px;padding: 5px");

            ////Asignar atributos al objeto caja de texto de IMAGEN
            imagen .setAttribute('type', "text");
            imagen .setAttribute('id', "imagen");
            imagen .setAttribute('name', "imagen");
            imagen .setAttribute('placeholder', "Imagen");
            imagen .setAttribute('style', "width:100%;margin: 10px 0px;padding: 5px");
 
            ////Asignar atributos al objeto caja de texto de ROL
            cajaTextRol.setAttribute('type', "text");
            cajaTextRol.setAttribute('id', "rol");
            cajaTextRol.setAttribute('name', "rol");
            cajaTextRol.setAttribute('placeholder', "Rol");
            cajaTextRol.setAttribute('style', "width:100%;margin: 10px 0px;padding: 5px");
        
            ////Asignar atributos al objeto boton
            boton.setAttribute('type', "submit");	
            boton.setAttribute('value', "Enviar");
            boton.setAttribute('onlcick', "location.reload()");
            boton.setAttribute('style', "width:100px;margin: 10px 0px;padding: 10px;background:#F05133;color:#fff;border:solid 1px #000;");
            //boton.setAttribute('onclick', "alert('Se ha añadido un nuevo bandas')");
 
            titulo.innerHTML='<h1>Bandas</h1>';
            formulario.appendChild(titulo);
            formulario.appendChild(nombre);
            formulario.appendChild(contrasena);
            formulario.appendChild(mail);
            formulario.appendChild(indicativo);
            formulario.appendChild(ubi );
            formulario.appendChild(imagen );
            formulario.appendChild(cajaTextRol);
            formulario.appendChild(boton);
            document.getElementById('cuerpo').appendChild(formulario);//Agregar el formulario a la etiqueta con el ID		
            

                //debugger;
            formulario.onsubmit = function(e){
                    e.preventDefault();
                    //alert("hola");
                    guardar();
                }
                async function guardar(){
                   // console.log("guardar datos...");
                  /* var indicativo = document.getElementById("indicativo").value;
                   var email = document.getElementById("email").value;
                   var localizacion = document.getElementById("localizacion").value;
                   var imagen = document.getElementById("imagen").value;
                   var nombre = document.getElementById("nombre").value;
                   var contrasena = document.getElementById("contrasena").value;
                   var rol = document.getElementById("rol").value;
           
                 if(indicativo == "" || email == "" || localizacion == "" || imagen == "" || nombre == "" || contrasena == "" || rol == ""){
                       alert("todos los campos son obligatorios");
                       return;
                   }*/
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
    modal.style.background = "#020202";
    modal.style.opacity = 0.5;
    modal.style.top = 0;
    modal.style.left = 0;
    modal.style.width = "100%";
    modal.style.height = "100%";
    modal.style.zIndex = 100;
    document.body.appendChild(modal,titulo);

    var caja = document.createElement("div");
    var left = parseInt((window.innerWidth - 400) / 2) + "px";
    var top = parseInt((window.innerHeight - 300) / 2) + "px";

    caja.style.position = "fixed";
    caja.style.background = "#FFFFFF";
    caja.style.top = top;
    caja.style.left = left;
    caja.style.width = "600px";
    caja.style.height = "400px";
    caja.style.zIndex = 101;
    document.body.appendChild(caja);

    var titulo = document.createElement("div");
    titulo.style.position = "absolute";
    titulo.style.background = "#BBBBBB";
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
    contenido.style.width="100%";
    contenido.style.padding ="15px";
    contenido.style.overflowY="scroll";
    caja.appendChild(contenido);
    contenido.appendChild(div)
}
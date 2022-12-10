window.addEventListener("load", function () {

    var nuevo = document.getElementById("annadir");

    nuevo.onclick = function (ev) {
        // Evitamos que nos redireccione
        ev.preventDefault();
        ////Crear el objeto formulario, titulo, input y boton
        let formulario=document.createElement("form");
        let nombre=document.createElement("input");
        let contrasena=document.createElement("input");
        let mail=document.createElement("input");
        let indicativo=document.createElement("input");
        let ubi =document.createElement("input");
        let imagen =document.createElement("input");
        let Rol=document.createElement("select");
        let boton=document.createElement("input");
 
        // El objeto formulario
            formulario.setAttribute('method', "post");
            formulario.setAttribute('action', "");
 
            // El input del nombres
            nombre.setAttribute('type', "text");
            nombre.setAttribute('id', "nombre");
            nombre.setAttribute('name', "nombre");
            nombre.setAttribute('placeholder', "Nombre");
            nombre.setAttribute('style', "width:90%;margin: 10px 0px;padding: 5px");
 
            // El input de la contraseña
            contrasena.setAttribute('type', "password");
            contrasena.setAttribute('id', "contrasena");
            contrasena.setAttribute('name', "contrasena");
            contrasena.setAttribute('placeholder', "Contraseña");
            contrasena.setAttribute('style', "width:90%;margin: 10px 0px;padding: 5px");
 
            // El input del correo
            mail.setAttribute('type', "email");
            mail.setAttribute('name', "email");
            mail.setAttribute('id', "email");
            mail.setAttribute('placeholder', "Email");
            mail.setAttribute('style', "width:90%;margin: 10px 0px;padding: 5px");
 
            // El input del INDICATIVO
            indicativo.setAttribute('type', "text");
            indicativo.setAttribute('id', "indicativo");
            indicativo.setAttribute('name', "indicativo");
            indicativo.setAttribute('placeholder', "Indicativo");
            indicativo.setAttribute('style', "width:90%;margin: 10px 0px;padding: 5px");

            // El input de la ubicación
            ubi .setAttribute('type', "text");
            ubi .setAttribute('name', "ubi");
            ubi .setAttribute('placeholder', "Localización");
            ubi .setAttribute('style', "width:90%;margin: 10px 0px;padding: 5px");

            // La IMAGEN
            imagen .setAttribute('type', "file");
            imagen .setAttribute('id', "imagen");
            imagen .setAttribute('name', "imagen");
            imagen .setAttribute('placeholder', "Imagen");
            imagen .setAttribute('style', "width:90%;margin: 10px 0px;padding: 5px");
 
            // Asignamos atributos al select de ROL
            var mindundi = document.createElement('option');
            var admin = document.createElement('option');
            mindundi.innerHTML = "Participante";
            mindundi.value = "user";
            admin.innerHTML = "Administrador";
            admin.value = "admin";
            
            Rol.setAttribute('id', "rol");
            Rol.setAttribute('name', "rol");
            Rol.setAttribute('placeholder', "Rol");
            Rol.setAttribute('style', "width:90%;margin: 10px 0px;padding: 5px");
            Rol.appendChild(mindundi);
            Rol.appendChild(admin);
        
            // Asignamos atributos al objeto boton
            boton.setAttribute('type', "submit");	
            boton.setAttribute('value', "Crear");
            boton.setAttribute('class', "c-card__btn c-btn--primary");
            boton.setAttribute('onlcick', "location.reload()");
            boton.setAttribute('style', "width:100px;margin: 10px 0px;padding: 10px;");
            //boton.setAttribute('onclick', "alert('Se ha añadido un nuevo participante')");
 
            formulario.appendChild(nombre);
            formulario.appendChild(contrasena);
            formulario.appendChild(mail);
            formulario.appendChild(indicativo);
            formulario.appendChild(ubi );
            formulario.appendChild(imagen );
            formulario.appendChild(Rol);
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
                       var respuesta = await fetch("./API/participantesApi.php",{
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
                       alert ("Nuevo participante creado");

                   } catch(err){
                       console.log("Ocurrió un error: "+err);
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
    var left = parseInt((window.innerWidth - 400) / 2) + "px";
    var top = parseInt((window.innerHeight - 300) / 2) + "px";

    caja.style.position = "fixed";
    caja.style.background = "white";
    caja.style.top = top;
    caja.style.left = left;
    caja.style.width = "400px";
    caja.style.height = "490px";
    caja.style.borderRadius = "10px";
    caja.style.zIndex = 101;
    document.body.appendChild(caja);

    var titulo = document.createElement("div");
    titulo.style.position = "absolute";
    titulo.style.background = "#FF8F35";
    titulo.style.fontFamily = '-apple-system, BlinkMacSystemFont, Roboto, Helvetica, Arial, sans-serif';
    titulo.style.color = "white";
    titulo.style.height = "20px";
    titulo.style.width = "100%";
    titulo.style.padding= "10px";
    titulo.innerHTML="Nuevo Participante";
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
window.addEventListener("load",()=>{
    // los TDs de borrado
    var btns = document.querySelectorAll('.del');
    for (let i = 0; i < btns.length; i++) {
        var btn = btns[i];
        btn.addEventListener('click',() =>
        {
            borrar(btn.getAttribute('idConcurso'));
        });
    }

    async function borrar(x) {
        try {
            // debugger;
            
            const data = x;
            //
            await fetch("./API/borraConcurso.php", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: data,
                headers: new Headers()
            })
                .then(respuesta => console.log(respuesta));
        } catch (err) {
            console.log("Ocurrió un error: " + err);
        }
    }
});
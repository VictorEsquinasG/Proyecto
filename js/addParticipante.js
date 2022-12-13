//TODO adaptarlo a RADIO
window.onload = function () {

    const zonaBotones = document.getElementById('btnes');
    const botones = zonaBotones.getElementsByTagName('button');
    const participantes = document.getElementById('participantes');
    const concursantes = document.getElementById('concursantes');

    botones[0].onclick = botonSele1;
    botones[1].onclick = botonTdos1;
    botones[2].onclick = botonTdos2;
    botones[3].onclick = botonSele2;

    function botonTdos1() {
        var childs = document.getElementById('participantes').options;
        const opt = [];
        //Pasamos a array
        for (let j = 0; j < childs.length; j++) {
            opt.push(childs[j]);
        }
        //Movemos
        for (let i = 0; i < opt.length; i++) {
            concursantes.appendChild(opt[i]);
            opt[i].selected = false;
        }
    };
    function botonTdos2() {
        var childs = document.getElementById('concursantes').options;
        const opt = [];
        //Pasamos a array
        for (let j = 0; j < childs.length; j++) {
            opt.push(childs[j]);
        }
        //Movemos
        for (let i = 0; i < opt.length; i++) {
            const seleccionado = opt[i];
            participantes.appendChild(seleccionado);
            seleccionado.selected = false;
        }
    };
    function botonSele1() {
        var childs = document.getElementById('participantes').options;
        const opt = [];
        //Pasamos a array
        for (let j = 0; j < childs.length; j++) {
            opt.push(childs[j]);
        }
        //Movemos
        for (let i = 0; i < opt.length; i++) {
            const seleccionado = opt[i];
            if (seleccionado.selected) {
                concursantes.appendChild(seleccionado);
                seleccionado.selected = false;
            }
        }
    };
    function botonSele2() {
        var childs = document.getElementById('concursantes').options;
        const opt = [];
        //Pasamos a array
        for (let j = 0; j < childs.length; j++) {
            opt.push(childs[j]);
        }
        //Movemos
        for (let i = 0; i < opt.length; i++) {
            const seleccionado = opt[i];
            if (seleccionado.selected) {
                participantes.appendChild(seleccionado);
                seleccionado.selected = false; // des-seleccionamos
            }
        }
    };

    // function throwAll(path) {

    //     const opt = [];

    //     // for (let i; i<participantes.options.length;i++) {
    //     //     opt.push(participantes.options[i])
    //     // }


    // }

    function set() {
        caja1.removeChild(participantes.options[i]);
        if (path === '1') {
            i = 0;
            while (participantes.selectedIndex > -1) {
                caja2.appendChild(participantes.options[i]);
                caja1.removeChild(participantes[i]);
                i++;
            }

        } else {
            while (concursantes.selectedIndex > -1) {
                caja1.appendChild(concursantes.options[i]);
            }
        }
    }


}
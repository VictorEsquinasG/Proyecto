window.addEventListener("load", () => {
    const long = document.getElementById('lon');
    const lat = document.getElementById('lat');
    const captu = document.getElementById('btnCaptura');
    
    function captura(x) {
        const crd = x.coords;       
        long.value = crd.longitude;
        lat.value = crd.latitude;
    }
    captu.addEventListener("click", (ev) => {
        // Impedimos que recargue
        ev.preventDefault();
        // Cogemos la localización
        var posicion = navigator.geolocation.getCurrentPosition(captura);
        // console.log(posicion);
    });

});

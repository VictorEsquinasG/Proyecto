window.addEventListener("load", () => {
    const long = document.getElementById('lon');
    const lat = document.getElementById('lat');
    const captu = document.getElementById('btnCaptura');
    
    function captura(x) {
        long.value = x.longitude;
        lat.value = x.latitude;
    }
    captu.addEventListener("click", () => {
        var posicion = navigator.geolocation.getCurrentPosition(captura);
        console.log(posicion);
    });

});


function capturar () {
    preventDefault();
    var posicion = navigator.geolocation.getCurrentPosition();
    return posicion;
}
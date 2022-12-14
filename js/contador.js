window.addEventListener('load',function () {
    let contador = this.document.getElementById('contador');
    if (contador!=null) {
      contador.style.color='orangered';
      contador.style.fontWeight='bold';
      contador.style.fontFamily='Segoe UI';
      contador.style.marginTop='1.25vh';
      
      let fechaStr = contador.getAttribute('fechaFin');
      let idConcurso = contador.getAttribute('idConcurso');
      // Separamos la fecha y la hora
      const [dateValues, timeValues] = fechaStr.split(' ');
      // FECHA
      const [year, month, day] = dateValues.split('-');
      // HORA 
      const [hours, minutes, seconds] = timeValues.split(':');

      const fecha = new Date(+year, +month - 1, +day, +hours, +minutes, +seconds);
      var countDownDate = new Date(fecha).getTime();
      
      // Update the count down every 1 second
      var x = setInterval(function() {
      
        var now = new Date().getTime();
          
        var distance = countDownDate - now;
        // Cogemos los días, meses, etc de diferencia (que quedan)  
        var dias = Math.floor(distance / (1000 * 60 * 60 * 24));
        var horas = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var mins = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var segs = Math.floor((distance % (1000 * 60)) / 1000);
          
        contador.innerHTML = 'Fin de concurso en : '+dias + " días con " + horas + " horas, "
        + mins + " minutos, " + segs + " segundos ";
          
        if (distance < 0) {
            // el concurso ha acabado
          clearInterval(x);
          contador.innerHTML = "El concurso ha finalizado";
          // Creamos un botón para ver la puntuación y los premios
          var botom = document.createElement('button');
          botom.setAttribute("class","c-btn--secundary c-card__btn"); // estilo

          botom.onclick = () => {
            location.href = "?menu=premios&conc="+idConcurso;
          }
          contador.appendChild(botom);
        }
      }, 1000);
    }
  })
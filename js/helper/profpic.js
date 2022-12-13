/* ABREVIADO PROFILE-PICTURE */
window.addEventListener("load", () => {
  var input = document.getElementById("inpFile");
  var btn = document.getElementById('btnImg');
  var canvas = document.getElementById('canvas');

  btn.addEventListener("click", () => {
    return getFile();
  });

  input.addEventListener("change", () => {
    var preview = document.getElementById('foto');
    const [file] = input.files
    // var file = input.value;
    // var fileName = file.split("\\");
    // previsualización 
    if (file) {
      preview.setAttribute('height',"100");
      preview.src = URL.createObjectURL(file);
      canvas.style.display = "none";
    }
  });

  function getFile() {
    // Activamos el input type file
    input.click();
    // setTimeout(sub(input),15000);
  }

  function sub(obj) {
    // preventDefault();
    debugger;
    var file = obj.value;
    var fileName = file.split("\\");
    btn.innerHTML = '' + fileName[fileName.length - 1];

    // document.myForm.submit();
  }
});



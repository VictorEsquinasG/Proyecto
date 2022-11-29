/* ABREVIADO PROFILE-PICTURE */
function getFile() {
    document.getElementById("inpFile").click();
  }
  
  function sub(obj) {
    var file = obj.value;
    var fileName = file.split("\\");
    document.getElementById("btnImg").innerHTML = fileName[fileName.length - 1];
    document.myForm.submit();
    preventDefault();
  }
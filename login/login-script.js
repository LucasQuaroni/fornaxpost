function validacion() {
  var user = document.forms["myForm"]["user"].value;
  var pass = document.forms["myForm"]["pass"].value;

  if (user == "" || pass == "") {
    alert("Los campos de Usuario y Contraseña no pueden estar vacíos");
    return false;
  }

  return true;
}

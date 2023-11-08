document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('form');
  const dniInput = document.querySelector('input[name="dni_cliente"]');

  form.addEventListener('submit', function (e) {
    // Obtén el valor del campo de entrada de DNI
    const dniValue = dniInput.value.trim();

    if (!/^\d{7,8}$/.test(dniValue)) {
      alert('El DNI debe contener entre 7 y 8 números.');
      e.preventDefault(); // Evita que el formulario se envíe
    }
  });
});
document.addEventListener('DOMContentLoaded', function () {
   var crearUsuariosContainer = document.querySelector('#jefe-mesa-usuario-1');
   var crearUsuariosOption = document.querySelector('#usuarios-1');

   var verUsuariosContainer = document.querySelector('#jefe-mesa-usuario-2');
   var verUsuariosOption = document.querySelector('#usuarios-2');

   crearUsuariosOption.addEventListener('click', function () {
      crearUsuariosContainer.style.display = 'block';
   });

   verUsuariosOption.addEventListener('click', function () {
      verUsuariosContainer.style.display = 'block';
   });
});

function cleanInputs() {
   var inputs = document.querySelectorAll('.clean-input');

   inputs.forEach(function (input) {
      input.value = '';
   });
}
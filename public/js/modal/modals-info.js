document.addEventListener('DOMContentLoaded', function () {

    // Esto corresponse a la vista de gestion de Usuarios del  Jefe de Mesa
    var actionsButtonsUsers = document.querySelectorAll(".acciones-usuarios");
    actionsButtonsUsers.forEach(function (actionButton) {

        actionButton.addEventListener('click', function () {

            var tdName = actionButton.parentElement.parentElement;
            var rol = tdName.children[1].getAttribute('title');
            var area = tdName.children[2].getAttribute('title');
            console.log(tdName);
            document.getElementById('replaceRut').innerText = tdName.children[0].textContent;
            document.getElementById('replaceName').innerText = tdName.children[4].textContent;
            document.getElementById('replaceEmail').innerText = tdName.children[5].textContent;
            document.getElementById('replaceRol').innerText = rol;
            document.getElementById('replaceArea').innerText = area;

            document.getElementById("allow").href = '/usuarios/habilitar/' + tdName.children[0].textContent;
            document.getElementById('disallow').href = '/usuarios/deshabilitar/' + tdName.children[0].textContent;
            document.getElementById('reset').href = '/usuarios/resetear/' + tdName.children[0].textContent;
        });
    });

    //Contenedor universal para el método update
    var updateActionContainer = document.querySelector('#update-action-container');
    var updateTrigger = document.querySelector("#update-trigger");
    updateTrigger.addEventListener('click', function () {

        updateActionContainer.style.display = 'block';
    });
    // Termino contenedor universal para metodo update

    // CRITICIDAD JEFE DE MESA
    var actionButtonsCriticidad = document.querySelectorAll('.acciones-criticidad');
    actionButtonsCriticidad.forEach(function (actionButton) {

        actionButton.addEventListener('click', function () {
            var tdName = actionButton.parentElement.parentElement;

            document.querySelector('#replaceCriticidadID').innerText = tdName.children[0].textContent;
            document.querySelector('#replaceCriticidadName').innerText = tdName.children[1].textContent;
            document.querySelector('#replaceCriticidadValor').innerText = tdName.children[2].textContent;

            document.querySelector('#delete-criticidad').href = '/criticidad/eliminar/' + tdName.children[0].textContent;
            document.querySelector('#criticidad-id-input').value = tdName.children[0].textContent;
        });
    });

    // AREAS JEFE DE MESA

    var actionButtonsArea = document.querySelectorAll('.acciones-areas');

    actionButtonsArea.forEach(function (actionButton) {
        actionButton.addEventListener('click', function () {
            var tdName = actionButton.parentElement.parentElement;

            document.querySelector('#replaceAreaID').innerText = tdName.children[0].textContent;
            document.querySelector('#replaceAreaName').innerText = tdName.children[1].textContent;

            document.querySelector('#delete-area').href = '/areas/eliminar/' + tdName.children[0].textContent;
            document.querySelector('#area-id-input').value = tdName.children[0].textContent;
        });
    });

    // TIPO TIQUE JEFE DE MESA

    var actionButtonsTipoTique = document.querySelectorAll('.acciones-tipo-tique');

    actionButtonsTipoTique.forEach(function (actionButton) {
        actionButton.addEventListener('click', function () {
            var tdName = actionButton.parentElement.parentElement;

            document.querySelector('#replaceTipoTiqueID').innerText = tdName.children[0].textContent;
            document.querySelector('#replaceTipoTiqueName').innerText = tdName.children[1].textContent;

            document.querySelector('#delete-tipo-tique').href = '/tipos-tique/eliminar/' + tdName.children[0].textContent;
            document.querySelector('#tipo-tique-id-input').value = tdName.children[0].textContent;
        });
    });
});
document.addEventListener('DOMContentLoaded', function () {

    // Esto corresponse a la vista de gestion de Usuarios del  Jefe de Mesa
    var actionsButtonsUsers = document.querySelectorAll(".acciones-usuarios") || [];
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
    if (updateTrigger !== null && updateActionContainer !== null) {
        updateTrigger.addEventListener('click', function () {

            updateActionContainer.style.display = 'block';
        });
    }

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

    // PREVIASUALIZACION EJECUTIVO DE MESA
    var prevButton = document.querySelector('#prev-button');

    if (prevButton !== null) {
        prevButton.addEventListener('click', function () {
            (document.querySelectorAll('.prev-input') || []).forEach(function (input) {
                var target = input.dataset.target;
                var text = void 0;
                if (input.hasChildNodes() && input.firstChild.nodeType !== 3) {
                    text = input.options[input.selectedIndex].text;
                } else if (input.firstChild.nodeType === 3) {
                    // 3 means text node
                    text = input.textContent;
                } else {
                    text = input.value;
                }

                var textContainer = document.getElementById(target);
                if (textContainer.nodeName === 'INPUT') {
                    console.log(textContainer.nodeName);
                    textContainer.value = text;
                } else {
                    textContainer.innerText = text;
                }
            });
        });
    }

    var submitTique = document.querySelector('#submit-tique-form');

    if (submitTique !== null) {
        submitTique.addEventListener('click', function () {
            var oneEmpty = void 0;
            submitTique.addEventListener('click', function () {
                (document.querySelectorAll('.prev-input') || []).forEach(function (input) {

                    if (input.value === null) {
                        oneEmpty = true;
                    }
                });
            });

            if (oneEmpty) {
                document.getElementById('tique-form').submit();
            } else {
                document.querySelector('#error-message').innerText = "Hay campos que están vacíos";
            }
        });
    }

    // Previsualización Ejecutivo de Area

    var tiquesPrevButtons = document.querySelectorAll('.tiques-prev-buttons');

    tiquesPrevButtons.forEach(function (button) {

        button.addEventListener('click', function () {
            var tdName = button.parentElement.parentElement;

            document.querySelector('#prev-rut-cliente').innerText = tdName.children[9].textContent;
            document.querySelector('#prev-fecha').innerText = tdName.children[1].textContent;
            document.querySelector('#prev-nombre-cliente').innerText = tdName.children[0].textContent;
            document.querySelector('#prev-telefono-cliente').innerText = tdName.children[10].textContent;
            document.querySelector('#prev-correo-cliente').innerText = tdName.children[11].textContent;
            document.querySelector('#prev-criticidad').innerText = tdName.children[3].textContent;
            document.querySelector('#prev-tipo-tique').innerText = tdName.children[2].textContent;
            document.querySelector('#prev-area').innerText = tdName.children[4].textContent;
            document.querySelector('#prev-id-tique').value = tdName.children[6].textContent;
            document.querySelector('#prev-estado').innerText = tdName.children[5].textContent;
            document.querySelector('#prev-problema').innerText = tdName.children[7].textContent;
            document.querySelector('#prev-servicio').innerText = tdName.children[8].textContent;
        });
    });

    // Boton para enviar el form de Ejecutivo de area
    var closeTiqueButton = document.querySelector('#button-cerrar-tique');
    closeTiqueButton.addEventListener('click', function (e) {
        e.preventDefault();
        var targetForm = closeTiqueButton.dataset.form;

        var errorMessage = document.querySelector('#error');
        var observacion = document.querySelector('#observacion');

        if (observacion.value === null || observacion.value.length < 10) {
            errorMessage.innerText = 'Asegúrese de que la observación sea detallada( min 10 caracteres ) y no esté vacía';
        } else {
            document.getElementById(targetForm).submit();
        }
    });
});
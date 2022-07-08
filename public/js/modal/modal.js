document.addEventListener('DOMContentLoaded', function () {
    // Functions to open and close a modal
    function openModal($el) {
        $el.classList.add('is-active');
    }

    function closeModal($el) {
        $el.classList.remove('is-active');
        //cerrar formulario para actualizar las criticidades
        document.querySelector('#update-action-container').style.display = 'none';
        // Clean inputs
        cleanInputs();
    }

    function closeAllModals() {
        (document.querySelectorAll('.modal') || []).forEach(function ($modal) {
            closeModal($modal);
        });
    }

    // Add a click event on buttons to open a specific modal
    (document.querySelectorAll('.js-modal-trigger') || []).forEach(function ($trigger) {
        var modal = $trigger.dataset.target;
        var $target = document.getElementById(modal);

        $trigger.addEventListener('click', function () {
            openModal($target);
        });
    });

    // Add a click event on various child elements to close the parent modal
    (document.querySelectorAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button') || []).forEach(function ($close) {
        var $target = $close.closest('.modal');

        $close.addEventListener('click', function () {
            closeModal($target);
        });
    });

    // Add a keyboard event to close all modals
    document.addEventListener('keydown', function (event) {
        var e = event || window.event;

        if (e.keyCode === 27) {
            // Escape key
            closeAllModals();
        }
    });
});
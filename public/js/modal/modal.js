document.addEventListener('DOMContentLoaded', function () {
    // Functions to open and close a modal
    function openModal($el) {
        $el.classList.add('is-active');
    }

    function closeModal($el) {
        $el.classList.remove('is-active');
        //cerrar formulario para actualizar las criticidades
        var updateActionContainer = document.querySelector('#update-action-container');
        if (updateActionContainer !== null) updateActionContainer.style.display = 'none';

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
            if ($close.classList.contains('do-not-close') === false) {
                closeModal($target);
            }
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

    // DROPDOWNS CODE WITH CLICK EVENT
    function openDropdown($el) {
        if ($el.classList.contains('is-active')) {
            closeModal($el);
        } else {
            openModal($el);
        }
    }

    // Add a click evento on buttons to open specific dropdown
    (document.querySelectorAll('.js-dropdown-trigger') || []).forEach(function ($trigger) {
        var dropdown = $trigger.dataset.target;
        var target = document.getElementById(dropdown);

        $trigger.addEventListener('click', function (e) {
            e.preventDefault();
            openDropdown(target);
        });
    });

    // CHECKBOXES TO ALLOW OR DISALLOW FORM'S INPUT NAMES
    (document.querySelectorAll('.checks-for-name') || []).forEach(function ($trigger) {
        var input = $trigger.dataset.target;
        var target = document.getElementById(input);
        var name = $trigger.dataset.name;

        $trigger.addEventListener('change', function () {

            if ($trigger.getAttribute('name') === 'aux-radio-name') {
                target.disabled = false;
                if (!target.hasAttribute('name') && name !== 'disabled') {
                    target.setAttribute('name', name);
                    target.setAttribute('required', 'required');
                } else {
                    if ($trigger.dataset.name === 'disabled') {
                        target.removeAttribute('name');
                        target.disabled = true;
                    } else {
                        target.setAttribute('name', name);
                        target.setAttribute('required', 'required');
                    }
                }
            } else {
                if (!target.hasAttribute('name')) {
                    target.setAttribute('name', name);
                    target.setAttribute('required', 'required');
                } else {
                    target.removeAttribute('name');
                }
            }
        });
    });
});

function cleanInputs() {
    var inputs = document.querySelectorAll('.clean-input');

    inputs.forEach(function (input) {
        input.value = '';
    });
}
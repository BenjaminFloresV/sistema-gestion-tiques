function verifyRut(input_rut) {
    /*
    6.	Construir un algoritmo que nos permita ingresar nuestro número de Run y generar automáticamente nuestro dígito verificador (Rol único nacional).
    */

    var rut = input_rut.value;
    var rutParts = rut.split('-');
    //Validamos que el rut esté ingresado sin el dígito verifcador
    var isValid = void 0;

    if (!Number.isNaN(rutParts[0]) && rutParts[0].length >= 7) {
        isValid = true;
    }

    if (isValid) {

        rut = rutParts[0].split(''); // Con el método split separamos un string en base al parámetro ingresado y lo convertimos en un array.
        // Ejemplo, sin ingresamos rut sin dígito '20217260', al nosotros pasar como parámetro '' que es un string vacío lo que hace js es separar todos los char del string y los convierte en un array --> ['2','0', ... etc]

        // Ahora que nuestro valor ingresao es un array, podemos utilzar el método reverse para invertir el array.
        // (paso "a" de la guía)
        rut.reverse();

        // Ahora paso "b": Tome los números y vaya multiplicando cada uno de ellos por la siguiente serie de números: 2, 3, 4, 5, 6, 7… en ese orden. Volver a 2 en caso de llegar a 7.

        // Para ello delcaramos e inicializamos un array con todos los valores que multiplicarán a cada número
        // del rut ingresado. En este caso lo llamamos multipliers ( muliplicadores )
        var multipliers = [2, 3, 4, 5, 6, 7];
        var i = 0; // Establecemos un contador que nos ayudará de determinar si se ha llegao al número 7

        // Recorremos nuestro array 'rut' que contiene cada dígito de nuestro rut sin dígito verificador.
        rut.forEach(function (element, index) {
            /*
            Si i es mayor que 5 significa que ya se ha alcanzado el número 7 de nusetro array multipliers
            ya que 5 es el índice máximo de nuestro array. Si se cumple esa condición, reseteamos el contador
            a 0 para que vuelva a 2 el número que multiplicará a nuestro siguiente dígito de nuestro array 'rut'
            y seguimos así hasta terminar el recorrido.
            */
            if (i > 5) {
                i = 0;
            }
            /*
            Declaramos e inicializamos la variable 'numRut' por cada vuelta del ciclo la cual
            contendrá el valor de la multiplicación del dígito actual( element ) y el multiplicador
            actual ( multipliers[i] ).
            */
            rut[index] = element * multipliers[i]; // Reasignamos el valor resultante de la variable 'numRut' a la posición correspondiente de nuestro array 'rut'.
            i++; // Incrementamos el contador i de nuestro array multipliers
        });

        // Finalmente obtenemos un array que contendrá los valores de los dígitos multiplicados por los números indicados.


        // Paso "c": c.	Una vez que haya multiplicado cada uno de los números, sume los resultados obtenidos.
        // Utilizamos el método current de la misma forma en que lo utilizamos en el ejericio 2.
        var sumNumbers = rut.reduce(function (previous, current) {
            return previous + current;
        });

        // Paso "d": Divida, el número obtenido, por 11 y obtenga el resto de esa división
        var rest = sumNumbers % 11;

        // Paso "e": Al número 11, réstele el resto de la división anterior y ahora debemos analizar el número obtenido. Hay tres posibilidades:
        var finalNum = 11 - rest;
        var message = void 0; // Declaramos la variable que almacenará el mensaje dependiendo del resultado obtenido
        var digitoVerificador = void 0;
        switch (finalNum) {
            case 11:
                //message = 'Tu dígito verificador es: 0'
                digitoVerificador = 0;
                break;
            case 10:
                //message = 'Tu dígito verificador es: K';
                digitoVerificador = 'K';
                break;
            default:
                //message = `Tu dígito verificador es: ${finalNum}`;
                digitoVerificador = finalNum;
        }

        var isValidRut = void 0;
        isValidRut = parseInt(rutParts[1]) === parseInt(digitoVerificador);

        return isValidRut;
    }

    return false;
}

function validEmail(input) {
    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    return input.value.match(validRegex);
}

function validPhone(input) {
    return !Number.isNaN(input.value) && input.value.length === 9;
}

function validatePassword(isValid) {
    // timeout before a callback is called

    var timeout = void 0;
    // traversing the DOM and getting the input and span using their IDs

    var password = document.getElementById('PassEntry');
    var strengthBadge = document.getElementById('StrengthDisp');

    // The strong and weak password Regex pattern checker

    var strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})');
    var mediumPassword = new RegExp('((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))');

    function StrengthChecker(PasswordParameter) {
        // We then change the badge's color and text based on the password strength

        if (strongPassword.test(PasswordParameter)) {
            if (isValid.length < 1) {
                isValid.push(true);
            }

            strengthBadge.style.backgroundColor = "green";
            strengthBadge.textContent = 'Fuerte';
        } else if (mediumPassword.test(PasswordParameter)) {
            if (isValid.length === 1) {
                isValid.pop();
            }
            strengthBadge.style.backgroundColor = 'blue';
            strengthBadge.textContent = 'Mediana';
        } else {
            if (isValid.length === 1) {
                isValid.pop();
            }
            strengthBadge.style.backgroundColor = 'red';
            strengthBadge.textContent = 'Débil';
        }
    }

    // Adding an input event listener when a user types to the  password input

    password.addEventListener("input", function () {

        //The badge is hidden by default, so we show it

        strengthBadge.style.display = 'block';
        clearTimeout(timeout);

        //We then call the StrengChecker function as a callback then pass the typed password to it

        timeout = setTimeout(function () {
            return StrengthChecker(password.value);
        }, 200);

        //Incase a user clears the text, the badge is hidden again

        if (password.value.length !== 0) {
            strengthBadge.style.display !== 'block';
        } else {
            strengthBadge.style.display = 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    var buttons = document.querySelectorAll('.rut-btn-verify') || [];
    buttons.forEach(function (button) {
        var target = button.dataset.target;
        var rutInput = document.getElementById(target);

        button.addEventListener('click', function (e) {
            var ningunoOption = document.getElementById('ninguno');
            if (ningunoOption !== null) {
                if (!ningunoOption.checked) {
                    e.preventDefault();
                } else {
                    return undefined;
                }
            }
            e.preventDefault();
            var isValid = verifyRut(rutInput);

            if (isValid) {
                var targetForm = rutInput.dataset.form;

                var isValidEmail = void 0;
                var isValidPhone = void 0;
                var isOneEmpty = void 0;
                (document.querySelectorAll('.email-inputs') || []).forEach(function (input) {
                    isValidEmail = !!validEmail(input);
                });

                (document.querySelectorAll('.phone-inputs') || []).forEach(function (input) {
                    isValidPhone = !!validPhone(input);
                });

                (document.querySelectorAll('.prev-input') || []).forEach(function (input) {

                    if (input.value === null || input.value === '') {
                        isOneEmpty = true;
                    }
                });

                if (isValidEmail === undefined && isValidPhone === undefined && isOneEmpty === undefined) {
                    document.getElementById(targetForm).submit();
                } else if (isValidEmail && isValidPhone && !isOneEmpty) {
                    document.getElementById(targetForm).submit();
                } else if (isValidEmail && !isOneEmpty) {
                    document.getElementById(targetForm).submit();
                } else {
                    var messages = '';
                    if (!isValidEmail && isValidEmail !== undefined) messages += '<p class="is-text has-text-danger">Email inválido</p>';
                    if (!isValidPhone && isValidPhone !== undefined) messages += '<p class="is-text has-text-danger">Teléfono inválido</p>';
                    if (isOneEmpty) messages += '<p class="is-text has-text-danger">Faltan campos por completar</p>';
                    document.getElementById('error').innerHTML = messages;
                }
            } else {
                document.getElementById('error').innerText = '*Rut inválido*';
            }
        });
    });
});
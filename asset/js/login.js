//se captura el boton
const ingresar = document.getElementById('loginButton');
//se captura el boton del icono de la contraseña
const Bicon = document.getElementById('B-icon');
//con esta funcion, cuando haga click al icono se mostrara la contraseña
Bicon.addEventListener('click', function () {

    const icon = document.getElementById('eyeIcon');
    const password = document.getElementById('password');

    if (password.type == 'password' && icon.classList.contains('fa-eye')) {

        password.type = 'text';
        icon.classList.replace("fa-eye", "fa-eye-slash");

    } else {

        password.type = 'password';
        icon.classList.replace("fa-eye-slash", "fa-eye");

    }
});
//si si ejecuta el evento click en el boton, ejecuta una funcion
ingresar.addEventListener('click', function () {
    //se capturan los inputs del login y se guardan en constantes
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const csrf_token = document.getElementById('csrf_token').value;
    //hace un fetch al controlador del login
    fetch('../controller/controllerlogin.php', {
        method: 'POST', //define el metodo HTTP que el controlador debe esperar
        headers: { //define que la peticion es tipo json
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ //el body tipo json con las credenciales para validar el usuario con el controlador
            username: username,
            password: password,
            csrf_token: csrf_token
        })
    }).then(response => response.json())
        .then(data => { //
            if (data.status == 'success') {
                Swal.fire({ 
                    title: "!Has iniciado sesión correctamente!",
                    icon: 'success',
                    theme: 'dark',
                    showConfirmButton: false,
                    timer: 1000
                });
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: data.message,
                    text: '!',
                    theme: 'dark',
                    timer: 1500,
                    showConfirmButton: false,
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: "error",
                title: "¡Ha ocurrido un error!",
                theme: 'dark',
                timer: 1500,
                showConfirmButton: false,
            });
        });
});
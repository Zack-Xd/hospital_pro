const username = document.getElementById('username').value;
const password = document.getElementById('password').value;
const csrfToken = document.getElementById('csrf_token').value;

const ingresar = document.getElementById('loginButton');

ingresar.addEventListener('click', function () {

    if(username === '' || password === '') {
        Swal.fire({
            icon: "error",
            title: "¡Campos vacíos!",
            text: "Por favor, complete todos los campos.",
            theme: 'dark',
            timer: 1500,
            showConfirmButton: false,
        }); 
    }

    fetch('../../controllerlogin.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            username: username,
            password: password,
            csrf_token: csrfToken
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: "!Has iniciado sesión correctamente!",
                    icon: 'success',
                    theme: 'dark',
                    showConfirmButton: false,
                    timer: 1000
                });
                setTimeout(() => {
                    window.location.href = '../pages/dashboard.php';
                }, 1000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Parece que algo salió mal",
                    text: `${respuesta.mensaje}`,
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
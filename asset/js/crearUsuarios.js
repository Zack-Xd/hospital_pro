const ingresar = document.getElementById('btnCrear');


ingresar.addEventListener('click', function () {
    const rol = document.getElementById('rol').value;
    const nombre_completo = document.getElementById('nombre_completo').value;
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    fetch('../../controller/registrarUsuario.php',{
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        rol: rol,
        nombre_completo: nombre_completo,
        username: username,
        password: password
    })
    }) .then(response => response.json())
    .then(data => {
        if (data.status == 'success') {
                Swal.fire({ 
                    title: "!Guardado!",
                    text: "El usuario ha sido creado correctamente.", 
                    icon: 'success',
                    theme: 'dark',
                    showConfirmButton: false,
                    timer: 1000
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data.message,
                    theme: 'dark',
                    timer: 1500,
                    showConfirmButton: false,
                });
            }

    }) .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: "error",
                title: "¡Ha ocurrido un error en el servidor!",
                theme: 'dark',
                timer: 1500,
                showConfirmButton: false,
            });
        });
})

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
function agregar(ID_libro) {
    fetch('agregar_carrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            ID_libro: ID_libro
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.success) {
            alert('Libro agregado al carrito');
            document.getElementById('contador').textContent = data.contador;
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


function agregarAlCarrito() {
    fetch('ver_carrito.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('contador').textContent = data.count; 
        })
        .catch(error => {
            console.error('Error al obtener el contador del carrito:', error);
        });
}

document.addEventListener('DOMContentLoaded', agregarAlCarrito);


function seguridad(){
  document.getElementById('registroForm').addEventListener('submit', function(e) {
    var password = document.getElementById('password').value;
    var confirmar = document.getElementById('confirmar_password').value;
    
    var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    
    if (password !== confirmar) {
      e.preventDefault();
      alert('Las contraseñas no coinciden');
    } 
    else if (!passwordRegex.test(password)) {
      e.preventDefault();
      alert('La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, una minúscula, un número y un carácter especial.');
    }
  });
}

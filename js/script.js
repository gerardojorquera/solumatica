// 1. Inicializar EmailJS con tu llave pública
emailjs.init(
  {
    publicKey: "77koF9BcQy3u4KDdk",
  },
  "https://api.emailjs.com" // <-- Esto fuerza al script local a apuntar al servidor correcto
);

// 2. Escuchar el envío del formulario
/*document.getElementById('contact-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita que la página se recargue */
function onSubmit(token) {
    alert("¡Google me llamó y el token es: " + token);
    
    const subject = document.getElementById('subject').value;
    const name = document.getElementById('user_name').value;
    const email = document.getElementById('user_email').value;
    const message = document.getElementById('user_message').value;

    // alert(subject + " // " + name + " // " + email + " // " + message);
    // 3. Recolectar los datos escritos por el usuario
    const datosFormulario = {
        title: "Solumática - Formulario Web de contacto: " + subject,
        //from_name: document.getElementById('user_name').value,
        //user_email: document.getElementById('user_email').value,
        name: name,
        reply_to: email,
        message: message
    };
    // console.log("Datos del formulario:", datosFormulario);

    // 4. Enviar el correo usando EmailJS
    // emailjs.send("TU_SERVICE_ID", "TU_TEMPLATE_ID", datosFormulario)
    emailjs.send("service_payxvxb", "template_b56fnaa", datosFormulario)
        .then(function(response) {
            // alert("¡Correo enviado con éxito!");
            document.getElementById('success').innerHTML = "<div class='alert alert-success'>¡Correo enviado con éxito!</div>";
            // Limpia el formulario
            document.getElementById('contact-form').reset();
        }, function(error) {
            // alert("Hubo un error al enviar el mensaje. Inténtalo de nuevo.");
            document.getElementById('success').innerHTML = "<div class='alert alert-danger'>Hubo un error al enviar el mensaje. Inténtalo de nuevo.</div>";
            console.error("Detalle del error:", error);
        });
//});
    }
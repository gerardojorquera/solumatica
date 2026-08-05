// 1. Inicializar EmailJS con tu llave pública
emailjs.init(
  {
    publicKey: "77koF9BcQy3u4KDdk",
  },
  "https://api.emailjs.com" 
);

// 2. Función que se ejecuta tras validar el reCAPTCHA
function onSubmit(token) {
    const btnEnviar = document.getElementById('btnEnviar');
    const contenedorAlerta = document.getElementById('success-message');
    
    // Deshabilita el botón para evitar múltiples envíos y cambia el texto
    btnEnviar.disabled = true;
    btnEnviar.innerText = "Enviando mensaje...";

    // 3. Recolectar los datos escritos por el usuario
    const subject = document.getElementById('subject').value;
    const name = document.getElementById('user_name').value;
    const email = document.getElementById('user_email').value;
    const message = document.getElementById('user_message').value;

    // Validación de seguridad por si saltan el required del HTML
    if (!name.trim() || !email.trim() || !message.trim()) {
        contenedorAlerta.innerHTML = "<div class='alert alert-danger my-3'>Debe ingresar todos los campos requeridos.</div>";
        btnEnviar.disabled = false;
        btnEnviar.innerText = "Enviar Mensaje de Cotización";
        return;
    }

    const datosFormulario = {
        title: "Solumática - Formulario Web de contacto: " + subject,
        name: name,
        reply_to: email,
        message: message
    };

    // 4. Enviar el correo usando EmailJS
    emailjs.send("service_payxvxb", "template_b56fnaa", datosFormulario)
        .then(function(response) {
            contenedorAlerta.innerHTML = "<div class='alert alert-success my-3'>¡Tu mensaje ha sido enviado con éxito! Nos contactaremos a la brevedad.</div>";
            
            // Limpia el formulario usando el ID correcto del nuevo HTML
            document.getElementById('form-contacto').reset();
            
            // Reinicia el reCAPTCHA visualmente para un próximo envío
            if (typeof grecaptcha !== 'undefined') {
                grecaptcha.reset();
            }
            
            // Reactiva el botón a su estado original
            btnEnviar.disabled = false;
            btnEnviar.innerText = "Enviar Mensaje de Cotización";
            
        }, function(error) {
            contenedorAlerta.innerHTML = "<div class='alert alert-danger my-3'>Hubo un error al enviar el mensaje. Inténtalo de nuevo por favor.</div>";
            
            // Reactiva el botón para permitir reintento
            btnEnviar.disabled = false;
            btnEnviar.innerText = "Enviar Mensaje de Cotización";
        });
}
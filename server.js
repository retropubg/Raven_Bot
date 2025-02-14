// server.js

const fetch = require('node-fetch');

// Aquí va la lógica para inicializar tu bot o servidor (por ejemplo, Express, bot framework, etc.)
console.log("Servidor o bot iniciado");

// URL para mantener el bot activo (puedes usar la URL de tu aplicación en Railway)
const url = 'https://ravenbot-production.up.railway.app'; // Asegúrate de poner la URL correcta

// Intervalo en milisegundos (5 minutos)
const intervalo = 5 * 60 * 1000;

// Función para enviar peticiones y mantener el bot activo
function mantenerActivo() {
  setInterval(() => {
    fetch(url)
      .then(response => {
        if (response.ok) {
          console.log('Solicitud exitosa para mantener el bot activo');
        } else {
          console.log('Error en la solicitud de keep-alive');
        }
      })
      .catch(error => {
        console.error('Error al hacer la solicitud: ', error);
      });
  }, intervalo);
}

// Iniciar el keep-alive
mantenerActivo();

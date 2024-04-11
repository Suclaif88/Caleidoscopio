var openBtn = document.getElementById("openBtn");
var closeBtn = document.getElementById("closeBtn");
var popupForm = document.getElementById("popupForm");
var sendBtn = document.getElementById("sendBtn"); // Agregar un ID al botón de enviar dentro del formulario emergente

// Función para abrir la ventana emergente
openBtn.addEventListener("click", function(event) {
  popupForm.style.display = "block";
});

// Función para cerrar la ventana emergente
closeBtn.addEventListener("click", function(event) {
  popupForm.style.display = "none";
});

// Evitar que el clic en la ventana emergente la cierre
popupForm.addEventListener("click", function(event) {
  event.stopPropagation();
});

// Función para enviar los datos a la base de datos
sendBtn.addEventListener("click", function(event) {
  // Aquí colocarías el código para enviar los datos a la base de datos
  // Por ejemplo, podrías usar AJAX para enviarlos sin recargar la página
  console.log("Datos enviados a la base de datos");
  // Una vez que se hayan enviado los datos, puedes cerrar la ventana emergente si es necesario
  popupForm.style.display = "none";
});

// Función para cerrar la ventana emergente si se hace clic fuera de ella
window.addEventListener("click", function(event) {
  if (event.target !== popupForm && event.target !== openBtn) {
    popupForm.style.display = "none";
  }
});

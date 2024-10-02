const API = "https://aniversariohero.com/her/logica/action.php";
// const API = "http://localhost/hero/logica/action.php";

const formularioItem = document.getElementById("formcontainer");
const fileInput = document.getElementById("facturaimage");
const imgFactura = document.getElementById("imgFactura");
const fileFactura = document.getElementById("fileFactura");

fileInput.addEventListener("change", changeInput);
formularioItem.addEventListener("submit", registrar);
function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}
function changeInput() {
  fileFactura.innerHTML = "";
  imgFactura.style.display = "none";
  if (fileInput.files.length > 0) {
    fileFactura.innerHTML = `<p class="text-white font-semibold text-sm bg-hero-red rounded text-white py-2 px-12">${fileInput.files[0].name}</p>`;
  }
}

function procesarImagen(file) {
  fileFactura.innerHTML = ""; // Limpiar errores anteriores

  if (!file) {
    fileFactura.innerHTML += `<p class="text-white  font-semibold text-sm">Por favor, selecciona una imagen de factura.</p>`;
    return false; // Retorna false si no se seleccionó un archivo
  } else {
    // Mostrar el nombre del archivo seleccionado
    fileFactura.innerHTML += `<p class="text-white font-semibold text-sm bg-hero-red rounded text-white py-2 px-12">${file.name}</p>`;
    return true; // Retorna true si el archivo es válido
  }
}
function registrar(event) {
  event.preventDefault();
  const nombre = document.getElementById("nombre").value.trim();
  const email = document.getElementById("email").value.trim();
  const ciudad = document.getElementById("ciudad").value.trim();
  const cedula = document.getElementById("cedula").value.trim();
  const placa = document.getElementById("placa").value.trim();
  const telefono = document.getElementById("telefono").value.trim();

  const errorMessage = document.getElementById("errorMessage");
  errorMessage.innerHTML = "";

  if (nombre.length <= 1) {
    errorMessage.innerHTML += `<p class="text-white mt-3 font-semibold text-sm">Por favor, ingresa un nombre válido.</p>`;
  }
  if (!validateEmail(email)) {
    errorMessage.innerHTML += `<p class="text-white mt-3 font-semibold text-sm">Por favor, ingresa un email válido</p>`;
  }
  if (ciudad.length <= 1) {
    errorMessage.innerHTML += `<p class="text-white mt-3 font-semibold text-sm">Por favor, ingresa una ciudad válida</p>`;
  }
  if (!Number(cedula) || cedula.length < 4) {
    errorMessage.innerHTML += `<p class="text-white mt-3 font-semibold text-sm">Por favor, ingresa un número de cédula válido</p>`;
  }
  if (placa.length <= 3) {
    errorMessage.innerHTML += `<p class="text-white mt-3 font-semibold text-sm">Por favor, ingresa una placa válida</p>`;
  }
  console.log(telefono.length);
  if (!Number(telefono) || telefono.length != 10) {
    errorMessage.innerHTML += `<p class="text-white mt-3 font-semibold text-sm">Por favor, ingresa un número de teléfono válido</p>`;
  }

  if (!procesarImagen(fileInput.files[0])) {
    errorMessage.innerHTML += `<p class="text-white  font-semibold text-sm">Por favor, ingresa una factura válida.</p>`;
  }
  if (errorMessage.innerHTML === "") {
    sendFormulario(nombre, email, ciudad, cedula, placa, telefono);
  }
}
function sendFormulario(nombre, email, ciudad, cedula, placa, telefono) {
  const loader = `<span class="loader"></span>`;

  console.log("se ejecuta el registro");

  let formData = new FormData();
  formData.append("action", "registrar");
  formData.append("nombre", nombre);
  formData.append("email", email);
  formData.append("ciudad", ciudad);
  formData.append("cedula", cedula);
  formData.append("placa", placa);
  formData.append("telefono", telefono);
  const btnCargar = document.getElementById("btnCargar");

  if (fileInput.files.length > 0) {
    formData.append("foto", fileInput.files[0]);
  }

  btnCargar.disabled = true;
  btnCargar.classList.add("bg-neutral-400");
  btnCargar.innerHTML = loader;
  // Enviar la solicitud con fetch
  fetch(`${API}`, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text()) // Obtener el texto sin intentar convertirlo a JSON
    .then((text) => {
      try {
        const data = JSON.parse(text); // Intentar convertir a JSON manualmente
        console.log("Success: ", data);
        // // Mostrar un mensaje o redirigir si es necesario
        if (data.success) {
          localStorage.setItem("int", 0);
          localStorage.setItem("datpt", 0);
          const randomData1 = generateRandomData();
          const randomData2 = generateRandomData();
          const randomData3 = generateRandomData();
          location.href = `./juego?data=${randomData1}&i=${data.newId}&flow=${randomData2}&d=${cedula}&p=${randomData3}&e=${email}`;
        } else {
          Toastify({
            close: true,
            text: data.message,
            backgroundColor: "rgb(234 88 12)",

            duration: 3000,
          }).showToast();
          btnCargar.disabled = false;
          btnCargar.classList.remove("bg-neutral-400");
          btnCargar.innerHTML = `Enviar
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="#FF3333" fill-rule="evenodd" d="M10.271 5.575C8.967 4.501 7 5.43 7 7.12v9.762c0 1.69 1.967 2.618 3.271 1.544l5.927-4.881a2 2 0 0 0 0-3.088l-5.927-4.88Z" clip-rule="evenodd" />
                            </svg>`;
        }
      } catch (error) {
        console.error("Error al convertir a JSON: ", error);
        console.log("Respuesta recibida:", text); // Mostrar la respuesta en bruto
      }
    })
    .catch((error) => {
      console.error("Error: ", error);
    });
}
function generateRandomData(length = 50) {
  let result = "";
  const characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  const charactersLength = characters.length;
  let counter = 0;

  while (counter < length) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
    counter += 1;
  }

  return result;
}
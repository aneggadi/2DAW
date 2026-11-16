document.addEventListener("DOMContentLoaded", () => {
    const formulario = document.getElementById("formulario");

    formulario.addEventListener("submit", (evt) => {
        const errores = [];

        const nombre = document.getElementById("nombre").value.trim();
        const correo = document.getElementById("correo").value.trim();
        const telefono = document.getElementById("telefono").value.trim();
        const asunto = document.getElementById("asunto").value;
        const mensaje = document.getElementById("mensaje").value;
        const privacidad = document.getElementById("privacidad").checked;

        const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const regexTelefono = /^\d{9}$/;

        if (nombre === "") {
            errores.push("- El nombre es obligatorio y no puede contener solo espacios.");
        }

        if (!regexCorreo.test(correo)) {
            errores.push("- El correo electrónico no tiene un formato válido.");
        }

        if (!regexTelefono.test(telefono)) {
            errores.push("- El teléfono debe estar formado por exactamente 9 dígitos.");
        }

        if (asunto === "") {
            errores.push("- Debes seleccionar un asunto distinto del inicial.");
        }

        if (mensaje.trim() === "" || mensaje.length < 20) {
            errores.push("- El mensaje debe contener al menos 20 caracteres.");
        }

        if (!privacidad) {
            errores.push("- Debes aceptar la política de privacidad.");
        }

        if (errores.length > 0) {
            alert("Se han encontrado los siguientes errores:\n\n" + errores.join("\n"));
            evt.preventDefault();
        }
    });
});
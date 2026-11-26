class Reproductor {
    constructor(nombre, canciones = []) {
        this.nombre = nombre;
        this.canciones = canciones;
        this.cancionActual = 0;
        this.volumen = 50;
        this.reproduciendo = false;
    }

    reproducir() {
        if (this.canciones.length === 0) {
            console.log("No hay canciones en la lista.");
            return;
        }
        this.reproduciendo = true;
    }

    pausar() {
        this.reproduciendo = false;
    }

    siguienteCancion() {
        if (this.canciones.length === 0) return;

        this.cancionActual = (this.cancionActual + 1) % this.canciones.length;
    }

    cancionAnterior() {
        if (this.canciones.length === 0) return;

        this.cancionActual = (this.cancionActual - 1 + this.canciones.length) % this.canciones.length;
    }

    subirVolumen(cantidad) {
        if (cantidad <= 0) {
            console.log("Error: La cantidad debe ser positiva.");
            return;
        }
        this.volumen = Math.min(100, this.volumen + cantidad);
    }

    bajarVolumen(cantidad) {
        if (cantidad <= 0) {
            console.log("Error: La cantidad debe ser positiva.");
            return;
        }
        this.volumen = Math.max(0, this.volumen - cantidad);
    }

    mostrarEstado() {
        const tema = this.canciones.length > 0 ? this.canciones[this.cancionActual] : "Ninguna";
        console.log(`Reproductor: ${this.nombre} | Canción: ${tema} | Volumen: ${this.volumen}% | Reproduciendo: ${this.reproduciendo}`);
    }
}

// Pruebas Ejercicio 5
const mp3 = new Reproductor("Walkman", ["Canción A", "Canción B", "Canción C"]);
mp3.reproducir();
mp3.siguienteCancion();
mp3.subirVolumen(30);
mp3.mostrarEstado(); 
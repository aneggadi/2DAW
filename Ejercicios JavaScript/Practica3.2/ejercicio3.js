class Temporizador {
    constructor(nombre, duracionInicial) {
        this.nombre = nombre;
        this.duracionInicial = duracionInicial;
        this.tiempoRestante = duracionInicial;
        this.activo = false;
        this.finalizado = false;
    }

    iniciar() {
        if (this.tiempoRestante > 0) {
            this.activo = true;
            this.finalizado = false;
        }
    }

    pausar() {
        this.activo = false;
    }

    avanzar(segundos) {
        if (!this.activo) return;

        this.tiempoRestante -= segundos;
        if (this.tiempoRestante <= 0) {
            this.tiempoRestante = 0;
            this.activo = false;
            this.finalizado = true;
        }
    }

    reiniciar() {
        this.tiempoRestante = this.duracionInicial;
        this.activo = false;
        this.finalizado = false;
    }

    obtenerTiempoFormateado() {
        const segundos = this.tiempoRestante % 60;
        const minutos = (this.tiempoRestante - segundos) / 60;

        const minTexto = minutos < 10 ? "0" + minutos : minutos;
        const segTexto = segundos < 10 ? "0" + segundos : segundos;

        return `${minTexto}:${segTexto}`;
    }

    mostrarEstado() {
        let estado = "Detenido";
        if (this.finalizado) estado = "Finalizado";
        else if (this.activo) estado = "En marcha";

        console.log(`[${this.nombre}] Tiempo restante: ${this.obtenerTiempoFormateado()} | Estado: ${estado}`);
    }
}

// Pruebas
const temp = new Temporizador("Pomodoro", 125);
temp.iniciar();
temp.avanzar(65);
temp.mostrarEstado(); 
temp.avanzar(70);
temp.mostrarEstado(); 
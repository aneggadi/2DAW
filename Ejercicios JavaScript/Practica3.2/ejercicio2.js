class Alumno {
    constructor(nombre, asignatura) {
        this.nombre = nombre;
        this.asignatura = asignatura;
        this.notas = [];
        this.media = 0;
    }

    agregarNota(nota) {
        if (nota >= 0 && nota <= 10) {
            this.notas.push(nota);
            this.media = this.calcularMedia();
        } else {
            console.log("Error: La nota debe estar comprendida entre 0 y 10.");
        }
    }

    calcularMedia() {
        if (this.notas.length === 0) return 0;
        
        let suma = 0;
        for (let i = 0; i < this.notas.length; i++) {
            suma += this.notas[i];
        }
        return Number((suma / this.notas.length).toFixed(2));
    }

    calcularNotaMasAlta() {
        if (this.notas.length === 0) return 0;

        let notaAlta = this.notas[0];
        for (let i = 1; i < this.notas.length; i++) {
            if (this.notas[i] > notaAlta) {
                notaAlta = this.notas[i];
            }
        }
        return notaAlta;
    }

    calcularNotaMasBaja() {
        if (this.notas.length === 0) return 0;

        let notaBaja = this.notas[0];
        for (let i = 1; i < this.notas.length; i++) {
            if (this.notas[i] < notaBaja) {
                notaBaja = this.notas[i];
            }
        }
        return notaBaja;
    }

    estaAprobado() {
        return this.media >= 5;
    }

    mostrarInformacion() {
        console.log(`Alumno: ${this.nombre} | Asignatura: ${this.asignatura}`);
        console.log(`Notas: [${this.notas.join(", ")}] | Media: ${this.media}`);
        console.log(`Nota más alta: ${this.calcularNotaMasAlta()} | Nota más baja: ${this.calcularNotaMasBaja()}`);
        console.log(`Estado: ${this.estaAprobado() ? "Aprobado" : "Suspenso"}`);
    }
}

// Pruebas
const alumno1 = new Alumno("Lucía", "Programación");
alumno1.agregarNota(7.5);
alumno1.agregarNota(4);
alumno1.agregarNota(8.5);
alumno1.mostrarInformacion();
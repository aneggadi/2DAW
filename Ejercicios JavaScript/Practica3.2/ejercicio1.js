class CuentaBancaria {
    constructor(titular) {
        this.titular = titular;
        this.saldo = 100;
    }

    ingresar(cantidad) {
        if (cantidad > 0) {
            this.saldo += cantidad;
        }
    }

    retirar(cantidad) {
        if (cantidad <= this.saldo) {
            this.saldo -= cantidad;
        } else {
            console.log(`Error: ${this.titular} no tiene saldo suficiente para retirar ${cantidad}€.`);
        }
    }

    mostrarSaldo() {
        console.log(`Titular: ${this.titular} | Saldo actual: ${this.saldo}€`);
    }
}

// Pruebas Ejercicio 1
const cuenta1 = new CuentaBancaria("Juan");
const cuenta2 = new CuentaBancaria("Álvaro");

cuenta1.ingresar(100);
cuenta1.retirar(50);
cuenta1.mostrarSaldo(); // 150€

cuenta2.ingresar(10000);
cuenta2.retirar(2890);
cuenta2.mostrarSaldo(); // 7210€

cuenta1.retirar(500); // Error: saldo insuficiente
cuenta1.mostrarSaldo(); // Sigue en 150€ (no afectada por cuenta2)
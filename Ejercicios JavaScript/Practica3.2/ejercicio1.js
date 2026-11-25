    class CuentaBancaria{
        constructor(titular){
            this.titular = titular
            this.saldo = 100
        }
        ingresar(cantidad){
            this.saldo += cantidad
        }
        retirar(cantidad){
            this.saldo -= cantidad
        }
        mostrarsaldo(){
            console.log(this.saldo)
        }
    }

        let cliente1 = new CuentaBancaria("Juan")
        cliente1.ingresar(100)
        cliente1.mostrarsaldo()
        cliente1.retirar(50)
        cliente1.mostrarsaldo()
        
        let cliente2 = new CuentaBancaria("Alvaro")
        cliente2.ingresar(10000)
        cliente2.mostrarsaldo()
        cliente2.retirar(2890)
        cliente2.mostrarsaldo()


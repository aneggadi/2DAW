class ConversorTemperatura {
    static temperaturaMinima = -273.15;

    static esTemperaturaValida(celsius) {
        return celsius >= this.temperaturaMinima;
    }

    static celsiusAFahrenheit(celsius) {
        if (!this.esTemperaturaValida(celsius)) {
            console.log("Error: Temperatura inferior al cero absoluto (-273.15 °C).");
            return null;
        }
        return (celsius * 9 / 5) + 32;
    }

    static fahrenheitACelsius(fahrenheit) {
        const celsius = (fahrenheit - 32) * 5 / 9;
        if (!this.esTemperaturaValida(celsius)) {
            console.log("Error: Temperatura inferior al cero absoluto (-273.15 °C).");
            return null;
        }
        return celsius;
    }

    static celsiusAKelvin(celsius) {
        if (!this.esTemperaturaValida(celsius)) {
            console.log("Error: Temperatura inferior al cero absoluto (-273.15 °C).");
            return null;
        }
        return celsius + 273.15;
    }
}

// Pruebas Ejercicio 4
console.log(ConversorTemperatura.celsiusAFahrenheit(25)); // 77
console.log(ConversorTemperatura.fahrenheitACelsius(77)); // 25
console.log(ConversorTemperatura.celsiusAKelvin(0)); // 273.15
console.log(ConversorTemperatura.celsiusAKelvin(-300)); // Error
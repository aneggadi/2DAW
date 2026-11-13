"""Ejercicio 6 Medición de latencia
Una prueba de red guarda la latencia en milisegundos. El valor None significa que la prueba todavía no
se ha realizado, mientras que 0 es un resultado válido para una conexión local. Escribe un programa que
distinga None, 0 y cualquier valor positivo. Prueba el programa asignando manualmente los tres tipos de
valores a la variable latencia."""

latencia = input("Ingrese la latencia en milisegundos: ")
if latencia:
    print("La latencia es valida")
    latencia = int(latencia)
    if (latencia >= 0):
        print(f"La latencia es: {latencia} ")
    else:
        print("No es numero positvo")
else:
    print("Latencia es None")


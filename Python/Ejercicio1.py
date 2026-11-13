bateria = int(input("Ingrese el porentaje de bateria (0-100): "))

if( bateria < 20):
    print(f"{bateria}Bateria baja porfavor conecte el cargador.")
else:
    print(f"{bateria}% de bateria")
edad = int(input("Ingrese su edad: "))

if 0 < edad < 14:
    print("Tu cuota es de 0 euros")
elif 14 <= edad <= 25:
    print("Tu cuota es de 5 euros")
elif 25 < edad < 64:
    print("Tu cuota es de 8 euros")
elif edad > 65:
    print("Tu cuota es de 3 euros")
else: print("Canitdad introducida no valida")



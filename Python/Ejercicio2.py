precio_pedido = int(input("Ingrese el precio de su pedido: "))

if precio_pedido < 60:
    precio_pedido += 4.95
    print(f"El precio final del pedido es: {precio_pedido}")
else:
    print(f"El precio final del pedido es: {precio_pedido}")
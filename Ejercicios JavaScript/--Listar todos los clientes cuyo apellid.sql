--Listar todos los clientes cuyo apellido empiece con "S", ordenados alfabéticamente.

select * from clientes where apellido like 'S%';

--Mostrar el número total de películas registradas en la tabla film.

select count(*) as total_peliculas from film;

--Listar las 10 películas con mayor tarifa de alquiler (rental_rate), mostrando título y tarifa.

select title, rental_rate from film order by rental_rate desc limit 10;



--Mostrar el total recaudado (SUM) por cada tienda (store_id) en la tabla payment.

select store_id, sum(amount) as total_recaudado from payment group by store_id;

--Listar los nombres de las 5 categorías con más películas asociadas.

select c.name from category c
join film_category fc on c.category_id = fc.category_id
group by c.category_id, c.name
order by count(fc.film_id) desc limit 5;

--Mostrar cada cliente con el número total de alquileres que ha realizado, ordenado de mayor a menor.

select c.first_name, c.last_name, count(r.rental_id) as total_alquileres
from customer c
join rental r on c.customer_id = r.customer_id
group by c.customer_id, c.first_name, c.last_name
order by total_alquileres desc;

--Obtener el promedio de duración (length) de las películas por cada categoría, solo categorías con promedio > 120 minutos.

select c.name, avg(f.length) as promedio_duracion
from category c
join film_category fc on c.category_id = fc.category_id
join film f on fc.film_id = f.film_id
group by c.category_id, c.name
having avg(f.length) > 120;





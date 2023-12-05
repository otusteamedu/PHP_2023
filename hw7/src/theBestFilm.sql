select film.id, film.name, sum(ticketprice.price*film.long) as sum_price
from ticketsale
left join showfilm on showfilm.id=ticketsale.id_show_film
left join ticketprice on
(ticketprice.id_show=showfilm.id_show and showfilm.id_room =ticketprice.id_room
and ticketsale.line=ticketprice.line AND extract(dow from showfilm.data::timestamp) = ticketprice.weekday)
left join film on film.id=showfilm.id_film
GROUP BY film.id
ORDER BY sum_price DESC
LIMIT 1


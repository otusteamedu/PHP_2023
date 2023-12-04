select Film.ID, Film.NAME, sum(TicketPrice.PRICE) as sum_price
from TicketSale
left join ShowFilm on ShowFilm.ID=TicketSale.ID_SHOW_FILM
left join Show on ShowFilm.ID_SHOW=SHOW.ID
left join TicketPrice on
(TicketPrice.ID_SHOW=Show.ID and ShowFilm.ID_ROOM=TicketPrice.ID_ROOM
and TicketSale.LINE=TicketPrice.LINE AND extract(dow from ShowFilm.DATA::timestamp) = TicketPrice.WEEKDAY)
left join Film on Film.ID=ShowFilm.ID_FILM
GROUP BY Film.ID
ORDER BY sum_price DESC
LIMIT 1


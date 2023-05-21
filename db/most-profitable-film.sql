select Movies.name, sum(Tickets.price) as box_office
from Ticket_payments
left join Tickets on Tickets.id = Ticket_payments.ticket_id
left join Sessions on Tickets.session_id = Sessions.id
left join Movies on Sessions.movie_id = Movies.id
group by Movies.name
order by box_office DESC
limit 1
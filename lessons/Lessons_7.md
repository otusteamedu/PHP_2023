# Сущности:
Cinemas - информация о кинотеатрах.
Halls - залы внутри каждого кинотеатра.
Movies - фильмы, которые идут в кинотеатре.
Sessions - сеансы, на которые клиенты могут купить билеты.
Seats - места в зале.
Tickets - билеты, приобретенные на сеансы.
Prices - стоимость билетов.


# Схемы с данными
- [cinemas.sql](..%2Fdeployment%2Fdb%2Fdump%2Fcinemas.sql)
- [halls.sql](..%2Fdeployment%2Fdb%2Fdump%2Fhalls.sql)
- [movies.sql](..%2Fdeployment%2Fdb%2Fdump%2Fmovies.sql)
- [price_categories.sql](..%2Fdeployment%2Fdb%2Fdump%2Fprice_categories.sql)
- [prices.sql](..%2Fdeployment%2Fdb%2Fdump%2Fprices.sql)
- [seats.sql](..%2Fdeployment%2Fdb%2Fdump%2Fseats.sql)
- [sessions.sql](..%2Fdeployment%2Fdb%2Fdump%2Fsessions.sql)
- [tickets.sql](..%2Fdeployment%2Fdb%2Fdump%2Ftickets.sql)
- [session_price_categories.sql](..%2Fdeployment%2Fdb%2Fdump%2Fsession_price_categories.sql)

![img_1.png](..%2Fimages%2Fimg_1.png)


# Запрос самый прибыльный фильм
```sql
SELECT 
    movies.title,
    SUM(prices.amount) AS total_revenue
FROM 
    tickets
INNER JOIN sessions ON tickets.session_id = sessions.id
INNER JOIN movies ON sessions.movie_id = movies.id
INNER JOIN seats ON tickets.seat_id = seats.id
INNER JOIN price_categories ON seats.price_category_id = price_categories.id
INNER JOIN prices ON price_categories.id = prices.category_id
GROUP BY 
    movies.id, movies.title
ORDER BY 
    total_revenue DESC
LIMIT 1;

```


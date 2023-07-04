SELECT MIN(quantity) AS min_price, MAX(quantity) AS max_price
FROM ticket_sales
WHERE movie_id = <movie_id>
  AND sale_date = <sale_date>;
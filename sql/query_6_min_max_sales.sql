SELECT MIN(quantity) AS min_price, MAX(quantity) AS max_price
FROM ticket_sales
WHERE movie_id = 1
  AND sale_date = '2023-07-01';
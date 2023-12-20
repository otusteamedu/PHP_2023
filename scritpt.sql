SELECT
    M.MovieID,
    M.Title,
    SUM(T.Price) AS TotalRevenue
FROM
    Movies M
        JOIN
    Showtimes S ON M.MovieID = S.MovieID
        JOIN
    Tickets T ON S.ShowtimeID = T.ShowtimeID
GROUP BY
    M.MovieID, M.Title
ORDER BY
    TotalRevenue DESC
    LIMIT 1;
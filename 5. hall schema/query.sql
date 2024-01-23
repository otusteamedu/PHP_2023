SELECT a.seat_num, a.row, a.col,
  CASE
    WHEN c.id IS NOT NULL THEN 'BUSY'
    ELSE 'FREE'
  END as seat_type
FROM halls_seat_schema a
JOIN seances b on b.hall_id=a.hall_id
LEFT JOIN seance_tikets c ON c.seance_id=b.id and c.seat_num=a.seat_num
where b.id=3

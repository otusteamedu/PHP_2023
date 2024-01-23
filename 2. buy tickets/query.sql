SELECT COUNT(st.ID)  as count_tickets
FROM
	seance_tikets AS st
	INNER JOIN seances AS s ON s.ID = st.seance_id 
WHERE
	s."date" >= '2023-12-01' 
	AND s.DATE <= '2023-12-07'
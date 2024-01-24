DROP PROCEDURE hall_seats(integer);
CREATE or REPLACE PROCEDURE hall_seats(sid integer)
LANGUAGE plpgsql
AS $$
declare 
	ticket tickets;
	rows integer := 0;
	row_i integer;
	sql_query text;
	s text[];
begin		
	
	rows := (select h.rows from seances s join halls h on h.id = s.hall_id where s.id = sid);
	
	drop table if exists hall_scheme;
	
	CREATE TEMPORARY TABLE hall_scheme(
	   seat_1 boolean,
	   seat_2 boolean,
	   seat_3 boolean,
	   seat_4 boolean,
	   seat_5 boolean,
	   seat_6 boolean,
	   seat_7 boolean,
	   seat_8 boolean,
	   seat_9 boolean,
	   seat_10 boolean,
	   seat_11 boolean,
	   seat_12 boolean,
	   seat_13 boolean,
	   seat_14 boolean,
	   seat_15 boolean
	);
	FOR row_i IN 1..rows loop
		s := array[]::text[];
		sql_query := 'insert into hall_scheme (seat_1, seat_2, seat_3, seat_4, seat_5, seat_6, seat_7, seat_8, seat_9, seat_10, seat_11, seat_12, seat_13, seat_14, seat_15) values(';
	
		FOR ticket in
	  		select * from tickets t where t.seance_id = 1 and t.row = row_i
	   	LOOP
	   		s := array_append(s, case when ticket.status in ('paid', 'booked') then 'true' else 'false' end);
	   	END LOOP;	  
	   	sql_query := sql_query || array_to_string(s, ',') || ');';
	   	execute sql_query;
   
end loop;

end;
$$;

call hall_seats(2);
select ROW_NUMBER() over() as row, * from hall_scheme;


/**
row|seat_1|seat_2|seat_3|seat_4|seat_5|seat_6|seat_7|seat_8|seat_9|seat_10|seat_11|seat_12|seat_13|seat_14|seat_15|
---+------+------+------+------+------+------+------+------+------+-------+-------+-------+-------+-------+-------+
  1|true  |true  |true  |true  |true  |true  |true  |true  |true  |true   |true   |true   |true   |false  |false  |
  2|true  |true  |true  |true  |true  |true  |true  |true  |false |true   |true   |true   |true   |true   |true   |
  3|false |true  |true  |true  |true  |true  |true  |false |true  |true   |true   |true   |true   |true   |false  |
  4|true  |true  |false |true  |true  |true  |true  |true  |true  |true   |true   |true   |false  |false  |true   |
  5|true  |true  |true  |true  |true  |true  |true  |true  |false |true   |true   |false  |true   |true   |false  |
  6|true  |true  |false |true  |false |false |true  |true  |true  |false  |true   |true   |false  |true   |true   |
  7|true  |true  |true  |true  |true  |true  |false |true  |true  |false  |true   |false  |true   |false  |true   |
  8|true  |true  |true  |true  |false |true  |false |true  |true  |false  |false  |true   |true   |true   |true   |
  9|true  |false |true  |true  |true  |true  |true  |true  |true  |false  |true   |false  |true   |true   |true   |
 10|true  |true  |true  |true  |true  |false |true  |true  |true  |true   |false  |true   |true   |true   |true   |
 11|true  |true  |false |true  |true  |false |true  |true  |true  |true   |true   |true   |false  |true   |true   |
*/
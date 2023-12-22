-- 1
explain select
            f.name as "фильм",
            (((CAST((sp.attendance_rate + d.attendance_rate) AS FLOAT) / 1000)+cnf.coefficient)*f.price)::int AS "цена",
                (sess."text" || '_' || h.name || '::' || sp.seat_place || '~' || sp.name) AS "сеанс",
            s.name as "статус",
            t.showen_date as "дата показа",
            t.purchasen_date::date as "дата брони/продажи"
        from
            (
                select
                    tck.id as id,
                    tck.showen_date as showen_date,
                    tck.purchasen_date as purchasen_date,
                    tck.demonstration_id as demonstration_id,
                    tck.status_id as status_id,
                    tck.position_id as position_id
                from ticket tck where tck.showen_date=now()::date
            ) t
                left join demonstration d
                          on t.demonstration_id = d.id
                left join dict_hall h
                          on d.hall_id = h.id --
                left join dict_session sess
                          on d.session_id  = sess.id
                left join film f
                          on d.film_id  = f.id
                left join dict_status s
                          on t.status_id = s.id
                left join seating_position sp
                          on t.position_id = sp.id
                left join "_config" AS cnf ON cnf.id = 1;

/*
Nested Loop Left Join  (cost=365684.39..821932.09 rows=8469593 width=108)
  ->  Merge Right Join  (cost=365684.39..377240.18 rows=769963 width=188)
        Merge Cond: (s.id = tck.status_id)
        ->  Sort  (cost=88.17..91.35 rows=1270 width=36)
              Sort Key: s.id
              ->  Seq Scan on dict_status s  (cost=0.00..22.70 rows=1270 width=36)
        ->  Sort  (cost=365596.22..365899.35 rows=121254 width=160)
              Sort Key: tck.status_id
              ->  Hash Left Join  (cost=183003.92..355357.73 rows=121254 width=160)
                    Hash Cond: (d.session_id = sess.id)
                    ->  Hash Left Join  (cost=182965.34..351027.55 rows=19095 width=132)
                          Hash Cond: (d.hall_id = h.id)
                          ->  Hash Left Join  (cost=182928.34..350314.17 rows=3183 width=104)
                                Hash Cond: (tck.position_id = sp.id)
                                ->  Gather  (cost=182895.39..350134.60 rows=883 width=68)
                                      Workers Planned: 2
                                      ->  Hash Left Join  (cost=181895.39..349046.30 rows=368 width=68)
                                            Hash Cond: (d.film_id = f.id)
                                            ->  Parallel Hash Left Join  (cost=181859.97..348957.55 rows=368 width=36)
                                                  Hash Cond: (tck.demonstration_id = d.id)
                                                  ->  Parallel Seq Scan on ticket tck  (cost=0.00..142672.29 rows=368 width=24)
                                                        Filter: (showen_date = (now())::date)
                                                  ->  Parallel Hash  (cost=105361.65..105361.65 rows=4166665 width=20)
                                                        ->  Parallel Seq Scan on demonstration d  (cost=0.00..105361.65 rows=4166665 width=20)
                                            ->  Hash  (cost=21.30..21.30 rows=1130 width=40)
                                                  ->  Seq Scan on film f  (cost=0.00..21.30 rows=1130 width=40)
                                ->  Hash  (cost=20.20..20.20 rows=1020 width=44)
                                      ->  Seq Scan on seating_position sp  (cost=0.00..20.20 rows=1020 width=44)
                          ->  Hash  (cost=22.00..22.00 rows=1200 width=36)
                                ->  Seq Scan on dict_hall h  (cost=0.00..22.00 rows=1200 width=36)
                    ->  Hash  (cost=22.70..22.70 rows=1270 width=36)
                          ->  Seq Scan on dict_session sess  (cost=0.00..22.70 rows=1270 width=36)
  ->  Materialize  (cost=0.00..38.30 rows=11 width=4)
        ->  Seq Scan on _config cnf  (cost=0.00..38.25 rows=11 width=4)
              Filter: (id = 1)
JIT:
  Functions: 59
  Options: Inlining true, Optimization true, Expressions true, Deforming true
*/

-- 2
explain select
            count(tck.id) as "кол-во проданных билетов"
        from ticket tck
        where tck.status_id=2
          and
            (
                (((now()::date - interval '1 week')::date) <= tck.purchasen_date)
	and
	(tck.purchasen_date <= (now()::date))
);

/*
Aggregate  (cost=205764.93..205764.94 rows=1 width=8)
  ->  Gather  (cost=1000.00..205764.93 rows=1 width=4)
        Workers Planned: 2
        ->  Parallel Seq Scan on ticket tck  (cost=0.00..204764.83 rows=1 width=4)
              Filter: ((status_id = 2) AND (purchasen_date <= (now())::date) AND ((((now())::date - '7 days'::interval))::date <= purchasen_date))
JIT:
  Functions: 6
  Options: Inlining false, Optimization false, Expressions true, Deforming true
*/


-- 3
explain select
            f.name as film_name,
            f.duration_in_minutes AS "(мин.)",
            t.price as "цена", --@FixMe
            (sess."text" || '_' || h.name || '::' || sp.seat_place) AS "сеанс",
            t.showen_date as "дата показа"
        from (select id, demonstration_id,status_id,position_id,showen_date,price  from ticket where showen_date=now()::date) t
                 left join demonstration d
                           on t.demonstration_id = d.id
                 left join dict_hall h
                           on d.hall_id = h.id
                 left join dict_session sess
                           on d.session_id  = sess.id
                 left join film f
                           on d.film_id  = f.id
                 left join dict_status s
                           on t.status_id = s.id
                 left join seating_position sp
                           on t.position_id = sp.id;
/*
Merge Right Join  (cost=357546.39..380651.63 rows=769963 width=76)
  Merge Cond: (s.id = ticket.status_id)
  ->  Sort  (cost=88.17..91.35 rows=1270 width=4)
        Sort Key: s.id
        ->  Seq Scan on dict_status s  (cost=0.00..22.70 rows=1270 width=4)
  ->  Sort  (cost=357458.22..357761.35 rows=121254 width=116)
        Sort Key: ticket.status_id
        ->  Hash Left Join  (cost=178934.92..347219.73 rows=121254 width=116)
              Hash Cond: (d.session_id = sess.id)
              ->  Hash Left Join  (cost=178896.34..342889.55 rows=19095 width=88)
                    Hash Cond: (d.hall_id = h.id)
                    ->  Hash Left Join  (cost=178859.34..342176.17 rows=3183 width=60)
                          Hash Cond: (ticket.position_id = sp.id)
                          ->  Gather  (cost=178826.39..341996.60 rows=883 width=60)
                                Workers Planned: 2
                                ->  Hash Left Join  (cost=177826.39..340908.30 rows=368 width=60)
                                      Hash Cond: (d.film_id = f.id)
                                      ->  Parallel Hash Left Join  (cost=177790.97..340819.55 rows=368 width=28)
                                            Hash Cond: (ticket.demonstration_id = d.id)
                                            ->  Parallel Seq Scan on ticket  (cost=0.00..142672.29 rows=368 width=20)
                                                  Filter: (showen_date = (now())::date)
                                            ->  Parallel Hash  (cost=105361.65..105361.65 rows=4166665 width=16)
                                                  ->  Parallel Seq Scan on demonstration d  (cost=0.00..105361.65 rows=4166665 width=16)
                                      ->  Hash  (cost=21.30..21.30 rows=1130 width=40)
                                            ->  Seq Scan on film f  (cost=0.00..21.30 rows=1130 width=40)
                          ->  Hash  (cost=20.20..20.20 rows=1020 width=8)
                                ->  Seq Scan on seating_position sp  (cost=0.00..20.20 rows=1020 width=8)
                    ->  Hash  (cost=22.00..22.00 rows=1200 width=36)
                          ->  Seq Scan on dict_hall h  (cost=0.00..22.00 rows=1200 width=36)
              ->  Hash  (cost=22.70..22.70 rows=1270 width=36)
                    ->  Seq Scan on dict_session sess  (cost=0.00..22.70 rows=1270 width=36)
JIT:
  Functions: 52
  Options: Inlining false, Optimization false, Expressions true, Deforming true
 */

-- 4
explain select
            tmp.film_name,
            sum(tmp.ticket_price)
        from (
                 select
                     f.name as film_name,
                     t.price as ticket_price,
                     (now()::date - interval '1 week')::date as once_week_ago_date,
                         t.purchasen_date as ticket_purchasen_date,
                     now()::date as now_date
                 from ticket t
                          left join demonstration d on t.demonstration_id = d.id
                          left join film f on d.film_id  = f.id
                 where t.status_id = 2) as tmp
        where ((tmp.once_week_ago_date <= tmp.ticket_purchasen_date) and (tmp.ticket_purchasen_date <= tmp.now_date))
        group by tmp.film_name
        order by sum(tmp.ticket_price) desc
            limit 3;
/*
Limit  (cost=395801.38..395801.39 rows=1 width=40)
  ->  Sort  (cost=395801.38..395801.39 rows=1 width=40)
        Sort Key: (sum(t.price)) DESC
        ->  GroupAggregate  (cost=395801.35..395801.37 rows=1 width=40)
              Group Key: f.name
              ->  Sort  (cost=395801.35..395801.36 rows=1 width=36)
                    Sort Key: f.name
                    ->  Nested Loop Left Join  (cost=174721.97..395801.34 rows=1 width=36)
                          Join Filter: (d.film_id = f.id)
                          ->  Gather  (cost=174721.97..395765.92 rows=1 width=8)
                                Workers Planned: 2
                                ->  Parallel Hash Left Join  (cost=173721.97..394765.82 rows=1 width=8)
                                      Hash Cond: (t.demonstration_id = d.id)
                                      ->  Parallel Seq Scan on ticket t  (cost=0.00..204764.83 rows=1 width=8)
                                            Filter: ((status_id = 2) AND (purchasen_date <= (now())::date) AND ((((now())::date - '7 days'::interval))::date <= purchasen_date))
                                      ->  Parallel Hash  (cost=105361.65..105361.65 rows=4166665 width=8)
                                            ->  Parallel Seq Scan on demonstration d  (cost=0.00..105361.65 rows=4166665 width=8)
                          ->  Seq Scan on film f  (cost=0.00..21.30 rows=1130 width=36)
JIT:
  Functions: 22
  Options: Inlining false, Optimization false, Expressions true, Deforming true
*/

-- 5
explain select
            max(case when (l."row"=0) then (l.name||'::'||uc.name) else null end) as "0",
            max(case when (l."row"=1) then (l.name||'::'||uc.name) else null end) as "1",
            max(case when (l."row"=2) then (l.name||'::'||uc.name) else null end) as "2",
            max(case when (l."row"=3) then (l.name||'::'||uc.name) else null end) as "3",
            max(case when (l."row"=4) then (l.name||'::'||uc.name) else null end) as "4",
            max(case when (l."row"=5) then (l.name||'::'||uc.name) else null end) as "5",
            max(case when (l."row"=6) then (l.name||'::'||uc.name) else null end) as "6",
            max(case when (l."row"=7) then (l.name||'::'||uc.name) else null end) as "7",
            max(case when (l."row"=8) then (l.name||'::'||uc.name) else null end) as "8",
            max(case when (l."row"=9) then (l.name||'::'||uc.name) else null end) as "9",
            max(case when(l."row"=10) then (l.name||'::'||uc.name) else null end) as "10"
        from
            "location" l
                join seating_position sp on sp.location_id = l.id
                join dict_ui_color uc on uc.id = (sp.attendance_rate/20)
        where l.floor =1 and sp.hall_id = 3
        GROUP BY l.number_in_row;
/*
GroupAggregate  (cost=75.71..76.45 rows=5 width=356)
  Group Key: l.number_in_row
  ->  Sort  (cost=75.71..75.73 rows=6 width=72)
        Sort Key: l.number_in_row
        ->  Hash Join  (cost=46.52..75.64 rows=6 width=72)
              Hash Cond: (uc.id = (sp.attendance_rate / 20))
              ->  Seq Scan on dict_ui_color uc  (cost=0.00..22.70 rows=1270 width=36)
              ->  Hash  (cost=46.51..46.51 rows=1 width=44)
                    ->  Nested Loop  (cost=0.00..46.51 rows=1 width=44)
                          Join Filter: (l.id = sp.location_id)
                          ->  Seq Scan on location l  (cost=0.00..23.38 rows=5 width=44)
                                Filter: (floor = 1)
                          ->  Materialize  (cost=0.00..22.77 rows=5 width=8)
                                ->  Seq Scan on seating_position sp  (cost=0.00..22.75 rows=5 width=8)
                                      Filter: (hall_id = 3)
 */

explain select  -- OK
                l."row",
                max(case when (l.number_in_row =1) then (l.name||'::'||uc.name) else null end) as "1",
                max(case when (l.number_in_row =2) then (l.name||'::'||uc.name) else null end) as "2",
                max(case when (l.number_in_row =3) then (l.name||'::'||uc.name) else null end) as "3",
                max(case when (l.number_in_row =4) then (l.name||'::'||uc.name) else null end) as "4",
                max(case when (l.number_in_row =5) then (l.name||'::'||uc.name) else null end) as "5",
                max(case when (l.number_in_row =6) then (l.name||'::'||uc.name) else null end) as "6",
                max(case when (l.number_in_row =7) then (l.name||'::'||uc.name) else null end) as "7",
                max(case when (l.number_in_row =8) then (l.name||'::'||uc.name) else null end) as "8",
                max(case when (l.number_in_row =9) then (l.name||'::'||uc.name) else null end) as "9",
                max(case when (l.number_in_row =10) then (l.name||'::'||uc.name) else null end) as "10",
                max(case when (l.number_in_row =11) then (l.name||'::'||uc.name) else null end) as "11",
                max(case when (l.number_in_row =12) then (l.name||'::'||uc.name) else null end) as "12",
                max(case when (l.number_in_row =13) then (l.name||'::'||uc.name) else null end) as "13",
                max(case when (l.number_in_row =14) then (l.name||'::'||uc.name) else null end) as "14",
                max(case when (l.number_in_row =15) then (l.name||'::'||uc.name) else null end) as "15",
                max(case when (l.number_in_row =16) then (l.name||'::'||uc.name) else null end) as "16",
                max(case when (l.number_in_row =17) then (l.name||'::'||uc.name) else null end) as "17",
                max(case when (l.number_in_row =18) then (l.name||'::'||uc.name) else null end) as "18",
                max(case when (l.number_in_row =19) then (l.name||'::'||uc.name) else null end) as "19",
                max(case when (l.number_in_row =20) then (l.name||'::'||uc.name) else null end) as "20",
                max(case when (l.number_in_row =21) then (l.name||'::'||uc.name) else null end) as "21",
                max(case when (l.number_in_row =22) then (l.name||'::'||uc.name) else null end) as "22",
                max(case when (l.number_in_row =23) then (l.name||'::'||uc.name) else null end) as "23",
                max(case when (l.number_in_row =24) then (l.name||'::'||uc.name) else null end) as "24",
                max(case when (l.number_in_row =25) then (l.name||'::'||uc.name) else null end) as "25",
                max(case when (l.number_in_row =26) then (l.name||'::'||uc.name) else null end) as "26",
                max(case when (l.number_in_row =27) then (l.name||'::'||uc.name) else null end) as "27",
                max(case when (l.number_in_row =28) then (l.name||'::'||uc.name) else null end) as "28",
                max(case when (l.number_in_row =29) then (l.name||'::'||uc.name) else null end) as "29",
                max(case when (l.number_in_row =30) then (l.name||'::'||uc.name) else null end) as "30",
                max(case when (l.number_in_row =31) then (l.name||'::'||uc.name) else null end) as "31",
                max(case when (l.number_in_row =32) then (l.name||'::'||uc.name) else null end) as "32",
                max(case when (l.number_in_row =33) then (l.name||'::'||uc.name) else null end) as "33",
                max(case when (l.number_in_row =34) then (l.name||'::'||uc.name) else null end) as "34",
                max(case when (l.number_in_row =35) then (l.name||'::'||uc.name) else null end) as "35",
                max(case when (l.number_in_row =36) then (l.name||'::'||uc.name) else null end) as "36",
                max(case when (l.number_in_row =37) then (l.name||'::'||uc.name) else null end) as "37"
        from
            "location" l
                join seating_position sp on sp.location_id = l.id
                join dict_ui_color uc on uc.id = (sp.attendance_rate/20)
        where l.floor =1 and sp.hall_id = 3
        GROUP BY l."row";
/*
GroupAggregate  (cost=75.71..78.01 rows=5 width=1188)
  Group Key: l."row"
  ->  Sort  (cost=75.71..75.73 rows=6 width=72)
        Sort Key: l."row"
        ->  Hash Join  (cost=46.52..75.64 rows=6 width=72)
              Hash Cond: (uc.id = (sp.attendance_rate / 20))
              ->  Seq Scan on dict_ui_color uc  (cost=0.00..22.70 rows=1270 width=36)
              ->  Hash  (cost=46.51..46.51 rows=1 width=44)
                    ->  Nested Loop  (cost=0.00..46.51 rows=1 width=44)
                          Join Filter: (l.id = sp.location_id)
                          ->  Seq Scan on location l  (cost=0.00..23.38 rows=5 width=44)
                                Filter: (floor = 1)
                          ->  Materialize  (cost=0.00..22.77 rows=5 width=8)
                                ->  Seq Scan on seating_position sp  (cost=0.00..22.75 rows=5 width=8)
                                      Filter: (hall_id = 3)
*/


-- 6
explain select
            demonstration_id as demo_id,
            count(demonstration_id) as count_tickets,
            min(price) as min_price,
            max(price) as max_price
        from ticket
        group by demonstration_id
        order by count(demonstration_id) desc;
/*
Sort  (cost=158080.39..158105.37 rows=9993 width=20)
  Sort Key: (count(demonstration_id)) DESC
  ->  Finalize GroupAggregate  (cost=154784.87..157416.52 rows=9993 width=20)
        Group Key: demonstration_id
        ->  Gather Merge  (cost=154784.87..157116.73 rows=19986 width=20)
              Workers Planned: 2
              ->  Sort  (cost=153784.85..153809.83 rows=9993 width=20)
                    Sort Key: demonstration_id
                    ->  Partial HashAggregate  (cost=153021.04..153120.97 rows=9993 width=20)
                          Group Key: demonstration_id
                          ->  Parallel Seq Scan on ticket  (cost=0.00..111626.02 rows=4139502 width=8)
JIT:
  Functions: 7
  Options: Inlining false, Optimization false, Expressions true, Deforming true
*/


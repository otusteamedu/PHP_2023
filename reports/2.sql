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
Nested Loop Left Join  (cost=144861.10..145247.59 rows=5645 width=108)
  ->  Merge Left Join  (cost=144861.10..144950.22 rows=5645 width=188)
        Merge Cond: (tck.status_id = s.id)
        ->  Sort  (cost=144772.92..144775.15 rows=889 width=160)
              Sort Key: tck.status_id
              ->  Hash Left Join  (cost=144286.63..144729.38 rows=889 width=160)
                    Hash Cond: (d.film_id = f.id)
                    ->  Hash Left Join  (cost=144285.41..144724.81 rows=889 width=128)
                          Hash Cond: (d.session_id = sess.id)
                          ->  Hash Left Join  (cost=144284.32..144711.50 rows=889 width=100)
                                Hash Cond: (d.hall_id = h.id)
                                ->  Merge Right Join  (cost=144283.25..144698.21 rows=889 width=72)
                                      Merge Cond: (d.id = tck.demonstration_id)
                                      ->  Index Scan using demonstration_id_idx on demonstration d  (cost=0.43..323386.39 rows=9999997 width=20)
                                      ->  Sort  (cost=144282.82..144285.04 rows=889 width=60)
                                            Sort Key: tck.demonstration_id
                                            ->  Gather  (cost=1001.23..144239.27 rows=889 width=60)
                                                  Workers Planned: 2
                                                  ->  Hash Left Join  (cost=1.23..143150.37 rows=370 width=60)
                                                        Hash Cond: (tck.position_id = sp.id)
                                                        ->  Parallel Seq Scan on ticket tck  (cost=0.00..143147.63 rows=370 width=24)
                                                              Filter: (showen_date = (now())::date)
                                                        ->  Hash  (cost=1.10..1.10 rows=10 width=44)
                                                              ->  Seq Scan on seating_position sp  (cost=0.00..1.10 rows=10 width=44)
                                ->  Hash  (cost=1.03..1.03 rows=3 width=36)
                                      ->  Seq Scan on dict_hall h  (cost=0.00..1.03 rows=3 width=36)
                          ->  Hash  (cost=1.04..1.04 rows=4 width=36)
                                ->  Seq Scan on dict_session sess  (cost=0.00..1.04 rows=4 width=36)
                    ->  Hash  (cost=1.10..1.10 rows=10 width=40)
                          ->  Seq Scan on film f  (cost=0.00..1.10 rows=10 width=40)
        ->  Sort  (cost=88.17..91.35 rows=1270 width=36)
              Sort Key: s.id
              ->  Seq Scan on dict_status s  (cost=0.00..22.70 rows=1270 width=36)
  ->  Materialize  (cost=0.00..1.02 rows=1 width=4)
        ->  Seq Scan on _config cnf  (cost=0.00..1.01 rows=1 width=4)
              Filter: (id = 1)
JIT:
  Functions: 59
  Options: Inlining false, Optimization false, Expressions true, Deforming true
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
Aggregate  (cost=159811.61..159811.62 rows=1 width=8)
  ->  Gather  (cost=40473.93..159811.60 rows=1 width=4)
        Workers Planned: 2
        ->  Parallel Bitmap Heap Scan on ticket tck  (cost=39473.93..158811.50 rows=1 width=4)
              Recheck Cond: (status_id = 2)
              Filter: ((purchasen_date <= (now())::date) AND ((((now())::date - '7 days'::interval))::date <= purchasen_date))
              ->  Bitmap Index Scan on ticket_status_id_idx  (cost=0.00..39473.92 rows=3626332 width=0)
                    Index Cond: (status_id = 2)
JIT:
  Functions: 8
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
Merge Left Join  (cost=144861.10..145034.89 rows=5645 width=76)
  Merge Cond: (ticket.status_id = s.id)
  ->  Sort  (cost=144772.92..144775.15 rows=889 width=116)
        Sort Key: ticket.status_id
        ->  Hash Left Join  (cost=144286.63..144729.38 rows=889 width=116)
              Hash Cond: (d.film_id = f.id)
              ->  Hash Left Join  (cost=144285.41..144724.81 rows=889 width=84)
                    Hash Cond: (d.session_id = sess.id)
                    ->  Hash Left Join  (cost=144284.32..144711.50 rows=889 width=56)
                          Hash Cond: (d.hall_id = h.id)
                          ->  Merge Right Join  (cost=144283.25..144698.21 rows=889 width=28)
                                Merge Cond: (d.id = ticket.demonstration_id)
                                ->  Index Scan using demonstration_id_idx on demonstration d  (cost=0.43..323386.39 rows=9999997 width=16)
                                ->  Sort  (cost=144282.82..144285.04 rows=889 width=20)
                                      Sort Key: ticket.demonstration_id
                                      ->  Gather  (cost=1001.23..144239.27 rows=889 width=20)
                                            Workers Planned: 2
                                            ->  Hash Left Join  (cost=1.23..143150.37 rows=370 width=20)
                                                  Hash Cond: (ticket.position_id = sp.id)
                                                  ->  Parallel Seq Scan on ticket  (cost=0.00..143147.63 rows=370 width=20)
                                                        Filter: (showen_date = (now())::date)
                                                  ->  Hash  (cost=1.10..1.10 rows=10 width=8)
                                                        ->  Seq Scan on seating_position sp  (cost=0.00..1.10 rows=10 width=8)
                          ->  Hash  (cost=1.03..1.03 rows=3 width=36)
                                ->  Seq Scan on dict_hall h  (cost=0.00..1.03 rows=3 width=36)
                    ->  Hash  (cost=1.04..1.04 rows=4 width=36)
                          ->  Seq Scan on dict_session sess  (cost=0.00..1.04 rows=4 width=36)
              ->  Hash  (cost=1.10..1.10 rows=10 width=40)
                    ->  Seq Scan on film f  (cost=0.00..1.10 rows=10 width=40)
  ->  Sort  (cost=88.17..91.35 rows=1270 width=4)
        Sort Key: s.id
        ->  Seq Scan on dict_status s  (cost=0.00..22.70 rows=1270 width=4)
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
Limit  (cost=159820.31..159820.31 rows=1 width=40)
  ->  Sort  (cost=159820.31..159820.31 rows=1 width=40)
        Sort Key: (sum(t.price)) DESC
        ->  GroupAggregate  (cost=159820.16..159820.30 rows=1 width=40)
              Group Key: f.name
              ->  Gather Merge  (cost=159820.16..159820.28 rows=1 width=36)
                    Workers Planned: 2
                    ->  Sort  (cost=158820.14..158820.14 rows=1 width=36)
                          Sort Key: f.name
                          ->  Nested Loop Left Join  (cost=39474.50..158820.13 rows=1 width=36)
                                ->  Nested Loop Left Join  (cost=39474.36..158819.97 rows=1 width=8)
                                      ->  Parallel Bitmap Heap Scan on ticket t  (cost=39473.93..158811.50 rows=1 width=8)
                                            Recheck Cond: (status_id = 2)
                                            Filter: ((purchasen_date <= (now())::date) AND ((((now())::date - '7 days'::interval))::date <= purchasen_date))
                                            ->  Bitmap Index Scan on ticket_status_id_idx  (cost=0.00..39473.92 rows=3626332 width=0)
                                                  Index Cond: (status_id = 2)
                                      ->  Index Scan using demonstration_id_idx on demonstration d  (cost=0.43..8.45 rows=1 width=8)
                                            Index Cond: (id = t.demonstration_id)
                                ->  Index Scan using film_id_idx on film f  (cost=0.14..0.15 rows=1 width=36)
                                      Index Cond: (id = d.film_id)
JIT:
  Functions: 17
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
GroupAggregate  (cost=3.40..3.52 rows=1 width=356)
  Group Key: l.number_in_row
  ->  Sort  (cost=3.40..3.40 rows=1 width=72)
        Sort Key: l.number_in_row
        ->  Nested Loop  (cost=0.00..3.39 rows=1 width=72)
              Join Filter: ((sp.attendance_rate / 20) = uc.id)
              ->  Nested Loop  (cost=0.00..2.26 rows=1 width=44)
                    Join Filter: (l.id = sp.location_id)
                    ->  Seq Scan on location l  (cost=0.00..1.12 rows=1 width=44)
                          Filter: (floor = 1)
                    ->  Seq Scan on seating_position sp  (cost=0.00..1.12 rows=1 width=8)
                          Filter: (hall_id = 3)
              ->  Seq Scan on dict_ui_color uc  (cost=0.00..1.05 rows=5 width=36)
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
GroupAggregate  (cost=3.40..3.78 rows=1 width=1188)
  Group Key: l."row"
  ->  Sort  (cost=3.40..3.40 rows=1 width=72)
        Sort Key: l."row"
        ->  Nested Loop  (cost=0.00..3.39 rows=1 width=72)
              Join Filter: ((sp.attendance_rate / 20) = uc.id)
              ->  Nested Loop  (cost=0.00..2.26 rows=1 width=44)
                    Join Filter: (l.id = sp.location_id)
                    ->  Seq Scan on location l  (cost=0.00..1.12 rows=1 width=44)
                          Filter: (floor = 1)
                    ->  Seq Scan on seating_position sp  (cost=0.00..1.12 rows=1 width=8)
                          Filter: (hall_id = 3)
              ->  Seq Scan on dict_ui_color uc  (cost=0.00..1.05 rows=5 width=36)
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
Sort  (cost=158623.64..158648.63 rows=9993 width=20)
  Sort Key: (count(demonstration_id)) DESC
  ->  Finalize GroupAggregate  (cost=155328.12..157959.77 rows=9993 width=20)
        Group Key: demonstration_id
        ->  Gather Merge  (cost=155328.12..157659.98 rows=19986 width=20)
              Workers Planned: 2
              ->  Sort  (cost=154328.10..154353.08 rows=9993 width=20)
                    Sort Key: demonstration_id
                    ->  Partial HashAggregate  (cost=153564.30..153664.23 rows=9993 width=20)
                          Group Key: demonstration_id
                          ->  Parallel Seq Scan on ticket  (cost=0.00..111897.65 rows=4166665 width=8)
JIT:
  Functions: 7
  Options: Inlining false, Optimization false, Expressions true, Deforming true
*/


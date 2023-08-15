select count(t.id) as cnt, sum(t.price) as price from ticket t
left join "session" s on t.session_id=s.id
where
    t.status = 1 AND
    s.start_time::date between (CURRENT_DATE - interval '1 WEEK') and CURRENT_DATE

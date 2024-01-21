SELECT oid::regclass,
       pg_relation_size(oid)
FROM pg_class
ORDER BY 2 DESC LIMIT 15;
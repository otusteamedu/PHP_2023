SELECT * FROM
    pg_stat_user_indexes
ORDER BY idx_scan DESC
LIMIT 5;

/**
relid|indexrelid|schemaname|relname   |indexrelname   |idx_scan|last_idx_scan                |idx_tup_read|idx_tup_fetch|
-----+----------+----------+----------+---------------+--------+-----------------------------+------------+-------------+
41309|     41313|public    |seances   |seances_pkey   |  233172|2024-01-20 16:10:12.934 +0300|      233172|       232966|
41302|     41306|public    |halls     |halls_pkey     |    2791|2024-01-20 15:14:07.515 +0300|        2791|         2791|
41246|     41252|public    |films     |films_pkey     |    1412|2024-01-20 15:13:48.877 +0300|        1412|         1412|
41309|     41355|public    |seances   |start_at_idx   |      20|2024-01-20 16:10:12.934 +0300|       11244|            0|
41275|     41279|public    |attributes|attributes_pkey|      10|2024-01-20 15:13:48.877 +0300|          10|           10|
*/



SELECT * FROM
    pg_stat_user_indexes
WHERE idx_scan > 0
ORDER BY idx_scan ASC
LIMIT 5;

/**
relid|indexrelid|schemaname|relname       |indexrelname       |idx_scan|last_idx_scan                |idx_tup_read|idx_tup_fetch|
-----+----------+----------+--------------+-------------------+--------+-----------------------------+------------+-------------+
41239|     41243|public    |genres        |genres_pkey        |       7|2024-01-20 15:13:48.877 +0300|           7|            7|
41268|     41272|public    |attribute_type|attribute_type_pkey|       9|2024-01-20 15:13:48.877 +0300|           9|            9|
41326|     41356|public    |tickets       |status_idx         |      10|2024-01-20 16:10:12.934 +0300|      583830|            0|
41275|     41279|public    |attributes    |attributes_pkey    |      10|2024-01-20 15:13:48.877 +0300|          10|           10|
41309|     41355|public    |seances       |start_at_idx       |      20|2024-01-20 16:10:12.934 +0300|       11244|            0|
*/
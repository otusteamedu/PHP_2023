### Query
```sql
QUERIES FOR 10000
```
### Explanation
```
EXPLAIN
```

### Query
```sql
SELECT name, release_date FROM movies WHERE release_date > '2020-01-01';

1)Seq Scan on movies (cost=0.00..228.00 rows=1452 width=14)
Filter: (release_date > '2020-01-01'::date)
```
### Explanation
```
EXPLAIN
```

### Query
```sql
SELECT COUNT(*) FROM movies;

2)Aggregate (cost=228.00..228.01 rows=1 width=8)
-> Seq Scan on movies (cost=0.00..203.00 rows=10000 width=0)
```
### Explanation
```
EXPLAIN
```

### Query
```sql
SELECT name, duration FROM movies WHERE duration >= 120;

3)Seq Scan on movies (cost=0.00..228.00 rows=8376 width=14)
Filter: (duration >= 120)
```
### Explanation
```
EXPLAIN
```

### Query
```sql
SELECT at.type_name, AVG(m.duration) AS average_duration
FROM movies m
JOIN attribute_values av ON m.movie_id = av.movie_id
JOIN attributes a ON av.attribute_id = a.attribute_id
JOIN attribute_types at ON a.type_id = at.type_id
GROUP BY at.type_name;


4)HashAggregate (cost=1007.31..1044.81 rows=3000 width=41)
Group Key: at.type_name
-> Hash Join (cost=706.50..957.31 rows=10000 width=13)
Hash Cond: (a.type_id = at.type_id)
-> Hash Join (cost=622.00..846.52 rows=10000 width=8)
Hash Cond: (av.attribute_id = at.attribute_id)
-> Hash Join (cost=328.00..526.26 rows=10000 width=8)
Hash Cond: (av.movie_id = m.movie_id)
-> Seq Scan on attribute_values av (cost=0.00..172.00 rows=10000 width=8)
-> Hash (cost=203.00..203.00 rows=10000 width=8)
```
### Explanation
```
EXPLAIN
```

### Query
```sql
SELECT m.name, COUNT(av.attribute_id) AS attribute_count
FROM movies m
JOIN attribute_values av ON m.movie_id = av.movie_id
GROUP BY m.name;


5)HashAggregate (cost=576.26..676.26 rows=10000 width=18)
Group Key: m.name
-> Hash Join (cost=328.00..526.26 rows=10000 width=14)
Hash Cond: (av.movie_id = m.movie_id)
-> Seq Scan on attribute_values av (cost=0.00..172.00 rows=10000 width=8)
-> Hash (cost=203.00..203.00 rows=10000 width=14)
-> Seq Scan on movies m (cost=0.00..203.00 rows=10000 width=14)
```
### Explanation
```
EXPLAIN
```

### Query
```sql
SELECT m.name, a.name AS attribute_name
FROM movies m
JOIN attribute_values av ON m.movie_id = av.movie_id
JOIN attributes a ON av.attribute_id = a.attribute_id
WHERE a.name = 'Оскар';


6)Nested Loop (cost=0.57..202.67 rows=1 width=22)
-> Nested Loop (cost=0.29..202.31 rows=1 width=16)
-> Seq Scan on attributes a (cost=0.00..194.00 rows=1 width=16)
Filter: ((name)::text = 'oscar'::text))
-> Index Scan using idx_attribute on attribute_values av (cost=0.29..8.30 rows=1 width=8)
Index Cond: (attribute_id = a.attribute_id)
-> Index Scan using movies_pkey on movies m (cost=0.29..0.36 rows=1 width=14)
Index Cond: (movie_id = av.movie_id)

QUERIES FOR 10000000 records
```
### Explanation
```
EXPLAIN
```

### Query
```sql
SELECT name, release_date FROM movies WHERE release_date > '2020-01-01';


1) Seq Scan on movies (cost=0.00..228318.36 rows=3960486 width=17)
   Filter: (release_date > '2020-01-01'::date)
   JIT:
   Functions: 4
   " Options: Inlining false, Optimization false, Expressions true, Deforming true"

Even though I checked the cost with index on release_date and then made a covering index on name, release_date columns which are fully applied in select the difference without indexes and with indexes is not different since sequential reading is performed, apparently the scheduler thought it was very expensive to do random reading.
After I made partitioning the request became cheaper example below

Append (cost=0.00..110896.49 rows=3985298 width=17)
-> Seq Scan on movies_2020 movies_1 (cost=0.00..22899.22 rows=1001212 width=17)
Filter: (release_date > '2020-01-01'::date)
-> Seq Scan on movies_2021 movies_2 (cost=0.00..22836.94 rows=1001096 width=17)
Filter: (release_date > '2020-01-01'::date)
-> Seq Scan on movies_2022 movies_3 (cost=0.00..22835.94 rows=1001095 width=17)
Filter: (release_date > '2020-01-01'::date)
-> Seq Scan on movies_2023 movies_4 (cost=0.00..22397.90 rows=981895 width=17)
Filter: (release_date > '2020-01-01'::date)
```
### Explanation
```
EXPLAIN
```

### Query
```sql
SELECT COUNT(*) FROM movies;

2) Finalize Aggregate (cost=156329.63..156329.64 rows=1 width=8)
   -> Gather (cost=156329.42..156329.63 rows=2 width=8)
   Workers Planned: 2
   -> Partial Aggregate (cost=155329.42..155329.43 rows=1 width=8)
   -> Parallel Seq Scan on movies (cost=0.00..144902.33 rows=4170833 width=0)
   JIT:
   Functions: 4
   " Options: Inlining false, Optimization false, Expressions true, Deforming true "



In this one, the movies table is scanned in parallel, which is an efficient way to handle large tables and the query is quite fast
```
### Explanation
```
EXPLAIN
```

### Query
```sql
SELECT name, duration FROM movies WHERE duration >= 120;


3) Seq Scan on movies (cost=0.00..228318.36 rows=8388227 width=17)
   Filter: (duration >= 120)
   JIT:
   Functions: 4
   " Options: Inlining false, Optimization false, Expressions true, Deforming true "

The query executes by itself quickly and I could not reduce the cost by indexing the duration field or by covering the name and duration fields only if you select only duration, the cost is reduced by half.
```
### Explanation
```
EXPLAIN
```

### Query
```sql
SELECT at.type_name, AVG(m.duration) AS average_duration
FROM movies m
JOIN attribute_values av ON m.movie_id = av.movie_id
JOIN attributes a ON av.attribute_id = a.attribute_id
JOIN attribute_types at ON a.type_id = at.type_id
GROUP BY at.type_name;

4) Finalize GroupAggregate (cost=658228.64..658996.19 rows=3000 width=41)
   Group Key: at.type_name
   -> Gather Merge (cost=658228.64..658928.69 rows=6000 width=41)
   Workers Planned: 2
   -> Sort (cost=657228.62..657236.12 rows=3000 width=41)
   Sort Key: at.type_name
   -> Partial HashAggregate (cost=657025.36..657055.36 rows=3000 width=41)
   Group Key: at.type_name
   -> Hash Join (cost=392120.49..636150.36 rows=4175000 width=13)
   Hash Cond: (a.type_id = at.type_id)
   -> Parallel Hash Join (cost=391952.49..625015.24 rows=4175000 width=8)
   Hash Cond: (av.attribute_id = a.attribute_id)
   -> Parallel Hash Join (cost=213330.75..386523.12 rows=4175000 width=8)
   Hash Cond: (av.movie_id = m.movie_id)
   -> Parallel Seq Scan on attribute_values av (cost=0.00..113322.00 rows=4175000 width=8)
   -> Parallel Hash (cost=144902.33..144902.33 rows=4170833 width=8)
   -> Parallel Seq Scan on movies m (cost=0.00..144902.33 rows=4170833 width=8)
   -> Parallel Hash (cost=110193.33..110193.33 rows=4170833 width=8)
   -> Parallel Seq Scan on attributes a (cost=0.00..110193.33 rows=4170833 width=8)
   -> Hash (cost=93.00..93.00 rows=6000 width=13)
   -> Seq Scan on attribute_types at (cost=0.00..93.00 rows=6000 width=13)
   JIT:
   Functions: 31
   " Options: Inlining true, Optimization true, Expressions true, Deforming true".

The query itself took about 30 seconds to execute and the cost is expensive as you can see in the analysis

Creating indexes did not help me to speed up this query so I created a materialized view (assuming that this query will have a high frequency of use) and the difference in cost and query speed is huge as you can see in the example below:

Seq Scan on avg_duration_by_type (cost=0.00..50.00 rows=3000 width=21)
```
### Explanation
```
EXPLAIN
```

### Query
```sql
SELECT m.name, COUNT(av.attribute_id) AS attribute_count
FROM movies m
JOIN attribute_values av ON m.movie_id = av.movie_id
GROUP BY m.name;


5) HashAggregate (cost=1442274.62..1659796.93 rows=10009949 width=21)
   Group Key: m.name
   Planned Partitions: 256
   -> Hash Join (cost=387070.85..722081.37 rows=10020080 width=17)
   Hash Cond: (av.movie_id = m.movie_id)
   -> Seq Scan on attribute_values av (cost=0.00..171772.80 rows=10020080 width=8)
   -> Hash (cost=203293.49..203293.49 rows=10009949 width=17)
   -> Seq Scan on movies m (cost=0.00..203293.49 rows=10009949 width=17)
   JIT:
   Functions: 12
   " Options: Inlining true, Optimization true, Expressions true, Deforming true"

Creating indexes on columns av.movie_id and m.name did not help only materializing data result below in the example

Seq Scan on movie_attribute_count (cost=0.00..45964.80 rows=564480 width=524)
```
### Explanation
```
EXPLAIN
```

### Query
```sql
SELECT m.name, a.name AS attribute_name
FROM movies m
JOIN attribute_values av ON m.movie_id = av.movie_id
JOIN attributes a ON av.attribute_id = a.attribute_id
WHERE a.name = 'Оскар';


6) Hash Join (cost=708762.39..1184858.30 rows=6985666 width=26)
   Hash Cond: (av.movie_id = m.movie_id)
   -> Hash Join (cost=321691.54..638933.06 rows=6985666 width=17)
   Hash Cond: (av.attribute_id = a.attribute_id)
   -> Seq Scan on attribute_values av (cost=0.00..171772.80 rows=10020080 width=8)
   -> Hash (cost=193589.11..193589.11 rows=6977474 width=17)
   -> Seq Scan on attributes a (cost=0.00..193589.11 rows=6977474 width=17)
   Filter: ((name)::text = 'Oscar'::text))
   -> Hash (cost=203293.49..203293.49 rows=10009949 width=17)
   -> Seq Scan on movies m (cost=0.00..203293.49 rows=10009949 width=17)
   JIT:
   Functions: 20
   " Options: Inlining true, Optimization true, Expressions true, Deforming true "

All methods except partitioning failed to speed up my table the result is below

Seq Scan on movie_attributes_oscar (cost=0.00..121146.69 rows=7013869 width=24)

The bottom line is that on large tables with records from 1000000 works well partitioning or creating materialized views (but they are relevant if queries are executed frequently on certain conditions). And on rows up to 10000, no significant increase was found when adding indexing.
```


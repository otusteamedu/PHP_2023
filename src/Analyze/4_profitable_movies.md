# Три самых прибыльных фильмов за неделю

Sql запрос:

```postgresql
EXPLAIN SELECT m.name movie, sum(t.price) total_revenue FROM movie m
    INNER JOIN showtime s on m.id = s.movie_id
    INNER JOIN ticket t on s.id = t.showtime_id
WHERE DATE(s.start_time) BETWEEN CURRENT_DATE - INTERVAL '6 days' AND CURRENT_DATE
GROUP BY m.name
ORDER BY total_revenue DESC
LIMIT 3;
```

## Explain до оптимизации

### 10 тысяч записей

```csv
Limit  (cost=133.15..133.16 rows=3 width=548)
  ->  Sort  (cost=133.15..133.23 rows=32 width=548)
        Sort Key: (sum(t.price)) DESC
        ->  GroupAggregate  (cost=132.10..132.74 rows=32 width=548)
              Group Key: m.name
              ->  Sort  (cost=132.10..132.18 rows=32 width=522)
                    Sort Key: m.name
                    ->  Nested Loop  (cost=7.25..131.30 rows=32 width=522)
                          ->  Hash Join  (cost=7.10..125.94 rows=32 width=10)
                                Hash Cond: (t.showtime_id = s.id)
                                ->  Seq Scan on ticket t  (cost=0.00..103.00 rows=5900 width=10)
                                ->  Hash  (cost=7.09..7.09 rows=1 width=8)
                                      ->  Seq Scan on showtime s  (cost=0.00..7.09 rows=1 width=8)
                                            Filter: ((date(start_time) <= CURRENT_DATE) AND (date(start_time) >= (CURRENT_DATE - '6 days'::interval)))
                          ->  Memoize  (cost=0.15..2.37 rows=1 width=520)
                                Cache Key: s.movie_id
                                Cache Mode: logical
                                ->  Index Scan using movie_pkey on movie m  (cost=0.14..2.36 rows=1 width=520)
                                      Index Cond: (id = s.movie_id)
```

### 10 миллионов записей

```csv
Limit  (cost=76837.62..76837.63 rows=3 width=41)
  ->  Sort  (cost=76837.62..76838.37 rows=300 width=41)
        Sort Key: (sum(t.price)) DESC
        ->  Finalize GroupAggregate  (cost=76755.49..76833.75 rows=300 width=41)
              Group Key: m.name
              ->  Gather Merge  (cost=76755.49..76825.50 rows=600 width=41)
                    Workers Planned: 2
                    ->  Sort  (cost=75755.47..75756.22 rows=300 width=41)
                          Sort Key: m.name
                          ->  Partial HashAggregate  (cost=75739.37..75743.12 rows=300 width=41)
                                Group Key: m.name
                                ->  Hash Join  (cost=76.74..75678.66 rows=12142 width=15)
                                      Hash Cond: (s.movie_id = m.id)
                                      ->  Hash Join  (cost=66.99..75636.60 rows=12142 width=10)
                                            Hash Cond: (t.showtime_id = s.id)
                                            ->  Parallel Seq Scan on ticket t  (cost=0.00..69003.10 rows=2495810 width=10)
                                            ->  Hash  (cost=66.88..66.88 rows=9 width=8)
                                                  ->  Seq Scan on showtime s  (cost=0.00..66.88 rows=9 width=8)
                                                        Filter: ((date(start_time) <= CURRENT_DATE) AND (date(start_time) >= (CURRENT_DATE - '6 days'::interval)))
                                      ->  Hash  (cost=6.00..6.00 rows=300 width=13)
                                            ->  Seq Scan on movie m  (cost=0.00..6.00 rows=300 width=13)
```

## Оптимизация

Индекс `showtime.start_time`.

## Explain после оптимизации

```csv
Limit  (cost=76837.92..76837.92 rows=3 width=41)
  ->  Sort  (cost=76837.92..76838.67 rows=300 width=41)
        Sort Key: (sum(t.price)) DESC
        ->  Finalize GroupAggregate  (cost=76755.78..76834.04 rows=300 width=41)
              Group Key: m.name
              ->  Gather Merge  (cost=76755.78..76825.79 rows=600 width=41)
                    Workers Planned: 2
                    ->  Sort  (cost=75755.76..75756.51 rows=300 width=41)
                          Sort Key: m.name
                          ->  Partial HashAggregate  (cost=75739.67..75743.42 rows=300 width=41)
                                Group Key: m.name
                                ->  Hash Join  (cost=76.74..75678.96 rows=12142 width=15)
                                      Hash Cond: (s.movie_id = m.id)
                                      ->  Hash Join  (cost=66.99..75636.89 rows=12142 width=10)
                                            Hash Cond: (t.showtime_id = s.id)
                                            ->  Parallel Seq Scan on ticket t  (cost=0.00..69003.33 rows=2495833 width=10)
                                            ->  Hash  (cost=66.88..66.88 rows=9 width=8)
                                                  ->  Seq Scan on showtime s  (cost=0.00..66.88 rows=9 width=8)
                                                        Filter: ((date(start_time) <= CURRENT_DATE) AND (date(start_time) >= (CURRENT_DATE - '6 days'::interval)))
                                      ->  Hash  (cost=6.00..6.00 rows=300 width=13)
                                            ->  Seq Scan on movie m  (cost=0.00..6.00 rows=300 width=13)
```
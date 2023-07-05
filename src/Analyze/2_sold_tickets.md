# Проданные билеты за неделю

Sql запрос:

```postgresql
EXPLAIN SELECT id FROM ticket
        WHERE sale_date BETWEEN CURRENT_DATE - INTERVAL '6 days' AND CURRENT_DATE;
```

## Explain до оптимизации

### 10 тысяч записей

```csv
Seq Scan on ticket  (cost=0.00..176.75 rows=17 width=4)
  Filter: ((sale_date <= CURRENT_DATE) AND (sale_date >= (CURRENT_DATE - '6 days'::interval)))
```

### 10 миллионов записей

```csv
Gather  (cost=1000.00..103166.12 rows=19654 width=30)
  Workers Planned: 2
  ->  Parallel Seq Scan on ticket  (cost=0.00..100200.73 rows=8189 width=30)
        Filter: ((sale_date <= CURRENT_DATE) AND (sale_date >= (CURRENT_DATE - '6 days'::interval)))
JIT:
  Functions: 2
  Options: Inlining false, Optimization false, Expressions true, Deforming true"
```

## Оптимизация

Добавил индекс на поле `sale_date` таблицы `ticket`:

```postgresql
CREATE INDEX idx_ticket_sale_date ON ticket (sale_date);
```

## Explain после оптимизации

```csv
Bitmap Heap Scan on ticket  (cost=221.44..15190.94 rows=16624 width=4)
  Recheck Cond: ((sale_date >= (CURRENT_DATE - '6 days'::interval)) AND (sale_date <= CURRENT_DATE))
  ->  Bitmap Index Scan on idx_ticket_sale_date  (cost=0.00..217.28 rows=16624 width=0)
        Index Cond: ((sale_date >= (CURRENT_DATE - '6 days'::interval)) AND (sale_date <= CURRENT_DATE))
```
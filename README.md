#### Размеры таблиц при заполненных 100 000 фильмов и 10 000 000 проданных билетов
| Table                  | Size       |
|------------------------|------------|
| tickets                | 730 MB     |
| movie_attribute_values | 85 MB      |
| movies                 | 37 MB      |
| schedule_prices        | 10192 kB   |
| schedules              | 5888 kB    |
| movie_genres           | 4328 kB    |
| places                 | 40 kB      |
| attribute_types        | 8192 bytes |
| attributes             | 8192 bytes |
| genres                 | 8192 bytes |
| cinema_halls           | 8192 bytes |
| place_types            | 8192 bytes |

#### Размеры индексов при заполненных 100 000 фильмов и 10 000 000 проданных билетов
| Table                  | Size    |
|------------------------|---------|
| tickets                | 347 MB  |
| movie_attribute_values | 17 MB   |
| schedule_prices        | 9248 kB |
| schedules              | 4416 kB |
| movie_genres           | 3088 kB |
| movies                 | 2208 kB |
| places                 | 48 kB   |
| attribute_types        | 32 kB   |
| place_types            | 16 kB   |
| attributes             | 16 kB   |
| genres                 | 16 kB   |
| cinema_halls           | 16 kB   |

#### Наиболее часто используемые индексы:
- schedules_datetime_index
- tickets_created_at_index
- places_cinema_hall_id_index 
- tickets_place_id_index

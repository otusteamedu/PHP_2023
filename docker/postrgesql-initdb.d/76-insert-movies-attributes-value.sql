set my.date_start = '2023-07-01';
set my.date_end = '2023-08-01';
set my.review_cnt_max = 4;

do
$$
    declare
        movie_r record;
        date timestamp;
        review_cnt int;
    begin
        for movie_r in select id from movie loop
            /* 6c9aa14d-3268-4eed-b5f6-3ae0d0125f48,Оскар */
            if (random() > 0.5) then
                INSERT INTO movie_attributes_value (movie_id, attribute_id, value) VALUES (movie_r.id, '6c9aa14d-3268-4eed-b5f6-3ae0d0125f48', true);
            end if;
            /* 29f4acb3-a3ec-4265-ac5e-df50d2a9d94b,Ника */
            if (random() > 0.5) then
                INSERT INTO movie_attributes_value (movie_id, attribute_id, value) VALUES (movie_r.id, '29f4acb3-a3ec-4265-ac5e-df50d2a9d94b', true);
            end if;
            /* 3f2d56c0-dd07-4f0a-963a-39bdaea3b411,Мировая премьера */
            date := current_setting('my.date_start')::timestamp + (random() * (current_setting('my.date_end')::timestamp - current_setting('my.date_start')::timestamp));
            INSERT INTO movie_attributes_value (movie_id, attribute_id, value) VALUES (movie_r.id, '3f2d56c0-dd07-4f0a-963a-39bdaea3b411', DATE(date));
            /* 86ff5d2c-7f23-4244-aa21-a2e45c9efd34,Премьера в РФ */
            INSERT INTO movie_attributes_value (movie_id, attribute_id, value) VALUES (movie_r.id, '86ff5d2c-7f23-4244-aa21-a2e45c9efd34', DATE(date + (random() * (current_setting('my.date_end')::timestamp - date))));
            /* f140113e-5878-4df1-9f35-a5522a062f6a,Начало продажи билетов */
            INSERT INTO movie_attributes_value (movie_id, attribute_id, value) VALUES (movie_r.id, 'f140113e-5878-4df1-9f35-a5522a062f6a', DATE(date + (random() * (current_setting('my.date_end')::timestamp - date))));
            /* b1eac707-7178-47be-800a-1144950749a6,Запуск рекламы на ТВ */
            INSERT INTO movie_attributes_value (movie_id, attribute_id, value) VALUES (movie_r.id, 'b1eac707-7178-47be-800a-1144950749a6', DATE(date + (random() * (current_setting('my.date_end')::timestamp - date))));
            /* 5df94c81-0320-415c-b48d-be0a79a6453f,Критиков */
            review_cnt := floor(random() * (current_setting('my.review_cnt_max')::int + 1));
            for i in 1..review_cnt loop
                INSERT INTO movie_attributes_value (movie_id, attribute_id, value) VALUES (movie_r.id, '5df94c81-0320-415c-b48d-be0a79a6453f',
                                                                                           concat('Рецензия критика',
                                                                                               to_char(i, '000'),
                                                                                               CASE WHEN random() > 0.5 THEN ' - хорошо' ELSE ' - плохо' END
                                                                                            )
                );
            end loop;
            /* f377ab20-ac36-42b7-8822-695375f63db2,Неизвестной киноакадемии */
            review_cnt := floor(random() * (current_setting('my.review_cnt_max')::int + 1));
            for i in 1..review_cnt loop
                 INSERT INTO movie_attributes_value (movie_id, attribute_id, value) VALUES (movie_r.id, 'f377ab20-ac36-42b7-8822-695375f63db2',
                                                                                            concat('Рецензия неизвестного',
                                                                                                to_char(i, '000'),
                                                                                                CASE WHEN random() > 0.5 THEN ' - хорошо' ELSE ' - плохо' END
                                                                                            )
                );
            end loop;
        end loop;
    end;
$$;

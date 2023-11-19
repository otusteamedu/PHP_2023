INSERT INTO films (name, type, description) VALUES
    ('Я, Франкенштейн', 'научно-фэнтезийный',  'Он - монстр. Он - двухсотлетний плод безумной фантазии своего создателя. Он - легенда. Мир, в котором он живет, населен древними горгульями и бессмертными демонами, которые сражаются за обладание человечеством. Величественные соборы скрывают огромные арсеналы, за дверьми научных лабораторий проводятся эксперименты по воскрешению мертвых. Война двух кланов могущественных существ достигает своего пика. И только он, Адам, монстр Франкенштейна, в силах ее остановить.'),
    ('Полтора шпиона', 'боевик, комедия, криминал',  'От лайка в соцсети до спасения мира – один шаг. Сегодня ты френдишь бывшего одноклассника, а завтра – он тащит тебя под пули. Кто ж знал, что заядлый любитель пончиков превратится в похожего на скалу супершпиона.'),
    ('Облачный атлас', 'фантастика, драма, боевик, детектив, приключения',  'Шесть историй — пять реинкарнаций, происходящих в разное время, тесно переплетающихся между собой.');

INSERT INTO 
    Attributes (name, type) 
VALUES 
    ('рецензии критиков', 'text'),    
    ('отзыв неизвестной киноакадемии', 'text'),    
    ('отзыв кинопоиск', 'text'),  
    ('премия оскар', 'date'),
    ('премия ника', 'bool'),
    ('мировая премьера', 'date'),
    ('премьера в РФ', 'date'),
    ('начала продажи билетов', 'datetime'),
    ('запуск рекламы на TВ', 'datetime'),
    ('продолжительность фильма', 'int'),
    ('cлоган', 'string'),
    ('бюджет', 'float'),
    ('возраст', 'int'),
    ('рейтинг', 'float');

INSERT INTO AttributeValues(film_id, attribute_id, text_value) 
VALUES (1, 1, 'Я, Франкенштейн - наиболее типичный представитель одноразовых попкорновых блокбастеров, на который даже не стоит тратить время. Но всем желающим посмотреть на очередную интерпретацию войны Добра со Злом - добро пожаловать. История проста - есть у нас монстр Франкенштейна, который доживает аж до наших дней, есть армия демонов, состоящая из 666 легионов (и это не шутка, в фильме это четко оговаривается), и противостоящая им армия горгулий, с гораздо меньшей численностью, но зато более имбовая в плане способностей и мощи. И разумеется обеим сторонам конфликта очень нужен наш главный герой, который просто хочет спокойной жизни вдали от всего этого.');

INSERT INTO AttributeValues (film_id, attribute_id, text_value) 
VALUES (1, 3, 'Вот такие дела, вечная проблема злодеев в том, что им нужны живые герои, а не мертвые, что собственно делает антагонистов тупыми и немощными, а героев возвышает до уровня “Бог”. Печально, съешьте печенье, ведь (тут должно было быть слово “фильм”) продолжается.');

INSERT INTO AttributeValues (film_id, attribute_id, text_value) 
VALUES (1, 6, '2014-01-20');

INSERT INTO AttributeValues (film_id, attribute_id, text_value) 
VALUES (1, 7, '2014-01-23');

INSERT INTO AttributeValues (film_id, attribute_id, datetime_value) 
VALUES  (1, 8, '2014-01-10 00:00:00');

INSERT INTO AttributeValues (film_id, attribute_id, datetime_value) 
VALUES  (1, 9, '2014-01-02 00:00:00');

INSERT INTO AttributeValues (film_id, attribute_id, int_value) 
VALUES   (1, 10, '92');

INSERT INTO AttributeValues (film_id, attribute_id, float_value) 
VALUES   (1, 12, '65000000');

INSERT INTO AttributeValues (film_id, attribute_id, int_value) 
VALUES  (1, 13, '12');

INSERT INTO AttributeValues (film_id, attribute_id, float_value) 
VALUES   (1, 14, '5.2');
    
    

INSERT INTO AttributeValues(film_id, attribute_id, text_value) 
VALUES (2, 1, 'Полтора шпиона - весьма неплохой комедийный боевик, который прекрасно справляется со своей первоочередной задачей, а именно - развлекает зрителя. Всем любителям (или нелюбителям) встреч с бывшими одноклассниками - добро пожаловать.');

INSERT INTO AttributeValues (film_id, attribute_id, text_value) 
VALUES (2, 3, 'Типичная американская комедия. Полная шуток над которыми не всегда хочется смеяться. Шпионская тема, но растолкована недостаточно. Все события не станут для тебя неожиданностью. Половину фильма просидишь с рукой у лица, а другую половину сам не поймешь, над чем смеешься.');

INSERT INTO AttributeValues (film_id, attribute_id, text_value) 
VALUES (2, 6, '2016-06-10');

INSERT INTO AttributeValues (film_id, attribute_id, text_value) 
VALUES (2, 7, '2016-06-01');

INSERT INTO AttributeValues (film_id, attribute_id, datetime_value) 
VALUES  (2, 8, '2016-06-01 00:00:00');

INSERT INTO AttributeValues (film_id, attribute_id, datetime_value) 
VALUES  (2, 9, '2016-05-27 00:00:00');

INSERT INTO AttributeValues (film_id, attribute_id, int_value) 
VALUES   (2, 10, '107');

INSERT INTO AttributeValues (film_id, attribute_id, float_value) 
VALUES   (2, 12, '50000000');

INSERT INTO AttributeValues (film_id, attribute_id, int_value) 
VALUES  (2, 13, '16');

INSERT INTO AttributeValues (film_id, attribute_id, string_value) 
VALUES   (2, 11, 'Они попробуют спасти мир: малыш Харт и скала Джонсон');


INSERT INTO AttributeValues(film_id, attribute_id, text_value) 
VALUES (3, 1, 'Об этом фильме лучше всего говорят сами авторы устами одного из своих персонажей: «Почти 3 часа безудержного самолюбования, заканчивающегося невообразимо плоским финалом». В этой характеристике можно узреть здоровую самоиронию, что, несомненно, достойно повышения итоговой оценки. Но, откровенно говоря, просмотр был скучным.');

INSERT INTO AttributeValues (film_id, attribute_id, text_value) 
VALUES (3, 3, 'Актеры в лице Тома Хенкса, Холи Бери, и Хью Гранта не спасают. Их актерская игра вымарана калейдоскопным повествованием скучных сюжетов с претензией на лихо закрученную гениальную сказку. Есть чуть-чуть зачем-то вставленного секса (можно было обойтись и без для лучшего рейтинга), есть гей-юноша композитор.');

INSERT INTO AttributeValues (film_id, attribute_id, text_value) 
VALUES (3, 6, '2021-06-10');

INSERT INTO AttributeValues (film_id, attribute_id, text_value) 
VALUES (3, 7, '2021-06-15');

INSERT INTO AttributeValues (film_id, attribute_id, datetime_value) 
VALUES  (3, 8, '2021-06-01 00:00:00');

INSERT INTO AttributeValues (film_id, attribute_id, datetime_value) 
VALUES  (3, 9, '2021-05-27 00:00:00');

INSERT INTO AttributeValues (film_id, attribute_id, int_value) 
VALUES   (3, 10, '172');

INSERT INTO AttributeValues (film_id, attribute_id, float_value) 
VALUES   (3, 12, '102000000');

INSERT INTO AttributeValues (film_id, attribute_id, int_value) 
VALUES  (3, 13, '18');

INSERT INTO AttributeValues (film_id, attribute_id, string_value) 
VALUES   (3, 11, 'Всё взаимосвязано');

INSERT INTO AttributeValues (film_id, attribute_id, bool_value) 
VALUES   (3, 5, true); 


INSERT INTO halls (name) VALUES ('Зал1'), ('Зал2'); 

INSERT INTO 
    "sessions" (hall_id, film_id, start_at) 
VALUES 
    (1, 1, TIMESTAMP '2023-10-12 10:00:00'),
    (2, 2, TIMESTAMP '2023-10-12 10:00:00'),  
    (1, 3, TIMESTAMP '2023-10-12 12:00:00'),
    (2, 1, TIMESTAMP '2023-10-12 12:00:00'),
    (1, 1, TIMESTAMP '2023-10-12 16:00:00'),
    (2, 2, TIMESTAMP '2023-10-12 16:00:00'),
    (1, 3, TIMESTAMP '2023-10-12 19:00:00'),
    (2, 1, TIMESTAMP '2023-10-12 19:00:00'),
    (1, 1, TIMESTAMP '2023-10-12 22:00:00'),
    (2, 2, TIMESTAMP '2023-10-12 22:00:00'),
    (1, 3, TIMESTAMP '2023-11-01 10:00:00'),
    (2, 1, TIMESTAMP '2023-11-01 10:00:00'),
    (1, 2, TIMESTAMP '2023-11-01 12:00:00'),
    (2, 3, TIMESTAMP '2023-11-01 12:00:00'),
    (1, 2, TIMESTAMP '2023-11-01 16:00:00'),
    (2, 1, TIMESTAMP '2023-11-01 16:00:00'),
    (1, 3, TIMESTAMP '2023-11-01 19:00:00'),
    (2, 2, TIMESTAMP '2023-11-01 19:00:00'),
    (1, 3, TIMESTAMP '2023-11-01 22:00:00'),
    (2, 2, TIMESTAMP '2023-11-01 22:00:00');
--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1 (Debian 16.1-1.pgdg120+1)
-- Dumped by pg_dump version 16.1 (Debian 16.1-1.pgdg120+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Data for Name: film_attributes_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.film_attributes_types (id, name, type) FROM stdin;
1	Целое число	int
2	Год	int
3	Продолжительность	time
4	Дата	date
5	Дробное	float
6	Список	checkbox
7	Текст	text
\.


--
-- Data for Name: film_attributes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.film_attributes (id, name, type_id, title) FROM stdin;
2	year	1	Год выпуска
7	description	7	Описание
5	rating_kp	5	Рейтинг кинопоиска
8	rating_imdb	5	Рейтинг imdb
3	movieLength	3	Продолжительность
9	genres	6	Жанры
10	premiere	4	Премьера
4	persons	6	Актеры
11	start_seances	4	Начало сеансов
\.


--
-- Data for Name: films; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.films (id, name, length, kp_id) FROM stdin;
1	Тёща	01:38:00	5330291
5	Хоккейные папы	02:11:00	4920181
2	Дворец	01:40:00	4472264
6	Проклятие дудочника 	01:31:00	4414461
7	Паранормальные явления: Другое измерение 	01:41:00	5322923
8	Мой мир Shinee	01:51:00	5401992
9	Астрал. Сомния 	01:27:00	4652728
10	Королевство зверей 	02:08:00	4876740
11	Призраки в Венеции	01:43:00	5135249
12	Щенячий патруль: Мегафильм	01:32:00	4708940
13	Пять ночей с Фредди	01:50:00	952158
4	Немая ярость	01:44:00	4908570
3	По щучьему велению	01:55:00	4959134
\.


--
-- Data for Name: film_attributes_vals; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.film_attributes_vals (film_id, attr_id, val) FROM stdin;
6	2	2023
6	3	5460
1	2	2023
1	3	5880
1	7	Ольга Николаевна — волевая женщина и начальница ЖКХ, которая вполне довольна своей жизнью. Она хозяйка дома и на работе, полностью контролирует своего мужа Романа Павловича и оберегает дочь Варю. Единственный, кто не вписывается в её счастливую картину мира, — это зять Виктор, от которого на днях должна родить горячо любимая дочка. И вот однажды шквал взаимных претензий становится так велик, что прямо на семейном празднике ситуация выходит из-под контроля.
1	5	6.077
1	9	комедия
1	4	Лариса Гузеева|Гарик Харламов|Настасья Самбурская|Александр Лыков|Марк Богатырев|Никита Тарасов|Анна Уколова|Толепберген Байсакалов|Жаныл Асанбекова|Ёла Санько|Игорь Сычев |Аскар Узабаев|Тимофей Шалаев|Александр Дмитриев|Тимур Вайнштейн|Михаил Погосов|Евгений Мишиев|Иван Ильин|Виолетта Титовская|Сауле Юсупова|Маргарита Родина|Ерзия Ертлес|Аскар Узабаев
1	10	2023-11-30
5	2	2023
5	3	7860
5	7	Андрей — тренер детской хоккейной команды маленького провинциального городка. Размеренную жизнь героя нарушает известие о том, что единственный в городе ледовый дворец, где он тренирует детей, собираются снести. Единственная возможность его спасти — победить в любительском турнире по хоккею. У Андрея есть всего несколько месяцев для того, чтобы собрать команду и подготовить её к играм. Отцы маленьких хоккеистов решают сами выйти на лед и побороться за будущее своих детей.
5	5	7.829
5	9	спорт|семейный
5	4	Алексей Бардуков|Аня Чиповская|Михаил Пореченков|Юрий Чурсин|Алексей Кравченко|Владислав Ветров|Сергей Перегудов|Александр Обласов|Полина Гагарина|Даниил Вахрушев|Алексей Чинцов|Анна Утробина|Андрей Булатов|Максим Смирнов|Сергей Федотов|Андрей Булатов|Андрей Полубояринов|Андрей Каторженко|Андрей Гуркин|Екатерина Михайлова|Андрей Гуркин|Анастасия Трубчевская|Екатерина Михайлова|Андрей Булатов
5	10	2023-11-23
2	2	2023
2	3	6000
2	7	31 декабря 1999 года. Роскошный отель в Швейцарии и его гости-миллионеры готовятся к самому долгожданному Новому году. Впереди ночь, полная самых разных причуд, пороков и странностей богатых и знаменитых.
2	5	6.148
2	8	5.1
2	9	комедия
2	4	Оливер Мазуччи|Микки Рурк|Фанни Ардан|Джон Клиз|Милан Пешель|Александр Петров|Жоакин де Алмейда|Фортунато Серлино|Бронвин Джеймс|Дэнни Экснар|Александр Деспла|Клаудия Ди Берардино|Паскуале Риччарди|Карло Поджоли|Моника Сирони|Роман Полански|Эрве де Люз|Павел Эдельман|Лука Барбарески|Войцех Гостомчик|Жан-Луи Порше|Пётр Богуш|Владимир Зайцев|Владимир Еремин|Любовь Германова|Борис Быстров|Дмитрий Филимонов|Ева Пясковска|Роман Полански|Ежи Сколимовский
2	10	2023-11-23
6	7	Древняя легенда о Пегом Дудочнике пугала людей на протяжении веков. Но что, если не все в ней вымысел, а мистический странник в пёстром костюме, который безжалостно обрекал целые поселения на смерть, существует? Мэл далека от древних историй: она обычный музыкант в современном мире и старается лишь обеспечить свою дочь. Однажды ей удается наиграть мелодию, способную вводить людей в транс, но таким даром легендарный Гамельнский крысолов делиться не станет. Теперь древнее зло опять появится в этом мире, чтобы написать новую кровавую историю.
6	8	5.6
6	9	ужасы
6	4	Шарлотта Хоуп|Джулиан Сэндс|Оливер Сэвелл|Кейт Николс|Филипп Кристофер|Алексис Родни|Саломе Чандлер|Пиппа Уинслоу|Ива О’Флэнаган|Боян Анев|Кристофер Янг|Анна Боянова|Эрлингур Тороддсен|Майкл Дж. Дути|Дэниэл Кац|Джеффри Гринштейн|Бернард Кира|Ярив Лернер|Тэннер Мобли|Ирина Обрезкова|Валентин Морозов|Арсений Рогов|Ирина Чумантьева|Александр Васильев|Эрлингур Тороддсен
6	10	2023-11-30
7	2	2023
7	3	6060
7	7	Команда разработчиков игр на основе городских страшилок решает провести тестирование нового продукта в настоящем доме с паранормальными явлениями. По легенде, местные призраки заводят непрошенных гостей в другое измерение и заставляют плутать там в бесконечном лабиринте ужаса. Специалисты по хоррор-играм столкнутся здесь с настоящими потусторонними силами и должны будут переиграть призраков в их собственной игре.
7	5	4.704
7	8	5.8
7	9	ужасы
7	4	Джей.Си. Линь|Чжан Нин|Саммер Мэн|Ван Юйсюань|Вера Ень|Вон Киньвай|Ли Рошунь|Лю Шоусян|Лестер Ши|Шон Чун|Хао Босян|Олег Фёдоров|Наталья Терешкова|Иван Чабан|Дмитрий Стрелков|Ирина Обрезкова|Чжан Гэнмин|Хао Босян|Лу Шиюань
7	10	2023-11-30
8	2	2023
8	3	6660
8	7	История кей-поп-группы SHINee на протяжении 15 лет.
8	5	8.71
8	9	документальный|концерт|музыка
8	4	Shinee|Оню|Ки|Минхо|Тхэмин|Ким Джон-хён
8	10	2023-11-30
9	2	2022
9	3	5220
9	7	Эпидемия ковида, все сидят в изоляции, нервы на пределе. Когда Моник узнает, что у ее подруги Мэвис проблемы, она нарушает условия карантина и спешит на помощь. Но все не так просто, дело тут не в вынужденном одиночестве и не в заразном вирусе. Мэвис одолевают необычные ночные кошмары, в которых сон и явь переплетаются между собой, и даже смерть может быть реальной. Пытаясь помочь подруге справиться с ее страхами, Моник сама «заболевает кошмарами» и оказывается втянута в мир снов, где ей предстоит сразиться с жуткой сверхъестественной сущностью.
9	5	4.255
9	8	5.6
9	9	ужасы
9	4	Эмили Дэвис|Рэймонд Энтони Томас|Стефани Рот Хаберли|Гэбби Бинс|Лаура Хейслер|Коуди Брэверман|Кэндис Эдкинс|Джей Данн|Ричард В. Кинг|Анита Морено|Энди Миттон|Соня Фольтарц|Кендес Фелан|Энди Миттон|Энди Миттон|Людовика Исидоре|Джей Данн|Ричард В. Кинг|Альваро Бакеро Бенедетти|Кэссиди Фриман|Наталья Терешкова|Олег Фёдоров|Мария Цветкова-Овсянникова|Екатерина Ландо|Александра Богданович|Энди Миттон
9	10	2023-11-16
10	2	2023
10	3	7680
10	7	Мир охвачен волной неизвестной мутации, которая превращает людей в зверей. Опасны ли мутанты? Как передаётся заболевание? \nФрансуа делает всё, чтобы спасти свою заражённую жену Лану. Когда её отправляют в больничный филиал на юге Франции, он с 16-летним сыном Эмилем едет следом. В результате аварии некоторые из существ, среди которых может быть жена Франсуа, исчезают. Отец с сыном начинают поиски Ланы, которые навсегда изменят их жизнь.
10	5	7.229
10	8	7.2
10	9	фантастика|драма|детектив|приключения
10	4	Ромен Дюрис|Поль Киршер|Адель Экзаркопулос|Том Мерсье|Билли Блэйн|Ксавьер Обер|Саадиа Бентайеб|Габриэль Кабальеро|Илиана Хелифа|Поль Мугуруза|Андреа Лазло Де Симоне|Себастьен Пан|Ариан Дора|Тома Кайе|Лилиан Корбей|Давид Кайе|Пьер Гиар|Филипп Боэффар|Ева Мачуэль|Кристоф Россиньон|Антон Эльдаров|Владимир Войтюк|Варвара Чабан|Станислав Тикунов|Ева Финкельштейн|Тома Кайе|Полин Мюнье
10	10	2023-11-30
11	2	2023
11	3	6180
11	7	Венеция. Вышедший на пенсию Эркюль Пуаро неохотно посещает спиритический сеанс, во время которого один из гостей оказывается убит. Бывший детектив берется за расследование.
11	5	6.649
11	8	6.5
11	9	детектив|криминал
11	4	Кеннет Брана|Кайл Аллен|Камилль Коттен|Джейми Дорнан|Тина Фей|Джуд Хилл|Эмма Лейрд|Келли Райлли|Риккардо Скамарчо|Мишель Йео|Хильдур Гуднадоуттир|Сузанна Кодоньято|Питер Расселл|Крис Стефенсон|Сэмми Шелдон|Селия Бобак|Кеннет Брана|Люси Дональдсон|Харис Замбарлукос|Энрико Балларин|Кеннет Брана|Мартин Керри|Марк Гордон|Виталий Давыдов|Евгений Сорокин|Татьяна Костюченко|Илья Шилкин|Лариса Паукова|Майкл Грин|Агата Кристи
11	10	2023-09-13
12	2	2023
12	3	5280
12	7	Волшебный метеор падает в Городе приключений и наделяет членов Щенячьего патруля сверхспособностями, тем самым превращая их в Мегащенков.
12	5	7.087
12	8	6
12	9	мультфильм|фантастика|приключения|детский
12	4	Маккенна Грейс|Тараджи П. Хенсон|Марсаи Мартин|Кристиан Конвери|Рон Пардо|Лил Рел Ховери|Ким Кардашьян|Крис Рок|Серена Уильямс|Алан С. Ким|Пинар Топрак||Кэллан Брункер|Эд Фуллер|Боб Барлен|Адам Бедер|Лаура Клуни|Андре Кутю|Мария Крылова|Ирина Кильфин|Анастасия Поплавская|Лидия Тарнавская|Кирилл Сафонов|Кит Чэпман|Кэллан Брункер|Боб Барлен|Шэйн Моррис
12	10	2023-09-21
13	2	2023
13	3	6540
13	7	Пытаясь сохранить опекунство над сестрёнкой, Майк Шмидт устраивается работать ночным охранником в «Freddy Fazbear’s» — некогда популярный, но ныне закрытый семейный развлекательный центр. Несколько лет назад, когда Майк был ещё ребёнком, его младшего брата похитил неизвестный, и к этому событию парень снова и снова возвращается во сне, пытаясь вспомнить лицо похитителя. На новой работе в его снах появляются новые подробности — кажется, это место хранит зловещие тайны.
13	5	5.841
13	8	5.5
13	9	ужасы|драма
13	4	Джош Хатчерсон|Пайпер Рубио|Элизабет Лэил|Мэттью Лиллард|Мэри Стюарт Мастерсон|Кэт Коннер Стерлинг|Дэвид Линд|Кристиан Стоукс|Джозеф Поликуин|Грант Фили||Лэндон Лотт|Марк А. Терри|Натали О’Брайэн|Клер Санчез|Эмма Тамми|Уилльям Палей|Эндрю Уэсман|Лин Монкриф|Расселл Биндер|Джейсон Блум|Скотт Коутон||Савва Самодуров|Ярослава Николаева|Катя Хейфец|Андрей Бибиков|Маргарита Корш|Сет Каддебэк|Эмма Тамми|Скотт Коутон|Крис Ли Хилл
13	10	2023-10-25
4	2	2023
4	3	6240
4	7	В ходе бандитской разборки случайная пуля лишает счастливую семью маленького сына, а его отца — голоса. Спустя год усиленной подготовки папа мальчика становится кошмаром для врагов в любой перестрелке, погоне или рукопашной. В годовщину трагедии он намерен разыграть безостановочную симфонию возмездия всем, кто встанет у него на пути. Теперь его действия скажут всё громче любых слов.
4	5	6.024
4	8	5.7
4	9	боевик|драма|криминал
4	4	Юэль Киннаман|Кид Кади|Арольд Торрес|Каталина Сандино Морено|Ёко Хамамура||Винни О’Брайэн|||Анджелес Ву|Марко Белтрами|Хульета Хименес|Хуан Фелипе Каттах|Мария Эстела Фернандес|Клаудия Брюстер|Джон Ву|Зак Стэнберг|Шэрон Мейр|Бэзил Иваник|Эрика Ли|Кристиан Меркури|Лори Тилькин|Михаил Данилюк|Валентина Варлашина|Роберт Арчер Линн
4	10	2023-11-30
3	2	2023
3	3	6900
3	7	Если ты идешь на рыбалку — будь готов к тому, что вытянешь рыбу своей мечты, волшебную Щуку, которая может исполнить три любых твоих желания. Только Емеля спустил два желания на ветер, а третье решил приберечь. Поэтому, чтобы добиться руки царской дочери Анфисы, придется ему действовать без волшебной силы, самому. А помогать ему будет Щука, которая без своей шкурки предстает обычной девушкой Василисой. Вместе им предстоит найти скатерть-самобранку, встретиться с Котом Баюном, отправиться в мрачное царство Кощея и понять, что настоящее чудо — это быть с тем, кого любишь.
3	5	7.233
3	8	6.6
3	9	фэнтези|приключения|семейный
3	4	Никита Кологривый|Мила Ершова|Алина Алексеева|Юрий Колокольников|Роман Мадянов|Фёдор Лавров|Агриппина Стеклова|Сергей Бурунов|Тимофей Меренков|Валерия Рустамова|Сергей Луран |Надежда Васильева|Ольга Михайлова|Александр Войтинский|Серик Бейсеу|Сергей Нестеров|Владимир Башта|Сергей Сельянов|Наталья Смирнова|Александр Горохов|Александр Архипов
3	10	2023-10-26
1	11	2023-12-20 00:00:00
5	11	2023-12-13 00:00:00
2	11	2023-12-13 00:00:00
6	11	2023-12-20 00:00:00
7	11	2023-12-20 00:00:00
8	11	2023-12-20 00:00:00
9	11	2023-12-06 00:00:00
10	11	2023-12-20 00:00:00
11	11	2023-10-03 00:00:00
12	11	2023-10-11 00:00:00
13	11	2023-11-14 00:00:00
4	11	2023-12-20 00:00:00
3	11	2023-11-15 00:00:00
\.


--
-- Data for Name: halls; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.halls (id, name, count_seats, price_ratio) FROM stdin;
1	Синий (1)	20	1
3	Красный (3)	40	0.95
2	Зеленый (2)	30	1.1
\.


--
-- Data for Name: halls_seat_schema; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.halls_seat_schema (seat_num, hall_id, price_ratio, "row", col) FROM stdin;
11	2	0.8	2	5
12	2	0.8	2	6
1	1	1	1	1
2	1	1	1	2
3	1	1	1	3
4	1	1	1	4
5	1	1	1	5
6	1	1	2	1
7	1	1	2	2
8	1	1	2	3
9	1	1	2	4
10	1	1	2	5
11	1	1	3	1
12	1	1	3	2
13	1	1	3	3
14	1	1	3	4
15	1	1	3	5
16	1	1	4	1
17	1	1	4	2
18	1	1	4	3
19	1	1	4	4
20	1	1	4	5
1	2	0.8	1	1
2	2	0.8	1	2
3	2	0.8	1	3
4	2	0.8	1	4
5	2	0.8	1	5
6	2	0.8	1	6
7	2	0.8	2	1
8	2	0.8	2	2
9	2	0.8	2	3
10	2	0.8	2	4
13	2	1	3	1
14	2	1	3	2
15	2	1	3	3
16	2	1	3	4
17	2	1	3	5
18	2	1	3	6
19	2	1	4	1
20	2	1.5	4	2
21	2	1.5	4	3
22	2	1.5	4	4
23	2	1.5	4	5
24	2	1.5	4	6
25	2	1.5	5	1
26	2	1.5	5	2
27	2	1.5	5	3
28	2	1.5	5	4
29	2	1.5	5	5
30	2	1.5	5	6
1	3	1	1	1
2	3	1	1	2
3	3	1	1	3
4	3	1	1	4
5	3	1	1	5
6	3	1	1	6
7	3	1	1	7
8	3	1	1	8
9	3	1	2	1
10	3	1	2	2
11	3	1	2	3
12	3	1	2	4
13	3	1	2	5
14	3	1	2	6
15	3	1	2	7
16	3	1	2	8
17	3	1	3	1
18	3	1	3	2
19	3	1	3	3
20	3	1	3	4
21	3	1	3	5
22	3	1	3	6
23	3	1	3	7
24	3	1	3	8
25	3	1	4	1
26	3	1	4	2
27	3	1	4	3
28	3	1	4	4
29	3	1	4	5
30	3	1	4	6
31	3	1	4	7
32	3	1	4	8
33	3	1	5	1
34	3	1	5	2
35	3	1	5	3
36	3	1	5	4
37	3	1	5	5
38	3	1	5	6
39	3	1	5	7
40	3	1	5	8
\.


--
-- Data for Name: seance_tikets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.seance_tikets (id, seance_id, user_id, seat_num, price) FROM stdin;
2	1	1060	7	167.20
3	1	1380	28	313.50
4	1	1376	1	167.20
5	1	1261	26	313.50
6	1	1417	15	209.00
7	1	1133	5	167.20
8	1	1089	19	209.00
9	1	1181	14	209.00
10	1	1198	9	167.20
11	1	1487	4	167.20
12	1	1023	11	209.00
13	1	1449	10	167.20
14	1	1362	25	313.50
15	1	1468	8	167.20
16	1	1425	23	313.50
17	1	1101	27	313.50
18	1	1404	30	313.50
19	1	1212	22	313.50
20	1	1268	13	209.00
21	1	1232	18	209.00
22	1	1434	24	313.50
23	1	1441	17	209.00
24	1	1480	3	167.20
25	3	1023	36	313.50
26	3	1475	28	313.50
27	3	1188	16	313.50
28	3	1172	15	313.50
29	3	1369	7	313.50
30	3	1204	17	313.50
31	3	1138	29	313.50
32	3	1418	30	313.50
33	3	1243	12	313.50
34	3	1323	39	313.50
35	3	1332	27	313.50
36	3	1350	20	313.50
37	3	1307	38	313.50
38	3	1074	8	313.50
39	3	1272	13	313.50
40	3	1196	32	313.50
41	3	1460	26	313.50
42	3	1066	4	313.50
43	3	1153	21	313.50
44	3	1442	11	313.50
45	3	1081	31	313.50
46	9	1018	2	330.00
47	9	1149	20	330.00
48	9	1186	19	330.00
49	9	1284	10	330.00
50	9	1181	8	330.00
51	9	1154	16	330.00
52	9	1206	4	330.00
53	9	1019	9	330.00
54	9	1460	11	330.00
55	9	1408	7	330.00
56	9	1477	5	330.00
57	9	1338	14	330.00
58	9	1059	13	330.00
59	9	1424	6	330.00
60	9	1458	3	330.00
61	9	1339	18	330.00
62	9	1435	17	330.00
63	10	1468	12	332.50
64	10	1291	18	332.50
65	10	1174	7	332.50
66	10	1297	4	332.50
67	10	1068	15	332.50
68	10	1489	5	332.50
69	10	1443	39	332.50
70	10	1179	11	332.50
71	10	1066	33	332.50
72	10	1476	21	332.50
73	10	1142	30	332.50
74	10	1224	9	332.50
75	10	1424	24	332.50
76	10	1334	29	332.50
77	10	1363	16	332.50
78	10	1260	1	332.50
79	10	1174	34	332.50
80	10	1225	13	332.50
81	10	1431	17	332.50
82	10	1051	28	332.50
83	10	1112	32	332.50
84	10	1378	2	332.50
85	10	1030	22	332.50
86	10	1284	35	332.50
87	10	1204	23	332.50
88	10	1246	37	332.50
89	11	1395	9	308.00
90	11	1485	5	308.00
91	11	1158	18	385.00
92	11	1257	6	308.00
93	11	1022	17	385.00
94	11	1446	7	308.00
95	11	1116	23	577.50
96	11	1429	13	385.00
97	11	1276	25	577.50
98	11	1460	8	308.00
99	11	1246	16	385.00
100	11	1256	28	577.50
101	11	1036	14	385.00
102	11	1199	20	577.50
103	11	1323	27	577.50
104	11	1018	10	308.00
105	11	1382	4	308.00
106	11	1413	24	577.50
107	11	1460	22	577.50
108	11	1278	1	308.00
109	11	1197	12	385.00
110	11	1022	29	577.50
111	11	1455	19	385.00
112	11	1423	21	577.50
113	11	1149	3	308.00
114	11	1472	2	308.00
115	12	1166	1	190.00
116	12	1107	15	190.00
117	12	1438	17	190.00
118	12	1344	6	190.00
119	12	1104	14	190.00
120	12	1154	13	190.00
121	12	1433	4	190.00
122	12	1073	8	190.00
123	12	1242	2	190.00
124	12	1212	16	190.00
125	12	1281	7	190.00
126	12	1058	18	190.00
127	12	1429	11	190.00
128	12	1289	3	190.00
129	12	1182	12	190.00
130	12	1262	5	190.00
131	12	1233	20	190.00
132	13	1371	6	270.00
133	13	1299	2	270.00
134	13	1471	3	270.00
135	13	1285	17	270.00
136	13	1220	12	270.00
137	13	1412	8	270.00
138	13	1169	4	270.00
139	13	1194	10	270.00
140	13	1178	5	270.00
141	13	1272	1	270.00
142	13	1085	19	270.00
143	13	1444	9	270.00
144	13	1346	20	270.00
145	14	1034	3	350.00
146	14	1253	1	350.00
147	14	1050	6	350.00
148	14	1293	12	350.00
149	14	1331	19	350.00
150	14	1443	9	350.00
151	14	1433	8	350.00
152	14	1490	2	350.00
153	14	1461	4	350.00
154	14	1209	17	350.00
155	14	1397	20	350.00
156	14	1012	13	350.00
157	14	1043	5	350.00
158	14	1398	11	350.00
159	14	1087	10	350.00
160	14	1019	7	350.00
161	14	1231	14	350.00
162	14	1105	15	350.00
163	14	1457	16	350.00
164	15	1393	16	350.00
165	15	1389	8	350.00
166	15	1332	3	350.00
167	15	1091	1	350.00
168	15	1105	20	350.00
169	15	1388	4	350.00
170	15	1435	14	350.00
171	15	1096	12	350.00
172	15	1187	10	350.00
173	15	1141	5	350.00
174	15	1110	2	350.00
175	15	1348	11	350.00
176	15	1399	13	350.00
177	15	1383	6	350.00
178	15	1166	7	350.00
179	16	1200	8	350.00
180	16	1235	7	350.00
181	16	1128	16	350.00
182	16	1375	9	350.00
183	16	1260	20	350.00
184	16	1432	19	350.00
185	16	1429	5	350.00
186	16	1131	3	350.00
187	16	1319	4	350.00
188	16	1341	12	350.00
189	16	1427	18	350.00
190	18	1156	31	180.50
191	18	1174	15	180.50
192	18	1397	26	180.50
193	18	1289	23	180.50
194	18	1101	40	180.50
195	18	1121	33	180.50
196	18	1102	4	180.50
197	18	1330	20	180.50
198	18	1202	17	180.50
199	18	1096	34	180.50
200	18	1308	27	180.50
201	18	1305	16	180.50
202	18	1322	11	180.50
203	18	1018	13	180.50
204	18	1291	1	180.50
205	18	1266	6	180.50
206	18	1208	5	180.50
207	18	1075	29	180.50
208	18	1227	32	180.50
209	18	1134	30	180.50
210	18	1293	21	180.50
211	18	1390	35	180.50
212	19	1485	18	363.00
213	19	1159	14	363.00
214	19	1051	21	544.50
215	19	1139	1	290.40
216	19	1206	13	363.00
217	19	1276	27	544.50
218	19	1122	16	363.00
219	19	1359	17	363.00
220	19	1403	28	544.50
221	19	1256	9	290.40
222	19	1257	12	363.00
223	19	1273	4	290.40
224	19	1022	20	544.50
225	19	1202	25	544.50
226	19	1271	6	290.40
227	19	1185	15	363.00
228	19	1294	30	544.50
229	19	1201	26	544.50
230	19	1082	8	290.40
231	19	1482	3	290.40
232	19	1470	23	544.50
233	19	1115	29	544.50
234	19	1229	24	544.50
235	19	1184	2	290.40
236	19	1032	7	290.40
237	19	1172	22	544.50
238	20	1145	1	313.50
239	20	1479	35	313.50
240	20	1202	30	313.50
241	20	1263	31	313.50
242	20	1231	19	313.50
243	20	1189	11	313.50
244	20	1054	13	313.50
245	20	1348	15	313.50
246	20	1414	17	313.50
247	20	1082	7	313.50
248	20	1109	24	313.50
249	20	1168	39	313.50
250	20	1211	21	313.50
251	20	1328	9	313.50
252	20	1380	38	313.50
253	20	1328	34	313.50
254	20	1462	37	313.50
255	20	1079	3	313.50
256	20	1387	10	313.50
257	20	1026	5	313.50
258	20	1211	22	313.50
259	20	1245	27	313.50
260	20	1062	14	313.50
261	20	1098	18	313.50
262	20	1221	23	313.50
263	20	1171	16	313.50
264	20	1315	12	313.50
265	20	1229	32	313.50
266	20	1217	25	313.50
267	20	1268	29	313.50
268	20	1359	26	313.50
269	20	1444	36	313.50
270	20	1265	33	313.50
271	20	1243	20	313.50
272	20	1420	6	313.50
273	20	1030	2	313.50
274	20	1053	40	313.50
275	21	1046	26	332.50
276	21	1013	3	332.50
277	21	1433	19	332.50
278	21	1431	40	332.50
279	21	1413	2	332.50
280	21	1234	8	332.50
281	21	1253	23	332.50
282	21	1073	24	332.50
283	21	1462	10	332.50
284	21	1305	18	332.50
285	21	1309	20	332.50
286	21	1464	1	332.50
287	21	1126	4	332.50
288	21	1417	16	332.50
289	21	1251	36	332.50
290	21	1142	6	332.50
291	21	1042	9	332.50
292	21	1342	27	332.50
293	21	1063	5	332.50
294	21	1044	30	332.50
295	21	1464	21	332.50
296	21	1428	33	332.50
297	21	1019	17	332.50
298	21	1115	11	332.50
299	21	1444	13	332.50
300	21	1288	28	332.50
301	21	1034	14	332.50
302	21	1129	35	332.50
\.


--
-- Data for Name: seances; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.seances (id, film_id, date, "time", hall_id, base_price) FROM stdin;
1	1	2023-12-03	10:15:00	2	190.00
3	1	2023-12-03	14:25:00	3	330.00
9	1	2023-12-03	15:50:00	1	330.00
10	1	2023-12-03	18:30:00	3	350.00
11	1	2023-12-03	19:40:00	2	350.00
12	3	2023-12-03	10:40:00	1	190.00
13	3	2023-12-03	13:05:00	1	270.00
14	3	2023-12-03	18:00:00	1	350.00
15	11	2023-12-03	20:25:00	1	350.00
16	11	2023-12-03	22:20:00	1	350.00
18	12	2023-12-03	10:10:00	3	190.00
19	12	2023-12-03	16:00:00	2	330.00
20	13	2023-12-03	16:25:00	3	330.00
21	13	2023-12-03	20:30:00	3	350.00
\.


--
-- Data for Name: settings; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.settings (name, val) FROM stdin;
curdate	2023-11-30
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email) FROM stdin;
1009	Bree Peters	ipsum.porta@aol.com
1010	Zeph Barry	adipiscing@aol.org
1011	Ginger Mcguire	curabitur.sed@hotmail.couk
1012	Fletcher Woods	aenean.eget@protonmail.couk
1013	Shannon Kaufman	cras.dictum@outlook.org
1014	Eagan Morrow	et.tristique@yahoo.com
1015	Cole Walker	consectetuer.rhoncus@yahoo.net
1016	Murphy Blake	orci.quis@hotmail.ca
1017	Hayes Rose	tempor@aol.net
1018	Sawyer Pennington	nibh.phasellus.nulla@aol.edu
1019	Jasper Rose	magna.nam@aol.ca
1020	Ivy Small	mauris.vestibulum@outlook.edu
1021	Derek Chase	elit.nulla.facilisi@icloud.edu
1022	Kim Dominguez	integer.eu@outlook.ca
1023	Ifeoma O'donnell	cras@aol.com
1024	Quyn Harrison	vel@outlook.ca
1025	Zena Mayo	urna.vivamus.molestie@icloud.net
1026	Garrison Miranda	luctus@icloud.couk
1027	Candice Barber	nec.ligula@hotmail.ca
1028	Olivia Levine	eros@outlook.edu
1029	Brandon Downs	duis.a@protonmail.ca
1030	Eaton Giles	et.magnis@outlook.ca
1031	Hiroko Gilliam	enim.sed@protonmail.com
1032	Fallon Aguilar	arcu.eu.odio@hotmail.couk
1033	Imogene Jackson	accumsan.laoreet@icloud.edu
1034	Zachery Underwood	diam.nunc.ullamcorper@yahoo.edu
1035	Cameron Pugh	arcu.imperdiet@outlook.com
1036	Megan Wyatt	mauris@hotmail.edu
1037	Ivy Petty	dolor.nulla@outlook.edu
1038	Lionel Murphy	suspendisse@protonmail.com
1039	Kennan O'donnell	morbi.accumsan.laoreet@protonmail.org
1040	Colorado Mcgee	dolor.fusce@aol.org
1041	Marvin Bailey	inceptos.hymenaeos@outlook.org
1042	Zelda Alvarado	praesent.eu.dui@icloud.edu
1043	Bertha Paul	at@icloud.couk
1044	Tanek Hale	aliquam@hotmail.org
1045	Hayfa Mcgowan	ultrices.iaculis.odio@icloud.com
1046	Talon Fulton	vel@hotmail.edu
1047	Britanni Wynn	eros@yahoo.edu
1048	Dawn Hudson	magna.sed@yahoo.edu
1049	Benedict Kent	nulla@yahoo.net
1050	Velma Ware	est@outlook.couk
1051	Vladimir Rodriguez	neque@hotmail.edu
1052	Noel Bullock	magna@yahoo.couk
1053	Audra Burton	erat.volutpat@protonmail.net
1054	Bernard Nolan	nam.consequat.dolor@hotmail.ca
1055	Todd Reed	consequat.dolor@protonmail.couk
1056	Damian Dunlap	vulputate.risus.a@google.com
1057	Ignatius Richardson	cubilia.curae@aol.org
1058	Matthew Charles	morbi.quis@hotmail.net
1059	Zelda Strickland	ligula.aenean.gravida@protonmail.edu
1060	Amy Short	lorem@outlook.edu
1061	Rebecca Lara	sagittis.augue@google.net
1062	Austin Branch	ligula.nullam@outlook.ca
1063	Brady Gallegos	vitae@aol.com
1064	Tanisha Ramos	tincidunt.adipiscing@outlook.edu
1065	MacKenzie Stout	hendrerit.a@outlook.net
1066	Colby Warren	nulla@aol.edu
1067	Hall Cruz	in.lobortis.tellus@protonmail.com
1068	Olivia Ross	primis.in.faucibus@protonmail.org
1069	Samuel Lynch	enim.mauris@aol.net
1070	Karyn Wood	sem.molestie@protonmail.ca
1071	Ishmael Oliver	gravida.sagittis@outlook.com
1072	Thomas Mcfarland	cursus@protonmail.ca
1073	April Mcdonald	sed.hendrerit@aol.org
1074	Wayne Mullen	praesent.luctus@icloud.org
1075	Christian Hubbard	duis@hotmail.edu
1076	Mona Hyde	convallis.ligula.donec@icloud.couk
1077	Garrison Watson	luctus@outlook.ca
1078	Alea Fitzgerald	mus.proin@aol.couk
1079	Tanya Moran	sit.amet.ante@yahoo.net
1080	Harper Norman	vitae.aliquam.eros@yahoo.ca
1081	Isabella Ferrell	nullam.scelerisque@protonmail.ca
1082	Lester Booker	iaculis.odio@outlook.org
1083	Vincent Lancaster	nunc@outlook.edu
1084	Jared Faulkner	magna.malesuada.vel@protonmail.org
1085	Zenia Rosales	diam.luctus.lobortis@yahoo.edu
1086	Felix Pitts	dictum.placerat.augue@aol.net
1087	Cadman Alford	risus.varius.orci@protonmail.edu
1088	Nell Zamora	non@protonmail.edu
1089	Lionel Brock	dui.cum.sociis@icloud.com
1090	Malik Conley	dui.fusce@yahoo.org
1091	Valentine Richards	cum.sociis@yahoo.net
1092	Unity Henry	dictum.cursus@icloud.org
1093	Martina Nielsen	odio.sagittis@aol.org
1094	Lois Rojas	fusce@icloud.couk
1095	Lee Schultz	massa@hotmail.net
1096	Gannon Lara	dictum.eu@icloud.org
1097	Sylvia Mack	metus.facilisis@aol.net
1098	Carlos Cote	duis.cursus@protonmail.edu
1099	Chiquita Rosales	accumsan@protonmail.org
1100	Mason Tyler	in.faucibus@icloud.org
1101	Marshall Cherry	nibh.dolor@protonmail.ca
1102	Conan Bennett	magna.lorem@google.org
1103	Mannix Barber	neque.vitae@protonmail.edu
1104	Rogan Schroeder	ligula.aliquam@aol.couk
1105	Macon Curtis	penatibus@aol.org
1106	Latifah Hays	magna.sed@hotmail.com
1107	Abel Woodward	ornare.placerat@outlook.ca
1108	Hunter Burgess	purus.sapien.gravida@icloud.net
1109	Prescott Cross	nec.cursus@google.org
1110	Baxter Harris	nullam.feugiat@hotmail.com
1111	Abra Rosa	quisque.porttitor@aol.couk
1112	Sophia Weaver	in.faucibus@protonmail.ca
1113	Gareth Hogan	malesuada@aol.ca
1114	Benedict Higgins	sapien@outlook.edu
1115	Talon Mcfadden	metus.aliquam.erat@aol.couk
1116	Knox Oliver	faucibus.orci@icloud.org
1117	Gisela O'brien	ipsum.non.arcu@icloud.org
1118	Teagan Perkins	massa@google.net
1229	Tanner Glover	vel.quam@outlook.edu
1119	Gwendolyn Hardin	amet.dapibus@aol.edu
1120	Talon Smith	lobortis.augue.scelerisque@protonmail.ca
1121	Mufutau Robertson	tempus@hotmail.couk
1122	Angelica Ratliff	massa.non@google.net
1123	Octavius Gomez	nisi.dictum.augue@yahoo.couk
1124	Cathleen Kerr	tempor@outlook.ca
1125	Cynthia Gill	torquent.per@protonmail.net
1126	Jade Estrada	mollis.dui@outlook.couk
1127	Sarah Rhodes	arcu.vestibulum@hotmail.com
1128	Marcia Gallagher	nec.tempus@yahoo.edu
1129	Kelly Holman	blandit.at.nisi@google.com
1130	Kenyon Shaw	urna.nullam.lobortis@yahoo.ca
1131	Wang Key	tortor.at.risus@outlook.net
1132	Virginia Hester	dictum.proin.eget@icloud.com
1133	Fiona Cain	vestibulum.mauris@icloud.ca
1134	Herrod Luna	ut.nec.urna@outlook.org
1135	Liberty George	in.faucibus.morbi@yahoo.couk
1136	Ariel Raymond	et.magnis.dis@icloud.couk
1137	Bruce Floyd	proin.velit@google.edu
1138	Brennan Hebert	a1@aol.net
1139	Palmer Carpenter	nulla@hotmail.couk
1140	Fredericka Rodriguez	purus@google.net
1141	Kellie Atkins	sapien.cras.dolor@google.edu
1142	Kieran Joseph	non@aol.org
1143	Quamar Wilson	enim.suspendisse@yahoo.edu
1144	Tatyana Frank	tellus.justo@aol.net
1145	Akeem Petty	morbi.quis@icloud.org
1146	Amena Jackson	erat.sed@aol.net
1147	Delilah Perez	in.lobortis@google.org
1148	Flavia Garner	nunc.lectus@google.couk
1149	Mohammad Huffman	rutrum.lorem@icloud.couk
1150	Ezekiel Weaver	augue.eu@protonmail.ca
1151	Veda Carr	scelerisque.sed@protonmail.ca
1152	Anthony Gould	class@outlook.org
1153	Rhoda Clarke	sed.nunc@aol.com
1154	Halee Dalton	eget.odio.aliquam@protonmail.com
1155	Charlotte Armstrong	proin.mi@outlook.net
1156	Nathaniel Ferrell	vel.vulputate.eu@google.com
1157	Nigel Moore	lorem.eu@google.ca
1158	Vladimir Daniel	odio.sagittis.semper@protonmail.ca
1159	Yardley Bullock	vehicula.aliquet@protonmail.com
1160	Phelan Avery	parturient.montes.nascetur@yahoo.org
1161	Anika Joyce	fermentum.convallis@yahoo.ca
1162	Richard Beasley	eu.tellus@protonmail.org
1163	Stephen Mcgee	mauris@protonmail.ca
1164	Olympia Sawyer	eu.tempor@aol.ca
1165	Laura Robles	nascetur.ridiculus@aol.ca
1166	Leonard Booth	rutrum@outlook.ca
1167	Maggie Gilliam	parturient.montes@google.net
1168	Mark Padilla	quis.turpis.vitae@icloud.ca
1169	Jesse Franks	malesuada@aol.net
1170	Amethyst Shields	aliquet.magna@yahoo.com
1171	Vernon Goodman	ipsum.leo@yahoo.ca
1172	Priscilla Graves	eu.tempor.erat@outlook.com
1173	Lavinia Horn	mi.enim@google.com
1174	Sacha Burns	urna@protonmail.org
1175	Amethyst O'Neill	sit.amet@google.couk
1176	Melyssa Evans	nibh.vulputate@icloud.org
1177	Diana Gilmore	in.scelerisque@google.com
1178	Roth Justice	massa@hotmail.couk
1179	Madeline Poole	vel@aol.net
1180	Illana Rojas	risus.nunc@yahoo.ca
1181	Yetta Brewer	bibendum@yahoo.net
1182	Maggy Crawford	mollis.duis.sit@outlook.net
1183	Chelsea Mendez	diam.luctus@yahoo.edu
1184	Barrett Cox	scelerisque.neque@google.net
1185	Nigel Evans	interdum.ligula@yahoo.couk
1186	Cody Stein	diam.dictum@yahoo.ca
1187	Bruce Sargent	dictum@aol.net
1188	Genevieve Davidson	mi@hotmail.edu
1189	Micah Brennan	libero.morbi@outlook.org
1190	Britanney Oneil	volutpat.nulla@icloud.com
1191	Liberty Clay	pretium.aliquet@icloud.couk
1192	Gil Coleman	tellus.aenean@yahoo.ca
1193	Miriam Peterson	congue.in.scelerisque@yahoo.com
1194	Quynn Bean	a.ultricies.adipiscing@hotmail.net
1195	Roanna Brady	nam@protonmail.ca
1196	Adena Morris	nec.tempus@google.net
1197	Craig Hogan	egestas.duis@aol.org
1198	Shaeleigh James	quam.a.felis@protonmail.couk
1199	Tobias Gibbs	cras.eget@yahoo.com
1200	Rajah Guzman	nascetur.ridiculus.mus@google.org
1201	Yoko Simon	quisque.varius.nam@aol.ca
1202	Reece Cash	sit.amet@icloud.org
1203	Peter Bernard	neque.morbi@outlook.edu
1204	Mannix Zamora	ridiculus.mus@hotmail.ca
1205	Lysandra Marshall	augue.malesuada.malesuada@yahoo.org
1206	Mari Olson	sit@hotmail.ca
1207	Bethany Crane	elit.aliquam.auctor@aol.edu
1208	Scott Solomon	ac.metus.vitae@yahoo.edu
1209	Nerea Ramos	auctor.vitae@icloud.edu
1210	Joan Wood	orci.luctus@google.org
1211	Brennan Hutchinson	feugiat.sed@aol.edu
1212	Isaiah Cox	eu@icloud.net
1213	Lane Martin	primis.in@google.org
1214	Otto Schroeder	enim.diam.vel@google.ca
1215	Maile Walsh	dolor.dolor@aol.org
1216	Elvis Griffin	a.scelerisque@google.com
1217	Dustin Hart	fusce.fermentum@google.org
1218	Cathleen Durham	ut.quam@yahoo.ca
1219	Oleg Burns	aliquet.magna.a@icloud.ca
1220	Samson Sandoval	adipiscing.elit.aliquam@aol.couk
1221	Randall Blankenship	hendrerit.consectetuer@icloud.org
1222	Kerry Hughes	mus.aenean@google.edu
1223	Jenna Mcfarland	in.tincidunt@icloud.couk
1224	Adrienne Witt	in.tempus@google.org
1225	Robin Carson	ipsum.dolor@yahoo.couk
1226	Tatum Tyler	ante.iaculis@protonmail.net
1227	Arden Navarro	cursus.purus.nullam@icloud.ca
1228	Colby Bowers	nunc.mauris.sapien@outlook.couk
1230	Maris Cantu	velit.eget@google.ca
1231	Yuli Mayo	non@google.net
1232	Theodore Allen	in@aol.org
1233	Adara Burnett	ipsum.donec.sollicitudin@hotmail.couk
1234	Nolan Carpenter	diam.at.pretium@outlook.edu
1235	Juliet Cunningham	scelerisque.scelerisque.dui@yahoo.net
1236	Donovan Owens	luctus.et@google.org
1237	Laurel Carson	metus@hotmail.couk
1238	Calista Guerra	consequat@google.couk
1239	Orla Sandoval	eros.non@protonmail.edu
1240	Brett Floyd	donec.consectetuer@outlook.couk
1241	Kennedy Barker	eget.magna.suspendisse@yahoo.couk
1242	Nathaniel Bauer	libero@icloud.ca
1243	Keith Reynolds	nec.mollis@aol.com
1244	Drake Day	in@aol.edu
1245	Roanna Stafford	dignissim@outlook.couk
1246	Raja Sargent	sit.amet.luctus@aol.couk
1247	Nathan Gutierrez	nunc.sed@protonmail.org
1248	Len Petersen	et@hotmail.org
1249	Rhonda Donovan	semper@icloud.net
1250	Timothy Moran	nunc.ullamcorper@hotmail.edu
1251	Macon Lowe	ipsum.cursus@aol.com
1252	Jacob Abbott	curabitur.massa.vestibulum@yahoo.com
1253	Plato Mcclure	sem@yahoo.ca
1254	Bell Cochran	ultricies.ornare.elit@icloud.org
1255	Brock Meadows	mauris.blandit@yahoo.com
1256	Yardley Molina	non.luctus@protonmail.net
1257	Daniel Vaughn	ante.blandit@aol.com
1258	Macy Terry	ipsum@outlook.edu
1259	Bert Justice	nam.porttitor@icloud.net
1260	Zeph Bridges	amet@outlook.org
1261	Orlando Joyner	parturient.montes@outlook.edu
1262	Brandon Fuller	aliquet@outlook.couk
1263	Evelyn Bond	sodales.purus@icloud.com
1264	Lawrence Key	a.arcu@aol.net
1265	Sara Wolf	malesuada.fringilla@yahoo.ca
1266	Stephanie Flores	ridiculus.mus@google.org
1267	Calista Sullivan	mauris@yahoo.org
1268	Jolie Hogan	hendrerit.a@google.edu
1269	Indira Cleveland	a@aol.net
1270	Stacy Mathis	nullam.ut.nisi@icloud.com
1271	Hayfa Mcdowell	eget.ipsum@yahoo.edu
1272	Jane Mosley	ac@outlook.net
1273	Neville Hart	vehicula.pellentesque@icloud.net
1274	Keaton Dennis	neque.in@yahoo.com
1275	Ulric Mcgowan	cum.sociis.natoque@aol.org
1276	Riley Buck	id@protonmail.ca
1277	Violet Chen	libero.mauris@icloud.net
1278	Lionel Bright	vulputate.mauris@outlook.com
1279	Colton Tyler	aliquam.erat@aol.ca
1280	Gareth Bullock	sit.amet@aol.com
1281	Leila Lang	parturient.montes.nascetur@icloud.org
1282	September Graham	inceptos.hymenaeos@yahoo.net
1283	Kermit Chapman	dignissim.maecenas@protonmail.com
1284	Xanthus Ramirez	eget.volutpat@icloud.ca
1285	Jaden Snider	facilisis.suspendisse@google.edu
1286	Bevis Faulkner	sem.pellentesque@google.couk
1287	Dante Dodson	morbi.quis@hotmail.couk
1288	Dalton Madden	nulla.facilisi@google.org
1289	Maxwell Dunlap	vestibulum@google.com
1290	Rajah Sanford	donec@aol.edu
1291	Beau O'Neill	vulputate.posuere@yahoo.edu
1292	Desirae Stout	risus@yahoo.couk
1293	Reese Stewart	purus.gravida.sagittis@aol.couk
1294	Nero Rosario	purus.gravida@icloud.couk
1295	Fiona Martinez	diam.proin@aol.org
1296	Aretha Park	eu@google.ca
1297	Norman Head	vivamus.molestie.dapibus@outlook.net
1298	Holly Calhoun	metus.in@aol.edu
1299	Constance Hull	a.malesuada@protonmail.net
1300	Hedy Dawson	interdum.sed@yahoo.couk
1301	Warren Whitehead	pellentesque@hotmail.net
1302	Hayden Yang	nunc@yahoo.org
1303	Lillian Castro	vitae.orci@google.ca
1304	Danielle Morrow	vestibulum.ut.eros@outlook.com
1305	Jamalia Mcneil	ligula1@hotmail.org
1306	Daphne Morrison	et.magnis@protonmail.edu
1307	Jesse Davidson	dolor.vitae.dolor@google.com
1308	Priscilla Vega	est.mauris@icloud.net
1309	Colin Roberts	donec.nibh.quisque@hotmail.org
1310	Thomas Mays	senectus.et.netus@hotmail.couk
1311	Yoko Shaffer	cursus.in@outlook.edu
1312	Whitney Trujillo	purus.nullam@icloud.net
1313	Roary Cardenas	libero@yahoo.ca
1314	Wylie Short	neque@google.com
1315	Tashya Bush	aliquam.tincidunt@google.ca
1316	Alden Cannon	lectus@hotmail.com
1317	Marah Dejesus	vel.turpis@icloud.edu
1318	Ella Weber	morbi.tristique@outlook.edu
1319	Breanna Holt	natoque.penatibus@protonmail.net
1320	Upton Howard	aliquam.eu@protonmail.org
1321	Russell Kline	quis.accumsan.convallis@protonmail.net
1322	Claire Woodard	libero.morbi.accumsan@yahoo.ca
1323	Upton Hahn	sem@hotmail.edu
1324	Carl Harding	diam.lorem@icloud.couk
1325	Ulysses Pugh	quis@icloud.couk
1326	Cain O'donnell	porttitor.eros@icloud.edu
1327	Rose Clayton	semper.rutrum.fusce@protonmail.net
1328	Carol Hatfield	mi.lacinia.mattis@protonmail.org
1329	Ferdinand Frank	pede.et@icloud.edu
1330	Olivia Cote	turpis.in@outlook.edu
1331	Rooney Bradshaw	habitant.morbi@icloud.org
1332	Ila Mccall	mattis.integer@google.com
1333	Brady Mueller	pede@google.net
1334	September Wilkerson	vitae@aol.org
1335	Fulton Beard	mauris.non@hotmail.org
1336	Delilah Murray	quis@hotmail.org
1337	Sara Shaw	justo.proin@protonmail.net
1338	Unity Calhoun	odio@hotmail.couk
1339	Rebekah Bender	egestas.aliquam@google.edu
1340	Edward Barron	turpis@google.ca
1341	Molly Carney	orci.sem.eget@google.net
1342	Wynter Morgan	augue.ac@aol.ca
1343	Deacon Massey	cum.sociis.natoque@google.net
1344	Tasha Daniel	orci.lobortis@aol.ca
1345	Petra Simon	velit.egestas@yahoo.ca
1346	Cruz Alston	mattis@google.ca
1347	Gavin Holman	elit.a@outlook.ca
1348	Lane Walters	amet.metus@yahoo.org
1349	Amena Summers	ipsum.donec@google.net
1350	Shay Weiss	in.faucibus@outlook.net
1351	Vaughan Montgomery	auctor.non.feugiat@yahoo.org
1352	Nash Bowers	lacus.varius@protonmail.couk
1353	Carl Weiss	orci.lacus@yahoo.couk
1354	Melanie Schultz	nec.ligula.consectetuer@aol.ca
1355	Uta Bond	in@icloud.edu
1356	Drew Wagner	eget.varius@protonmail.ca
1357	Rosalyn Bass	varius.et@protonmail.ca
1358	Perry Jennings	et.nunc@icloud.net
1359	Mollie Greene	lacus.cras.interdum@outlook.com
1360	Desiree Gallegos	eu@yahoo.com
1361	Ivan Gutierrez	tristique@hotmail.ca
1362	Kane Carver	nibh@hotmail.org
1363	Maris Mercado	a.odio.semper@outlook.net
1364	Urielle Giles	magna.phasellus.dolor@icloud.ca
1365	Iris Blevins	nunc@outlook.org
1366	Vance Wall	interdum.libero@aol.couk
1367	Grady Simpson	in.cursus@hotmail.couk
1368	Lavinia Berger	pede.ac.urna@hotmail.com
1369	Althea Hicks	luctus@google.couk
1370	Blake Berger	augue@icloud.net
1371	Geoffrey Clarke	egestas.aliquam@outlook.ca
1372	Claudia Meadows	porttitor@aol.couk
1373	Shannon Ramirez	scelerisque.lorem.ipsum@hotmail.ca
1374	Elijah Sosa	odio.phasellus@hotmail.org
1375	Jenna Walter	lorem.ipsum.dolor@google.com
1376	Quentin Hatfield	donec.nibh@yahoo.org
1377	Paul Dennis	penatibus.et@outlook.couk
1378	Mary Frost	nibh@google.org
1379	Kameko Elliott	et@protonmail.ca
1380	Damon West	convallis.ligula@icloud.net
1381	Penelope Roman	sodales.mauris@outlook.ca
1382	Sylvia Craft	sed@protonmail.edu
1383	Oprah Morton	ac.tellus@google.couk
1384	Sharon Mcintosh	diam.sed.diam@protonmail.ca
1385	Thomas Tyler	aliquam@outlook.couk
1386	Florence Mclaughlin	urna@icloud.com
1387	Sybil Franklin	auctor.ullamcorper@yahoo.couk
1388	Uma Britt	sodales.purus.in@aol.ca
1389	Ciara Winters	aenean@icloud.org
1390	Sebastian Davis	mi.eleifend@hotmail.couk
1391	Mona Williamson	tincidunt.tempus@yahoo.net
1392	Maggy Caldwell	metus.vitae@aol.org
1393	Sacha Sweeney	ornare.egestas@yahoo.edu
1394	Tanek Snider	ut.odio@outlook.org
1395	Aurora Mckinney	malesuada@yahoo.ca
1396	Bruno Brewer	cras@hotmail.edu
1397	April Emerson	purus@hotmail.com
1398	Giacomo Nguyen	donec@google.ca
1399	Wang Lara	ante.blandit@yahoo.com
1400	Melissa Mccray	lacus.pede@google.com
1401	Lillian Pruitt	non.lorem.vitae@protonmail.couk
1402	Rhoda Fisher	neque.morbi.quis@protonmail.net
1403	Quinn Strong	quam.a@icloud.edu
1404	Cecilia Vargas	eget.ipsum@yahoo.ca
1405	Cyrus Black	suspendisse.aliquet@protonmail.edu
1406	Kuame Christian	dolor.nonummy@icloud.couk
1407	Hilel Duke	morbi@icloud.net
1408	Clark Mullen	aliquam@hotmail.ca
1409	Lydia Colon	arcu@hotmail.com
1410	Herman Cardenas	consequat@google.ca
1411	Gareth Jacobs	eget@icloud.edu
1412	Jacob Torres	consectetuer@outlook.ca
1413	Kieran Schmidt	dapibus.quam@yahoo.edu
1414	Axel Bowers	eu.nulla.at@protonmail.net
1415	Francesca Kennedy	amet.consectetuer@aol.net
1416	Kieran Marshall	augue.id@protonmail.net
1417	Illana Payne	egestas@outlook.net
1418	Hedley Frye	feugiat.metus.sit@hotmail.com
1419	Aspen Collier	magna.sed@hotmail.org
1420	Joshua Webb	semper.auctor@yahoo.couk
1421	Reed Norris	malesuada@aol.edu
1422	Alfonso Clark	non.massa.non@protonmail.couk
1423	Silas Trevino	integer.id@google.net
1424	Shellie Cantu	ultricies.dignissim@aol.com
1425	Justine Holloway	bibendum.sed@outlook.couk
1426	Dorian Ferrell	est.arcu.ac@icloud.org
1427	Abra Holland	orci.quis@aol.edu
1428	Erich Chan	dis.parturient@icloud.net
1429	Zachary Puckett	nulla@aol.ca
1430	Tucker Meadows	magna@aol.org
1431	Ryder Richard	aliquam@google.com
1432	Phyllis Franco	non@icloud.edu
1433	Carter Barber	blandit.viverra@outlook.ca
1434	Giselle Gilmore	aliquet.vel.vulputate@yahoo.com
1435	Brooke Brady	sed.est@aol.ca
1436	Wilma Buckley	adipiscing@aol.couk
1437	Linda Jacobson	urna.vivamus@icloud.ca
1438	Fuller Deleon	nulla@google.org
1439	Marah Raymond	sit.amet@protonmail.com
1440	Chastity Black	quis.massa.mauris@icloud.edu
1441	Melinda Ellison	nullam@aol.com
1442	Pearl York	erat.nonummy@outlook.net
1443	Kasimir Stafford	diam@aol.org
1444	Thor Blair	sem@google.couk
1445	Kaitlin Jarvis	viverra@aol.edu
1446	Moses Buckner	erat.volutpat.nulla@google.net
1447	Tallulah Hawkins	varius.et.euismod@aol.net
1448	Amena Barr	blandit.viverra.donec@icloud.com
1449	Ross Tyson	mi.pede@hotmail.org
1450	Camilla Mccall	pede.ac.urna@icloud.ca
1451	Elijah Sharp	adipiscing.lobortis.risus@hotmail.org
1452	Matthew Davenport	metus.vivamus@outlook.ca
1453	Guinevere Ramsey	integer.mollis@yahoo.net
1454	Astra Finley	integer.in@outlook.org
1455	Branden Rowe	felis.ullamcorper@aol.couk
1456	Phelan Holt	sagittis.augue.eu@outlook.couk
1457	Nyssa Beard	nec@outlook.couk
1458	Walter Chapman	enim.etiam.imperdiet@protonmail.edu
1459	Roth Hinton	elementum@yahoo.net
1460	Hyacinth Garner	lacus@outlook.net
1461	Autumn Weaver	justo.nec@yahoo.edu
1462	Bernard Daniels	sociis.natoque@protonmail.net
1463	Merritt Bennett	lorem.fringilla@yahoo.edu
1464	Scarlett Burch	eu.ligula@outlook.com
1465	Daria Pena	senectus.et@outlook.com
1466	Hayley Mcguire	ligula.aenean.euismod@outlook.edu
1467	Whitney Wooten	praesent@outlook.net
1468	Aurelia Best	commodo@aol.com
1469	Barry Haynes	eget.ipsum@protonmail.ca
1470	Quin Franklin	nisi.sem@protonmail.ca
1471	Illiana Booker	augue.id@hotmail.net
1472	Knox Downs	et.netus@aol.net
1473	Richard Hays	donec.est.mauris@icloud.org
1474	Chester Peters	non@protonmail.net
1475	Malik Stein	malesuada.id@aol.org
1476	Alan Mosley	tempus.lorem.fringilla@icloud.org
1477	Theodore Harrington	natoque.penatibus@icloud.com
1478	Tanya Owen	lectus.quis@outlook.couk
1479	Lance Lowe	bibendum@google.com
1480	Brian Copeland	tincidunt.donec@google.com
1481	Jacob Carney	mollis.non@google.org
1482	Kiara Sharpe	suspendisse.eleifend@outlook.ca
1483	Tana Baird	viverra@hotmail.org
1484	Fuller Kidd	id@protonmail.net
1485	Shea Sutton	ullamcorper.duis@icloud.org
1486	Vielka Francis	sed.dictum@google.com
1487	Regina Melton	ligula@hotmail.org
1488	Azalia Carey	diam@hotmail.ca
1489	Uriel Hood	lectus.ante@icloud.edu
1490	Jakeem Fulton	nec@protonmail.couk
1491	Marvin Willis	varius.orci.in@outlook.couk
\.


--
-- Name: film_attributes_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.film_attributes_types_id_seq', 5, true);


--
-- Name: film_attrs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.film_attrs_id_seq', 11, true);


--
-- Name: films_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.films_id_seq', 48, true);


--
-- Name: halls_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.halls_id_seq', 3, true);


--
-- Name: seance_tikets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seance_tikets_id_seq', 302, true);


--
-- Name: seances_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seances_id_seq', 1, false);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 1, false);


--
-- PostgreSQL database dump complete
--


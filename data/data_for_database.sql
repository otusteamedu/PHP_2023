INSERT INTO public.film (id, name, description) VALUES (1, 'Три богатыря', 'По сказкам мы знаем, что было давным-давно, но что было ещё давным-давнее? Трём богатырям предстоит узнать ответ на этот вопрос');
INSERT INTO public.film (id, name, description) VALUES (2, 'Принцесса Мононоке', 'Юный принц Аситака, убив вепря, навлёк на себя смертельное проклятие. Старая знахарка предсказала ему, что только он сам способен изменить свою судьбу. И отважный воин отправился в опасное путешествие.');


INSERT INTO public.attribute_type (id, type, description) VALUES (1, 'text', 'текст');
INSERT INTO public.attribute_type (id, type, description) VALUES (2, 'boolean', 'логический');
INSERT INTO public.attribute_type (id, type, description) VALUES (3, 'timestamptz', 'дата');
INSERT INTO public.attribute_type (id, type, description) VALUES (4, 'integer', 'целое число');
INSERT INTO public.attribute_type (id, type, description) VALUES (5, 'real', 'вещественное число');


INSERT INTO public.attribute (id, attribute_type, name) VALUES (1, 1, 'рецензия');
INSERT INTO public.attribute (id, attribute_type, name) VALUES (3, 3, 'служебные даты');
INSERT INTO public.attribute (id, attribute_type, name) VALUES (4, 3, 'мировая премьера');
INSERT INTO public.attribute (id, attribute_type, name) VALUES (5, 3, 'премьера в РФ');
INSERT INTO public.attribute (id, attribute_type, name) VALUES (2, 2, 'премия оскар');
INSERT INTO public.attribute (id, attribute_type, name) VALUES (6, 2, 'премия ника');


INSERT INTO public.attribute_value (id, entity_name, entity_id, attribute, value) VALUES (1, 'Film', 1, 1, 'Можно по-разному относиться к знаковым для нашего нынешнего кинематографа фильмам, к картинам Бекмбамбетова или историческим эпикам, вроде ''Адмирала'' или ''Царя'', но серия мультфильмов про богатырей - это явный успех. На фоне остальной нашей мультипликации, которая скорее мертва, чем жива просто хорошие, яркие, веселые и смешные мультики - это прямо-таки прорыв. ''Три богатыря'', где персонажи предыдущих частей встречаются вместе - это заключительный эпизод, четвертый по счету. Что одновременно и обнадеживает (еще бы, знакомые персонажи, знакомый антураж, да и художников рука уже набита), и беспокоит - четвертые эпизоды в таких сериях редко удаются на славу, кроме разве что четвертого эпизода ''Звездных войн''.');
INSERT INTO public.attribute_value (id, entity_name, entity_id, attribute, value) VALUES (2, 'Film', 1, 1, 'Мультфильм «Три богатыря и Шамаханская царица» был несколько ожидаем. После громадного успеха, который в России имела «богатырская» трилогия, всем можно было придти к логическому выводу о том, что, скорее всего, выйдет и четвёртая история, в которой все три могучих богатыря, с такими разными характерами, но общим патриотизмом соберутся вместе. Так и случилось, и всё вышло удачно. Правда, до новости о том, что выйдут «Три богатыря», я всё ломал голову о том, с кем же они будут воевать, с какими супостатами им придётся встретиться? Тугарин Змей и Соловья-разбойник уже получили своё надолго, а со Змеем Горынычем, как вы знаете по «Добрыне Никитичу», вышла история покруче! И тут, на тебе - сценаристы всё же нашли ещё одного врага Земли Русской. Серьёзного врага, причём настолько серьёзного, сильного и хитрого, что трём богатырям было под силу остановить его только вместе... ');
INSERT INTO public.attribute_value (id, entity_name, entity_id, attribute, value) VALUES (3, 'Film', 1, 1, e'Надо отметить сразу, что предыдущие истории про славных богатырей я не смотрел и теперь осознаю, что немало потерял. Так что в скором времени буду наверстывать упущенное.

Князь Киевский заскучал, ничего ему не мило, кризис среднего возраста в общем. А тут девица красавица, мечтает познакомиться. И как увидел ее наш государь, так и засела она в его сердце зазнобой жаркой. А как известно, любовь зла, полюбишь и Шамаханскую царицу, у которой весьма коварные намерения. Надо нашего князя спасать, но как? Ответ прост, на помощь поспешат три богатыря вместе со своими боевыми подругами. ');
INSERT INTO public.attribute_value (id, entity_name, entity_id, attribute, value) VALUES (4, 'Film', 1, 2, 'true');
INSERT INTO public.attribute_value (id, entity_name, entity_id, attribute, value) VALUES (7, 'Film', 2, 5, '2025-01-14 00:00:00.000000 +00:00');
INSERT INTO public.attribute_value (id, entity_name, entity_id, attribute, value) VALUES (8, 'Film', 2, 1, 'рецензия 1');
INSERT INTO public.attribute_value (id, entity_name, entity_id, attribute, value) VALUES (9, 'Film', 2, 1, 'рецензия 2');
INSERT INTO public.attribute_value (id, entity_name, entity_id, attribute, value) VALUES (11, 'Film', 2, 6, 'true');
INSERT INTO public.attribute_value (id, entity_name, entity_id, attribute, value) VALUES (13, 'Film', 1, 3, '2025-02-14 00:00:00.000000 +00:00');
INSERT INTO public.attribute_value (id, entity_name, entity_id, attribute, value) VALUES (5, 'Film', 1, 4, '2024-01-17 00:00:00.000000 +00:00');
INSERT INTO public.attribute_value (id, entity_name, entity_id, attribute, value) VALUES (6, 'Film', 1, 5, '2024-01-17 00:00:00.000000 +00:00');
INSERT INTO public.attribute_value (id, entity_name, entity_id, attribute, value) VALUES (15, 'Film', 2, 3, '2025-01-17 00:00:00.000000 +00:00');
INSERT INTO public.attribute_value (id, entity_name, entity_id, attribute, value) VALUES (14, 'Film', 1, 3, '2025-03-14 00:00:00.000000 +00:00');
INSERT INTO public.attribute_value (id, entity_name, entity_id, attribute, value) VALUES (16, 'Film', 2, 3, '2025-02-18 00:00:00.000000 +00:00');
INSERT INTO public.attribute_value (id, entity_name, entity_id, attribute, value) VALUES (10, 'Film', 2, 4, '2024-01-17 00:00:00.000000 +00:00');
INSERT INTO public.attribute_value (id, entity_name, entity_id, attribute, value) VALUES (12, 'Film', 1, 3, '2025-01-14 00:00:00.000000 +00:00');
INSERT INTO public.attribute_value (id, entity_name, entity_id, attribute, value) VALUES (17, 'Film', 2, 3, '2024-03-17 00:00:00.000000 +00:00');

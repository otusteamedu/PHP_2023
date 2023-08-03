set my.cnt = 100;
set my.birthday_min = '1900-01-01';
set my.birthday_max = '2020-01-01';



INSERT INTO public.person (fam, nam, otc, birthday, nom, prenom)
select
    concat('Фамилия ', to_char(number, '000')) as fam,
    concat('Имя ', to_char(number, '000')) as nam,
    concat('Отчество ', to_char(number, '000')) as otc,
    DATE(current_setting('my.birthday_min')::timestamp + (random() * (current_setting('my.birthday_max')::timestamp - current_setting('my.birthday_min')::timestamp))) as birthday,
    concat('NOM ', to_char(number, '000')) as nom,
    concat('PRENOM ', to_char(number, '000')) as prenom
FROM
    GENERATE_SERIES(1, current_setting('my.cnt')::int) as number;

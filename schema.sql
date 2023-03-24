-- Создание таблиц с фильмами

CREATE TABLE films (
   id SERIAL PRIMARY KEY,
   name VARCHAR(256) NOT NULL,
   release_date DATE NOT NULL,
   country_production VARCHAR(50) NOT NULL,
   duration INT NOT NULL,
   description TEXT
);

CREATE TABLE attribute_types (
     id SERIAL PRIMARY KEY,
     name VARCHAR(50) NOT NULL,
     data_type VARCHAR(50) NOT NULL
);

CREATE TABLE attributes (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    required BOOLEAN DEFAULT FALSE,
    attribute_type_id INT NOT NULL,
    CONSTRAINT c_fk_attribute_type FOREIGN KEY (attribute_type_id) REFERENCES attribute_types (id) ON DELETE RESTRICT
);

CREATE TABLE film_attribute_values (
       id SERIAL PRIMARY KEY,
       char_value VARCHAR(256),
       integer_value INT,
       numeric_value NUMERIC(4,2),
       bool_value BOOL,
       date_value DATE,
       film_id INT NOT NULL,
       attribute_id INT NOT NULL,
       CONSTRAINT c_fk_film FOREIGN KEY (film_id) REFERENCES films (id) ON DELETE RESTRICT,
       CONSTRAINT c_fk_attribute FOREIGN KEY (attribute_id) REFERENCES attributes (id) ON DELETE RESTRICT
);

-- Создание таблиц с залами и всеми связанными сущностями

CREATE TABLE halls (
   id SERIAL PRIMARY KEY,
   number INT NOT NULL,
   capacity INT NOT NULL
);

CREATE TABLE rows (
    id SERIAL PRIMARY KEY,
    number INT NOT NULL,
    hall_id INT NOT NULL,
    CONSTRAINT c_fk_rows_hall FOREIGN KEY (hall_id) REFERENCES halls (id) ON DELETE RESTRICT
);

CREATE TABLE prices (
    id SERIAL PRIMARY KEY,
    amount INT NOT NULL
);

CREATE TABLE places (
    id SERIAL PRIMARY KEY,
    number INT NOT NULL,
    price_id INT NOT NULL,
    row_id INT NOT NULL,
    CONSTRAINT c_fk_price FOREIGN KEY (price_id) REFERENCES prices (id) ON DELETE RESTRICT,
    CONSTRAINT c_fk_row FOREIGN KEY (row_id) REFERENCES rows (id) ON DELETE RESTRICT
);

CREATE TABLE sessions (
    id SERIAL PRIMARY KEY,
    date_start TIMESTAMP NOT NULL,
    date_end TIMESTAMP,
    hall_id INT NOT NULL,
    film_id INT NOT NULL,
    CONSTRAINT c_fk_hall FOREIGN KEY (hall_id) REFERENCES halls (id) ON DELETE RESTRICT,
    CONSTRAINT c_fk_film FOREIGN KEY (film_id) REFERENCES films (id) ON DELETE RESTRICT
);

CREATE TABLE customers (
   id SERIAL PRIMARY KEY,
   user_name VARCHAR(50) NOT NULL,
   email VARCHAR(50) NOT NULL,
   birthday DATE,
   first_name VARCHAR(50),
   last_name VARCHAR(50)
);

CREATE TABLE tickets (
     id SERIAL PRIMARY KEY,
     total_price INT NOT NULL,
     payed BOOL DEFAULT FALSE,
     purchase_date TIMESTAMP,
     row_id INT NOT NULL,
     place_id INT NOT NULL,
     session_id INT NOT NULL,
     customer_id INT NOT NULL,
     CONSTRAINT c_fk_ticket_row FOREIGN KEY (row_id) REFERENCES rows (id) ON DELETE RESTRICT,
     CONSTRAINT c_fk_ticket_place FOREIGN KEY (place_id) REFERENCES places (id) ON DELETE RESTRICT,
     CONSTRAINT c_fk_session FOREIGN KEY (session_id) REFERENCES sessions (id) ON DELETE RESTRICT,
     CONSTRAINT c_fk_customer FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE RESTRICT
);

-- Вспомогательные функции
-- Получение случайной строки
CREATE OR REPLACE FUNCTION "random_string"(length integer) RETURNS text AS
$$
declare
    chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text := '';
    i integer := 0;
begin
    if length < 0 then
        raise exception 'Given length cannot be less than 0';
    end if;
    for i in 1..length loop
            result := result || chars[1+random()*(array_length(chars, 1)-1)];
        end loop;
    return result;
end;
$$ language plpgsql;
----

-- Получение случайного фильма
CREATE OR REPLACE FUNCTION "random_film"() RETURNS integer AS
$$
DECLARE
    result integer := 0;
BEGIN
    SELECT INTO result id FROM films ORDER BY RANDOM() LIMIT 1;
    RETURN result;
END;
$$ language plpgsql;
----

-- Получение случайного пользователя
CREATE OR REPLACE FUNCTION "random_customer"() RETURNS integer AS
$$
DECLARE
    result integer := 0;
BEGIN
    SELECT INTO result id FROM customers ORDER BY RANDOM() LIMIT 1;
    RETURN result;
END;
$$ language plpgsql;
----

-- Получение случайной цены
CREATE OR REPLACE FUNCTION "random_price"() RETURNS integer AS
$$
DECLARE
    result integer := 0;
BEGIN
    SELECT INTO result id FROM prices ORDER BY RANDOM() LIMIT 1;
    RETURN result;
END;
$$ language plpgsql;
----
----

-- Триггеры
-- Создание 10 рядов кинозала
CREATE OR REPLACE FUNCTION "fCreateRows"()
    RETURNS trigger
    LANGUAGE plpgsql
AS $function$
BEGIN
    INSERT INTO "rows" (number, hall_id)
    SELECT generate_series(1,10), NEW.id;
    RETURN NULL;
END;
$function$
;

CREATE TRIGGER "trCreateRows"
    AFTER INSERT ON "halls"
    FOR EACH ROW EXECUTE PROCEDURE "fCreateRows"();
----

-- Создание 30 мест в ряду кинозала
CREATE OR REPLACE FUNCTION "fCreatePlaces"()
    RETURNS trigger
    LANGUAGE plpgsql
AS $function$
BEGIN
    INSERT INTO "places" (number, price_id, row_id)
    SELECT generate_series(1,30), random_price(), NEW.id;
    RETURN NULL;
END;
$function$
;

CREATE TRIGGER "trCreatePlaces"
    AFTER INSERT ON "rows"
    FOR EACH ROW EXECUTE PROCEDURE "fCreatePlaces"();
----

-- Создание сеансов
-- примерно для 10 тыс. записей
CREATE OR REPLACE FUNCTION "fCreateSessions"()
    RETURNS trigger
    LANGUAGE plpgsql
AS $function$
BEGIN
    INSERT INTO "sessions" (date_start, date_end, hall_id, film_id)
    SELECT generate_series('2023-03-01', '2023-03-04', interval '2 hours'), NULL, NEW.id, random_film();
    RETURN NULL;
END;
$function$
;

-- примерно для 10 млн. записей
CREATE OR REPLACE FUNCTION "fCreateSessions"()
    RETURNS trigger
    LANGUAGE plpgsql
AS $function$
BEGIN
    INSERT INTO "sessions" (date_start, date_end, hall_id, film_id)
    SELECT generate_series('2023-03-04', '2023-04-01', interval '2 hours'), NULL, NEW.id, random_film();
    RETURN NULL;
END;
$function$
;

CREATE TRIGGER "trCreateSessions"
    AFTER INSERT ON "halls"
    FOR EACH ROW EXECUTE PROCEDURE "fCreateSessions"();
----

-- Создание билетов
CREATE OR REPLACE FUNCTION "fCreateTickets"()
    RETURNS trigger
    LANGUAGE plpgsql
AS $function$
DECLARE
    _row_id integer;
    _place_id integer;
    _price_id integer;
    _price integer;
BEGIN
    FOR _row_id IN SELECT id FROM "rows" WHERE hall_id=NEW.hall_id LOOP
        FOR _place_id IN SELECT id FROM "places" WHERE row_id=_row_id LOOP
            SELECT INTO _price_id price_id FROM places WHERE id=_place_id;
            SELECT INTO _price amount FROM prices WHERE id=_price_id;
            INSERT INTO "tickets" (total_price, payed, row_id, place_id, session_id, customer_id) VALUES (_price, random() < 0.8, _row_id, _place_id, NEW.id, random_customer());
        END LOOP;
    END LOOP;
    RETURN NULL;
END;
$function$
;

CREATE TRIGGER "trCreateTickets"
    AFTER INSERT ON "sessions"
    FOR EACH ROW EXECUTE PROCEDURE "fCreateTickets"();
----
----

-- Индексы
CREATE INDEX total_price_idx ON tickets (total_price);
CREATE INDEX session_id_idx ON tickets (session_id);
CREATE INDEX date_start_idx ON sessions (date_start);
----

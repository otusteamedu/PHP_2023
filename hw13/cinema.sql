
-- Создание структуры данных

CREATE TABLE "public.hall" (
	"id" serial NOT NULL,
	"name" VARCHAR(255) NOT NULL,
	CONSTRAINT "hall_pk" PRIMARY KEY ("id")
);

CREATE TABLE "public.seat" (
	"id" serial NOT NULL,
	"hall_id" integer NOT NULL,
	"row_num" integer NOT NULL,
	"seat_num" integer NOT NULL,
	"price_level_id" integer NOT NULL,
	CONSTRAINT "seat_pk" PRIMARY KEY ("id")
);

CREATE TABLE "public.price_level" (
	"id" serial NOT NULL,
	"name" varchar(255) NOT NULL,
	"price" integer NOT NULL,
	"currency_id" integer NOT NULL,
	CONSTRAINT "price_level_pk" PRIMARY KEY ("id")
);

CREATE TABLE "public.currency" (
	"id" serial NOT NULL,
	"name" varchar(255) NOT NULL,
	"sign" varchar(255),
	CONSTRAINT "currency_pk" PRIMARY KEY ("id")
);

CREATE TABLE "public.age_limit" (
	"id" serial NOT NULL,
	"age" integer NOT NULL,
	"name" varchar(255) NOT NULL,
	CONSTRAINT "age_limit_pk" PRIMARY KEY ("id")
);

CREATE TABLE "public.movie" (
	"id" serial NOT NULL,
	"title" varchar(255) NOT NULL,
	"duration" TIME NOT NULL,
	"description" TEXT NOT NULL,
	"age_limit_id" integer NOT NULL,
	CONSTRAINT "movie_pk" PRIMARY KEY ("id")
);

CREATE TABLE "public.hall_session" (
	"id" serial NOT NULL,
	"hall_id" integer NOT NULL,
	"session_time" TIME WITH TIME ZONE NOT NULL,
	CONSTRAINT "hall_session_pk" PRIMARY KEY ("id")
);

CREATE TABLE "public.sessions" (
	"id" serial NOT NULL,
	"hall_session_id" integer NOT NULL,
	"session_date" TIMESTAMP WITH TIME ZONE NOT NULL,
	"movie_id" integer NOT NULL,
	CONSTRAINT "sessions_pk" PRIMARY KEY ("id")
);

CREATE TABLE "public.customer" (
	"id" serial NOT NULL,
	"lastname" varchar(255) NOT NULL,
	"firstname" varchar(255) NOT NULL,
	"patronym" varchar(255) NOT NULL,
	"phone" varchar(255) NOT NULL,
	"email" varchar(255) NOT NULL,
	CONSTRAINT "customer_pk" PRIMARY KEY ("id")
);

CREATE TABLE "public.ticket" (
	"id" serial NOT NULL,
	"session_id" integer NOT NULL,
	"seat_id" integer NOT NULL,
	CONSTRAINT "ticket_pk" PRIMARY KEY ("id")
);

CREATE TABLE "public.orders" (
	"id" serial NOT NULL,
	"customer_id" integer NOT NULL,
	"order_datetime" TIMESTAMP WITH TIME ZONE NOT NULL,
	CONSTRAINT "orders_pk" PRIMARY KEY ("id")
);

CREATE TABLE "public.order_list" (
	"order_id" integer NOT NULL,
	"ticket_id" integer NOT NULL,
	"price" integer NOT NULL,
	"currency_id" integer NOT NULL,
	CONSTRAINT "order_list_pk" PRIMARY KEY ("order_id","ticket_id")
);

ALTER TABLE "public.seat" ADD CONSTRAINT "seat_fk0" FOREIGN KEY ("hall_id") REFERENCES "public.hall"("id");
ALTER TABLE "public.seat" ADD CONSTRAINT "seat_fk1" FOREIGN KEY ("price_level_id") REFERENCES "public.price_level"("id");
ALTER TABLE "public.price_level" ADD CONSTRAINT "price_level_fk0" FOREIGN KEY ("currency_id") REFERENCES "public.currency"("id");
ALTER TABLE "public.movie" ADD CONSTRAINT "movie_fk0" FOREIGN KEY ("age_limit_id") REFERENCES "public.age_limit"("id");
ALTER TABLE "public.hall_session" ADD CONSTRAINT "hall_session_fk0" FOREIGN KEY ("hall_id") REFERENCES "public.hall"("id");
ALTER TABLE "public.sessions" ADD CONSTRAINT "sessions_fk0" FOREIGN KEY ("hall_session_id") REFERENCES "public.hall_session"("id");
ALTER TABLE "public.sessions" ADD CONSTRAINT "sessions_fk1" FOREIGN KEY ("movie_id") REFERENCES "public.movie"("id");
ALTER TABLE "public.ticket" ADD CONSTRAINT "ticket_fk0" FOREIGN KEY ("session_id") REFERENCES "public.sessions"("id");
ALTER TABLE "public.ticket" ADD CONSTRAINT "ticket_fk1" FOREIGN KEY ("seat_id") REFERENCES "public.seat"("id");
ALTER TABLE "public.orders" ADD CONSTRAINT "orders_fk0" FOREIGN KEY ("customer_id") REFERENCES "public.customer"("id");
ALTER TABLE "public.order_list" ADD CONSTRAINT "order_list_fk0" FOREIGN KEY ("order_id") REFERENCES "public.orders"("id");
ALTER TABLE "public.order_list" ADD CONSTRAINT "order_list_fk1" FOREIGN KEY ("ticket_id") REFERENCES "public.ticket"("id");

ALTER TABLE "public.order_list" ADD CONSTRAINT "order_list_fk2" FOREIGN KEY ("currency_id") REFERENCES "public.currency"("id");


CREATE TABLE "public.attribute_type" (
	"id" serial NOT NULL,
	"name" varchar(10) NOT NULL,
	CONSTRAINT "attribute_type" PRIMARY KEY ("id")
);


CREATE TABLE "public.data_type" (
	"id" serial NOT NULL,
	"name" varchar(10) NOT NULL,
	CONSTRAINT "data_type" PRIMARY KEY ("id")
);


CREATE TABLE "public.attribute" (
	"id" serial NOT NULL,
	"data_type_id" integer NOT NULL,
	"type_id" integer NOT NULL,
	"name" varchar(255) NOT NULL,
	CONSTRAINT "attribute_pk" PRIMARY KEY ("id")
);
ALTER TABLE "public.attribute" ADD CONSTRAINT "attribute_fk0" FOREIGN KEY ("data_type_id") REFERENCES "public.data_type"("id");
ALTER TABLE "public.attribute" ADD CONSTRAINT "attribute_fk1" FOREIGN KEY ("type_id") REFERENCES "public.attribute_type"("id");


CREATE TABLE "public.movie_attribute" (
	"id" serial NOT NULL,
	"movie_id" integer NOT NULL,
	"attribute_id" integer NOT NULL,
	"attribute_value_text" text,
	"attribute_value_bool" boolean,
	"attribute_value_time" TIME WITH TIME ZONE,
	"attribute_value_datetime" TIMESTAMP WITH TIME ZONE,
	"attribute_value_int" integer,
	"attribute_value_num" NUMERIC(4, 2),
	CONSTRAINT "movie_attribute_pk" PRIMARY KEY ("id")
);
ALTER TABLE "public.movie_attribute" ADD CONSTRAINT "movie_attribute_fk0" FOREIGN KEY ("movie_id") REFERENCES "public.movie"("id");
ALTER TABLE "public.movie_attribute" ADD CONSTRAINT "movie_attribute_fk1" FOREIGN KEY ("attribute_id") REFERENCES "public.attribute"("id");




-- Заполнение данными

Create or replace function random_string(length integer) returns text as
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

CREATE OR REPLACE FUNCTION random_between(low INT, high INT) 
   RETURNS INT AS
$$
BEGIN
   RETURN floor(random()* (high-low + 1) + low);
END;
$$ language 'plpgsql' STRICT;



INSERT INTO "public.hall" ("name") 
VALUES 
('Большой зал'),
('Малый зал');


INSERT INTO "public.currency" ("name","sign") 
VALUES 
('Рубль','р.');


TRUNCATE TABLE "public.price_level" RESTART IDENTITY CASCADE;
INSERT INTO "public.price_level" ("name","price","currency_id") 
VALUES 
('дешевые места',100,1),
('дорогие места',200,1),
('лучшие места',300,1);


TRUNCATE TABLE "public.seat" RESTART IDENTITY CASCADE;
do $$
begin    
    <<r>>
    FOR r IN 1..30 LOOP
	    <<seat>>
	    for seat in 1..30 loop				
			IF (r>20) THEN
					INSERT INTO "public.seat" ("hall_id","row_num","seat_num","price_level_id")
					values
					(
						1,
						r,
						seat,
						3
					);
			ELSEIF (r>10) THEN
				 	INSERT INTO "public.seat" ("hall_id","row_num","seat_num","price_level_id")
					values
					(
						1,
						r,
						seat,
						2
					);
			ELSE
				 	INSERT INTO "public.seat" ("hall_id","row_num","seat_num","price_level_id")
					values
					(
						1,
						r,
						seat,
						1
					);
			END IF;
	    end loop seat;
    end loop r;
    
    <<r>>
    FOR r IN 1..20 LOOP
	    <<seat>>
	    for seat in 1..20 loop				
			IF (r>10) THEN
					INSERT INTO "public.seat" ("hall_id","row_num","seat_num","price_level_id")
					values
					(
						2,
						r,
						seat,
						2
					);
			ELSE
				 	INSERT INTO "public.seat" ("hall_id","row_num","seat_num","price_level_id")
					values
					(
						2,
						r,
						seat,
						1
					);
			END IF;
	    end loop seat;
    end loop r;
end; $$
		
	


INSERT INTO "public.age_limit" ("age","name") 
VALUES 
(0,'0+'),
(6,'6+'),
(12,'12+'),
(18,'18+');



INSERT INTO "public.movie" ("title","duration","description","age_limit_id") 
VALUES 
('Дюна','03:00:00','',2),
('Чебурашка','02:00:00','',1),
('Аватар 2','02:30:00','',3);


TRUNCATE TABLE "public.hall_session" RESTART IDENTITY CASCADE;
INSERT INTO "public.hall_session" ("hall_id","session_time") 
VALUES 
(1,'08:30:00'),
(1,'11:30:00'),
(1,'14:30:00'),
(1,'17:30:00'),
(1,'20:30:00'),
(1,'23:30:00'),
(2,'08:30:00'),
(2,'11:30:00'),
(2,'14:30:00'),
(2,'17:30:00'),
(2,'20:30:00'),
(2,'23:30:00');



TRUNCATE TABLE "public.sessions" RESTART IDENTITY CASCADE;
do $$
DECLARE
    sess INTEGER;
begin   
    FOR sess IN (select "id" from "public.hall_session") LOOP
 
	INSERT INTO "public.sessions" ("hall_session_id","session_date","movie_id") 
	select
		sess,
		gs.d,
		random_between(1,3)
	from generate_series(date '2020-03-28', date '2023-03-28', '1 day') as gs(d);

    end loop;
end; $$



TRUNCATE TABLE "public.customer" RESTART IDENTITY CASCADE;
INSERT INTO "public.customer" ("lastname","firstname","patronym","phone","email") 
VALUES 
('Иванов','Иван','Иванович','+79991234567','ivanov@mail.ru'),
('Петров','Петр','Петрович','+79997654321','petrov@mail.ru'),
('Сидоров','Сидор','Сидорович','+79997652222','sidorov@mail.ru');



TRUNCATE TABLE "public.ticket" RESTART IDENTITY CASCADE;
do $$
DECLARE
    sess INTEGER;
begin   
    FOR sess IN (select "id" from "public.sessions") LOOP
 
	INSERT INTO "public.ticket" ("session_id","seat_id") 
	select
		sess,
		gs.d
	from generate_series(1, 1300) as gs(d);

    end loop;
end; $$


					

TRUNCATE TABLE "public.orders" RESTART IDENTITY CASCADE;
INSERT INTO "public.orders" ("customer_id","order_datetime")
select
	random_between(1, 3),
	CURRENT_DATE - random_between(1, 100)
from generate_series(1, 10000) as gs(d);
	
	
	

TRUNCATE TABLE "public.order_list" RESTART IDENTITY CASCADE;
INSERT INTO "public.order_list" ("order_id","ticket_id","price","currency_id") 
SELECT 
	random_between(1, 10000),
	"public.ticket"."id",
	"public.price_level"."price",
	1
FROM 
	"public.ticket"
LEFT JOIN 
	"public.seat" ON "public.seat"."id" = "public.ticket"."seat_id"
LEFT JOIN
	"public.price_level" ON "public.seat"."price_level_id" = "public.price_level"."id"
LIMIT 20000;



INSERT INTO "public.data_type" ("name") 
VALUES 
('text'),
('boolean'),
('time'),
('datetime'),
('integer'),
('numeric');

INSERT INTO "public.attribute_type" ("name") 
VALUES 
('promo'),
('info'),
('task');

INSERT INTO "public.attribute" ("data_type_id", "type_id", "name") 
VALUES 
(1,1,'рецензии'),
(2,1,'премия Oscar'),
(2,1,'премия «Ника»'),
(2,1,'премия Golden Globes'),
(2,1,'премия BAFTA'),
(2,1,'премия Cèsar'),
(2,1,'премия «Золотой Орел»'),
(2,1,'премия Goya'),
(2,1,'премия Emmy'),
(2,1,'Каннский кинофестиваль'),
(2,1,'Берлинский кинофестиваль'),
(2,1,'Венецианский кинофестиваль'),
(2,1,'ММКФ'),
(2,1,'«Кинотавр»'),
(4,3,'мировая премьера'),
(4,3,'премьера в РФ'),
(4,3,'начало продажи билетов'),
(4,3,'запуск рекламной кампании'),
(6,2,'рейтинг IMDb');


INSERT INTO "public.movie_attribute" (
	"movie_id", 
	"attribute_id", 
	"attribute_value_text", 
	"attribute_value_bool", 
	"attribute_value_time", 
	"attribute_value_datetime", 
	"attribute_value_int",
	"attribute_value_num"
) 
VALUES 
(1,1,'Хороший фильм!',NULL,NULL,NULL,NULL,NULL),
(1,1,'Так себе...',NULL,NULL,NULL,NULL,NULL),
(1,2,NULL,true,NULL,NULL,NULL,NULL),
(1,4,NULL,true,NULL,NULL,NULL,NULL),
(1,5,NULL,true,NULL,NULL,NULL,NULL),
(1,15,NULL,NULL,NULL,'2021-09-03 00:00:00+00',NULL,NULL),
(1,16,NULL,NULL,NULL,'2021-09-16 00:00:00+00',NULL,NULL),
(1,19,NULL,NULL,NULL,NULL,NULL,8.00),
(1,17,NULL,NULL,NULL,'2021-09-06 00:00:00+00',NULL,NULL),
(1,18,NULL,NULL,NULL,'2021-08-16 00:00:00+00',NULL,NULL);






































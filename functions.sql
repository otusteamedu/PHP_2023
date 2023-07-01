
--random_between function
CREATE OR REPLACE FUNCTION rand_between(low INT ,high INT) RETURNS INT AS
$$
BEGIN
   RETURN floor(random()* (high-low + 1) + low);
END;
$$ language plpgsql STRICT;


--random string function
CREATE OR REPLACE FUNCTION random_str(length integer) returns text
    language plpgsql
as
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
$$;


CREATE OR REPLACE FUNCTION rand_date_time(start_date date, end_date date) RETURNS TIMESTAMP AS
$$
 DECLARE
    interval_days integer;
    random_seconds integer;
    random_dates integer;
    random_date date;
    random_time time;
BEGIN
    interval_days := end_date - start_date;
    random_dates:= trunc(random()*interval_days);
    random_date := start_date + random_dates;
    random_seconds:= trunc(random()*3600*24);
    random_time:=' 00:00:00'::time+(random_seconds || ' second')::INTERVAL;
    RETURN random_date +random_time;
END;
$$ LANGUAGE plpgsql;



CREATE OR REPLACE FUNCTION rand_film_name() RETURNS TEXT AS
$$
DECLARE
    filmsList text[] := array['Mortal Kombat', 'Cheburashka', 'Rasputin', 'Friends'];
BEGIN
   RETURN (filmsList::text[])[ceil(random()*array_length(filmsList::text[], 1))];
END;
$$ language plpgsql STRICT;


CREATE OR REPLACE FUNCTION rand_schedule_day() RETURNS day AS
$$
DECLARE
    schedule text[] := array['monday', 'thuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
BEGIN
   RETURN (schedule::text[])[ceil(random()*array_length(schedule::text[], 1))];
END;
$$ language plpgsql STRICT;


CREATE OR REPLACE FUNCTION rand_schedule_time() RETURNS time AS
$$
DECLARE
    schedule text[] := array['10:00:00', '12:00:00', '15:00:00', '17:00:00', '20:00:00'];
BEGIN
   RETURN (schedule::text[])[ceil(random()*array_length(schedule::text[], 1))];
END;
$$ language plpgsql STRICT;
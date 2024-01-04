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

CREATE OR REPLACE FUNCTION rand_ticket_status() RETURNS TEXT AS
$$
DECLARE
ticketStatusList text[] := array['new', 'sold', 'reserved'];
BEGIN
RETURN (ticketStatusList::text[])[ceil(random()*array_length(ticketStatusList::text[], 1))];
END;
$$ language plpgsql STRICT;

CREATE OR REPLACE FUNCTION rand_str(length integer) returns text
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

CREATE OR REPLACE FUNCTION rand_duration() RETURNS time AS
$$
DECLARE
schedule text[] := array['02:00:00', '03:00:00', '01:00:00', '01:30:00', '02:30:00'];
BEGIN
RETURN (schedule::text[])[ceil(random()*array_length(schedule::text[], 1))];
END;
$$ language plpgsql STRICT;

CREATE OR REPLACE FUNCTION rand_movie_name() RETURNS TEXT AS
$$
DECLARE
filmsList text[] := array['1+1', 'Властелин колец: Братство Кольца', 'Телохранитель ', 'Индиана Джонс: В поисках утраченного ковчега'];
BEGIN
RETURN (filmsList::text[])[ceil(random()*array_length(filmsList::text[], 1))];
END;
$$ language plpgsql STRICT;


CREATE OR REPLACE FUNCTION rand_release_date() RETURNS date AS
$$
DECLARE
start_date date := '2000-01-01';
    end_date date := '2025-12-31';
    random_days integer;
BEGIN
    random_days := floor(random() * (end_date - start_date + 1));
RETURN start_date + random_days;
END;
$$ LANGUAGE plpgsql STRICT;
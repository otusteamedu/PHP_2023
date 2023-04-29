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

Create or replace function random_date(date_from timestamp with time zone, date_to timestamp with time zone) returns timestamp as
$$
declare
    result timestamp with time zone := '2023-04-01 00:00:00';
begin
    result := date_from + random() * (date_to - date_from);
    return result;
end;
$$ language plpgsql;

Create or replace function sell_tickets(movieId bigint) returns int as
$$
declare
begin
    INSERT INTO tickets (id, movie_id, place_id, datetime, amount, created_at)
    SELECT nextval('tickets_id_seq'),
           movieId,
           p.id,
           random_date('2023-01-01 00:00:00', '2023-05-01 00:00:00'),
           CASE WHEN p.place_type_id = 1 THEN 350 ELSE 500 END,
           now()
    FROM places p
    INNER JOIN schedules s on p.cinema_hall_id = s.cinema_hall_id
    WHERE s.movie_id = movieId
    ORDER BY random()
    LIMIT 100;
    return 0;
end;
$$ language plpgsql;

Create or replace function random_number(num_from bigint, num_to bigint) returns bigint as
$$
declare
begin
    return floor(random() * (num_to - num_from + num_from) + 1)::bigint;
end;
$$ language plpgsql;

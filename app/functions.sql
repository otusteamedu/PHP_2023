create or replace function random_string(length integer) returns text as
$$
declare
    chars  text[]  := '{0,1,2,3,4,5,6,7,8,9,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text    := '';
    i      integer := 0;
begin
    if length < 0 then
        raise exception 'given length cannot be less than 0';
    end if;
    for i in 1..length
        loop
            result := result || chars[1 + random() * (array_length(chars, 1) - 1)];
        end loop;
    return result;
end;
$$ language plpgsql;

create or replace function random_timestamp_in_range(timestamp, timestamp)
    returns timestamp
    language sql
as
$$
select $1 + floor(
        (extract(epoch from $2 - $1) + 1) * random()
    )::integer::text::interval;
$$;

create or replace function
    random_in_range(integer, integer) returns integer
as
$$
select floor(($1 + ($2 - $1 + 1) * random()))::integer;
$$ language sql;

create or replace function generate_movies(movies_count integer) returns void as
$$
begin
    for i in 1..movies_count
        loop
            insert into movies (name, duration) values (random_string(50), random() * 120 * interval '1 minute');
        end loop;
end;
$$ language plpgsql;

create or replace function generate_hall_schemas() returns void as
$$
declare
    r_hall record;
begin
    for r_hall in (select * from halls)
        loop
            for i_row in 1..r_hall.rows_count
                loop
                    for j_seat in 1..r_hall.seats_per_row
                        loop
                            insert into hall_schema
                                (hall_id, "row", "seat")
                            values (r_hall.id, i_row, j_seat);
                        end loop;
                end loop;
        end loop;
end;
$$ language plpgsql;

create or replace function generate_sessions_tickets(
    sessions_count integer,
    tickets_count integer,
    timestamp_from timestamp,
    timestamp_to timestamp
) returns void as
$$
declare
    r_session record;
begin
    --сеансы
    for i in 1..sessions_count
        loop
            insert into sessions (movie_id, hall_id, begin_at)
            values ((select id from movies order by random() limit 1),
                    (select id from halls order by random() limit 1),
                    random_timestamp_in_range(timestamp_from, timestamp_to));
        end loop;

    --билеты
    for i in 1..tickets_count
        loop
            for r_session in select id, hall_id, begin_at
                             from sessions
                             where id >= (select random_in_range(
                                                         (select min(id) from sessions),
                                                         (select max(id) from sessions)
                                                     ))
                             order by id
                             limit 1
                loop
                    insert into tickets (session_id, hall_schema_id, price, created_at)
                    values (r_session.id,
                            (select id
                             from hall_schema
                             where hall_id = r_session.hall_id
                             order by random()
                             limit 1),
                            random_in_range(20000, 70000),
                            r_session.begin_at - make_interval(days => random_in_range(0, 5)))
                    on conflict do nothing;
                end loop;
        end loop;
end;
$$ language plpgsql;
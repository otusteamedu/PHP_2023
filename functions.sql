create or replace function random_int(fromInt integer, toInt integer) returns integer as
$$
begin
    return floor(random() * (toInt - fromInt + 1) + fromInt);
end;
$$ language plpgsql strict;

create or replace function random_date(fromYear integer, toYear integer) returns date as
$$
declare
    random_day   int := floor(random() * 28 + 1);
    random_month int := floor(random() * 12 + 1);
    random_year  int := floor(random() * (toYear - fromYear + 1) + fromYear);
begin
    return concat(random_year, '-', random_month, '-', random_day)::date;
end;
$$ language plpgsql strict;

create or replace function random_string(fromLength integer, toLength integer) returns text as
$$
declare
    chars  text[]  := '{A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text    := '';
    length int     := floor(random() * (toLength - fromLength + 1) + fromLength);
    i      integer := 0;
begin
    if length < 0 then
        raise exception 'Given length cannot be less than 0';
    end if;
    for i in 1..length
        loop
            result := result || chars[1 + random() * (array_length(chars, 1) - 1)];
        end loop;
    return result;
end;
$$ language plpgsql strict;

create or replace function random_hall_class() returns text as
$$
declare
    class_list text[] := array ['Classic', 'Comfort', 'Premium', 'VIP'];
begin
    return (class_list::text[])[ceil(random() * array_length(class_list::text[], 1))];
end ;
$$ language plpgsql strict;
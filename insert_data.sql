insert into type_halls (name, description) values
    ('name_1_hall', 'description_1_hall'),
    ('name_2_hall', 'description_2_hall')

insert into type_sessions  (name, description) values
    ('name_1_session', 'description_1_session'),
    ('name_2_session', 'description_2_session')


insert into movie_categories  (name, description) values
    ('name_1_movie_cat', 'description_1_movie_cat'),
    ('name_2_movie_cat', 'description_2_movie_cat')

insert into movie_genres  (name, description) values
    ('name_1_movie_gen', 'description_1_movie_gen'),
    ('name_2_movie_gen', 'description_2_movie_gen')

insert into scheme_halls  (name, description) values
    ('name_1_scheme_hall', 'description_1_scheme_hall'),
    ('name_2_scheme_hall', 'description_2_scheme_hall')


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



insert into movies (name, genre_id, category_id, description)
    select
        random_string((1 + random()*10)::integer),
        (1 + random())::integer,
        (1 + random())::integer,
        random_string((1 + random()*20)::integer)
    from
        generate_series(1, 100) as gs(id);


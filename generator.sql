CREATE OR REPLACE
FUNCTION random_string(length integer) RETURNS TEXT AS
$$
DECLARE
  chars TEXT[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';

RESULT TEXT := '';

i integer := 0;

BEGIN
  IF length < 0 THEN
    RAISE EXCEPTION 'Given length cannot be less than 0';
END IF;

FOR i IN 1.. length LOOP
    RESULT := RESULT || chars[1 + random()*(array_length(chars,
1)-1)];
END LOOP;

RETURN RESULT;
END;

$$ LANGUAGE plpgsql;

CREATE OR REPLACE
FUNCTION random_between(low INT, high INT) RETURNS INT AS
$$
BEGIN
   RETURN floor(random()* (high-low + 1) + low);
END;

$$ LANGUAGE plpgsql;

CREATE OR REPLACE
FUNCTION random_timestamp_between(TIMESTAMP, TIMESTAMP)
RETURNS TIMESTAMP
LANGUAGE SQL
AS $$
    SELECT $1 + floor( 
      ( extract(epoch FROM $2 - $1) + 1) * random()
    )::INTEGER::TEXT::INTERVAL;
$$;

CREATE FUNCTION random_date_between(DATE, DATE)
RETURNS DATE
LANGUAGE SQL
AS $$
    SELECT $1 + floor( ($2 - $1 + 1) * random() )::INTEGER;
$$;

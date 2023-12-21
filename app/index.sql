
CREATE INDEX indx_sessions_create_at_today ON sessions (DATE(sessions.start_at));


CREATE OR REPLACE FUNCTION get_orders_week(time_at timestamp) 
  RETURNS text
AS
$BODY$
    SELECT DATE(time_at) >= DATE( CURRENT_TIMESTAMP - '7 days'::interval )and DATE(time_at) < CURRENT_DATE 
$BODY$
LANGUAGE sql
IMMUTABLE;

CREATE INDEX indx_orders_week_purchased ON orders (status, date(created_at));
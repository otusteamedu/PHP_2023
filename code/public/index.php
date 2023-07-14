<?php

echo "Hello!";

$dbconn3 = pg_connect("host=hw13-postgres port=5432 dbname=test user=test password=test");
var_dump(pg_version($dbconn3));

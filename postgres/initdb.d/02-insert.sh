#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
	INSERT INTO example (id, text) values
	  (uuid_generate_v4(), 'example 01'),
	  (uuid_generate_v4(), 'example 02');
EOSQL
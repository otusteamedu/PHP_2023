#!/bin/bash

export POSTGRES_USER=your_username
export POSTGRES_PASSWORD=your_password
export POSTGRES_DB=your_db

docker-compose up -d

echo "Waiting for PostgreSQL to start..."
sleep 4

docker exec -i postgresql psql -U ${POSTGRES_USER} -d ${POSTGRES_DB} -a -f /mnt/schema.sql
docker exec -i postgresql psql -U ${POSTGRES_USER} -d ${POSTGRES_DB} -a -f /mnt/records.sql

echo "SQL scripts have been executed."

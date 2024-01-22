#!/usr/bin/env sh
psql -b default -U cinema -f /var/www/html/1_create_tables.sql && \
psql -b default -U cinema -f /var/www/html/2_fill_data.sql && \
psql -b default -U cinema -f /var/www/html/10000/sessions.sql && \
psql -b default -U cinema -f /var/www/html/10000/tickets.sql
CREATE INDEX screenings_start_date ON screenings USING BTREE ((DATE(start_at)));

CREATE INDEX tickets_created_at ON tickets (created_at);

CREATE INDEX visitors_screening_id ON visitors (screening_id);
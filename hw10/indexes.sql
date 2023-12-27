CREATE INDEX ind_sessions_start_time ON sessions(start_time);

CREATE INDEX ind_tickets_session_id ON tickets(session_id);

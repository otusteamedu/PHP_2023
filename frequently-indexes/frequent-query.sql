SELECT * FROM pg_stat_user_indexes 
ORDER BY idx_scan DESC LIMIT 5;
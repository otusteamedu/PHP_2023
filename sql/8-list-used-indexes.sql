SELECT
    idstat.schemaname AS schema_name,
    idstat.relname    AS table_name,
    indexrelname      AS index_name,
    idstat.idx_scan   AS index_scans_count,
    pg_size_pretty(pg_relation_size(indexrelid))AS index_size,
    pg_size_pretty(pg_relation_size(idstat.relid)) AS table_size,
    tabstat.idx_scan AS table_reads_index_count,
    tabstat.seq_scan AS table_reads_seq_count,
    tabstat.seq_scan + tabstat.idx_scan AS table_reads_count,
    n_tup_upd + n_tup_ins + n_tup_del   AS table_writes_count
FROM pg_stat_user_indexes AS idstat
JOIN pg_indexes ON indexrelname = indexname AND idstat.schemaname = pg_indexes.schemaname
JOIN pg_stat_user_tables AS tabstat ON idstat.relid = tabstat.relid
WHERE indexdef !~* 'unique'
ORDER BY idstat.idx_scan DESC, pg_relation_size(indexrelid) desc;
/*
|schema_name|table_name      |index_name              |index_scans_count|index_size|table_size|table_reads_index_count|table_reads_seq_count|table_reads_count|table_writes_count|
|-----------|----------------|------------------------|-----------------|----------|----------|-----------------------|---------------------|-----------------|------------------|
|public     |demonstration   |demonstration_id_idx    |1,553,947        |214 MB    |498 MB    |1,553,947              |317                  |1,554,264        |9,999,998         |
|public     |seating_position|seating_position_id_idx |3,861            |16 kB     |32 kB     |3,861                  |11,029               |14,890           |334               |
|public     |dict_session    |session_id_idx          |76               |16 kB     |8192 bytes|100                    |44,597               |44,697           |4                 |
|public     |dict_hall       |hall_id_idx             |57               |16 kB     |8192 bytes|75                     |44,597               |44,672           |3                 |
|public     |dict_session    |dict_session_hall_id_idx|24               |16 kB     |8192 bytes|100                    |44,597               |44,697           |4                 |
|public     |dict_hall       |dict_hall_id_idx        |18               |16 kB     |8192 bytes|75                     |44,597               |44,672           |3                 |
|public     |dict_status     |status_id_idx           |0                |16 kB     |8192 bytes|0                      |616                  |616              |3                 |
|public     |dict_status     |dict_status_hall_id_idx |0                |16 kB     |8192 bytes|0                      |616                  |616              |3                 |
|public     |dict_ui_color   |dict_ui_color_id_idx    |0                |16 kB     |8192 bytes|218                    |28                   |246              |5                 |
*/

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
|schema_name|table_name      |index_name                 |index_scans_count|index_size|table_size|table_reads_index_count|table_reads_seq_count|table_reads_count|table_writes_count|
|-----------|----------------|---------------------------|-----------------|----------|----------|-----------------------|---------------------|-----------------|------------------|
|public     |demonstration   |demonstration_id_idx       |6                |214 MB    |498 MB    |6                      |30                   |36               |9,999,997         |
|public     |ticket          |ticket_demonstration_id_idx|6                |69 MB     |549 MB    |6                      |45                   |51               |10,002,553        |
|public     |ticket          |ticket_id_idx              |0                |214 MB    |549 MB    |6                      |45                   |51               |10,002,553        |
|public     |ticket          |ticket_position_id_idx     |0                |66 MB     |549 MB    |6                      |45                   |51               |10,002,553        |
|public     |ticket          |ticket_status_id_idx       |0                |66 MB     |549 MB    |6                      |45                   |51               |10,002,553        |
|public     |dict_ui_color   |dict_ui_color_id_idx       |0                |16 kB     |8192 bytes|0                      |5                    |5                |5                 |
|public     |_config         |_config_id_idx             |0                |16 kB     |8192 bytes|0                      |9                    |9                |1                 |
|public     |location        |location_id_idx            |0                |16 kB     |8192 bytes|0                      |5                    |5                |10                |
|public     |seating_position|seating_position_id_idx    |0                |16 kB     |8192 bytes|0                      |13                   |13               |10                |
|public     |film            |film_id_idx                |0                |16 kB     |8192 bytes|0                      |1,040                |1,040            |10                |
|public     |dict_hall       |dict_hall_id_idx           |0                |16 kB     |8192 bytes|0                      |11                   |11               |3                 |
|public     |dict_hall       |hall_id_idx                |0                |16 kB     |8192 bytes|0                      |11                   |11               |3                 |
|public     |dict_session    |dict_session_hall_id_idx   |0                |16 kB     |8192 bytes|0                      |12                   |12               |4                 |
|public     |dict_session    |session_id_idx             |0                |16 kB     |8192 bytes|0                      |12                   |12               |4                 |
*/
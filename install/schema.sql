
DROP DATABASE IF EXISTS balance;

CREATE DATABASE balance;

CREATE TABLE balance.positions (id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT, name VARCHAR(256) NOT NULL UNIQUE, rate INT UNSIGNED NOT NULL, created_at TIMESTAMP, updated_at TIMESTAMP, CONSTRAINT c_max_rate CHECK(rate < 101));

CREATE TABLE balance.employees (id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT, name VARCHAR(256) NOT NULL, position_id INT UNSIGNED NOT NULL, created_at TIMESTAMP, updated_at TIMESTAMP, CONSTRAINT c_fk_position FOREIGN KEY (position_id) REFERENCES positions (id) ON DELETE CASCADE);

CREATE TABLE balance.tasks (id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT, title VARCHAR(256) NOT NULL UNIQUE, created_at TIMESTAMP, updated_at TIMESTAMP);

CREATE TABLE balance.timesheets (id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT, task_id INT UNSIGNED NOT NULL, employee_id INT UNSIGNED NOT NULL, start_time TIMESTAMP NOT NULL, end_time TIMESTAMP NOT NULL, created_at TIMESTAMP, updated_at TIMESTAMP, CONSTRAINT c_fk_employee FOREIGN KEY (employee_id) REFERENCES employees (id) ON DELETE CASCADE, CONSTRAINT c_fk_task FOREIGN KEY (task_id) REFERENCES tasks (id) ON DELETE CASCADE, CONSTRAINT c_startTime_more_endTime CHECK(start_time < end_time));

CREATE TABLE balance.timesheet_history (id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT, employee_id INT UNSIGNED NOT NULL, task_title VARCHAR(256) NOT NULL, start_time TIMESTAMP NOT NULL, end_time TIMESTAMP NOT NULL);

DELIMITER //
CREATE TRIGGER balance.intersection_tasks_insert
    BEFORE INSERT
    ON balance.timesheets
    FOR EACH ROW
    BEGIN
    DECLARE count_rows INT;
    SELECT COUNT(*) INTO count_rows FROM balance.timesheets WHERE (employee_id=NEW.employee_id) AND (((NEW.start_time > start_time) AND (NEW.start_time < end_time)) OR ((NEW.end_time > start_time) AND (NEW.end_time < end_time)) OR ((start_time > NEW.start_time) AND (start_time < NEW.end_time)) OR ((end_time > NEW.start_time) AND (end_time < NEW.end_time)));
    IF count_rows>0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'An employee can only work on one task at a time every moment of time.';
    END IF;
    END//

CREATE TRIGGER balance.intersection_tasks_update
    BEFORE UPDATE
    ON balance.timesheets
    FOR EACH ROW
    BEGIN
    DECLARE count_rows INT;
    SELECT COUNT(*) INTO count_rows FROM balance.timesheets WHERE (employee_id=NEW.employee_id) AND (((NEW.start_time > start_time) AND (NEW.start_time < end_time)) OR ((NEW.end_time > start_time) AND (NEW.end_time < end_time)) OR ((start_time > NEW.start_time) AND (start_time < NEW.end_time)) OR ((end_time > NEW.start_time) AND (end_time < NEW.end_time)));
    IF count_rows>0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'An employee can only work on one task at a time every moment of time.';
    END IF;
    END//

CREATE TRIGGER balance.double_tasks_insert
    BEFORE INSERT
    ON balance.timesheets
    FOR EACH ROW
    BEGIN
    DECLARE count_rows INT;
    SELECT COUNT(*) INTO count_rows FROM balance.timesheets WHERE (NEW.employee_id=employee_id) AND (NEW.task_id=task_id) AND (NEW.start_time=start_time) AND (NEW.end_time=end_time);
    IF count_rows>0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'This entry already exists.';
    END IF;
    END//

CREATE TRIGGER balance.double_tasks_update
    BEFORE UPDATE
    ON balance.timesheets
    FOR EACH ROW
    BEGIN
    DECLARE count_rows INT;
    SELECT COUNT(*) INTO count_rows FROM balance.timesheets WHERE (NEW.employee_id=employee_id) AND (NEW.task_id=task_id) AND (NEW.start_time=start_time) AND (NEW.end_time=end_time);
    IF count_rows>0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'This entry already exists.';
    END IF;
    END//

CREATE TRIGGER balance.timesheet_delete
    AFTER DELETE
    ON balance.timesheets
    FOR EACH ROW
    BEGIN
    DECLARE taskTitle VARCHAR(256);
    SELECT title INTO taskTitle FROM balance.tasks WHERE (OLD.task_id=id);
    INSERT INTO timesheet_history (employee_id, task_title, start_time, end_time) VALUES (OLD.employee_id, taskTitle, OLD.start_time, OLD.end_time);
    END//
DELIMITER ;

-- INSERT INTO timesheets (employee_id, task_id, start_time, end_time) VALUES (1, 1, '2021-01-01 18:00:00', '2021-01-01 21:00:00');
-- INSERT INTO timesheets (employee_id, task_id, start_time, end_time) VALUES (1, 1, '2021-01-01 19:00:00', '2021-01-01 20:00:00');

-- вариант 1
-- SELECT COUNT(*) INTO count_rows FROM balance.timesheets WHERE (employee_id=1) AND (((start_time > NEW.start_time) AND (start_time < NEW.end_time)) OR ((end_time > NEW.start_time) AND (end_time < NEW.end_time)));

-- вариант 2
-- SELECT COUNT(*) INTO count_rows FROM balance.timesheets WHERE (employee_id=1) AND ((start_time BETWEEN NEW.start_time AND NEW.end_time) OR (end_time BETWEEN NEW.start_time AND NEW.end_time));

-- вариант 3
-- SELECT COUNT(*) INTO count_rows FROM balance.timesheets WHERE (employee_id=1) AND ((NEW.start_time BETWEEN start_time AND end_time) OR (NEW.end_time BETWEEN start_time AND end_time));

-- вариант 4
-- SELECT COUNT(*) INTO count_rows FROM balance.timesheets WHERE (employee_id=1) AND ((NEW.start_time BETWEEN start_time AND end_time) OR (NEW.end_time BETWEEN start_time AND end_time) OR (start_time BETWEEN NEW.start_time AND NEW.end_time) OR (end_time BETWEEN NEW.start_time AND NEW.end_time));

-- вариант 5
-- SELECT COUNT(*) INTO count_rows FROM balance.timesheets WHERE (employee_id=1) AND (((NEW.start_time > start_time) AND (NEW.start_time < end_time)) OR ((NEW.end_time > start_time) AND (NEW.end_time < end_time)) OR (start_time BETWEEN NEW.start_time AND NEW.end_time) OR (end_time BETWEEN NEW.start_time AND NEW.end_time));

-- вариант 6
-- SELECT COUNT(*) INTO count_rows FROM balance.timesheets WHERE (employee_id=1) AND (((NEW.start_time > start_time) AND (NEW.start_time < end_time)) OR ((NEW.end_time > start_time) AND (NEW.end_time < end_time)) OR ((start_time > NEW.start_time) AND (start_time < NEW.end_time)) OR ((end_time > NEW.start_time) AND (end_time < NEW.end_time)));

-- SELECT COUNT(*) FROM balance.timesheets WHERE (employee_id=1) AND (((start_time > NEW.start_time) AND (start_time < NEW.end_time)) OR ((end_time > NEW.start_time) AND (end_time < NEW.end_time)));
-- SELECT COUNT(*) FROM balance.timesheets WHERE (employee_id=1) AND (((start_time > '2021-01-01 11:00:00') AND (start_time < '2021-01-01 14:00:00')) OR ((end_time > '2021-01-01 12:00:00') AND (end_time < '2021-01-01 14:00:00')));

-- report top5longTasks
-- SELECT SUM(ROUND((UNIX_TIMESTAMP(end_time) - UNIX_TIMESTAMP(start_time)) / 3600)) AS spent_hours, tasks.title FROM timesheets LEFT JOIN tasks ON task_id=tasks.id GROUP BY task_id ORDER BY spent_hours DESC LIMIT 5;

-- report top5costTasks
-- SELECT SUM( ROUND((UNIX_TIMESTAMP(end_time) - UNIX_TIMESTAMP(start_time)) / 3600) * (SELECT positions.rate FROM employees JOIN positions ON employees.position_id = positions.id WHERE employees.id = timesheets.employee_id) ) AS total_cost, tasks.title FROM timesheets LEFT JOIN tasks ON task_id=tasks.id GROUP BY task_id ORDER BY total_cost DESC LIMIT 5;

-- report top5employees
-- SELECT SUM(ROUND((UNIX_TIMESTAMP(end_time) - UNIX_TIMESTAMP(start_time)) / 3600)) AS total_hours, employees.name FROM timesheets LEFT JOIN employees ON timesheets.employee_id=employees.id GROUP BY employee_id ORDER BY total_hours DESC LIMIT 5;

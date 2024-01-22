-- Create DB Products
CREATE TABLE IF NOT EXISTS products(
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    color VARCHAR(255),
    volume VARCHAR(255),
    price DECIMAL(10,2) NOT NULL
);

-- Generate data for DB Products
WITH names(names) AS (
    SELECT ARRAY_AGG(name)
    FROM unnest(ARRAY['Иван', 'Алексей', 'Мария', 'Елена', 'Андрей', 'Анастасия']) AS name
), actions(names) AS (
    SELECT ARRAY_AGG(actions)
    FROM unnest(ARRAY['пойдет', 'встанет', 'попрыгает', 'отдохнет', 'ляжет', 'споет', 'поиграет']) AS actions
), location(names) AS (
    SELECT ARRAY_AGG(location)
    FROM unnest(ARRAY['у дома', 'на дороге', 'в магазине', 'на работе', 'у остановки']) AS location
), color(name) AS (
    SELECT ARRAY_AGG(color)
    FROM unnest(ARRAY['красный', 'синий', 'зеленый', 'оранжевый', 'белый', 'черный']) as color
), volume(name) AS (
    SELECT ARRAY_AGG(volume)
    FROM unnest(ARRAY['100 кг', '1 тонна', '1 кг', '300 гр', '1 литр', '20 тонн']) as volume
)
INSERT INTO products (title, description, color, volume, price)
SELECT
    names.names[FLOOR(RANDOM() * ARRAY_LENGTH(names.names, 1)) + 1]
        || ' '
        || actions.names[FLOOR(RANDOM() * ARRAY_LENGTH(actions.names, 1)) + 1]
        || ' '
        || location.names[FLOOR(RANDOM() * ARRAY_LENGTH(location.names, 1)) + 1],
    md5(random()::text),
    color.name[FLOOR(RANDOM() * ARRAY_LENGTH(color.name, 1)) + 1],
    volume.name[FLOOR(RANDOM() * ARRAY_LENGTH(volume.name, 1)) + 1],
    CAST(random() * (90 - 10) + 10 AS decimal(10, 2))
FROM generate_series(1, 100)
CROSS JOIN names, actions, location, color, volume;

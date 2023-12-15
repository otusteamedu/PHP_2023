INSERT INTO attributes_type (name)
VALUES
('Text'),
('Image'),
('Date'),
('Date');

INSERT INTO attributes (attribute_name, attribute_type_id) VALUES
('рецензии', (SELECT id FROM attributes WHERE name = 'text')),
('премия оскар', (SELECT id FROM attributes WHERE name = 'bool')),
('важные даты', (SELECT id FROM attributes WHERE name = 'date')),
('служебные даты', (SELECT id FROM attributes WHERE name = 'date')),

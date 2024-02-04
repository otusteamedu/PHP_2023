-- Вставка типов атрибутов
INSERT INTO AttributeTypes (type_name)
VALUES ('Text'),
       ('Image'),
       ('Date');

-- Вставка атрибутов
INSERT INTO Attributes (attribute_name, type_id)
VALUES ('Рецензии', (SELECT type_id FROM AttributeTypes WHERE type_name = 'Text')),
       ('Премия оскар', (SELECT type_id FROM AttributeTypes WHERE type_name = 'Image')),
       ('Важные даты', (SELECT type_id FROM AttributeTypes WHERE type_name = 'Date')),
       ('Служебные даты', (SELECT type_id FROM AttributeTypes WHERE type_name = 'Date'));
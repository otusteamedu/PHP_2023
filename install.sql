CREATE TABLE IF NOT EXISTS `product`
(
    id int not null auto_increment,
    name varchar(150),
    description text,
    price float,
    category varchar(50),
    primary key (id)
);
CREATE TABLE IF NOT EXISTS `discount_price`
(
    id int not null auto_increment,
    product_id int,
    discount_price float,
    primary key (id)
);
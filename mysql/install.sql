CREATE TABLE IF NOT EXISTS `cinema`
(
    id int not null auto_increment,
    name varchar(50),
    primary key (id)
);
CREATE TABLE IF NOT EXISTS `cinema_hall`
(
    id int not null auto_increment,
    cinema_id int not null,
    name varchar(50),
    PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS `cinema_hall_places`
(
    id int not null auto_increment,
    cinema_hall_id int not null,
    row smallint not null ,
    place smallint not null ,
    PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS `movie`
(
    id int not null auto_increment,
    name varchar(150),
    primary key (id)
);
CREATE TABLE IF NOT EXISTS `session`
(
    id int not null auto_increment,
    cinema_hall_id int not null,
    movie_id int not null,
    start_date datetime,
    end_date datetime,
    PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS `session_place`
(
    id int not null auto_increment,
    session_id int not null,
    cinema_hall_places_id int not null,
    status smallint DEFAULT 0,
    PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS `session_movie_price`
(
    id int not null auto_increment,
    movie_id int not null,
    session_id int not null,
    price float,
    PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS `ticket`
(
    id int not null auto_increment,
    session_id int not null,
    session_place_id int not null,
    price float not null,
    checkout_id int,
    primary key (id)
);
CREATE TABLE IF NOT EXISTS `checkout`
(
    id int not null auto_increment,
    date datetime default NOW(),
    primary key (id)
);
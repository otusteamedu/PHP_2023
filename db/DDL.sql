create or replace table Movies
(
    id          int          not null
        primary key,
    name        varchar(255) not null,
    description text         not null,
    year        int          not null,
    movie_type  int          not null
);

create or replace table Attribute_types
(
    id   int auto_increment
        primary key,
    name varchar(255) not null
);

create or replace table Attributes
(
    id                int auto_increment
        primary key,
    name              varchar(255) null,
    attribute_type_id int          null,
    constraint Attributes_Attribute_types_null_fk
        foreign key (attribute_type_id) references Attribute_types (id)
);

create or replace table Attribute_values
(
    id           int auto_increment
        primary key,
    movie_id     int        not null,
    attribute_id int        not null,
    text_value   text       null,
    bool_value   tinyint(1) null,
    column_name  int        null,
    date_value   date       null,
    int_value    int        null,
    float_value  float      null,
    constraint Attribute_values_Attributes_null_fk
        foreign key (attribute_id) references Attributes (id),
    constraint Attribute_values_Movies_null_fk
        foreign key (movie_id) references Movies (id)
);
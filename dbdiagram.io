Table "hall" {
  "id" uuid [pk, not null, default: `uuid_generate_v4()`]
  "name" varchar [note: 'Наименование']
  "seat" int2 [not null, default: 0, note: 'Кол-во мест']
  "active" bool [not null, default: true]

Indexes {
  active [type: btree, name: "hall_active_idx"]
}
}

Table "movie" {
  "id" uuid [pk, not null, default: `uuid_generate_v4()`]
  "name" varchar [not null, note: 'Наименование']
  "release_date" date
  "description" text [note: 'Описание']
  "length_minute" int2

Indexes {
  name [type: btree, name: "movie_name_idx"]
  release_date [type: btree, name: "movie_release_date_idx"]
}
}

Table "seat" {
  "id" uuid [pk, not null, default: `uuid_generate_v4()`]
  "hall_id" uuid [not null]
  "number" varchar(5) [not null]
  "row" varchar(5) [not null]
  "active" bool [not null, default: true]
  "type_id" uuid

Indexes {
  active [type: btree, name: "seat_active_idx"]
  hall_id [type: btree, name: "seat_hall_id_idx"]
  (row, number) [type: btree, name: "seat_row_idx"]
}
}

Table "session" {
  "id" uuid [pk, not null, default: `uuid_generate_v4()`]
  "hall_id" uuid [not null]
  "movie_id" uuid [not null]
  "start_time" timestamp [not null]
  "length_minute" int2

Indexes {
  hall_id [type: btree, name: "session_hall_id_idx"]
  movie_id [type: btree, name: "session_movie_id_idx"]
  start_time [type: btree, name: "session_start_time_idx"]
}
}

Table "ticket" {
  "id" uuid [pk, not null, default: `uuid_generate_v4()`]
  "session_id" uuid [not null]
  "seat_id" uuid [not null]
  "price" "numeric(10, 2)" [not null, default: 0.0]
  "status" int2 [default: 0, note: '0-доступен, 1-продан,2-забронирован,10-не доступен']

Indexes {
  seat_id [type: btree, name: "ticket_seat_id_idx"]
  session_id [type: btree, name: "ticket_session_id_idx"]
  status [type: btree, name: "ticket_status_idx"]
}
}

Table "seat_type" {
  "id" uuid [pk, not null, default: `uuid_generate_v4()`]
  "name" varchar
}

Table "price_catalog" {
  "id" uuid [pk, not null, default: `uuid_generate_v4()`]
  "session_id" uuid
  "seat_type_id" uuid
  "price" "numeric(10, 2)" [not null, default: 0.0]

Indexes {
  seat_type_id [type: btree, name: "price_catalog_seat_type_id_idx"]
  session_id [type: btree, name: "price_catalog_session_id_idx"]
}
}

Table "attributes_type" {
  "id" uuid [pk, not null, default: `uuid_generate_v4()`]
  "name" varchar [not null]

Indexes {
  name [type: btree, name: "attributes_type_name_idx"]
}
}

Table "movie_attributes" {
  "id" uuid [pk, not null, default: `uuid_generate_v4()`]
  "name" varchar [not null]
  "type_id" uuid
  "parent_id" uuid

Indexes {
  name [type: btree, name: "movie_attributes_name_idx"]
  parent_id [type: btree, name: "movie_attributes_parent_id_idx"]
}
}

Table "movie_attributes_value" {
  "id" uuid [pk, not null, default: `uuid_generate_v4()`]
  "movie_id" uuid [not null]
  "attribute_id" uuid [not null]
  "value_string" varchar
  "value_bool" bool
  "value_date" date
  "value_float" float
  "active" bool [default: true]

Indexes {
  active [type: btree, name: "movie_attributes_value_active_idx"]
  attribute_id [type: btree, name: "movie_attributes_value_attribute_id_idx"]
  movie_id [type: btree, name: "movie_attributes_value_movie_id_idx"]
  value_string [type: btree, name: "movie_attributes_value_value_string_idx"]
  value_bool [type: btree, name: "movie_attributes_value_value_bool_idx"]
  value_date [type: btree, name: "movie_attributes_value_value_date_idx"]
  value_float [type: btree, name: "movie_attributes_value_value_float_idx"]
}
}


Ref: seat.hall_id > hall.id
Ref: session.hall_id > hall.id
Ref: session.movie_id > movie.id
Ref: ticket.session_id > session.id
Ref: ticket.seat_id > seat.id
Ref: seat.type_id > seat_type.id
Ref: price_catalog.session_id > session.id
Ref: price_catalog.seat_type_id > seat_type.id


Ref: movie_attributes.type_id > attributes_type.id
Ref: movie_attributes.parent_id > movie_attributes.id
Ref: movie_attributes_value.movie_id > movie.id
Ref: movie_attributes_value.attribute_id > movie_attributes.id

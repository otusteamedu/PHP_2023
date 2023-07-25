CREATE TABLE public.user
(
    id SERIAL PRIMARY KEY,
    name CHARACTER VARYING(255) NOT NULL,
    surname CHARACTER VARYING(255) NOT NULL
);

INSERT INTO public.user (name, surname) VALUES ('Alexey', 'Tashmatov');
INSERT INTO public.user (name, surname) VALUES ('Michel', 'Ivanov');
INSERT INTO public.user (name, surname) VALUES ('Ivan', 'Petrov');

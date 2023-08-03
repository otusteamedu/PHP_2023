CREATE TYPE public.e_contact_type AS ENUM (
	'Mobile phone',
	'Telegram');
CREATE TYPE public.e_sex AS ENUM (
	'F',
	'M');

CREATE TABLE public.person (
    id uuid NOT NULL DEFAULT uuid_generate_v4(),
    add_timestamp timestamp NOT NULL DEFAULT now()::timestamp without time zone,
    fam varchar NOT NULL,
    nam varchar NULL,
    otc varchar NULL,
    birthday date NULL,
    nom varchar NULL,
    prenom varchar NULL,
    sex public.e_sex NULL DEFAULT 'M'::e_sex,
    CONSTRAINT person_pk PRIMARY KEY (id)
);
CREATE INDEX person_add_timestamp_idx ON public.person USING btree (add_timestamp);
CREATE INDEX person_fam_idx ON public.person USING btree (fam, nam, otc);

CREATE TABLE public.person_city (
    id uuid NOT NULL DEFAULT uuid_generate_v4(),
    add_timestamp varchar NOT NULL DEFAULT now()::timestamp without time zone,
    person_id uuid NOT NULL,
    "text" varchar NULL,
    CONSTRAINT person_city_pk PRIMARY KEY (id)
);
CREATE INDEX person_city_add_timestamp_idx ON public.person_city USING btree (add_timestamp);
CREATE INDEX person_city_person_id_idx ON public.person_city USING btree (person_id);
CREATE INDEX person_city_text_idx ON public.person_city USING btree (text);

CREATE TABLE public.person_contacts (
    id uuid NOT NULL DEFAULT uuid_generate_v4(),
    add_timestamp varchar NOT NULL DEFAULT now()::timestamp without time zone,
    person_id uuid NOT NULL,
    "type" public.e_contact_type NULL DEFAULT 'Mobile phone'::e_contact_type,
    value varchar NULL,
    active bool NULL DEFAULT true,
    CONSTRAINT person_contacts_pk PRIMARY KEY (id)
);
CREATE INDEX person_contacts_active_idx ON public.person_contacts USING btree (active);
CREATE INDEX person_contacts_add_timestamp_idx ON public.person_contacts USING btree (add_timestamp);
CREATE INDEX person_contacts_person_id_idx ON public.person_contacts USING btree (person_id);
CREATE INDEX person_contacts_type_idx ON public.person_contacts USING btree (type, value);

CREATE TABLE public.person_notes (
    id uuid NOT NULL DEFAULT uuid_generate_v4(),
    add_timestamp varchar NOT NULL DEFAULT now()::timestamp without time zone,
    person_id uuid NOT NULL,
    "text" varchar NULL,
    CONSTRAINT person_notes_pk PRIMARY KEY (id)
);
CREATE INDEX person_notes_add_timestamp_idx ON public.person_notes USING btree (add_timestamp);
CREATE INDEX person_notes_person_id_idx ON public.person_notes USING btree (person_id);

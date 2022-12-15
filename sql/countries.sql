create table countries
(
    "ID_country" serial
        primary key,
    name         varchar(100) not null
);

alter table countries
    owner to postgres;

INSERT INTO public.countries ("ID_country", name) VALUES (1, 'Poland');

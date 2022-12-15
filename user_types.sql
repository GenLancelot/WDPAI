create table user_types
(
    "ID_user_type" serial
        primary key,
    name           text
);

alter table user_types
    owner to postgres;

INSERT INTO public.user_types ("ID_user_type", name) VALUES (1, 'normal');
INSERT INTO public.user_types ("ID_user_type", name) VALUES (2, 'admin');

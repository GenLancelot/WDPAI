create table users
(
    "ID_user"      integer   default nextval('users_id_seq'::regclass) not null
        primary key,
    email          varchar(255)                                        not null,
    password       varchar(255)                                        not null,
    enable         boolean   default true,
    created_at     timestamp default CURRENT_TIMESTAMP,
    "ID_user_type" integer   default 1
        constraint users_user_types_id_user_type_fk
            references user_types
);

alter table users
    owner to postgres;

INSERT INTO public.users ("ID_user", email, password, enable, created_at, "ID_user_type") VALUES (1, 'test@test.pl', 'test123', true, '2022-12-07 19:20:11.000000', 1);
INSERT INTO public.users ("ID_user", email, password, enable, created_at, "ID_user_type") VALUES (2, 'nowy@test.pl', 'nowehaslo', true, '2022-12-07 19:20:09.000000', 1);
INSERT INTO public.users ("ID_user", email, password, enable, created_at, "ID_user_type") VALUES (3, 'admin@teamfinder.io', 'admin', true, '2022-12-07 19:20:06.000000', 2);

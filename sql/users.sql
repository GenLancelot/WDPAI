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

INSERT INTO public.users ("ID_user", email, password, enable, created_at, "ID_user_type") VALUES (2, 'nowy@test.pl', '$2y$10$jl2axSJcjmkGHkW.T89juuZ/EftBaMZJQG5ifusnYLlNmeozJG81e', true, '2022-12-07 19:20:09.000000', 1);
INSERT INTO public.users ("ID_user", email, password, enable, created_at, "ID_user_type") VALUES (1, 'test@test.pl', '$2y$10$v3g2suqo9SdsQZb7Zm14Bu.on5Bkdebu0aQssu2CImVDPS5xLk9Fm', true, '2022-12-07 19:20:11.000000', 1);
INSERT INTO public.users ("ID_user", email, password, enable, created_at, "ID_user_type") VALUES (3, 'admin@teamfinder.io', '$2y$10$BdWfsu0r7c.KlLPpD.ynsODENhgUyUxG.WHxrAKtWIhNXtA7oYBre', true, '2022-12-07 19:20:06.000000', 2);
INSERT INTO public.users ("ID_user", email, password, enable, created_at, "ID_user_type") VALUES (4, 'testrejestarcji@test.pl', '$2y$10$Q77bHZvSkMJ9PND3UhI8H.N0VYyLbPS0PbvTO1RKQfG1ICE.H5trS', true, '2022-12-15 21:42:16.832203', 1);

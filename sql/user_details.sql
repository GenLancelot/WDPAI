create table user_details
(
    "ID_user_details"    serial
        primary key,
    "ID_user"            integer not null
        unique
        constraint user_details_users_id_user_fk
            references users,
    "ID_country"         integer not null
        constraint user_details_countries_id_country_fk
            references countries,
    description          text,
    icon_path            text,
    background_path      text,
    "ID_status"          integer
        constraint user_details_status_id_status_fk
            references status,
    "ID_prioritizedGame" integer
        constraint user_details_games_id_game_fk
            references games
);

alter table user_details
    owner to postgres;

INSERT INTO public.user_details ("ID_user_details", "ID_user", "ID_country", description, icon_path, background_path, "ID_status", "ID_prioritizedGame") VALUES (2, 1, 1, 'Testowy opis', 'default_icon.jpg', 'default_background.jpg', 2, null);

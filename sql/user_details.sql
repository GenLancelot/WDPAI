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
    icon_path            text default 'default_icon.jpg'::text,
    background_path      text default 'default_background.jpg'::text,
    "ID_status"          integer
        constraint user_details_status_id_status_fk
            references status,
    "ID_prioritizedGame" integer
        constraint user_details_games_id_game_fk
            references games
);

alter table user_details
    owner to postgres;

INSERT INTO public.user_details ("ID_user_details", "ID_user", "ID_country", description, icon_path, background_path, "ID_status", "ID_prioritizedGame") VALUES (1, 1, 1, 'John is an avid gamer who loves to play a variety of genres. He enjoys playing first-person shooters, role-playing games, and strategy games. He is always looking for new and exciting titles to try out. He has a passion for gaming and loves to share his experiences with others', 'wp2928790.jpg', 'wp2928790.jpg', 2, 2);
INSERT INTO public.user_details ("ID_user_details", "ID_user", "ID_country", description, icon_path, background_path, "ID_status", "ID_prioritizedGame") VALUES (3, 2, 1, 'Testowy opis user 2 ', 'default_icon.jpg', 'default_background.jpg', null, null);
INSERT INTO public.user_details ("ID_user_details", "ID_user", "ID_country", description, icon_path, background_path, "ID_status", "ID_prioritizedGame") VALUES (4, 4, 1, 'Test user 4', 'wp2928790.jpg', 'default_background.jpg', null, null);

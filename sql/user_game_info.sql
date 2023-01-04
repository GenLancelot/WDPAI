create table user_game_info
(
    "ID_user_game_info" serial
        primary key,
    "ID_user_details"   integer not null
        constraint user_game_info_user_details_id_user_details_fk
            references user_details,
    "ID_game"           integer not null
        constraint user_game_info_games_id_game_fk
            references games,
    "ID_rank"           integer
        constraint user_game_info_games_ranks_id_rank_fk
            references games_ranks
);

alter table user_game_info
    owner to postgres;

INSERT INTO public.user_game_info ("ID_user_game_info", "ID_user_details", "ID_game", "ID_rank") VALUES (9, 1, 4, 6);
INSERT INTO public.user_game_info ("ID_user_game_info", "ID_user_details", "ID_game", "ID_rank") VALUES (2, 1, 2, 2);
INSERT INTO public.user_game_info ("ID_user_game_info", "ID_user_details", "ID_game", "ID_rank") VALUES (1, 1, 1, 3);

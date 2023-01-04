create table games_ranks
(
    "ID_rank" serial
        primary key,
    "ID_game" integer not null,
    name      text,
    filename  text
);

alter table games_ranks
    owner to postgres;

INSERT INTO public.games_ranks ("ID_rank", "ID_game", name, filename) VALUES (1, 1, 'Gold I', 'lol_gold.png');
INSERT INTO public.games_ranks ("ID_rank", "ID_game", name, filename) VALUES (3, 1, 'Unranked', null);
INSERT INTO public.games_ranks ("ID_rank", "ID_game", name, filename) VALUES (4, 2, 'Unranked', null);
INSERT INTO public.games_ranks ("ID_rank", "ID_game", name, filename) VALUES (5, 3, 'Unranked', null);
INSERT INTO public.games_ranks ("ID_rank", "ID_game", name, filename) VALUES (6, 4, 'Unranked', null);
INSERT INTO public.games_ranks ("ID_rank", "ID_game", name, filename) VALUES (2, 2, 'Global Offensive', 'csgo_global-offensive.png');

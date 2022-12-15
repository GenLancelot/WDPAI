create table games
(
    "ID_game" serial
        primary key,
    name      text not null,
    filename  text
);

alter table games
    owner to postgres;

INSERT INTO public.games ("ID_game", name, filename) VALUES (1, 'League of Legends', 'Lol_icon.svg');
INSERT INTO public.games ("ID_game", name, filename) VALUES (2, 'Counter-Strike: Global Offensive', 'counter-strike-global-offensive-2-logo-svgrepo-com.svg');
INSERT INTO public.games ("ID_game", name, filename) VALUES (3, 'Call of Duty Warzone', 'Warzone.svg');
INSERT INTO public.games ("ID_game", name, filename) VALUES (4, 'Rocket League', 'rocket-league.svg');

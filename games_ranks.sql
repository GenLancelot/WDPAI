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


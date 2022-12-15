create table conversations
(
    "ID_conversation" serial
        primary key,
    "ID_user1"        integer not null
        constraint conversations_users_id_fk
            references users,
    "ID_user2"        integer not null
        constraint conversations_users_id_fk_2
            references users
);

alter table conversations
    owner to postgres;


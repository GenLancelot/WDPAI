create table messages
(
    "ID_message"      serial
        primary key,
    "ID_conservation" integer not null
        constraint messages_conversations_id_conversation_fk
            references conversations,
    "ID_user"         integer not null
        constraint messages_users_id_fk
            references users,
    messege           text
);

alter table messages
    owner to postgres;


create table friendships
(
    "ID_friendship" integer default nextval('"Friendship_ID_friendship_seq"'::regclass) not null
        constraint "Friendship_pkey"
            primary key,
    "ID_user1"      integer                                                             not null
        constraint friendship_users_id_user_fk
            references users,
    "ID_user2"      integer                                                             not null
        constraint friendship_users_id_user_fk_2
            references users,
    "ID_status"     integer default 4                                                   not null
        constraint friendship_friendship_status_id_friendship_status_fk
            references friendship_status
);

alter table friendships
    owner to postgres;


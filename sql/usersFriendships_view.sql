create view "usersFriendships"(user1_email, user2_email, friendship_status) as
SELECT u.email  AS user1_email,
       u2.email AS user2_email,
       fs.name  AS friendship_status
FROM friendships f
         JOIN users u ON u."ID_user" = f."ID_user1"
         JOIN users u2 ON u2."ID_user" = f."ID_user2"
         JOIN friendship_status fs ON fs."ID_friendship_status" = f."ID_status";

comment on view "usersFriendships" is 'print friendships between all users which have relation';

alter table "usersFriendships"
    owner to postgres;

INSERT INTO public."usersFriendships" (user1_email, user2_email, friendship_status) VALUES ('test@test.pl', 'nowy@test.pl', 'Accepted');

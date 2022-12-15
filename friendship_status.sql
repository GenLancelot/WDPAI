create table friendship_status
(
    "ID_friendship_status" serial
        primary key,
    name                   text not null
);

alter table friendship_status
    owner to postgres;

INSERT INTO public.friendship_status ("ID_friendship_status", name) VALUES (1, 'Requested');
INSERT INTO public.friendship_status ("ID_friendship_status", name) VALUES (2, 'Accepted');
INSERT INTO public.friendship_status ("ID_friendship_status", name) VALUES (3, 'Declined');
INSERT INTO public.friendship_status ("ID_friendship_status", name) VALUES (4, 'Unknown');

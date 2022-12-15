create table status
(
    "ID_status" integer default nextval('"table_name_ID_status_seq"'::regclass) not null
        constraint table_name_pkey
            primary key,
    name        text
);

alter table status
    owner to postgres;

INSERT INTO public.status ("ID_status", name) VALUES (1, 'Active');
INSERT INTO public.status ("ID_status", name) VALUES (2, 'Unknown');
INSERT INTO public.status ("ID_status", name) VALUES (3, 'Inactive');

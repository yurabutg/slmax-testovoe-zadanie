create table users
(
    id         int auto_increment
        primary key,
    first_name varchar(60) null,
    last_name  varchar(60) null,
    birth_date date        null,
    gender     tinyint(1)  null,
    birth_city varchar(60) null,
    constraint users_id_uindex
        unique (id)
);


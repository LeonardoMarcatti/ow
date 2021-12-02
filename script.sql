create database ow;
use ow;

create table users(
	id int unsigned auto_increment primary key,
    name varchar(50) not null,
    birthday date,
	created_at datetime,
    updated_at datetime
);

create table email(
	id int unsigned auto_increment primary key,
    email varchar(50) not null,
    id_user INT UNSIGNED NOT NULL,
    constraint user_email foreign key(id_user) references users(id)
);

delimiter $
CREATE PROCEDURE addUsers()
begin
	insert into users(name, birthday, created_at) values('User 1', '1978-12-31', now());
	insert into users(name, birthday, created_at) values('User 2', '2002-05-17', now());
	insert into users(name, birthday, created_at) values('User 3', '1945-12-08', now());
end;
$
delimiter ;

call addUsers();

delimiter $
CREATE PROCEDURE addEmails()
begin
	insert into email(email, id_user) values('user1@test.com', 1);
    insert into email(email, id_user) values('user2@test.com', 2);
    insert into email(email, id_user) values('user3@test.com', 3);
end;
$
delimiter ;

call addEmails();
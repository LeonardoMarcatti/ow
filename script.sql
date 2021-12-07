create database ow;
use ow;

create table users(
	id int unsigned not null auto_increment primary key,
    name varchar(50) not null,
    birthday date not null,
	created_at date not null,
    updated_at date null
);

create table email(
	id int unsigned auto_increment primary key,
    email varchar(50) not null unique,
    id_user INT UNSIGNED NOT NULL,
    constraint user_email foreign key(id_user) references users(id)
);

create table balance(
	id int unsigned not null auto_increment primary key,
    start_balance float(10,2) not null default 0,
	current_balance float(10,2) not null default 0,
    id_user INT UNSIGNED NOT NULL,
    constraint user_balance foreign key(id_user) references users(id)
);

create table moviment(
	id int unsigned auto_increment primary key,
    mov_type varchar(4) not null,
    mov_value float(10,2) not null,
    mov_created_at date not null,
    id_user INT UNSIGNED NOT NULL,
    constraint user_moviment foreign key(id_user) references users(id)
);

delimiter $
create trigger addbalance 
	after insert on users 
    for each row
	begin
		declare maxID int;
        set maxID = (select max(id) from users);
        insert into balance(id_user) values(maxID);
	end;
$
delimiter ;

delimiter $
CREATE PROCEDURE addUsers()
begin
	insert into users(name, birthday, created_at) values('User 1', '1978-12-31', date(now()));
	insert into users(name, birthday, created_at) values('User 2', '2002-05-17', date(now()));
	insert into users(name, birthday, created_at) values('User 3', '1945-12-08', date(now()));
end;
$
delimiter ;

call addUsers();

delimiter $
create trigger updatebalance 
	after insert on moviment 
    for each row
	begin
		declare maxID int;
        declare userID int;
        declare val float(10,2);
        declare movtype varchar(4);
        set maxID = (select max(id) from moviment);
        set userID = (select id_user from moviment where id = maxID);
        set val = (select mov_value from moviment where id = maxID);
        set movtype = (select mov_type from moviment where id = maxID);
        if movtype = 'CRED' or movtype = 'EST' then
			update balance set current_balance = ((select current_balance from balance where id_user = userID) + val) where id_user = userID;
		else
			update balance set current_balance = ((select current_balance from balance where id_user = userID) - val) where id_user = userID;
        end if;
	end;
$
delimiter ;

delimiter $
create trigger updatebalance2
	before delete on moviment 
    for each row
	begin
        declare userID int;
        declare val float(10,2);
        declare movtype varchar(4);
        set userID = (select id_user from moviment where id = old.id);
        set val = (select mov_value from moviment where id = old.id);
        set movtype = (select mov_type from moviment where id = old.id);
        if movtype = 'CRED' or movtype = 'EST' then
			update balance set current_balance = ((select current_balance from balance where id_user = userID) - val) where id_user = userID;
		else
			update balance set current_balance = ((select current_balance from balance where id_user = userID) + val) where id_user = userID;
        end if;
	end;
$
delimiter ;

delimiter $
CREATE PROCEDURE addMoviments()
begin
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('DEB', 23.65,  date(now() - interval floor(rand()*30) day), 1);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('CRED', 66.87, date(now() - interval floor(rand()*30) day), 1);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('EST', 48.98,  date(now() - interval floor(rand()*30) day), 1);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('DEB', 32.33,  date(now() - interval floor(rand()*30) day), 1);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('CRED', 10.05, date(now() - interval floor(rand()*30) day), 1);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('EST', 12.12,  date(now() - interval floor(rand()*30) day), 1);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('DEB', 24.58,  date(now() - interval floor(rand()*30) day), 1);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('CRED', 55.55, date(now() - interval floor(rand()*30) day), 1);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('EST', 48.98,  date(now() - interval floor(rand()*30) day), 1);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('DEB', 56.65,  date(now() - interval floor(rand()*30) day), 1);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('CRED', 63.97, date(now() - interval floor(rand()*30) day), 1);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('EST', 123.32, date(now() - interval floor(rand()*30) day), 1);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('DEB', 45.55,  date(now() - interval floor(rand()*30) day), 1);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('CRED', 99.99, date(now() - interval floor(rand()*30) day), 1);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('EST', 14.57,  date(now() - interval floor(rand()*30) day), 1);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('DEB', 55.62,  date(now() - interval floor(rand()*30) day), 1);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('CRED', 70.77, date(now() - interval floor(rand()*30) day), 1);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('EST', 250.36, date(now() - interval floor(rand()*30) day), 1);
    insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('DEB', 23.65,  date(now() - interval floor(rand()*30) day), 2);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('CRED', 66.87, date(now() - interval floor(rand()*30) day), 2);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('EST', 48.98,  date(now() - interval floor(rand()*30) day), 2);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('DEB', 32.33,  date(now() - interval floor(rand()*30) day), 2);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('CRED', 10.05, date(now() - interval floor(rand()*30) day), 2);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('EST', 12.12,  date(now() - interval floor(rand()*30) day), 2);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('DEB', 24.58,  date(now() - interval floor(rand()*30) day), 2);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('CRED', 55.55, date(now() - interval floor(rand()*30) day), 2);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('EST', 48.98,  date(now() - interval floor(rand()*30) day), 2);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('DEB', 56.65,  date(now() - interval floor(rand()*30) day), 2);
    insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('DEB', 23.65,  date(now() - interval floor(rand()*30) day), 3);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('CRED', 66.87, date(now() - interval floor(rand()*30) day), 3);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('EST', 48.98,  date(now() - interval floor(rand()*30) day), 3);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('DEB', 32.33,  date(now() - interval floor(rand()*30) day), 3);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('CRED', 10.05, date(now() - interval floor(rand()*30) day), 3);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('EST', 12.12,  date(now() - interval floor(rand()*30) day), 3);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('DEB', 24.58,  date(now() - interval floor(rand()*30) day), 3);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('CRED', 55.55, date(now() - interval floor(rand()*30) day), 3);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('EST', 48.98,  date(now() - interval floor(rand()*30) day), 3);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('DEB', 56.65,  date(now() - interval floor(rand()*30) day), 3);
    insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('DEB', 23.65,  date(now() - interval floor(rand()*30) day), 3);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('CRED', 66.87, date(now() - interval floor(rand()*30) day), 3);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('EST', 48.98,  date(now() - interval floor(rand()*30) day), 3);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('DEB', 32.33,  date(now() - interval floor(rand()*30) day), 3);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('CRED', 10.05, date(now() - interval floor(rand()*30) day), 3);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('EST', 12.12,  date(now() - interval floor(rand()*30) day), 3);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('DEB', 24.58,  date(now() - interval floor(rand()*30) day), 3);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('CRED', 55.55, date(now() - interval floor(rand()*30) day), 3);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('EST', 48.98,  date(now() - interval floor(rand()*30) day), 3);
	insert into moviment(mov_type, mov_value, mov_created_at, id_user) values('DEB', 56.65,  date(now() - interval floor(rand()*30) day), 3);
end;
$
delimiter ;

call addMoviments();

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

select 'Fim';
drop table if exists users cascade;
drop table if exists student cascade;
drop table if exists executive cascade;
drop table if exists coordinator cascade;
drop table if exists faculty cascade;
drop table if exists office cascade;
drop table if exists auth cascade;
drop table if exists transaction cascade;
drop table if exists approval cascade;
drop table if exists booking cascade;
drop table if exists requirement cascade;
drop table if exists lechall cascade;
drop table if exists location cascade;
drop table if exists calendar cascade;
drop table if exists timetable cascade;

create table users (
     userId	varchar(10) not null, 
     password	varchar(50) not null,
     name	varchar(30) not null,
     email	varchar(50) not null,
     contactno	varchar(15) not null,
     address	text,
     primary key (userId)
);

create table student (
     userId	varchar(10) not null,
     rollno	varchar(10) not null,
     primary key (rollno),
     foreign key (userId) references users on delete cascade
);

create table executive (
     rollno	varchar(10) not null,
     post	varchar(10) not null,
     primary key (rollno, post),
     foreign key (rollno) references student  on delete cascade
);

create table coordinator (
     rollno	varchar(10) not null,
     club	varchar(20) not null,
     primary key (rollno, club),
     foreign key (rollno) references student  on delete cascade
);

create table faculty (
     userId	varchar(10) not null,
     facId	varchar(10) not null,
     primary key (userId, facId),
     foreign key (userId) references users  on delete cascade
);

create table office (
     userId	varchar(10) not null,
     offtype	varchar(10) not null,
     primary key (userId, offtype),
     foreign key (userId) references users  on delete cascade
);

create table auth (
     userId	varchar(10) not null,
     authtype	varchar(10) not null,
     primary key (userId, authtype),
     foreign key (userId) references users  on delete cascade
);

create table booking(
     bookId	serial primary key,
     bookDate	date not null,
     startTime	time not null,
     endTime	time,
     aircon	boolean default false     
);

create table transaction(
     transNo	serial primary key,
     userId	varchar(10) not null,
     bookId	int not null,
     transtype	char(1) not null,
     atTime	timestamp default 'now',
     details	text,     
     foreign key (userId) references users on delete cascade     
);

create table approval(
     userId	varchar(10) not null,
     bookId	int not null,
     state	char(1) default 'P',
     updated	timestamp default 'now',     
     primary key (userId, bookId),
     foreign key (userId) references users on delete cascade,
     foreign key (bookId) references booking on delete cascade
);

create table requirement(
     bookId	int not null,
     equip	varchar(30),
     foreign key (bookId) references booking on delete cascade
);

create table lechall(
     hallno	varchar(8) not null,
     capacity	int,
     primary key (hallno)
);

create table location(
     bookId 	int not null,
     hallno	varchar(8) not null,
     foreign key (bookId) references booking on delete cascade,
     foreign key (hallno) references lechall on delete cascade
);

create table calendar(
     dateOf	date,
     dayOf	varchar(2),
     primary key (dateOf)
);

create table timetable(
     dayOf	varchar(2) not null,
     course	varchar(10),
     meettype	char(1),
     hallno	varchar(8) not null,
     startTime	time not null,
     endTime	time,
     foreign key (hallno) references lechall on delete cascade
);


create table instructor(
facid varchar(10) not null,
userId varchar(10) not null,			
course varchar(10), 
foreign key (userId, facid) references faculty on delete cascade);

create table precedence(
     approver varchar(10) not null,
     weight int,
     primary key(approver)
);

create table alerts(
     alertno 	serial primary key,
     userId	varchar(10) not null,
     alerttype 	varchar(5),
     alertto	varchar(20),
     msg	text not null,
     alertAt	timestamp default 'now',
     delivered	boolean default false,
     foreign key (userId) references users
);
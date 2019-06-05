DROP TABLE if exists purchases;
DROP TABLE if exists employees;
DROP TABLE if exists customers;
DROP TABLE if exists products;
DROP TABLE if exists suppliers;
DROP TABLE if exists logs;

create table employees
(eid int(3) not null,
ename varchar(15),
city varchar(15),
primary key(eid)) ENGINE=InnoDB;


-- 本文件用于建立pur、cid、eid、pid、key_value为INT数据类型的表格
create table customers
(cid int(4) not null,
cname varchar(15),
city varchar(15),
visits_made int(5) not null default '0',   -- 修改
last_visit_time datetime,
primary key(cid)) ENGINE=InnoDB;           -- 使用InnoDB引擎，保证外键约束，下同

create table suppliers
(sid varchar(2) not null,
sname varchar(15) not null,
city varchar(15),
telephone_no char(10),
primary key(sid),
unique(sname)) ENGINE=InnoDB;

create table products
(pid int(4) not null,
pname varchar(15) not null,
qoh int(5) not null,
qoh_threshold int(5),
original_price decimal(6,2),
discnt_rate decimal(3,2),
sid varchar(2),
primary key(pid),
foreign key (sid) references suppliers(sid)) ENGINE=InnoDB;

create table purchases
(pur int(4) not null auto_increment,
cid int(4) not null,
eid int(3) not null,
pid int(4) not null,
qty int(5),
ptime datetime,
total_price decimal(7,2),
primary key (pur),
foreign key (cid) references customers(cid),
foreign key (eid) references employees(eid),
foreign key (pid) references products(pid)) ENGINE=InnoDB;

create table logs
(logid int(5) not null auto_increment,
who varchar(10) not null,
`time` datetime not null,
`table_name` varchar(20) not null,
operation varchar(6) not null,
key_value int(4),
primary key (logid)) ENGINE=InnoDB; 


insert into employees values ('e00', 'Amy', 'Vestal');
insert into employees values ('e01', 'Bob', 'Binghamton');
insert into employees values ('e02', 'John', 'Binghamton');
insert into employees values ('e03', 'Lisa', 'Binghamton');
insert into employees values ('e04', 'Matt', 'Vestal');

insert into suppliers values ('s0', 'Supplier 1', 'Binghamton', '6075555431');
insert into suppliers values ('s1', 'Supplier 2', 'NYC', '6075555432');

insert into products values ('pr00', 'Milk', 12, 10, 2.40, 0.1, 's0');
insert into products values ('pr01', 'Egg', 20, 10, 1.50, 0.2, 's1');
insert into products values ('pr02', 'Bread', 15, 10, 1.20, 0.1, 's0');
insert into products values ('pr03', 'Pineapple', 6, 5, 2.00, 0.3, 's0');
insert into products values ('pr04', 'Knife', 10, 8, 2.50, 0.2, 's1');
insert into products values ('pr05', 'Shovel', 5, 5, 7.99, 0.1, 's0');

insert into customers values ('c000', 'Kathy', 'Vestal', 2, '2013-11-28 10:25:32'); 
insert into customers values ('c001', 'Brown', 'Binghamton', 1, '2013-12-05 09:12:30'); 
insert into customers values ('c002', 'Anne', 'Vestal', 1, '2013-11-29 14:30:00'); 
insert into customers values ('c003', 'Jack', 'Vestal', 1, '2013-12-04 16:48:02'); 
insert into customers values ('c004', 'Mike', 'Binghamton', 1, '2013-11-30 11:52:16'); 
    
insert into purchases values ('p000', 'c000', 'e00', 'pr00', 1, '2013-11-26 12:34:22', 2.16);
insert into purchases values ('p001', 'c001', 'e03', 'pr03', 2, '2013-12-05 09:12:30', 2.80);
insert into purchases values ('p002', 'c002', 'e03', 'pr00', 1, '2013-11-29 14:30:00', 2.16);
insert into purchases values ('p003', 'c000', 'e01', 'pr01', 5, '2013-11-28 10:25:32', 6.00);
insert into purchases values ('p004', 'c004', 'e04', 'pr02', 3, '2013-11-30 11:52:16', 3.24);
insert into purchases values ('p005', 'c003', 'e02', 'pr05', 1, '2013-12-04 16:48:02', 7.19);


-- 创建触发器，两个sql文件
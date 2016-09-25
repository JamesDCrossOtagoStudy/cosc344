DROP TABLE qualifications_type;
DROP TABLE qualifications;
DROP TABLE book_tran;
DROP TABLE transactions;
DROP TABLE customer;
DROP TABLE postcode;
DROP TABLE employee;
DROP TABLE employee_wage;
DROP TABLE supplies;
DROP TABLE supplier;
DROP TABLE book;
DROP table bookstore;





CREATE TABLE bookstore
(storeID     VARCHAR2(7) PRIMARY KEY,
city        VARCHAR2(20)  NOT NULL,
address     VARCHAR2(30)   NOT NULL,
account     CHAR(15)       NOT NULL,
date_opened   DATE      ,
total_salary    NUMBER(8) NOT NULL);

INSERT INTO bookstore VALUES
('0001', 'Milton', '33 Union Street', '0234-9871-8373', TO_DATE('05/22/1999','MM/DD/YYYY'), 0);
INSERT INTO bookstore VALUES
('0002', 'Bluff', '99 Oyster Road', '0453-1543-8532', TO_DATE('01/08/1998','MM/DD/YYYY'), 0);
INSERT INTO bookstore VALUES
('0003', 'Invercargill', '33 Dee Street', '0324-9553-8443', TO_DATE('06/14/1997','MM/DD/YYYY'), 0);
INSERT INTO bookstore VALUES
('0004', 'Waihola', '21 Lake Road', '0334-9321-7673', TO_DATE('12/14/2003','MM/DD/YYYY'), 0);
INSERT INTO bookstore VALUES
('0005', 'Gore', '11 Bogan Street', '0854-6354-9142', TO_DATE('12/24/2001','MM/DD/YYYY'), 0);
INSERT INTO bookstore VALUES
('0006','Temuka', '69 Kina Ave',  '0534-9143-6453', TO_DATE('10/31/2009','MM/DD/YYYY'), 0);



CREATE TABLE book
(title    VARCHAR2(30) NOT NULL,
isbn   CHAR(17)                         PRIMARY KEY,
fname    VARCHAR2(15) NOT NULL,
middle_init    CHAR,
lname    VARCHAR2(15) NOT NULL,
price    NUMBER(5), /*Currency*/
amount_in_stock   NUMBER(2));

INSERT INTO book VALUES
('Rusty Bed Springs', '326-1-234923-21-2', 'I','P','Knightley','2950', '2');
INSERT INTO book VALUES
('Snakes of the World', '321-1-234333-21-8', 'Anna','','Conda','2250', '5');
INSERT INTO book VALUES
('Tyrrants of the Potatoes', '336-1-285647-32-6', 'Dic','','Tater','1900', '12');
INSERT INTO book VALUES
('Trees', '284-1-573847-98-4', 'I','M','Board','2950', '5');
INSERT INTO book VALUES
('Robotics Handbook', '634-2-125445-65-2', 'Anne','D','Roid','7600', '3');
INSERT INTO book VALUES
('Windy Nights', '343-1-234352-21-2', 'Gale','','Force','4590', '5');
INSERT INTO book VALUES
('Lion Tamming', '323-3-323434-76-7', 'Claud','B','Ottem','2950', '20');



CREATE TABLE supplier
(bank_account_number    CHAR(18)    PRIMARY KEY,
company_name VARCHAR2(30) NOT NULL,
contact_number CHAR(10));

INSERT INTO supplier VALUES
('39-6443-9454523-48','National Scholastic','034191123');
INSERT INTO supplier VALUES
('33-3456-9482743-32','Mills and Boon','035763832');
INSERT INTO supplier VALUES
('26-6843-4856284-68','Paperback Writers','04457484');



CREATE TABLE supplies
(sbank_account_number CHAR(18) REFERENCES supplier (bank_account_number),
bisbn CHAR(17) REFERENCES book(isbn),
CONSTRAINT supplies_pk PRIMARY KEY(sbank_account_number, bisbn));

INSERT INTO supplies VALUES
('39-6443-9454523-48','326-1-234923-21-2');
INSERT INTO supplies VALUES
('39-6443-9454523-48','321-1-234333-21-8');



CREATE TABLE employee_wage
(weekly_hours   NUMBER(2),
hourly_rate    NUMBER(5),
wage NUMBER (8) default 1000,
CONSTRAINT employee_wage_pk PRIMARY KEY(weekly_hours, hourly_rate));

@trigger_employee_wage.sql

INSERT INTO employee_wage VALUES('38', '1525','57950');
INSERT INTO employee_wage VALUES('38', '1600','60800');
INSERT INTO employee_wage VALUES('38', '1700','64600');
INSERT INTO employee_wage VALUES('32', '1800','57600');
INSERT INTO employee_wage VALUES('32', '1900','60800');
INSERT INTO employee_wage VALUES(40, 1500, 60000);
INSERT INTO employee_wage VALUES(40, 1700, 68000);
INSERT INTO EMPLOYEE_WAGE VALUES(35, 1750, 61250);
INSERT INTO EMPLOYEE_WAGE VALUES(35, 1850, 64750);



CREATE TABLE employee
(fname    VARCHAR2(15) NOT NULL,
middle_init    CHAR,
lname    VARCHAR2(15) NOT NULL,
ird_number      CHAR(11)      PRIMARY KEY,
contact_number  CHAR(10),
weekly_hours   NUMBER(2),
hourly_rate    NUMBER(5) NOT NULL, /*Currency*/
bookstoreID VARCHAR2(7) CONSTRAINT bookstore_ID_constraint REFERENCES bookstore(storeID),
CONSTRAINT wage_constraint FOREIGN KEY(weekly_hours, hourly_rate) REFERENCES employee_wage(weekly_hours, hourly_rate));

@trigger_total_salary.sql

INSERT INTO employee VALUES
('John','B','Good', '024-613-323',       '0212344505', 38, 1525, (select storeID from (select * from bookstore order by DBMS_RANDOM.RANDOM) WHERE rownum < 2));
INSERT INTO employee VALUES
('Debbie','D','Dallas', '023-543-765',   '0215739542', 32, 1800, (select storeID from (select * from bookstore order by DBMS_RANDOM.RANDOM) WHERE rownum < 2));
INSERT INTO employee VALUES
('Tom','N','Mates', '013-643-923',       '0273938492', '38', 1600, (select storeID from (select * from bookstore order by DBMS_RANDOM.RANDOM) WHERE rownum < 2));
INSERT INTO employee VALUES
('Rebbecca','B','Smith', '075-142-345',  '0214847395', '40', '1700', (select storeID from (select * from bookstore order by DBMS_RANDOM.RANDOM) WHERE rownum < 2));
INSERT INTO employee VALUES
('Greg','T','Somerville', '087-681-765', '0270394722', '40', '1500', (select storeID from (select * from bookstore order by DBMS_RANDOM.RANDOM) WHERE rownum < 2));
INSERT INTO employee VALUES
('Todd','A','BlackAdder', '091-813-913', '0215738375', '35', '1750', (select storeID from (select * from bookstore order by DBMS_RANDOM.RANDOM) WHERE rownum < 2));
INSERT INTO employee VALUES
('Wayne','','Kerr', '023-842-366',       '0273231043', '35', '1850', (select storeID from (select * from bookstore order by DBMS_RANDOM.RANDOM) WHERE rownum < 2));
INSERT INTO employee VALUES
('Leroy','J','Brown', '073-834-552',     '0215551234', '32', '1900', (select storeID from (select * from bookstore order by DBMS_RANDOM.RANDOM) WHERE rownum < 2));
INSERT INTO employee VALUES
('Ying','G','Brown', '055-923-819',      '0214984833', '38', '1600', (select storeID from (select * from bookstore order by DBMS_RANDOM.RANDOM) WHERE rownum < 2));




/**
Randomly select 1 addresses from bookstore
select address from (select * from bookstore order by DBMS_RANDOM.RANDOM) WHERE rownum < 2;
*/

/**
select weekly_hours, hourly_rate from (select * from employee_wage order by DBMS_RANDOM.RANDOM) WHERE rownum < 2;
*/

CREATE TABLE postcode
(postcode NUMBER (4)            PRIMARY KEY,
suburb VARCHAR (15),
city VARCHAR (15));

INSERT INTO postcode VALUES
(9016, 'Dunedin City', 'Dunedin');
INSERT INTO postcode VALUES
(9012, 'South Dunedin', 'Dunedin');



CREATE TABLE customer
(street_number NUMBER(5),
Street_name VARCHAR2(30),
postcode NUMBER(4) NOT NULL REFERENCES postcode(postcode),
customer_id CHAR (7)            PRIMARY KEY,
fname VARCHAR(15) NOT NULL,
lname VARCHAR(15) NOT NULL,
phone CHAR (10)
);

INSERT INTO customer VALUES
(22, 'Strawberry Lane', 9016, '0007365','Chubby','Checker', '0212546798');
INSERT INTO customer VALUES
(16, 'Princes Street', 9012, '0046290','Slim','Dusty', '0279843873');
INSERT INTO customer VALUES
(11, 'Boiling Down Road',9012,'0002233','Jimmy','Johns','');
INSERT INTO customer VALUES
(17,'Duchess Ave',9016,'0000010','Callum','Grimmer','0223280679');
INSERT INTO customer VALUES
(14,'Findlayson Road',9012,'0022056','Tim','Shadbolt','0272524455');
INSERT INTO customer VALUES
(25,'River Street',9016,'0024789','Joseph','Parker','');
INSERT INTO customer VALUES
(560,'George Street',9016,'0001010','David','Clark','');
INSERT INTO customer VALUES
(34, 'Midland Street',9012,'0033210','Dave','Brubeck','');
INSERT INTO customer VALUES
(131,'Queen Street',9016,'0035670','Trent','Brown','0223220987');
INSERT INTO customer VALUES
(11,'Pitt Street',9016,'0668220','Sammy','Dee','0274429824');
INSERT INTO customer VALUES
(2,'Wigan Street',9012,'0096210','Michael','Peterson','0211197862');
INSERT INTO customer VALUES
(62,'Robertson Street',9016,'0000223','Foxy','Brown','0274542211');



CREATE TABLE transactions
(TDATE DATE NOT NULL,
 TTIME DATE NOT NULL,
transaction_number CHAR (18)    PRIMARY KEY,
eird_number CHAR(11)  REFERENCES employee (ird_number),
ccustomer_id CHAR (7) REFERENCES customer (customer_id)
);


/**
INSERT INTO transactions VALUES
(TO_DATE('22-05-2013','DD-MM-YYYY'), TO_DATE('13:34:23','hh24:mi:ss'),'000-0000-1234-124',
	(select IRD_NUMBER from (select * from employee order by DBMS_RANDOM.RANDOM) WHERE ROWNUM < 2),
	(select customer_id from (select * from customer order by DBMS_RANDOM.RANDOM) WHERE ROWNUM < 2));

INSERT INTO transactions VALUES
(TO_DATE('24-06-2013','DD-MM-YYYY'), TO_DATE('09:49:11','hh24:mi:ss'), '000-0000-1234-125',
	(select IRD_NUMBER from (select * from employee order by DBMS_RANDOM.RANDOM) WHERE ROWNUM < 2),
        (select customer_id from (select * from customer order by DBMS_RANDOM.RANDOM) WHERE ROWNUM < 2));
INSERT INTO transactions VALUES
(TO_DATE('02-08-2013','DD-MM-YYYY'), TO_DATE('11:40:57','hh24:mi:ss'), '000-0000-1234-126',
      	(select IRD_NUMBER from (select * from employee order by DBMS_RANDOM.RANDOM) WHERE ROWNUM < 2),
        (select customer_id from (select * from customer order by DBMS_RANDOM.RANDOM) WHERE ROWNUM < 2));
INSERT INTO transactions VALUES
(TO_DATE('13-09-2013','DD-MM-YYYY'), TO_DATE('15:23:31','hh24:mi:ss'), '000-0000-1234-127',
	(select IRD_NUMBER from (select * from employee order by DBMS_RANDOM.RANDOM) WHERE ROWNUM < 2),
        (select customer_id from (select * from customer order by DBMS_RANDOM.RANDOM) WHERE ROWNUM < 2));
INSERT INTO transactions VALUES
(TO_DATE('17-11-2013','DD-MM-YYYY'), TO_DATE('12:43:04','hh24:mi:ss'), '000-0000-1234-128',
	(select IRD_NUMBER from (select * from employee order by DBMS_RANDOM.RANDOM) WHERE ROWNUM < 2),
        (select customer_id from (select * from customer order by DBMS_RANDOM.RANDOM) WHERE ROWNUM < 2));
INSERT INTO transactions VALUES
(TO_DATE('30-11-2013','DD-MM-YYYY'), TO_DATE('16:31:23','hh24:mi:ss'), '000-0000-1234-200',
       (select IRD_NUMBER from (select * from employee order by DBMS_RANDOM.RANDOM) WHERE ROWNUM < 2),
       (select customer_id from (select * from customer order by DBMS_RANDOM.RANDOM) WHERE ROWNUM < 2));
INSERT INTO transactions VALUES
(TO_DATE('22-01-2014','DD-MM-YYYY'), TO_DATE('12:59:29','hh24:mi:ss'), '000-0000-1234-203',
       (select IRD_NUMBER from (select * from employee order by DBMS_RANDOM.RANDOM) WHERE ROWNUM < 2),
       (select customer_id from (select * from customer order by DBMS_RANDOM.RANDOM) WHERE ROWNUM < 2));
INSERT INTO transactions VALUES
(TO_DATE('22-03-2014','DD-MM-YYYY'), TO_DATE('14:03:40','hh24:mi:ss'), '000-0000-1234-204',
       (select IRD_NUMBER from (select * from employee order by DBMS_RANDOM.RANDOM) WHERE ROWNUM < 2),
       (select customer_id from (select * from customer order by DBMS_RANDOM.RANDOM) WHERE ROWNUM < 2));
*/


CREATE TABLE book_tran
(bisbn CHAR (17)   REFERENCES book(isbn),
ttransaction_number CHAR (18)  REFERENCES transactions(transaction_number),
CONSTRAINT book_tran_pk PRIMARY KEY(bisbn, ttransaction_number));

/**
INSERT INTO book_tran VALUES(
	(select isbn from (select * from book order by dbms_random.random) where rownum < 2),
	(select TRANSACTION_NUMBER from (select TRANSACTION_NUMBER, rownum as rn from transactions order by dbms_random.random) where rn=1)
);
INSERT INTO book_tran VALUES(
	(select isbn from (select * from book order by dbms_random.random) where rownum < 2),
	(select TRANSACTION_NUMBER from (select TRANSACTION_NUMBER, rownum as rn from transactions order by dbms_random.random) where rn=2)
);
INSERT INTO book_tran VALUES(
	(select isbn from (select * from book order by dbms_random.random) where rownum < 2),
	(select TRANSACTION_NUMBER from (select TRANSACTION_NUMBER, rownum as rn from transactions order by dbms_random.random) where rn=3)
);
INSERT INTO book_tran VALUES(
	(select isbn from (select * from book order by dbms_random.random) where rownum < 2),
	(select TRANSACTION_NUMBER from (select TRANSACTION_NUMBER, rownum as rn from transactions order by dbms_random.random) where rn=4)
);
INSERT INTO book_tran VALUES(
	(select isbn from (select * from book order by dbms_random.random) where rownum < 2),
	(select TRANSACTION_NUMBER from (select TRANSACTION_NUMBER, rownum as rn from transactions order by dbms_random.random) where rn=5)
);
INSERT INTO book_tran VALUES(
	(select isbn from (select * from book order by dbms_random.random) where rownum < 2),
	(select TRANSACTION_NUMBER from (select TRANSACTION_NUMBER, rownum as rn from transactions order by dbms_random.random) where rn=6)
);
INSERT INTO book_tran VALUES(
	(select isbn from (select * from book order by dbms_random.random) where rownum < 2),
	(select TRANSACTION_NUMBER from (select TRANSACTION_NUMBER, rownum as rn from transactions order by dbms_random.random) where rn=7)
);
INSERT INTO book_tran VALUES(
	(select isbn from (select * from book order by dbms_random.random) where rownum < 2),
	(select TRANSACTION_NUMBER from (select TRANSACTION_NUMBER, rownum as rn from transactions order by dbms_random.random) where rn=8)
);
*/



CREATE TABLE qualifications (
eird_number CHAR (11) REFERENCES EMPLOYEE(ird_number),
qname VARCHAR(30),
date_received DATE,
expiry_date DATE,
CONSTRAINT qualifications_pk PRIMARY KEY(eird_number, qname));


INSERT INTO qualifications VALUES
((select IRD_NUMBER from (select * from employee order by DBMS_RANDOM.RANDOM) WHERE ROWNUM < 2),
	'First Aid', TO_DATE('22-05-2013','DD-MM-YYYY'), TO_DATE('22-05-2015','DD-MM-YYYY'));
INSERT INTO qualifications VALUES
((select IRD_NUMBER from (select * from employee order by DBMS_RANDOM.RANDOM) WHERE ROWNUM < 2),
	'BSci', TO_DATE('25-10-1999','DD-MM-YYYY'), TO_DATE(''));

CREATE TABLE qualifications_type
(eird_number CHAR(11),
qname VARCHAR(30),
qtype VARCHAR(20),
CONSTRAINT qualifications_type_pk PRIMARY KEY (eird_number, qname, qtype),
CONSTRAINT qualifications_foreign_key FOREIGN KEY (eird_number, qname) REFERENCES QUALIFICATIONS(eird_number, qname));

INSERT INTO qualifications_type VALUES
(	(select eird_number from QUALIFICATIONS where rownum = 1),
	(select qname from QUALIFICATIONS where rownum = 1),
	'Health and Safety');
INSERT INTO qualifications_type VALUES
(	(select eird_number from QUALIFICATIONS where rownum = 1),
        (select qname from QUALIFICATIONS where rownum = 1),
	'bachelors degree');
/**
ask teach why the rownum = 2 return null?
*/


/**
INSERT INTO qualifications_type VALUES
('024-613-323','First Aid', 'Health and Safety');
INSERT INTO qualifications_type VALUES
('023-842-366', 'BSci', 'bachelors degree');
*/

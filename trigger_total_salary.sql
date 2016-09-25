create or replace trigger r1
after insert on employee
for each row
begin
        update bookstore
        set TOTAL_SALARY = TOTAL_SALARY + :NEW.WEEKLY_HOURS * :NEW.HOURLY_RATE
        where storeID = :NEW.bookstoreID;
end;
/

create or replace trigger r2
after update of weekly_hours, hourly_rate on employee
for each row
begin
        update bookstore
        set total_salary = total_salary + :NEW.WEEKLY_HOURS * :NEW.HOURLY_RATE - :old.weekly_hours * :old.hourly_rate
        where storeID = :new.bookstoreID;
end;
/

create or replace trigger r3
after update of bookstoreID on employee
for each row
begin
        update bookstore
        set total_salary = total_salary + :NEW.WEEKLY_HOURS * :NEW.HOURLY_RATE
        where storeID = :new.bookstoreID;
        update bookstore
        set total_salary = total_salary - :old.weekly_hours * :old.hourly_rate
        where storeID = :old.bookstoreID;
end;
/

create or replace trigger r4
after delete on employee
for each row
begin
        update bookstore
        set total_salary = total_salary - :old.weekly_hours * :old.hourly_rate
        where storeID = :old.bookstoreID;
end;
/

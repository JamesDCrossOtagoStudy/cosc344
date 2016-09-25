CREATE OR REPLACE TRIGGER check_wage_1
        BEFORE INSERT OR UPDATE ON employee_wage
        FOR EACH ROW
BEGIN
        :NEW.wage := :NEW.weekly_hours * :NEW.hourly_rate;
END;
/

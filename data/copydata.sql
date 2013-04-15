DELETE FROM lechall;
DELETE FROM users;
DELETE FROM student;
DELETE FROM coordinator;
DELETE FROM executive;
DELETE FROM faculty;
DELETE FROM auth;
DELETE from timetable;
DELETE from calendar;

COPY lechall FROM '/home/ankeshs/Programming/cs315/project/data/lechall.csv' DELIMITERS ';' CSV;
COPY users FROM '/home/ankeshs/Programming/cs315/project/data/user.csv' DELIMITERS ';' CSV;
COPY student FROM '/home/ankeshs/Programming/cs315/project/data/student.csv' DELIMITERS ';' CSV;
COPY coordinator FROM '/home/ankeshs/Programming/cs315/project/data/coordinator.csv' DELIMITERS ';' CSV;
COPY executive FROM '/home/ankeshs/Programming/cs315/project/data/executive.csv' DELIMITERS ';' CSV;
COPY faculty FROM '/home/ankeshs/Programming/cs315/project/data/faculty.csv' DELIMITERS ';' CSV;
COPY auth FROM '/home/ankeshs/Programming/cs315/project/data/auth.csv' DELIMITERS ';' CSV;
COPY calendar FROM '/home/ankeshs/Programming/cs315/project/data/calendar.csv' DELIMITERS ';' CSV;
COPY timetable FROM '/home/ankeshs/Programming/cs315/project/data/timetable.csv' DELIMITERS ';' CSV;
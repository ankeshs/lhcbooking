--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: alerts; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE alerts (
    alertno integer NOT NULL,
    userid character varying(10) NOT NULL,
    alerttype character varying(5),
    alertto character varying(20),
    msg text NOT NULL,
    alertat timestamp without time zone DEFAULT '2013-04-04 10:24:14.487026'::timestamp without time zone,
    delivered boolean DEFAULT false
);


ALTER TABLE public.alerts OWNER TO postgres;

--
-- Name: alerts_alertno_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE alerts_alertno_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.alerts_alertno_seq OWNER TO postgres;

--
-- Name: alerts_alertno_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE alerts_alertno_seq OWNED BY alerts.alertno;


--
-- Name: alerts_alertno_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('alerts_alertno_seq', 20, true);


--
-- Name: approval; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE approval (
    userid character varying(10) NOT NULL,
    bookid integer NOT NULL,
    state character(1) DEFAULT 'P'::bpchar,
    updated timestamp without time zone DEFAULT '2013-03-30 16:08:50.276722'::timestamp without time zone
);


ALTER TABLE public.approval OWNER TO postgres;

--
-- Name: auth; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE auth (
    userid character varying(10) NOT NULL,
    authtype character varying(10) NOT NULL
);


ALTER TABLE public.auth OWNER TO postgres;

--
-- Name: booking; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE booking (
    bookid integer NOT NULL,
    bookdate date NOT NULL,
    starttime time without time zone NOT NULL,
    endtime time without time zone,
    aircon boolean DEFAULT false
);


ALTER TABLE public.booking OWNER TO postgres;

--
-- Name: booking_bookid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE booking_bookid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_bookid_seq OWNER TO postgres;

--
-- Name: booking_bookid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE booking_bookid_seq OWNED BY booking.bookid;


--
-- Name: booking_bookid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('booking_bookid_seq', 12, true);


--
-- Name: calendar; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE calendar (
    dateof date NOT NULL,
    dayof character varying(2)
);


ALTER TABLE public.calendar OWNER TO postgres;

--
-- Name: coordinator; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE coordinator (
    rollno character varying(10) NOT NULL,
    club character varying(20) NOT NULL
);


ALTER TABLE public.coordinator OWNER TO postgres;

--
-- Name: executive; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE executive (
    rollno character varying(10) NOT NULL,
    post character varying(10) NOT NULL
);


ALTER TABLE public.executive OWNER TO postgres;

--
-- Name: faculty; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE faculty (
    userid character varying(10) NOT NULL,
    facid character varying(10) NOT NULL
);


ALTER TABLE public.faculty OWNER TO postgres;

--
-- Name: instructor; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE instructor (
    facid character varying(10) NOT NULL,
    userid character varying(10) NOT NULL,
    course character varying(10)
);


ALTER TABLE public.instructor OWNER TO postgres;

--
-- Name: lechall; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE lechall (
    hallno character varying(8) NOT NULL,
    capacity integer
);


ALTER TABLE public.lechall OWNER TO postgres;

--
-- Name: location; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE location (
    bookid integer NOT NULL,
    hallno character varying(8) NOT NULL
);


ALTER TABLE public.location OWNER TO postgres;

--
-- Name: office; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE office (
    userid character varying(10) NOT NULL,
    offtype character varying(10) NOT NULL
);


ALTER TABLE public.office OWNER TO postgres;

--
-- Name: precedence; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE precedence (
    approver character varying(10) NOT NULL,
    weight integer
);


ALTER TABLE public.precedence OWNER TO postgres;

--
-- Name: requirement; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE requirement (
    bookid integer NOT NULL,
    equip character varying(30)
);


ALTER TABLE public.requirement OWNER TO postgres;

--
-- Name: student; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE student (
    userid character varying(10) NOT NULL,
    rollno character varying(10) NOT NULL
);


ALTER TABLE public.student OWNER TO postgres;

--
-- Name: timetable; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE timetable (
    dayof character varying(2) NOT NULL,
    course character varying(10),
    meettype character(1),
    hallno character varying(8) NOT NULL,
    starttime time without time zone NOT NULL,
    endtime time without time zone
);


ALTER TABLE public.timetable OWNER TO postgres;

--
-- Name: transaction; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE transaction (
    transno integer NOT NULL,
    userid character varying(10) NOT NULL,
    bookid integer NOT NULL,
    transtype character(1) NOT NULL,
    attime timestamp without time zone DEFAULT '2013-03-30 16:08:50.166351'::timestamp without time zone,
    details text
);


ALTER TABLE public.transaction OWNER TO postgres;

--
-- Name: transaction_transno_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE transaction_transno_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.transaction_transno_seq OWNER TO postgres;

--
-- Name: transaction_transno_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE transaction_transno_seq OWNED BY transaction.transno;


--
-- Name: transaction_transno_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('transaction_transno_seq', 14, true);


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE users (
    userid character varying(10) NOT NULL,
    password character varying(50) NOT NULL,
    name character varying(30) NOT NULL,
    email character varying(50) NOT NULL,
    contactno character varying(15) NOT NULL,
    address text
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: alertno; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY alerts ALTER COLUMN alertno SET DEFAULT nextval('alerts_alertno_seq'::regclass);


--
-- Name: bookid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY booking ALTER COLUMN bookid SET DEFAULT nextval('booking_bookid_seq'::regclass);


--
-- Name: transno; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY transaction ALTER COLUMN transno SET DEFAULT nextval('transaction_transno_seq'::regclass);


--
-- Data for Name: alerts; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO alerts VALUES (1, 'user1', 'email', 'ankeshs@iitk.ac.in', 'Your booking (ID = 6) has been requested and is now pending with LHC Office', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (2, 'user1', 'sms', '9838690113', 'Your booking (ID = 6) has been requested and is now pending with LHC Office', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (3, 'user18', 'email', 'user18', 'Booking (ID = 6) is pending your approval', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (4, 'user18', 'sms', '9838690130', 'Booking (ID = 6) is pending your approval', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (5, 'user1', 'email', 'ankeshs@iitk.ac.in', 'Your booking (ID = 6) has been requested and is now pending with LHC Office', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (6, 'user1', 'sms', '9838690113', 'Your booking (ID = 6) has been requested and is now pending with LHC Office', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (7, 'user18', 'email', 'user18', 'Booking (ID = 6) is pending your approval', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (8, 'user18', 'sms', '9838690130', 'Booking (ID = 6) is pending your approval', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (9, 'user2', 'email', 'user2', 'Your booking (ID = 11) has been requested and is now pending with president', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (10, 'user2', 'sms', '9838690114', 'Your booking (ID = 11) has been requested and is now pending with president', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (11, 'user10', 'email', 'user10', 'Booking (ID = 11) is pending your approval', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (12, 'user10', 'sms', '9838690122', 'Booking (ID = 11) is pending your approval', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (13, 'user2', 'email', 'user2', 'Your booking (ID = 11) has been approved by DOSA and is now pending with president', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (14, 'user2', 'sms', '9838690114', 'Your booking (ID = 11) has been approved by DOSA and is now pending with president', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (15, 'user10', 'email', 'user10', 'Booking (ID = 11) is pending your approval', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (16, 'user10', 'sms', '9838690122', 'Booking (ID = 11) is pending your approval', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (17, 'user1', 'email', 'ankeshs@iitk.ac.in', 'Your booking (ID = 12) has been requested and is now pending with sntsecy', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (18, 'user1', 'sms', '9838690113', 'Your booking (ID = 12) has been requested and is now pending with sntsecy', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (19, 'user7', 'email', 'user7', 'Booking (ID = 12) is pending your approval', '2013-04-04 10:24:14.487026', false);
INSERT INTO alerts VALUES (20, 'user7', 'sms', '9838690119', 'Booking (ID = 12) is pending your approval', '2013-04-04 10:24:14.487026', false);


--
-- Data for Name: approval; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO approval VALUES ('user18', 6, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user12', 7, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user15', 7, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user18', 7, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user11', 6, 'A', '2013-04-02 09:04:44');
INSERT INTO approval VALUES ('user15', 6, 'R', '2013-04-02 09:04:01');
INSERT INTO approval VALUES ('user10', 8, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user15', 8, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user18', 8, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user14', 8, 'A', '2013-04-02 12:04:46');
INSERT INTO approval VALUES ('user10', 1, 'A', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user11', 1, 'A', '2013-03-30 12:03:26');
INSERT INTO approval VALUES ('user12', 10, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user15', 10, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user16', 10, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user18', 10, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user10', 11, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user15', 11, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user16', 11, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user18', 11, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user14', 11, 'A', '2013-04-04 05:04:34');
INSERT INTO approval VALUES ('user14', 12, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user7', 12, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user15', 12, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user16', 12, 'P', '2013-03-30 16:08:50.276722');
INSERT INTO approval VALUES ('user18', 12, 'P', '2013-03-30 16:08:50.276722');


--
-- Data for Name: auth; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO auth VALUES ('user14', 'DOSA');
INSERT INTO auth VALUES ('user15', 'DOAA');
INSERT INTO auth VALUES ('user16', 'DD');


--
-- Data for Name: booking; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO booking VALUES (1, '2013-04-18', '09:00:00', '14:00:00', false);
INSERT INTO booking VALUES (6, '2013-04-10', '13:00:00', '14:00:00', false);
INSERT INTO booking VALUES (7, '2013-04-11', '19:00:00', '21:00:00', false);
INSERT INTO booking VALUES (10, '2013-04-08', '17:00:00', '21:00:00', true);
INSERT INTO booking VALUES (8, '2013-04-01', '18:00:00', '22:00:00', false);
INSERT INTO booking VALUES (11, '2013-04-09', '20:30:00', '22:00:00', true);
INSERT INTO booking VALUES (12, '2013-04-09', '18:00:00', '21:00:00', true);


--
-- Data for Name: calendar; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO calendar VALUES ('2013-04-01', 'M');
INSERT INTO calendar VALUES ('2013-04-02', 'T');
INSERT INTO calendar VALUES ('2013-04-03', 'W');
INSERT INTO calendar VALUES ('2013-04-04', 'Th');
INSERT INTO calendar VALUES ('2013-04-05', 'F');


--
-- Data for Name: coordinator; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO coordinator VALUES ('Y9090', 'Programming Club');
INSERT INTO coordinator VALUES ('Y9227', 'Dance Club');
INSERT INTO coordinator VALUES ('Y9001', 'Robotics Club');
INSERT INTO coordinator VALUES ('10100', 'Prayas');
INSERT INTO coordinator VALUES ('11011', 'Dramatics Club');


--
-- Data for Name: executive; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO executive VALUES ('Y8543', 'cultsecy');
INSERT INTO executive VALUES ('Y8322', 'president');
INSERT INTO executive VALUES ('Y9372', 'sntsecy');


--
-- Data for Name: faculty; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO faculty VALUES ('user11', 'smt');
INSERT INTO faculty VALUES ('user12', 'pkb');
INSERT INTO faculty VALUES ('user13', 'jks');


--
-- Data for Name: instructor; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO instructor VALUES ('pkb', 'user12', 'CHE251');


--
-- Data for Name: lechall; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO lechall VALUES ('L1', 200);
INSERT INTO lechall VALUES ('L2', 200);
INSERT INTO lechall VALUES ('L3', 50);
INSERT INTO lechall VALUES ('L4', 50);
INSERT INTO lechall VALUES ('L5', 60);
INSERT INTO lechall VALUES ('L6', 60);
INSERT INTO lechall VALUES ('L7', 500);
INSERT INTO lechall VALUES ('L8', 60);
INSERT INTO lechall VALUES ('L9', 60);
INSERT INTO lechall VALUES ('L10', 45);
INSERT INTO lechall VALUES ('L11', 45);
INSERT INTO lechall VALUES ('L12', 60);
INSERT INTO lechall VALUES ('L13', 60);
INSERT INTO lechall VALUES ('L14', 60);
INSERT INTO lechall VALUES ('L15', 60);
INSERT INTO lechall VALUES ('L16', 350);
INSERT INTO lechall VALUES ('L17', 350);


--
-- Data for Name: location; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO location VALUES (1, 'L15');
INSERT INTO location VALUES (6, 'L1');
INSERT INTO location VALUES (7, 'L10');
INSERT INTO location VALUES (8, 'L7');
INSERT INTO location VALUES (10, 'L11');
INSERT INTO location VALUES (11, 'L16');
INSERT INTO location VALUES (12, 'L17');


--
-- Data for Name: office; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO office VALUES ('user18', 'LHC Office');


--
-- Data for Name: precedence; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO precedence VALUES ('executive', 100);
INSERT INTO precedence VALUES ('faculty', 200);
INSERT INTO precedence VALUES ('DOSA', 300);
INSERT INTO precedence VALUES ('DOAA', 500);
INSERT INTO precedence VALUES ('DD', 600);
INSERT INTO precedence VALUES ('LHC Office', 1000);


--
-- Data for Name: requirement; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO requirement VALUES (6, 'Microphone');
INSERT INTO requirement VALUES (7, 'Microphone');
INSERT INTO requirement VALUES (7, 'Multimedia Projector');
INSERT INTO requirement VALUES (8, 'Multimedia Projector');
INSERT INTO requirement VALUES (10, 'Collar Microphone');
INSERT INTO requirement VALUES (10, 'Microphone');
INSERT INTO requirement VALUES (10, 'Multimedia Projector');
INSERT INTO requirement VALUES (11, 'Collar Microphone');
INSERT INTO requirement VALUES (11, 'Microphone');
INSERT INTO requirement VALUES (11, 'Multimedia Projector');
INSERT INTO requirement VALUES (12, 'Collar Microphone');
INSERT INTO requirement VALUES (12, 'Multimedia Projector');


--
-- Data for Name: student; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO student VALUES ('user1', 'Y9090');
INSERT INTO student VALUES ('user2', '10100');
INSERT INTO student VALUES ('user3', '11011');
INSERT INTO student VALUES ('user4', '10801');
INSERT INTO student VALUES ('user5', 'Y8543');
INSERT INTO student VALUES ('user6', 'Y9227');
INSERT INTO student VALUES ('user7', 'Y9372');
INSERT INTO student VALUES ('user8', '10444');
INSERT INTO student VALUES ('user9', 'Y9001');
INSERT INTO student VALUES ('user10', 'Y8322');


--
-- Data for Name: timetable; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO timetable VALUES ('M', 'MTH101', 'L', 'L17', '10:00:00', '11:00:00');
INSERT INTO timetable VALUES ('T', 'MTH101', 'L', 'L17', '10:00:00', '11:00:00');
INSERT INTO timetable VALUES ('Th', 'MTH101', 'L', 'L17', '10:00:00', '11:00:00');
INSERT INTO timetable VALUES ('W', 'MTH101', 'T', 'L5', '10:00:00', '11:00:00');
INSERT INTO timetable VALUES ('W', 'MTH101', 'T', 'L6', '10:00:00', '11:00:00');
INSERT INTO timetable VALUES ('W', 'MTH101', 'T', 'L3', '10:00:00', '11:00:00');
INSERT INTO timetable VALUES ('W', 'MTH101', 'T', 'L4', '10:00:00', '11:00:00');
INSERT INTO timetable VALUES ('W', 'MTH101', 'T', 'L9', '10:00:00', '11:00:00');
INSERT INTO timetable VALUES ('F', 'MTH101', 'D', 'L5', '10:00:00', '11:00:00');
INSERT INTO timetable VALUES ('F', 'MTH101', 'D', 'L6', '10:00:00', '11:00:00');
INSERT INTO timetable VALUES ('F', 'MTH101', 'D', 'L3', '10:00:00', '11:00:00');
INSERT INTO timetable VALUES ('F', 'MTH101', 'D', 'L4', '10:00:00', '11:00:00');
INSERT INTO timetable VALUES ('F', 'MTH101', 'D', 'L9', '10:00:00', '11:00:00');
INSERT INTO timetable VALUES ('M', 'PHY103', 'L', 'L7', '12:00:00', '13:00:00');
INSERT INTO timetable VALUES ('W', 'PHY103', 'L', 'L7', '12:00:00', '13:00:00');
INSERT INTO timetable VALUES ('F', 'PHY103', 'L', 'L7', '12:00:00', '13:00:00');
INSERT INTO timetable VALUES ('T', 'PHY103', 'T', 'L5', '12:00:00', '13:00:00');
INSERT INTO timetable VALUES ('T', 'PHY103', 'T', 'L6', '12:00:00', '13:00:00');
INSERT INTO timetable VALUES ('T', 'PHY103', 'T', 'L3', '12:00:00', '13:00:00');
INSERT INTO timetable VALUES ('T', 'PHY103', 'T', 'L4', '12:00:00', '13:00:00');
INSERT INTO timetable VALUES ('Th', 'PHY103', 'D', 'L1', '12:00:00', '13:00:00');
INSERT INTO timetable VALUES ('Th', 'PHY103', 'D', 'L2', '12:00:00', '13:00:00');
INSERT INTO timetable VALUES ('M', 'PHY102', 'L', 'L16', '12:00:00', '13:00:00');
INSERT INTO timetable VALUES ('W', 'PHY102', 'L', 'L16', '12:00:00', '13:00:00');
INSERT INTO timetable VALUES ('F', 'PHY102', 'L', 'L16', '12:00:00', '13:00:00');
INSERT INTO timetable VALUES ('T', 'PHY102', 'T', 'L11', '12:00:00', '13:00:00');
INSERT INTO timetable VALUES ('T', 'PHY102', 'T', 'L12', '12:00:00', '13:00:00');
INSERT INTO timetable VALUES ('T', 'PHY102', 'T', 'L13', '12:00:00', '13:00:00');
INSERT INTO timetable VALUES ('T', 'PHY102', 'T', 'L14', '12:00:00', '13:00:00');
INSERT INTO timetable VALUES ('Th', 'PHY102', 'D', 'L16', '12:00:00', '13:00:00');
INSERT INTO timetable VALUES ('Th', 'PHY102', 'D', 'L17', '12:00:00', '13:00:00');


--
-- Data for Name: transaction; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO transaction VALUES (1, 'user1', 1, 'B', '2013-03-30 16:08:50.166351', NULL);
INSERT INTO transaction VALUES (2, 'user1', 2, 'B', '2013-03-30 16:08:50.166351', NULL);
INSERT INTO transaction VALUES (3, 'user1', 3, 'B', '2013-03-30 16:08:50.166351', 'Pclub');
INSERT INTO transaction VALUES (4, 'user1', 5, 'B', '2013-03-30 16:08:50.166351', 'Pclub');
INSERT INTO transaction VALUES (5, 'user1', 6, 'B', '2013-03-30 16:08:50.166351', 'Web Lecture');
INSERT INTO transaction VALUES (6, 'user3', 7, 'B', '2013-03-30 16:08:50.166351', 'SPO PPT');
INSERT INTO transaction VALUES (8, 'user1', 5, 'C', '2013-03-30 16:08:50.166351', NULL);
INSERT INTO transaction VALUES (9, 'user2', 8, 'B', '2013-03-30 16:08:50.166351', '');
INSERT INTO transaction VALUES (10, 'user1', 9, 'B', '2013-03-30 16:08:50.166351', '');
INSERT INTO transaction VALUES (11, 'user4', 10, 'B', '2013-03-30 16:08:50.166351', 'Nerd talk.');
INSERT INTO transaction VALUES (12, 'user2', 11, 'B', '2013-03-30 16:08:50.166351', 'Openhouse on child labor');
INSERT INTO transaction VALUES (13, 'user1', 9, 'C', '2013-03-30 16:08:50.166351', NULL);
INSERT INTO transaction VALUES (14, 'user1', 12, 'B', '2013-03-30 16:08:50.166351', 'Pclub Lecture');


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO users VALUES ('user2', '1a1dc91c907325c69271ddf0c944bc72', 'user2', 'user2', '9838690114', 'G111/9');
INSERT INTO users VALUES ('user3', '1a1dc91c907325c69271ddf0c944bc72', 'user3', 'user3', '9838690115', 'G310/2');
INSERT INTO users VALUES ('user4', '1a1dc91c907325c69271ddf0c944bc72', 'user4', 'user4', '9838690116', '333/3');
INSERT INTO users VALUES ('user5', '1a1dc91c907325c69271ddf0c944bc72', 'user5', 'user5', '9838690117', 'B-105/GH1');
INSERT INTO users VALUES ('user6', '1a1dc91c907325c69271ddf0c944bc72', 'user6', 'user6', '9838690118', 'D111/2');
INSERT INTO users VALUES ('user7', '1a1dc91c907325c69271ddf0c944bc72', 'user7', 'user7', '9838690119', 'FB470');
INSERT INTO users VALUES ('user8', '1a1dc91c907325c69271ddf0c944bc72', 'user8', 'user8', '9838690120', 'DD office');
INSERT INTO users VALUES ('user9', '1a1dc91c907325c69271ddf0c944bc72', 'user9', 'user9', '9838690121', 'LHC Office');
INSERT INTO users VALUES ('user10', '1a1dc91c907325c69271ddf0c944bc72', 'user10', 'user10', '9838690122', 'FB210');
INSERT INTO users VALUES ('user12', '1a1dc91c907325c69271ddf0c944bc72', 'user12', 'user12', '9838690124', NULL);
INSERT INTO users VALUES ('user13', '1a1dc91c907325c69271ddf0c944bc72', 'user13', 'user13', '9838690125', NULL);
INSERT INTO users VALUES ('user14', '1a1dc91c907325c69271ddf0c944bc72', 'user14', 'user14', '9838690126', NULL);
INSERT INTO users VALUES ('user15', '1a1dc91c907325c69271ddf0c944bc72', 'user15', 'user15', '9838690127', NULL);
INSERT INTO users VALUES ('user16', '1a1dc91c907325c69271ddf0c944bc72', 'user16', 'user16', '9838690128', NULL);
INSERT INTO users VALUES ('user17', '1a1dc91c907325c69271ddf0c944bc72', 'user17', 'user17', '9838690129', NULL);
INSERT INTO users VALUES ('user18', '1a1dc91c907325c69271ddf0c944bc72', 'user18', 'user18', '9838690130', NULL);
INSERT INTO users VALUES ('user1', '1a1dc91c907325c69271ddf0c944bc72', 'Ankesh Kumar Singh', 'ankeshs@iitk.ac.in', '9838690113', 'D214/1, IIT Kanpur');
INSERT INTO users VALUES ('user11', '1a1dc91c907325c69271ddf0c944bc72', 'user11', 'user11', '9838690123', 'FB 570');


--
-- Name: alerts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY alerts
    ADD CONSTRAINT alerts_pkey PRIMARY KEY (alertno);


--
-- Name: approval_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY approval
    ADD CONSTRAINT approval_pkey PRIMARY KEY (userid, bookid);


--
-- Name: auth_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY auth
    ADD CONSTRAINT auth_pkey PRIMARY KEY (userid, authtype);


--
-- Name: booking_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY booking
    ADD CONSTRAINT booking_pkey PRIMARY KEY (bookid);


--
-- Name: calendar_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY calendar
    ADD CONSTRAINT calendar_pkey PRIMARY KEY (dateof);


--
-- Name: coordinator_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY coordinator
    ADD CONSTRAINT coordinator_pkey PRIMARY KEY (rollno, club);


--
-- Name: executive_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY executive
    ADD CONSTRAINT executive_pkey PRIMARY KEY (rollno, post);


--
-- Name: faculty_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY faculty
    ADD CONSTRAINT faculty_pkey PRIMARY KEY (userid, facid);


--
-- Name: lechall_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY lechall
    ADD CONSTRAINT lechall_pkey PRIMARY KEY (hallno);


--
-- Name: office_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY office
    ADD CONSTRAINT office_pkey PRIMARY KEY (userid, offtype);


--
-- Name: precedence_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY precedence
    ADD CONSTRAINT precedence_pkey PRIMARY KEY (approver);


--
-- Name: student_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY student
    ADD CONSTRAINT student_pkey PRIMARY KEY (rollno);


--
-- Name: transaction_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY transaction
    ADD CONSTRAINT transaction_pkey PRIMARY KEY (transno);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (userid);


--
-- Name: alerts_userid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY alerts
    ADD CONSTRAINT alerts_userid_fkey FOREIGN KEY (userid) REFERENCES users(userid);


--
-- Name: approval_bookid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY approval
    ADD CONSTRAINT approval_bookid_fkey FOREIGN KEY (bookid) REFERENCES booking(bookid) ON DELETE CASCADE;


--
-- Name: approval_userid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY approval
    ADD CONSTRAINT approval_userid_fkey FOREIGN KEY (userid) REFERENCES users(userid) ON DELETE CASCADE;


--
-- Name: auth_userid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY auth
    ADD CONSTRAINT auth_userid_fkey FOREIGN KEY (userid) REFERENCES users(userid) ON DELETE CASCADE;


--
-- Name: coordinator_rollno_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY coordinator
    ADD CONSTRAINT coordinator_rollno_fkey FOREIGN KEY (rollno) REFERENCES student(rollno) ON DELETE CASCADE;


--
-- Name: executive_rollno_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY executive
    ADD CONSTRAINT executive_rollno_fkey FOREIGN KEY (rollno) REFERENCES student(rollno) ON DELETE CASCADE;


--
-- Name: faculty_userid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY faculty
    ADD CONSTRAINT faculty_userid_fkey FOREIGN KEY (userid) REFERENCES users(userid) ON DELETE CASCADE;


--
-- Name: instructor_userid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY instructor
    ADD CONSTRAINT instructor_userid_fkey FOREIGN KEY (userid, facid) REFERENCES faculty(userid, facid) ON DELETE CASCADE;


--
-- Name: location_bookid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY location
    ADD CONSTRAINT location_bookid_fkey FOREIGN KEY (bookid) REFERENCES booking(bookid) ON DELETE CASCADE;


--
-- Name: location_hallno_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY location
    ADD CONSTRAINT location_hallno_fkey FOREIGN KEY (hallno) REFERENCES lechall(hallno) ON DELETE CASCADE;


--
-- Name: office_userid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY office
    ADD CONSTRAINT office_userid_fkey FOREIGN KEY (userid) REFERENCES users(userid) ON DELETE CASCADE;


--
-- Name: requirement_bookid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY requirement
    ADD CONSTRAINT requirement_bookid_fkey FOREIGN KEY (bookid) REFERENCES booking(bookid) ON DELETE CASCADE;


--
-- Name: student_userid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY student
    ADD CONSTRAINT student_userid_fkey FOREIGN KEY (userid) REFERENCES users(userid) ON DELETE CASCADE;


--
-- Name: timetable_hallno_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY timetable
    ADD CONSTRAINT timetable_hallno_fkey FOREIGN KEY (hallno) REFERENCES lechall(hallno) ON DELETE CASCADE;


--
-- Name: transaction_userid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY transaction
    ADD CONSTRAINT transaction_userid_fkey FOREIGN KEY (userid) REFERENCES users(userid) ON DELETE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--


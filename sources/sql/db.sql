--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: frame; Type: TABLE; Schema: public; Owner: maxime; Tablespace: 
--

CREATE TABLE frame (
    idframe character varying(100) NOT NULL,
    startframe timestamp without time zone,
    stopframe timestamp without time zone,
    uuidproject uuid
);


ALTER TABLE frame OWNER TO maxime;

--
-- Name: project; Type: TABLE; Schema: public; Owner: maxime; Tablespace: 
--

CREATE TABLE project (
    uuid uuid NOT NULL,
    name character varying(100),
    uuiduser uuid
);


ALTER TABLE project OWNER TO maxime;

--
-- Name: tag; Type: TABLE; Schema: public; Owner: maxime; Tablespace: 
--

CREATE TABLE tag (
    uuid uuid NOT NULL,
    idframe character varying(100) NOT NULL,
    tag character varying(100)
);


ALTER TABLE tag OWNER TO maxime;

--
-- Name: users; Type: TABLE; Schema: public; Owner: maxime; Tablespace: 
--

CREATE TABLE users (
    uuid uuid NOT NULL,
    email character varying(255),
    password character varying(100),
    role character varying(100),
    api character varying(255)
);


ALTER TABLE users OWNER TO maxime;

--
-- Data for Name: frame; Type: TABLE DATA; Schema: public; Owner: maxime
--

COPY frame (idframe, startframe, stopframe, uuidproject) FROM stdin;
\.


--
-- Data for Name: project; Type: TABLE DATA; Schema: public; Owner: maxime
--

COPY project (uuid, name, uuiduser) FROM stdin;
\.


--
-- Data for Name: tag; Type: TABLE DATA; Schema: public; Owner: maxime
--

COPY tag (uuid, idframe, tag) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: maxime
--

COPY users (uuid, email, password, role, api) FROM stdin;
\.


--
-- Name: frame_idframe_key; Type: CONSTRAINT; Schema: public; Owner: maxime; Tablespace: 
--

ALTER TABLE ONLY frame
    ADD CONSTRAINT frame_idframe_key UNIQUE (idframe);


--
-- Name: frame_pkey; Type: CONSTRAINT; Schema: public; Owner: maxime; Tablespace: 
--

ALTER TABLE ONLY frame
    ADD CONSTRAINT frame_pkey PRIMARY KEY (idframe);


--
-- Name: project_pkey; Type: CONSTRAINT; Schema: public; Owner: maxime; Tablespace: 
--

ALTER TABLE ONLY project
    ADD CONSTRAINT project_pkey PRIMARY KEY (uuid);


--
-- Name: tag_pkey; Type: CONSTRAINT; Schema: public; Owner: maxime; Tablespace: 
--

ALTER TABLE ONLY tag
    ADD CONSTRAINT tag_pkey PRIMARY KEY (uuid, idframe);


--
-- Name: users_emailuser_key; Type: CONSTRAINT; Schema: public; Owner: maxime; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_emailuser_key UNIQUE (email);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: maxime; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (uuid);


--
-- Name: frame_uuidproject_fkey; Type: FK CONSTRAINT; Schema: public; Owner: maxime
--

ALTER TABLE ONLY frame
    ADD CONSTRAINT frame_uuidproject_fkey FOREIGN KEY (uuidproject) REFERENCES project(uuid);


--
-- Name: project_uuiduser_fkey; Type: FK CONSTRAINT; Schema: public; Owner: maxime
--

ALTER TABLE ONLY project
    ADD CONSTRAINT project_uuiduser_fkey FOREIGN KEY (uuiduser) REFERENCES users(uuid);


--
-- Name: tag_idframe_fkey; Type: FK CONSTRAINT; Schema: public; Owner: maxime
--

ALTER TABLE ONLY tag
    ADD CONSTRAINT tag_idframe_fkey FOREIGN KEY (idframe) REFERENCES frame(idframe);


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


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
-- Name: users; Type: TABLE; Schema: public; Owner: maxime; Tablespace: 
--

CREATE TABLE users (
    uuid uuid NOT NULL,
    emailuser character varying(255),
    passworduser character varying(100),
    role character varying(100),
    apiuser character varying(255)
);


ALTER TABLE users OWNER TO maxime;

--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: maxime
--

COPY users (uuid, emailuser, passworduser, role, apiuser) FROM stdin;
\.


--
-- Name: users_emailuser_key; Type: CONSTRAINT; Schema: public; Owner: maxime; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_emailuser_key UNIQUE (emailuser);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: maxime; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (uuid);


--
-- PostgreSQL database dump complete
--


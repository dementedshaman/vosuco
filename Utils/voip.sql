--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.3
-- Dumped by pg_dump version 9.5.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: alunos; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE alunos (
    id integer NOT NULL,
    matricula character varying(20) NOT NULL,
    spass character varying(120) NOT NULL,
    CONSTRAINT alunos_matricula_check CHECK (((matricula)::text <> ''::text)),
    CONSTRAINT alunos_spass_check CHECK (((spass)::text <> ''::text))
);


--
-- Name: alunos_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE alunos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: alunos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE alunos_id_seq OWNED BY alunos.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY alunos ALTER COLUMN id SET DEFAULT nextval('alunos_id_seq'::regclass);


--
-- Name: alunos_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY alunos
    ADD CONSTRAINT alunos_pkey PRIMARY KEY (id);


--
-- Name: public; Type: ACL; Schema: -; Owner: -
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--


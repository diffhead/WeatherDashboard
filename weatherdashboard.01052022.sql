--
-- PostgreSQL database dump
--

-- Dumped from database version 13.5 (Debian 13.5-0+deb11u1)
-- Dumped by pg_dump version 13.5 (Debian 13.5-0+deb11u1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: access; Type: TABLE; Schema: public; Owner: tree
--

CREATE TABLE public.access (
    id integer NOT NULL,
    title text NOT NULL,
    description text DEFAULT ''::text NOT NULL
);


ALTER TABLE public.access OWNER TO tree;

--
-- Name: access_id_seq; Type: SEQUENCE; Schema: public; Owner: tree
--

CREATE SEQUENCE public.access_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.access_id_seq OWNER TO tree;

--
-- Name: access_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: tree
--

ALTER SEQUENCE public.access_id_seq OWNED BY public.access.id;


--
-- Name: cache; Type: TABLE; Schema: public; Owner: tree
--

CREATE TABLE public.cache (
    id integer NOT NULL,
    key text,
    value text,
    expiration integer,
    date_add timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.cache OWNER TO tree;

--
-- Name: cache_id_seq; Type: SEQUENCE; Schema: public; Owner: tree
--

CREATE SEQUENCE public.cache_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cache_id_seq OWNER TO tree;

--
-- Name: cache_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: tree
--

ALTER SEQUENCE public.cache_id_seq OWNED BY public.cache.id;


--
-- Name: config; Type: TABLE; Schema: public; Owner: tree
--

CREATE TABLE public.config (
    id integer NOT NULL,
    key text NOT NULL,
    value text,
    date_add timestamp without time zone DEFAULT now() NOT NULL,
    date_update timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.config OWNER TO tree;

--
-- Name: config_id_seq; Type: SEQUENCE; Schema: public; Owner: tree
--

CREATE SEQUENCE public.config_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.config_id_seq OWNER TO tree;

--
-- Name: config_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: tree
--

ALTER SEQUENCE public.config_id_seq OWNED BY public.config.id;


--
-- Name: country; Type: TABLE; Schema: public; Owner: tree
--

CREATE TABLE public.country (
    id integer NOT NULL,
    title text NOT NULL,
    iso text NOT NULL,
    itu text DEFAULT ''::text NOT NULL
);


ALTER TABLE public.country OWNER TO tree;

--
-- Name: country_id_seq; Type: SEQUENCE; Schema: public; Owner: tree
--

CREATE SEQUENCE public.country_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.country_id_seq OWNER TO tree;

--
-- Name: country_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: tree
--

ALTER SEQUENCE public.country_id_seq OWNED BY public.country.id;


--
-- Name: modules; Type: TABLE; Schema: public; Owner: tree
--

CREATE TABLE public.modules (
    id integer NOT NULL,
    name text,
    enable integer,
    priority integer DEFAULT 10 NOT NULL,
    environment text DEFAULT 'web'::text NOT NULL
);


ALTER TABLE public.modules OWNER TO tree;

--
-- Name: modules_id_seq; Type: SEQUENCE; Schema: public; Owner: tree
--

CREATE SEQUENCE public.modules_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.modules_id_seq OWNER TO tree;

--
-- Name: modules_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: tree
--

ALTER SEQUENCE public.modules_id_seq OWNED BY public.modules.id;


--
-- Name: user_access; Type: TABLE; Schema: public; Owner: tree
--

CREATE TABLE public.user_access (
    user_id integer NOT NULL,
    access integer NOT NULL
);


ALTER TABLE public.user_access OWNER TO tree;

--
-- Name: user_session; Type: TABLE; Schema: public; Owner: tree
--

CREATE TABLE public.user_session (
    user_id integer NOT NULL,
    token text NOT NULL,
    expiration timestamp without time zone DEFAULT (now() + '1 day'::interval) NOT NULL
);


ALTER TABLE public.user_session OWNER TO tree;

--
-- Name: users; Type: TABLE; Schema: public; Owner: tree
--

CREATE TABLE public.users (
    id integer NOT NULL,
    name text,
    secondname text DEFAULT ''::text NOT NULL,
    thirdname text DEFAULT ''::text NOT NULL,
    email text NOT NULL,
    date_add timestamp without time zone DEFAULT now() NOT NULL,
    date_upd timestamp without time zone DEFAULT now() NOT NULL,
    phone text DEFAULT ''::text NOT NULL,
    last_login timestamp without time zone DEFAULT now() NOT NULL,
    login text NOT NULL,
    password text NOT NULL,
    active integer DEFAULT 1 NOT NULL
);


ALTER TABLE public.users OWNER TO tree;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: tree
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO tree;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: tree
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: weather; Type: TABLE; Schema: public; Owner: tree
--

CREATE TABLE public.weather (
    id integer NOT NULL,
    city integer NOT NULL,
    weather text NOT NULL,
    weather_icon text DEFAULT ''::text NOT NULL,
    weather_description text DEFAULT ''::text NOT NULL,
    temperature double precision NOT NULL,
    temperature_feeling double precision NOT NULL,
    visibility integer DEFAULT 0 NOT NULL,
    wind_speed double precision NOT NULL,
    wind_deg integer NOT NULL,
    date_add timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.weather OWNER TO tree;

--
-- Name: weather_city; Type: TABLE; Schema: public; Owner: tree
--

CREATE TABLE public.weather_city (
    id integer NOT NULL,
    title text DEFAULT 'UnnamedCity'::text NOT NULL,
    latitude double precision DEFAULT 0 NOT NULL,
    longitude double precision DEFAULT 0 NOT NULL,
    active integer DEFAULT 1 NOT NULL,
    country integer NOT NULL
);


ALTER TABLE public.weather_city OWNER TO tree;

--
-- Name: weather_city_id_seq; Type: SEQUENCE; Schema: public; Owner: tree
--

CREATE SEQUENCE public.weather_city_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.weather_city_id_seq OWNER TO tree;

--
-- Name: weather_city_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: tree
--

ALTER SEQUENCE public.weather_city_id_seq OWNED BY public.weather_city.id;


--
-- Name: weather_id_seq; Type: SEQUENCE; Schema: public; Owner: tree
--

CREATE SEQUENCE public.weather_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.weather_id_seq OWNER TO tree;

--
-- Name: weather_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: tree
--

ALTER SEQUENCE public.weather_id_seq OWNED BY public.weather.id;


--
-- Name: access id; Type: DEFAULT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.access ALTER COLUMN id SET DEFAULT nextval('public.access_id_seq'::regclass);


--
-- Name: cache id; Type: DEFAULT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.cache ALTER COLUMN id SET DEFAULT nextval('public.cache_id_seq'::regclass);


--
-- Name: config id; Type: DEFAULT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.config ALTER COLUMN id SET DEFAULT nextval('public.config_id_seq'::regclass);


--
-- Name: country id; Type: DEFAULT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.country ALTER COLUMN id SET DEFAULT nextval('public.country_id_seq'::regclass);


--
-- Name: modules id; Type: DEFAULT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.modules ALTER COLUMN id SET DEFAULT nextval('public.modules_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: weather id; Type: DEFAULT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.weather ALTER COLUMN id SET DEFAULT nextval('public.weather_id_seq'::regclass);


--
-- Name: weather_city id; Type: DEFAULT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.weather_city ALTER COLUMN id SET DEFAULT nextval('public.weather_city_id_seq'::regclass);


--
-- Data for Name: access; Type: TABLE DATA; Schema: public; Owner: tree
--

COPY public.access (id, title, description) FROM stdin;
1	admin	User who has full access on the site
2	employee	User who can manipulate content
3	user	User who can view site content
4	guest	Guest user
\.


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: tree
--

COPY public.cache (id, key, value, expiration, date_add) FROM stdin;
\.


--
-- Data for Name: config; Type: TABLE DATA; Schema: public; Owner: tree
--

COPY public.config (id, key, value, date_add, date_update) FROM stdin;
1	ROUTES_HANDLER_CACHING	1	2022-02-12 10:39:47.635545	2022-02-12 10:39:47.635545
\.


--
-- Data for Name: country; Type: TABLE DATA; Schema: public; Owner: tree
--

COPY public.country (id, title, iso, itu) FROM stdin;
1	Russia	RU	250,251
2	Ukraine	UA	255
3	United Kindom	GB	234, 235, 236, 237
\.


--
-- Data for Name: modules; Type: TABLE DATA; Schema: public; Owner: tree
--

COPY public.modules (id, name, enable, priority, environment) FROM stdin;
1	WebFrontend	1	1	web
2	AuthModule	1	2	web
5	WeatherApi	1	3	any
4	ModulesHandler	1	4	any
3	CacheHandler	1	5	any
\.


--
-- Data for Name: user_access; Type: TABLE DATA; Schema: public; Owner: tree
--

COPY public.user_access (user_id, access) FROM stdin;
1	4
2	1
\.


--
-- Data for Name: user_session; Type: TABLE DATA; Schema: public; Owner: tree
--

COPY public.user_session (user_id, token, expiration) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: tree
--

COPY public.users (id, name, secondname, thirdname, email, date_add, date_upd, phone, last_login, login, password, active) FROM stdin;
1	Guest			info@site.com	2022-02-12 06:00:50.748785	2022-02-12 06:00:50.748785		2022-02-12 06:00:50.748785	guest		1
2				admin@development.me	2022-02-13 02:11:39	2022-02-13 02:11:39	+79304270218	2022-02-13 02:11:39	Admin	KKW8C7rMSw6t8RFGr+OCrQ==	1
\.


--
-- Data for Name: weather; Type: TABLE DATA; Schema: public; Owner: tree
--

COPY public.weather (id, city, weather, weather_icon, weather_description, temperature, temperature_feeling, visibility, wind_speed, wind_deg, date_add) FROM stdin;
\.


--
-- Data for Name: weather_city; Type: TABLE DATA; Schema: public; Owner: tree
--

COPY public.weather_city (id, title, latitude, longitude, active, country) FROM stdin;
2	Lviv	49.8397	24.0297	1	2
3	London	51.5072	0.1276	1	3
4	Volgograd	48.708	44.5133	1	1
1	Voronezh	51.6683	39.1919	1	1
\.


--
-- Name: access_id_seq; Type: SEQUENCE SET; Schema: public; Owner: tree
--

SELECT pg_catalog.setval('public.access_id_seq', 4, true);


--
-- Name: cache_id_seq; Type: SEQUENCE SET; Schema: public; Owner: tree
--

SELECT pg_catalog.setval('public.cache_id_seq', 1, false);


--
-- Name: config_id_seq; Type: SEQUENCE SET; Schema: public; Owner: tree
--

SELECT pg_catalog.setval('public.config_id_seq', 1, true);


--
-- Name: country_id_seq; Type: SEQUENCE SET; Schema: public; Owner: tree
--

SELECT pg_catalog.setval('public.country_id_seq', 3, true);


--
-- Name: modules_id_seq; Type: SEQUENCE SET; Schema: public; Owner: tree
--

SELECT pg_catalog.setval('public.modules_id_seq', 6, false);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: tree
--

SELECT pg_catalog.setval('public.users_id_seq', 2, true);


--
-- Name: weather_city_id_seq; Type: SEQUENCE SET; Schema: public; Owner: tree
--

SELECT pg_catalog.setval('public.weather_city_id_seq', 4, true);


--
-- Name: weather_id_seq; Type: SEQUENCE SET; Schema: public; Owner: tree
--

SELECT pg_catalog.setval('public.weather_id_seq', 1, false);


--
-- Name: access access_pkey; Type: CONSTRAINT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.access
    ADD CONSTRAINT access_pkey PRIMARY KEY (id);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (id);


--
-- Name: config config_pkey; Type: CONSTRAINT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.config
    ADD CONSTRAINT config_pkey PRIMARY KEY (key);


--
-- Name: country country_pkey; Type: CONSTRAINT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.country
    ADD CONSTRAINT country_pkey PRIMARY KEY (id);


--
-- Name: users email_unique; Type: CONSTRAINT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT email_unique UNIQUE (email);


--
-- Name: modules modules_pkey; Type: CONSTRAINT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.modules
    ADD CONSTRAINT modules_pkey PRIMARY KEY (id);


--
-- Name: user_access user_access_pkey; Type: CONSTRAINT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.user_access
    ADD CONSTRAINT user_access_pkey PRIMARY KEY (user_id);


--
-- Name: user_session user_session_pkey; Type: CONSTRAINT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.user_session
    ADD CONSTRAINT user_session_pkey PRIMARY KEY (user_id);


--
-- Name: users users_login_key; Type: CONSTRAINT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_login_key UNIQUE (login);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: weather_city weather_city_pkey; Type: CONSTRAINT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.weather_city
    ADD CONSTRAINT weather_city_pkey PRIMARY KEY (id);


--
-- Name: weather weather_pkey; Type: CONSTRAINT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.weather
    ADD CONSTRAINT weather_pkey PRIMARY KEY (id);


--
-- Name: user_access fk_access; Type: FK CONSTRAINT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.user_access
    ADD CONSTRAINT fk_access FOREIGN KEY (access) REFERENCES public.access(id) ON DELETE CASCADE;


--
-- Name: weather fk_city; Type: FK CONSTRAINT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.weather
    ADD CONSTRAINT fk_city FOREIGN KEY (city) REFERENCES public.weather_city(id) ON DELETE CASCADE;


--
-- Name: user_access fk_user; Type: FK CONSTRAINT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.user_access
    ADD CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: user_session fk_user_id; Type: FK CONSTRAINT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.user_session
    ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: weather_city wc_country; Type: FK CONSTRAINT; Schema: public; Owner: tree
--

ALTER TABLE ONLY public.weather_city
    ADD CONSTRAINT wc_country FOREIGN KEY (country) REFERENCES public.country(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--


--
-- PostgreSQL database dump
--

-- Dumped from database version 17.4
-- Dumped by pg_dump version 17.4

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
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
-- Name: bawahans; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bawahans (
    id bigint NOT NULL,
    karyawan_id bigint NOT NULL,
    nama character varying(255),
    bagian character varying(255),
    peran character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.bawahans OWNER TO postgres;

--
-- Name: bawahans_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.bawahans_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.bawahans_id_seq OWNER TO postgres;

--
-- Name: bawahans_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.bawahans_id_seq OWNED BY public.bawahans.id;


--
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- Name: critical_incidents; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.critical_incidents (
    id bigint NOT NULL,
    karyawan_id bigint NOT NULL,
    jenis_insiden character varying(255) NOT NULL,
    topik character varying(255),
    waktu_kejadian character varying(255),
    kejadian text,
    situasi text,
    pelaku text,
    pikiran_perasaan text,
    perilaku text,
    hasil text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT critical_incidents_jenis_insiden_check CHECK (((jenis_insiden)::text = ANY ((ARRAY['Sukses'::character varying, 'Gagal'::character varying])::text[])))
);


ALTER TABLE public.critical_incidents OWNER TO postgres;

--
-- Name: critical_incidents_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.critical_incidents_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.critical_incidents_id_seq OWNER TO postgres;

--
-- Name: critical_incidents_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.critical_incidents_id_seq OWNED BY public.critical_incidents.id;


--
-- Name: detail_pekerjaans; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.detail_pekerjaans (
    id bigint NOT NULL,
    karyawan_id bigint NOT NULL,
    tugas_dua_posisi_terakhir text,
    struktur_organisasi text,
    tanggung_jawab text,
    uraian_tanggung_jawab text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.detail_pekerjaans OWNER TO postgres;

--
-- Name: detail_pekerjaans_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.detail_pekerjaans_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.detail_pekerjaans_id_seq OWNER TO postgres;

--
-- Name: detail_pekerjaans_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.detail_pekerjaans_id_seq OWNED BY public.detail_pekerjaans.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO postgres;

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: karyawans; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.karyawans (
    id bigint NOT NULL,
    nama_lengkap character varying(255) NOT NULL,
    nik_sap character varying(255) NOT NULL,
    tempat_lahir character varying(255) NOT NULL,
    tanggal_lahir date NOT NULL,
    jenis_kelamin character varying(255) NOT NULL,
    agama character varying(255),
    status_pernikahan character varying(255),
    alamat text NOT NULL,
    perusahaan character varying(255),
    golongan character varying(255),
    jabatan character varying(255),
    alamat_perusahaan character varying(255),
    nama_atasan_langsung character varying(255),
    jabatan_atasan_langsung character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.karyawans OWNER TO postgres;

--
-- Name: karyawans_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.karyawans_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.karyawans_id_seq OWNER TO postgres;

--
-- Name: karyawans_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.karyawans_id_seq OWNED BY public.karyawans.id;


--
-- Name: kekuatan_kelemahans; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kekuatan_kelemahans (
    id bigint NOT NULL,
    karyawan_id bigint NOT NULL,
    kekuatan text,
    kelemahan text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.kekuatan_kelemahans OWNER TO postgres;

--
-- Name: kekuatan_kelemahans_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.kekuatan_kelemahans_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.kekuatan_kelemahans_id_seq OWNER TO postgres;

--
-- Name: kekuatan_kelemahans_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.kekuatan_kelemahans_id_seq OWNED BY public.kekuatan_kelemahans.id;


--
-- Name: keluargas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.keluargas (
    id bigint NOT NULL,
    karyawan_id bigint NOT NULL,
    hubungan character varying(255) NOT NULL,
    nama character varying(255),
    jenis_kelamin character varying(255),
    tempat_lahir character varying(255),
    tanggal_lahir date,
    pendidikan character varying(255),
    pekerjaan character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT keluargas_jenis_kelamin_check CHECK (((jenis_kelamin)::text = ANY ((ARRAY['L'::character varying, 'P'::character varying])::text[])))
);


ALTER TABLE public.keluargas OWNER TO postgres;

--
-- Name: keluargas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.keluargas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.keluargas_id_seq OWNER TO postgres;

--
-- Name: keluargas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.keluargas_id_seq OWNED BY public.keluargas.id;


--
-- Name: kondisi_kerjas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kondisi_kerjas (
    id bigint NOT NULL,
    karyawan_id bigint NOT NULL,
    penghasilan_sesuai character varying(255),
    penghasilan_penjelasan text,
    jaminan_belum_diberikan character varying(255),
    jaminan_penjelasan text,
    kondisi_kerja_saat_ini character varying(255),
    kondisi_kerja_penjelasan text,
    penilaian_prestasi character varying(255),
    aspek_optimalisasi text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.kondisi_kerjas OWNER TO postgres;

--
-- Name: kondisi_kerjas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.kondisi_kerjas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.kondisi_kerjas_id_seq OWNER TO postgres;

--
-- Name: kondisi_kerjas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.kondisi_kerjas_id_seq OWNED BY public.kondisi_kerjas.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: minat_harapans; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.minat_harapans (
    id bigint NOT NULL,
    karyawan_id bigint NOT NULL,
    hal_disukai text,
    hal_tidak_disukai text,
    alasan_memilih_karier text,
    aspirasi_lima_tahun text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.minat_harapans OWNER TO postgres;

--
-- Name: minat_harapans_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.minat_harapans_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.minat_harapans_id_seq OWNER TO postgres;

--
-- Name: minat_harapans_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.minat_harapans_id_seq OWNED BY public.minat_harapans.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- Name: pendidikans; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pendidikans (
    id bigint NOT NULL,
    karyawan_id bigint NOT NULL,
    kategori character varying(255) NOT NULL,
    tingkat character varying(255),
    nama_institusi character varying(255),
    jurusan character varying(255),
    tempat character varying(255),
    tahun character varying(255),
    keterangan character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT pendidikans_kategori_check CHECK (((kategori)::text = ANY ((ARRAY['Formal'::character varying, 'Informal'::character varying])::text[])))
);


ALTER TABLE public.pendidikans OWNER TO postgres;

--
-- Name: pendidikans_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pendidikans_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pendidikans_id_seq OWNER TO postgres;

--
-- Name: pendidikans_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pendidikans_id_seq OWNED BY public.pendidikans.id;


--
-- Name: pengalaman_kerjas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pengalaman_kerjas (
    id bigint NOT NULL,
    karyawan_id bigint NOT NULL,
    jabatan character varying(255),
    masa_kerja character varying(255),
    perusahaan character varying(255),
    bagian character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.pengalaman_kerjas OWNER TO postgres;

--
-- Name: pengalaman_kerjas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pengalaman_kerjas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pengalaman_kerjas_id_seq OWNER TO postgres;

--
-- Name: pengalaman_kerjas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pengalaman_kerjas_id_seq OWNED BY public.pengalaman_kerjas.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- Name: usaha_aspirasis; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usaha_aspirasis (
    id bigint NOT NULL,
    karyawan_id bigint NOT NULL,
    bidang_diminati character varying(255),
    posisi character varying(255),
    usaha_dilakukan character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.usaha_aspirasis OWNER TO postgres;

--
-- Name: usaha_aspirasis_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usaha_aspirasis_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usaha_aspirasis_id_seq OWNER TO postgres;

--
-- Name: usaha_aspirasis_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usaha_aspirasis_id_seq OWNED BY public.usaha_aspirasis.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    nik_sap character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    role character varying(255) DEFAULT 'peserta'::character varying NOT NULL
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: bawahans id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bawahans ALTER COLUMN id SET DEFAULT nextval('public.bawahans_id_seq'::regclass);


--
-- Name: critical_incidents id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.critical_incidents ALTER COLUMN id SET DEFAULT nextval('public.critical_incidents_id_seq'::regclass);


--
-- Name: detail_pekerjaans id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detail_pekerjaans ALTER COLUMN id SET DEFAULT nextval('public.detail_pekerjaans_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: karyawans id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.karyawans ALTER COLUMN id SET DEFAULT nextval('public.karyawans_id_seq'::regclass);


--
-- Name: kekuatan_kelemahans id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kekuatan_kelemahans ALTER COLUMN id SET DEFAULT nextval('public.kekuatan_kelemahans_id_seq'::regclass);


--
-- Name: keluargas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.keluargas ALTER COLUMN id SET DEFAULT nextval('public.keluargas_id_seq'::regclass);


--
-- Name: kondisi_kerjas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kondisi_kerjas ALTER COLUMN id SET DEFAULT nextval('public.kondisi_kerjas_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: minat_harapans id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.minat_harapans ALTER COLUMN id SET DEFAULT nextval('public.minat_harapans_id_seq'::regclass);


--
-- Name: pendidikans id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pendidikans ALTER COLUMN id SET DEFAULT nextval('public.pendidikans_id_seq'::regclass);


--
-- Name: pengalaman_kerjas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pengalaman_kerjas ALTER COLUMN id SET DEFAULT nextval('public.pengalaman_kerjas_id_seq'::regclass);


--
-- Name: usaha_aspirasis id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usaha_aspirasis ALTER COLUMN id SET DEFAULT nextval('public.usaha_aspirasis_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: bawahans; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.bawahans (id, karyawan_id, nama, bagian, peran, created_at, updated_at) FROM stdin;
3	1	asdasd	\N	\N	2026-04-10 04:04:05	2026-04-10 04:04:05
13	3	budi	SPI	krani	2026-04-16 04:41:25	2026-04-16 04:41:25
\.


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: critical_incidents; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.critical_incidents (id, karyawan_id, jenis_insiden, topik, waktu_kejadian, kejadian, situasi, pelaku, pikiran_perasaan, perilaku, hasil, created_at, updated_at) FROM stdin;
11	1	Sukses	wfewfewfef	Jan 2023 - Mar 2023	asdasdas	fjgnsdjkfnsjkfnkdjfn	fjgnsdjkfnsjkfnkdjfn	ppijoij	njknnkn	asdashbuvvhjvdasd	2026-04-10 04:33:48	2026-04-10 04:33:48
12	1	Gagal	jjhjkkjbk	Feb 2025	siuius	siuuuu	ajadnfjanf	asdafgwfwfqefqefsdasd	wfwbth4	tuk76egwr	2026-04-10 04:33:48	2026-04-10 04:33:48
21	3	Sukses	afwwefewf	Mar 2024	adffgaeg	aerger	aergaegrga	aeaergerg	awregr	argerag	2026-04-14 03:56:09	2026-04-14 03:56:09
22	3	Gagal	Pencapaian	Feb 2025	eagaergaregr	eargergergrg	aergergarg	ergeraaeg	aergaerg	earggeagr	2026-04-14 03:56:09	2026-04-14 03:56:09
\.


--
-- Data for Name: detail_pekerjaans; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.detail_pekerjaans (id, karyawan_id, tugas_dua_posisi_terakhir, struktur_organisasi, tanggung_jawab, uraian_tanggung_jawab, created_at, updated_at) FROM stdin;
1	1	asdasdad	\N	asdasd	asdasdad	2026-04-10 00:59:34	2026-04-10 03:33:01
2	3	asdadasdasd	\N	asdadasd	asdasd	2026-04-13 01:43:53	2026-04-13 01:43:53
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: karyawans; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.karyawans (id, nama_lengkap, nik_sap, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, status_pernikahan, alamat, perusahaan, golongan, jabatan, alamat_perusahaan, nama_atasan_langsung, jabatan_atasan_langsung, created_at, updated_at) FROM stdin;
1	Bahlil	2002002	Medan	1999-07-09	Laki-laki	Islam	Belum Kawin	Jl Menteng Raya	PT PERKEBUNAN NUSANTARA IV	III B	Asisten	Jl Seroja	Sudono	Direksi	2026-04-09 08:45:40	2026-04-09 08:45:40
2	seniman	123456	Konoha	1999-02-01	Laki-laki	Islam	Belum Kawin	Jl Mangga	PT PERKEBUNAN NUSANTARA IV	III A	Asisten	Jl Seroja	Sudono	Direksi	2026-04-13 01:28:28	2026-04-13 01:28:28
3	Ivan	234567	Medan	2000-09-09	Laki-laki	Islam	Belum Kawin	Medan	PT PERKEBUNAN NUSANTARA IV	III A	Asisten	Jl Seroja	Sudono	Direksi	2026-04-13 01:42:25	2026-04-14 04:17:30
\.


--
-- Data for Name: kekuatan_kelemahans; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kekuatan_kelemahans (id, karyawan_id, kekuatan, kelemahan, created_at, updated_at) FROM stdin;
1	1	ergegergreg	ergergrergegg	2026-04-10 02:27:54	2026-04-10 03:33:29
2	3	asddfwr	ergergr	2026-04-13 01:44:42	2026-04-13 01:44:42
\.


--
-- Data for Name: keluargas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.keluargas (id, karyawan_id, hubungan, nama, jenis_kelamin, tempat_lahir, tanggal_lahir, pendidikan, pekerjaan, created_at, updated_at) FROM stdin;
1	2	Istri / Suami	Mikasa Ackerman	P	Shiganshina	2000-01-24	\N	Tidak Bekerja	2026-04-13 01:39:18	2026-04-13 01:39:18
\.


--
-- Data for Name: kondisi_kerjas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kondisi_kerjas (id, karyawan_id, penghasilan_sesuai, penghasilan_penjelasan, jaminan_belum_diberikan, jaminan_penjelasan, kondisi_kerja_saat_ini, kondisi_kerja_penjelasan, penilaian_prestasi, aspek_optimalisasi, created_at, updated_at) FROM stdin;
1	1	Cukup	\N	Ada	\N	Baik	\N	Cukup Sesuai	asdadasdasdasd	2026-04-10 01:51:49	2026-04-10 03:33:10
2	3	Cukup	asdasdada	Tidak Ada	asdasdasd	Cukup Baik	asdadsd	Cukup Sesuai	asdadsa	2026-04-13 01:44:08	2026-04-13 01:44:08
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2026_03_10_080459_create_karyawans_table	1
5	2026_03_11_023735_create_keluargas_table	1
6	2026_03_12_025006_create_pendidikans_table	1
7	2026_03_12_082749_create_pengalaman_kerjas_table	1
8	2026_03_13_011156_create_detail_pekerjaans_table	1
9	2026_03_13_011158_create_bawahans_table	1
10	2026_03_13_012932_create_kondisi_kerjas_table	1
11	2026_03_13_014439_create_minat_harapans_table	1
12	2026_03_13_014441_create_usaha_aspirasis_table	1
13	2026_03_13_014925_create_kekuatan_kelemahans_table	1
14	2026_03_13_020428_create_critical_incidents_table	1
15	2026_04_07_091949_add_role_to_users_table	1
\.


--
-- Data for Name: minat_harapans; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.minat_harapans (id, karyawan_id, hal_disukai, hal_tidak_disukai, alasan_memilih_karier, aspirasi_lima_tahun, created_at, updated_at) FROM stdin;
1	1	asdasdadsasd	asdasd	asdasdad	asdasd	2026-04-10 01:59:25	2026-04-10 03:33:22
2	3	asdadad	asdasdadsad	asdadasdasd	asdadasdafrg	2026-04-13 01:44:36	2026-04-13 01:44:36
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: pendidikans; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pendidikans (id, karyawan_id, kategori, tingkat, nama_institusi, jurusan, tempat, tahun, keterangan, created_at, updated_at) FROM stdin;
9	3	Formal	S1	USU	Ilmu Komputer	Medan	2018-2022	Lulus	2026-04-14 04:17:36	2026-04-14 04:17:36
\.


--
-- Data for Name: pengalaman_kerjas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pengalaman_kerjas (id, karyawan_id, jabatan, masa_kerja, perusahaan, bagian, created_at, updated_at) FROM stdin;
1	1	Asisten	Jan 2020 - Mar 2023	PTPN IV	Tanaman	2026-04-10 04:23:22	2026-04-10 04:23:22
11	3	Asisten	Jan 2020 - Mar 2023	PT Perkebunan Nusantara IV	Tanaman	2026-04-14 04:04:28	2026-04-14 04:04:28
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
x0eqZkQ4SrBCGipURbpZ2wTDo92IX8nS9wZvLJEU	4	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0	YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSkYwb0t2dGo4M0gwd1lVaEl2emFZT1pyWmhGbHdsRUxjT2syMjhvYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mb3JtLWRldGFpbC1wZWtlcmphYW4iO3M6NToicm91dGUiO3M6MjE6ImZvcm0uZGV0YWlsX3Bla2VyamFhbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==	1776142951
gNA9My1tWVS0lUitPyLHTWzE8NZqTGsPKIBL0BK0	4	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0	YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV3NDM3Vic0g2ZUdtMzFPbTJBZ1JrN1k4S2lYM0tjWTFHSllYdERWeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mb3JtLWRldGFpbC1wZWtlcmphYW4iO3M6NToicm91dGUiO3M6MjE6ImZvcm0uZGV0YWlsX3Bla2VyamFhbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==	1776151275
2cr6QWTBODx6BV8QEvGm05DvL5qBL4G36atfHvyr	4	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0	YTo0OntzOjY6Il90b2tlbiI7czo0MDoiREhpeXhKRmJ3NDRRVjduZ3BHNjltZWpCUEpzOXR0UjZpb3pxVU96WiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mb3JtLWRldGFpbC1wZWtlcmphYW4iO3M6NToicm91dGUiO3M6MjE6ImZvcm0uZGV0YWlsX3Bla2VyamFhbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==	1776314488
\.


--
-- Data for Name: usaha_aspirasis; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usaha_aspirasis (id, karyawan_id, bidang_diminati, posisi, usaha_dilakukan, created_at, updated_at) FROM stdin;
3	1	asdasd	\N	\N	2026-04-10 04:17:09	2026-04-10 04:17:09
7	3	Keuangan	\N	\N	2026-04-14 03:56:03	2026-04-14 03:56:03
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, nik_sap, email_verified_at, password, remember_token, created_at, updated_at, role) FROM stdin;
1	Admin HRD	1001001	\N	$2y$12$GdFUhtjFqeDnubGxXzoxPueKRewHHyNDNDx6Pj9mGI2CGCk8XsoEa	\N	2026-04-08 02:46:11	2026-04-08 02:46:11	admin
2	Peserta Ujian	2002002	\N	$2y$12$k/bQfemElFs4O0AiWalgJO566ZS2LudUbyZtuWcVsWCKgqHX.S6h2	\N	2026-04-08 02:46:12	2026-04-08 02:46:12	user
3	seniman	123456	\N	$2y$12$Q7Re1cuY/Ar/tU.2NIdncOo6KLwGys.S128rY2/niMv3JixssIYvG	\N	2026-04-11 12:33:51	2026-04-11 12:33:51	user
4	Ivan	234567	\N	$2y$12$C0uKxwblcWKJROps0dJLcODpCKvPDoo3dBxZLGvKDmKRxdofWtn7W	\N	2026-04-13 01:41:11	2026-04-13 01:41:11	user
\.


--
-- Name: bawahans_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.bawahans_id_seq', 13, true);


--
-- Name: critical_incidents_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.critical_incidents_id_seq', 22, true);


--
-- Name: detail_pekerjaans_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.detail_pekerjaans_id_seq', 2, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: karyawans_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.karyawans_id_seq', 3, true);


--
-- Name: kekuatan_kelemahans_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.kekuatan_kelemahans_id_seq', 2, true);


--
-- Name: keluargas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.keluargas_id_seq', 2, true);


--
-- Name: kondisi_kerjas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.kondisi_kerjas_id_seq', 2, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 15, true);


--
-- Name: minat_harapans_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.minat_harapans_id_seq', 2, true);


--
-- Name: pendidikans_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pendidikans_id_seq', 9, true);


--
-- Name: pengalaman_kerjas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pengalaman_kerjas_id_seq', 11, true);


--
-- Name: usaha_aspirasis_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usaha_aspirasis_id_seq', 7, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 4, true);


--
-- Name: bawahans bawahans_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bawahans
    ADD CONSTRAINT bawahans_pkey PRIMARY KEY (id);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: critical_incidents critical_incidents_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.critical_incidents
    ADD CONSTRAINT critical_incidents_pkey PRIMARY KEY (id);


--
-- Name: detail_pekerjaans detail_pekerjaans_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detail_pekerjaans
    ADD CONSTRAINT detail_pekerjaans_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: karyawans karyawans_nik_sap_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.karyawans
    ADD CONSTRAINT karyawans_nik_sap_unique UNIQUE (nik_sap);


--
-- Name: karyawans karyawans_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.karyawans
    ADD CONSTRAINT karyawans_pkey PRIMARY KEY (id);


--
-- Name: kekuatan_kelemahans kekuatan_kelemahans_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kekuatan_kelemahans
    ADD CONSTRAINT kekuatan_kelemahans_pkey PRIMARY KEY (id);


--
-- Name: keluargas keluargas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.keluargas
    ADD CONSTRAINT keluargas_pkey PRIMARY KEY (id);


--
-- Name: kondisi_kerjas kondisi_kerjas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kondisi_kerjas
    ADD CONSTRAINT kondisi_kerjas_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: minat_harapans minat_harapans_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.minat_harapans
    ADD CONSTRAINT minat_harapans_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: pendidikans pendidikans_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pendidikans
    ADD CONSTRAINT pendidikans_pkey PRIMARY KEY (id);


--
-- Name: pengalaman_kerjas pengalaman_kerjas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pengalaman_kerjas
    ADD CONSTRAINT pengalaman_kerjas_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: usaha_aspirasis usaha_aspirasis_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usaha_aspirasis
    ADD CONSTRAINT usaha_aspirasis_pkey PRIMARY KEY (id);


--
-- Name: users users_nik_sap_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_nik_sap_unique UNIQUE (nik_sap);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: bawahans bawahans_karyawan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bawahans
    ADD CONSTRAINT bawahans_karyawan_id_foreign FOREIGN KEY (karyawan_id) REFERENCES public.karyawans(id) ON DELETE CASCADE;


--
-- Name: critical_incidents critical_incidents_karyawan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.critical_incidents
    ADD CONSTRAINT critical_incidents_karyawan_id_foreign FOREIGN KEY (karyawan_id) REFERENCES public.karyawans(id) ON DELETE CASCADE;


--
-- Name: detail_pekerjaans detail_pekerjaans_karyawan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detail_pekerjaans
    ADD CONSTRAINT detail_pekerjaans_karyawan_id_foreign FOREIGN KEY (karyawan_id) REFERENCES public.karyawans(id) ON DELETE CASCADE;


--
-- Name: kekuatan_kelemahans kekuatan_kelemahans_karyawan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kekuatan_kelemahans
    ADD CONSTRAINT kekuatan_kelemahans_karyawan_id_foreign FOREIGN KEY (karyawan_id) REFERENCES public.karyawans(id) ON DELETE CASCADE;


--
-- Name: keluargas keluargas_karyawan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.keluargas
    ADD CONSTRAINT keluargas_karyawan_id_foreign FOREIGN KEY (karyawan_id) REFERENCES public.karyawans(id) ON DELETE CASCADE;


--
-- Name: kondisi_kerjas kondisi_kerjas_karyawan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kondisi_kerjas
    ADD CONSTRAINT kondisi_kerjas_karyawan_id_foreign FOREIGN KEY (karyawan_id) REFERENCES public.karyawans(id) ON DELETE CASCADE;


--
-- Name: minat_harapans minat_harapans_karyawan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.minat_harapans
    ADD CONSTRAINT minat_harapans_karyawan_id_foreign FOREIGN KEY (karyawan_id) REFERENCES public.karyawans(id) ON DELETE CASCADE;


--
-- Name: pendidikans pendidikans_karyawan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pendidikans
    ADD CONSTRAINT pendidikans_karyawan_id_foreign FOREIGN KEY (karyawan_id) REFERENCES public.karyawans(id) ON DELETE CASCADE;


--
-- Name: pengalaman_kerjas pengalaman_kerjas_karyawan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pengalaman_kerjas
    ADD CONSTRAINT pengalaman_kerjas_karyawan_id_foreign FOREIGN KEY (karyawan_id) REFERENCES public.karyawans(id) ON DELETE CASCADE;


--
-- Name: usaha_aspirasis usaha_aspirasis_karyawan_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usaha_aspirasis
    ADD CONSTRAINT usaha_aspirasis_karyawan_id_foreign FOREIGN KEY (karyawan_id) REFERENCES public.karyawans(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--


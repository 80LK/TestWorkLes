PGDMP     %                
    y            testwork    14.0    14.0                0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            	           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            
           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false                       1262    16395    testwork    DATABASE     e   CREATE DATABASE testwork WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'Russian_Russia.1251';
    DROP DATABASE testwork;
                postgres    false            ?            1259    16420    delivery    TABLE       CREATE TABLE public.delivery (
    id integer NOT NULL,
    provider_id integer NOT NULL,
    wood_species_id integer NOT NULL,
    volume double precision NOT NULL,
    date timestamp(0) without time zone NOT NULL,
    note character varying(1000) DEFAULT NULL::character varying
);
    DROP TABLE public.delivery;
       public         heap    root    false            ?            1259    16419    delivery_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.delivery_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.delivery_id_seq;
       public          root    false    214                       0    0    delivery_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.delivery_id_seq OWNED BY public.delivery.id;
          public          root    false    213            ?            1259    16403    provider    TABLE     c  CREATE TABLE public.provider (
    id integer NOT NULL,
    phone character varying(255) NOT NULL,
    address character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    surname character varying(255) NOT NULL,
    father_name character varying(255) NOT NULL,
    company_name character varying(255) DEFAULT NULL::character varying
);
    DROP TABLE public.provider;
       public         heap    root    false            ?            1259    16402    provider_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.provider_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.provider_id_seq;
       public          root    false    210                       0    0    provider_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.provider_id_seq OWNED BY public.provider.id;
          public          root    false    209            ?            1259    16413    wood_species    TABLE     h   CREATE TABLE public.wood_species (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);
     DROP TABLE public.wood_species;
       public         heap    root    false            ?            1259    16412    wood_species_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.wood_species_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.wood_species_id_seq;
       public          root    false    212                       0    0    wood_species_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.wood_species_id_seq OWNED BY public.wood_species.id;
          public          root    false    211            i           2604    16423    delivery id    DEFAULT     j   ALTER TABLE ONLY public.delivery ALTER COLUMN id SET DEFAULT nextval('public.delivery_id_seq'::regclass);
 :   ALTER TABLE public.delivery ALTER COLUMN id DROP DEFAULT;
       public          root    false    213    214    214            f           2604    16406    provider id    DEFAULT     j   ALTER TABLE ONLY public.provider ALTER COLUMN id SET DEFAULT nextval('public.provider_id_seq'::regclass);
 :   ALTER TABLE public.provider ALTER COLUMN id DROP DEFAULT;
       public          root    false    209    210    210            h           2604    16416    wood_species id    DEFAULT     r   ALTER TABLE ONLY public.wood_species ALTER COLUMN id SET DEFAULT nextval('public.wood_species_id_seq'::regclass);
 >   ALTER TABLE public.wood_species ALTER COLUMN id DROP DEFAULT;
       public          root    false    211    212    212                      0    16420    delivery 
   TABLE DATA           X   COPY public.delivery (id, provider_id, wood_species_id, volume, date, note) FROM stdin;
    public          root    false    214   ?                 0    16403    provider 
   TABLE DATA           `   COPY public.provider (id, phone, address, name, surname, father_name, company_name) FROM stdin;
    public          root    false    210   "                  0    16413    wood_species 
   TABLE DATA           0   COPY public.wood_species (id, name) FROM stdin;
    public          root    false    212   ?                   0    0    delivery_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.delivery_id_seq', 5, true);
          public          root    false    213                       0    0    provider_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.provider_id_seq', 2, true);
          public          root    false    209                       0    0    wood_species_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.wood_species_id_seq', 5, true);
          public          root    false    211            p           2606    16428    delivery delivery_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.delivery
    ADD CONSTRAINT delivery_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.delivery DROP CONSTRAINT delivery_pkey;
       public            root    false    214            l           2606    16411    provider provider_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.provider
    ADD CONSTRAINT provider_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.provider DROP CONSTRAINT provider_pkey;
       public            root    false    210            n           2606    16418    wood_species wood_species_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.wood_species
    ADD CONSTRAINT wood_species_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.wood_species DROP CONSTRAINT wood_species_pkey;
       public            root    false    212            q           1259    16430    idx_3781ec10287d2c66    INDEX     T   CREATE INDEX idx_3781ec10287d2c66 ON public.delivery USING btree (wood_species_id);
 (   DROP INDEX public.idx_3781ec10287d2c66;
       public            root    false    214            r           1259    16429    idx_3781ec10a53a8aa    INDEX     O   CREATE INDEX idx_3781ec10a53a8aa ON public.delivery USING btree (provider_id);
 '   DROP INDEX public.idx_3781ec10a53a8aa;
       public            root    false    214            t           2606    16436    delivery fk_3781ec10287d2c66    FK CONSTRAINT     ?   ALTER TABLE ONLY public.delivery
    ADD CONSTRAINT fk_3781ec10287d2c66 FOREIGN KEY (wood_species_id) REFERENCES public.wood_species(id);
 F   ALTER TABLE ONLY public.delivery DROP CONSTRAINT fk_3781ec10287d2c66;
       public          root    false    212    3182    214            s           2606    16431    delivery fk_3781ec10a53a8aa    FK CONSTRAINT     ?   ALTER TABLE ONLY public.delivery
    ADD CONSTRAINT fk_3781ec10a53a8aa FOREIGN KEY (provider_id) REFERENCES public.provider(id);
 E   ALTER TABLE ONLY public.delivery DROP CONSTRAINT fk_3781ec10a53a8aa;
       public          root    false    210    3180    214               l   x?u?1?P???U?H?}o?"P?L`??? ?8?&Bȍ???? B*?R*?#yn??X??
???P?%?8b;??c?[?????^ ??KK?4??<[i?3_?j(         ?   x?????0E?? ??[?L?a?PP"(DK!???F?)?h)N'=??_I?k]V?1?N??&<0??7x?w???tb?t?D?jM?!??[?9?I???f-?ٸ2?9??5Z??.????}j̈?HH?K??B| ,??         H   x?3??0??֋?^?~a?煅?]l???1漰?¾??x??.?S?S?S.6_?????? 	2#?     
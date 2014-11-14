CREATE TABLE KECAMATAN(
kec_id varchar(255) not null,
kec_nama varchar(255),
kec_alamat varchar(500),
kec_kordinat_x varchar(50),
kec_kordinat_y varchar(50),
kec_icon_map varchar(50),
PRIMARY KEY(kec_id));

INSERT INTO KECAMATAN (kec_id,kec_nama,kec_kordinat_x,kec_kordinat_y) VALUES(uuid(), 'Cilincing', '-6.109132','106.753323');
INSERT INTO KECAMATAN (kec_id,kec_nama,kec_kordinat_x,kec_kordinat_y) VALUES(uuid(), 'Kelapa Gading', '-6.129132','106.753323');
INSERT INTO KECAMATAN (kec_id,kec_nama,kec_kordinat_x,kec_kordinat_y) VALUES(uuid(), 'Koja', '-6.139132','106.753323');
INSERT INTO KECAMATAN (kec_id,kec_nama,kec_kordinat_x,kec_kordinat_y) VALUES(uuid(), 'Pademangan', '-6.149132','106.753323');
INSERT INTO KECAMATAN (kec_id,kec_nama,kec_kordinat_x,kec_kordinat_y) VALUES(uuid(), 'Penjaringan', '-6.159132','106.753323');
INSERT INTO KECAMATAN (kec_id,kec_nama,kec_kordinat_x,kec_kordinat_y) VALUES(uuid(), 'Tanjung Priok', '-6.169132','106.753323');



CREATE TABLE KELURAHAN(
kel_id varchar(255) not null,
kec_id varchar(255) not null,
kel_nama varchar(255),
kel_alamat varchar(500),
kel_kordinat_x varchar(50),
kel_kordinat_y varchar(50),
kel_icon_map varchar(50),
PRIMARY KEY(kel_id),
FOREIGN KEY (kec_id) REFERENCES KECAMATAN(kec_id));

INSERT INTO KELURAHAN (kel_id,kec_id,kel_nama,kel_alamat,kel_kordinat_x,kel_kordinat_y) VALUES (uuid(),'5ae23506-375f-11e4-a0eb-20107afa84f9', 'Cilincing',				''			,'-6.109132','106.753323');
INSERT INTO KELURAHAN (kel_id,kec_id,kel_nama,kel_alamat,kel_kordinat_x,kel_kordinat_y) VALUES (uuid(),'5af45557-375f-11e4-a0eb-20107afa84f9', 'Kelapa Gading Barat',	''	,'-6.124132','106.753323');
INSERT INTO KELURAHAN (kel_id,kec_id,kel_nama,kel_alamat,kel_kordinat_x,kel_kordinat_y) VALUES (uuid(),'5afe60f0-375f-11e4-a0eb-20107afa84f9', 'Rawa Badak Selatan',	''	,'-6.135132','106.753323');
INSERT INTO KELURAHAN (kel_id,kec_id,kel_nama,kel_alamat,kel_kordinat_x,kel_kordinat_y) VALUES (uuid(),'5b04f9ff-375f-11e4-a0eb-20107afa84f9', 'Pademangan Timur',		''		,'-6.146132','106.753323');
INSERT INTO KELURAHAN (kel_id,kec_id,kel_nama,kel_alamat,kel_kordinat_x,kel_kordinat_y) VALUES (uuid(),'5b0f1067-375f-11e4-a0eb-20107afa84f9', 'Penjaringan',			''			,'-6.157132','106.753323');
INSERT INTO KELURAHAN (kel_id,kec_id,kel_nama,kel_alamat,kel_kordinat_x,kel_kordinat_y) VALUES (uuid(),'5b15c171-375f-11e4-a0eb-20107afa84f9', 'Kebon Bawang',			''			,'-6.168132','106.753323');

 	Edit Edit 	Copy Copy 	Delete Delete 	b512e4b0-3760-11e4-a0eb-20107afa84f9 	5ae23506-375f-11e4-a0eb-20107afa84f9 	Cilincing 		-6.109132 	106.753323
	Edit Edit 	Copy Copy 	Delete Delete 	b517b1d0-3760-11e4-a0eb-20107afa84f9 	5af45557-375f-11e4-a0eb-20107afa84f9 	Kelapa Gading Barat 		-6.124132 	106.753323
	Edit Edit 	Copy Copy 	Delete Delete 	b51ac0f3-3760-11e4-a0eb-20107afa84f9 	5afe60f0-375f-11e4-a0eb-20107afa84f9 	Rawa Badak Selatan 		-6.135132 	106.753323
	Edit Edit 	Copy Copy 	Delete Delete 	b544c5e7-3760-11e4-a0eb-20107afa84f9 	5b04f9ff-375f-11e4-a0eb-20107afa84f9 	Pademangan Timur 		-6.146132 	106.753323
	Edit Edit 	Copy Copy 	Delete Delete 	b54bb431-3760-11e4-a0eb-20107afa84f9 	5b0f1067-375f-11e4-a0eb-20107afa84f9 	Penjaringan 		-6.157132 	106.753323
	Edit Edit 	Copy Copy 	Delete Delete 	b54ecb90-3760-11e4-a0eb-20107afa84f9 	5b15c171-375f-11e4-a0eb-20107afa84f9 	Kebon Bawang 		-6.168132 	106.753323


CREATE TABLE PUSKESMAS(
pusk_id varchar(255) not null,
kel_id varchar(255),
pusk_nama varchar(255) not null,
pusk_kode_puskesmas varchar(255) not null,
pusk_alamat varchar(500) not null,
pusk_jenis_puskesmas varchar(255) null,
pusk_kordinat_x varchar(255) null,
pusk_kordinat_y varchar(255) null,
pusk_informasi text null,
pusk_keterangan text null,
pusk_icon_map varchar(50),
PRIMARY KEY (pusk_id),
FOREIGN KEY (kel_id) REFERENCES KELURAHAN(kel_id));

INSERT INTO PUSKESMAS VALUES (uuid(),'b512e4b0-3760-11e4-a0eb-20107afa84f9','KEL. CILINCING I','P3175060203','Jl. Pasar Pagi No.11A, Kec. Cilincing','Non Perawatan','-6.101134','106.939335' );
INSERT INTO PUSKESMAS VALUES (uuid(),'b517b1d0-3760-11e4-a0eb-20107afa84f9','KEC. KELAPA GADING (PKC BARU)','P3175050101','Jl. Pelepah Elok, Kec. Kelapa Gading','Non Perawatan','-6.157813','106.906056' );
INSERT INTO PUSKESMAS VALUES (uuid(),'b51ac0f3-3760-11e4-a0eb-20107afa84f9','KEL. RAWA BADAK UTARA I','P3175040208','Jl. Raya Kincir Rawa Badak Utara, Kec. Koja','Non Perawatan','-6.122125','106.899589' );
INSERT INTO PUSKESMAS VALUES (uuid(),'b544c5e7-3760-11e4-a0eb-20107afa84f9','KEL. PADEMANGAN TIMUR','P3175020205','Jl. Pademangan II Gg. 22/2, Kec. Pademangan','Non Perawatan','-6.139484','106.841453' );
INSERT INTO PUSKESMAS VALUES (uuid(),'b54bb431-3760-11e4-a0eb-20107afa84f9','KEL. PENJARINGAN II','P3175010206','Jl. Rawa Bebek Rt 0016/10 Pasar Royal, Kec. Penjaringan','Non Perawatan','-6.126309','106.794023' );
INSERT INTO PUSKESMAS VALUES (uuid(),'b54ecb90-3760-11e4-a0eb-20107afa84f9','KEL. KEBON BAWANG I','P3175030206','Jl. Swasembada Barat VII/2, Kec. Tanjung Priok','Perawatan','-6.115892','106.889417' );

CREATE TABLE DT_PUSKESMAS(
dt_id int NOT NULL AUTO_INCREMENT,
pusk_id varchar(255) NOT NULL,
dt_column varchar(255) NOT NULL,
dt_information text,
PRIMARY KEY (dt_id),
FOREIGN KEY (pusk_id) REFERENCES PUSKESMAS(pusk_id));

CREATE TABLE DT_KELURAHAN(
dt_id int NOT NULL AUTO_INCREMENT,
kel_id varchar(255) NOT NULL,
dt_column varchar(255) NOT NULL,
dt_information text,
PRIMARY KEY (dt_id),
FOREIGN KEY (kel_id) REFERENCES KELURAHAN(kel_id));


CREATE TABLE DT_INFO_KELURAHAN(
dt_info_id int NOT NULL AUTO_INCREMENT,
dt_id int(11) NOT NULL,
kel_id varchar(255) NOT NULL,
dt_data varchar(255) NOT NULL,
dt_periode varchar(50) not null,
dt_update date,
PRIMARY KEY (dt_info_id),
FOREIGN KEY (dt_id) REFERENCES DT_KELURAHAN(dt_id),
FOREIGN KEY (kel_id) REFERENCES KELURAHAN(kel_id));


CREATE TABLE DT_KECAMATAN(
dt_id int NOT NULL AUTO_INCREMENT,
kec_id varchar(255) NOT NULL,
dt_column varchar(255) NOT NULL,
dt_information text,
PRIMARY KEY (dt_id),
FOREIGN KEY (kec_id) REFERENCES KECAMATAN(kec_id));

CREATE TABLE INDICATOR(
idc_id varchar(255) NOT NULL,
idc_nama varchar(255) not null,
idc_satuan varchar(50) null,
idc_category varchar(255) not null,
PRIMARY KEY (idc_id) 
)



CREATE TABLE USER(
user_id varchar(255) not null,
username varchar(255) not null,
password varchar(500) not null,
level varchar(50) not null,
last_update date,
PRIMARY KEY (user_id));









1	KEC. PENJARINGAN	P3175010101	Jl. Raya Telok Gong No.2, Kec. Penjaringan	Perawatan
2	KEL. KAMAL MUARA	P3175010202	Jl. Kamal Muara Raya Rt 07/01, Kec. Penjaringan	Non Perawatan
3	KEL. KAPUK MUARA	P3175010203	Jl. Kapuk Kamal No. 28, Kec. Penjaringan	Non Perawatan
4	KEL. PEJAGALAN	P3175010204	Jl. Telok Gong Kav. Rt 003/12, Kec. Penjaringan	Non Perawatan
5	KEL. PENJARINGAN I	P3175010205	Jl. Pluit Raya Selatan No.2, Kec. Penjaringan	Non Perawatan
6	KEL. PENJARINGAN II	P3175010206	Jl. Rawa Bebek Rt 0016/10 Pasar Royal, Kec. Penjaringan	Non Perawatan
7	KEL. PLUIT	P3175010207	Jl. Muara Angke, Kec. Penjaringan	Non Perawatan
8	KEC. PADEMANGAN	P3175020201	Jl. Budi Mulya No.11, Kec. Pademangan	Non Perawatan
9	KEL. ANCOL	P3175020202	Jl. Ancol Barat VIII, Kec. Pademangan	Non Perawatan
10	KEL. PADEMANGAN BRT. I	P3175020203	Jl. Ampera Besar, Kec. Pademangan	Non Perawatan
11	KEL. PADEMANGAN BRT. II	P3175020204	Jl. Waspada Raya Gg. B2, Kec. Pademangan	Non Perawatan
12	KEL. PADEMANGAN TIMUR	P3175020205	Jl. Pademangan II Gg. 22/2, Kec. Pademangan	Non Perawatan
13	KEC. TANJUNG PRIOK	P3175030101	Jl. Bugis No.63, Kec. Tanjung Priok	Perawatan
14	KEL. SUNTER JAYA I	P3175030202	Jl. Sunter Jaya IV, Kec. Tanjung Priok	Non Perawatan
15	KEL. SUNTER JAYA II	P3175030203	Jl. Komplek Kebersihan DKI, Kec. Tanjung Priok	Non Perawatan
16	KEL. PAPANGGO I	P3175030204	Jl. Warakas X Gg D/69 Rt 006, Kec. Tanjung Priok	Non Perawatan
17	KEL. SUNGAI BAMBU	P3175030205	Jl. Sungai Bambu IV/24, Kec. Tanjung Priok	Non Perawatan
18	KEL. KEBON BAWANG I	P3175030206	Jl. Swasembada Barat VII/2, Kec. Tanjung Priok	Non Perawatan
19	KEL. KEBON BAWANG II	P3175030207	Jl. Swasembada Timur VI/1, Kec. Tanjung Priok	Non Perawatan
20	KEL. KEBON BAWANG III	P3175030208	Jl. Swasembada Barat II/83, Kec. Tanjung Priok	Non Perawatan
21	KEL. TANJUNG PRIOK	P3175030209	Jl. Bahari III/65, Kec. Tanjung Priok	Non Perawatan
22	KEL. SUNTER AGUNG I	P3175030210	Jl. Bambu Kuning Gg. II/1, Kec. Tanjung Priok	Non Perawatan
23	KEL. SUNTER AGUNG II	P3175030211	Jl. Agung Barat 25 Blok B, Kec. Tanjung Priok	Non Perawatan
24	KEL. SUNTER AGUNG III	P3175030212	Jl. Taman Nyiur Komp. Bl Blok P, Kec. Tanjung Priok	Non Perawatan
25	KEL. W A R A K A S	P3175030213	Jl. Warakas IX/22, Kec. Tanjung Priok	Non Perawatan
26	KEL. PAPANGGO II	P3175030214	Jl. Bisma Raya Komp. Kel. Papanggo, Kec. Tanjung Priok	Non Perawatan
27	KEC. K O J A	P3175040101	Jl. Walang Permai No. 39, Kec. Koja	Perawatan
28	KEL. K O J A	P3175040202	Jl. Deli Lorong 28/2, Kec. Koja	Non Perawatan
29	KEL. L A G O A	P3175040203	Jl. Menteng No.30, Kec. Koja	Non Perawatan
30	KEL. TUGU UTARA III	P3175040204	Jl. Mahoni No. 9, Kec. Koja	Non Perawatan
31	KEL. TUGU UTARA I	P3175040205	Jl. Mahoni, Kec. Koja	Non Perawatan
32	KEL. TUGU SELATAN	P3175040206	Jl. Bendungan Melayu Selatan Rt 001/05, Kec. Koja	Non Perawatan
33	KEL. RAWA BADAK UTARA II	P3175040207	Jl. Rawa Binangun V Rt. 08/08, Kec. Koja	Non Perawatan
34	KEL. RAWA BADAK UTARA I	P3175040208	Jl. Raya Kincir Rawa Badak Utara, Kec. Koja	Non Perawatan
35	KEC. KELAPA GADING (PKC BARU)	P3175050101	Jl. Pelepah Elok, Kec. Kelapa Gading	Perawatan
36	KEL. KELAPA GADING TMR. I	P3175050202	Komp. Perdagangan, Kec. Kelapa Gading	Non Perawatan
37	KEL. KELAPA GADING TMR. II	P3175050203	Jl. Merah Jambu Blok EJ/22, Kec. Kelapa Gading	Non Perawatan
38	KEL. PEGANGSAAN DUA A	P3175050204	Jl. Kesadaran Rt 005/01, Kec. Kelapa Gading	Non Perawatan
39	KEL. PEGANGSAAN DUA B	P3175050205	Gandang, Kec. Kelapa Gading	Non Perawatan
40	KEC. CILINCING	P3175060101	Jl. Madya Kebantenan IV, Kec. Cilincing	Perawatan
41	KEL. KALIBARU	P3175060202	Jl. Kalibaru Timur 1/50, Kec. Cilincing	Non Perawatan
42	KEL. CILINCING I	P3175060203	Jl. Pasar Pagi No.11A, Kec. Cilincing	Non Perawatan
43	KEL. CILINCING II	P3175060204	Jl. Sungai Landak No.26, Kec. Cilincing	Non Perawatan
44	KEL. SEMPER BARAT I	P3175060205	Jl. Durian No.49, Kec. Cilincing	Non Perawatan
45	KEL. SEMPER BARAT II	P3175060206	Jl. Tipar Cakung No. 18 Rt 01, Kec. Cilincing	Non Perawatan
46	KEL. SEMPER BARAT III	P3175060207	Jl. Pepaya V Blok S rt 06/016, Kec. Cilincing	Non Perawatan
47	KEL. MARUNDA	P3175060208	Jl. Marunda Baru No.5 Rt 009/02, Kec. Cilincing	Non Perawatan
48	KEL. SUKAPURA	P3175060209	Jl. Tipar Cakung, Kec. Cilincing	Non Perawatan
49	KEL. ROROTAN	P3175060210	Jl. Manunggal Juang 19 No.4, Kec. Cilincing	Non Perawatan
49	KEL. ROROTAN	P3175060210	Jl. Manunggal Juang 19 No.4, Kec. Cilincing	Non Perawatan



INSERT INTO `kelurahan`( `nama_kelurahan`, `alamat`, `kode_pos`, `kordinat_x`, `kordinat_y`) VALUES (uuid(),'DUMMY-JAKARTA UTARA 1','DUMMY-JAKARTA UATARA 1','440100','-6.121207','106.785681');
INSERT INTO `kelurahan`( `nama_kelurahan`, `alamat`, `kode_pos`, `kordinat_x`, `kordinat_y`) VALUES (uuid(),'DUMMY-JAKARTA UTARA 2','DUMMY-JAKARTA UATARA 1','440110','-6.131207','106.785681');
INSERT INTO `kelurahan`( `nama_kelurahan`, `alamat`, `kode_pos`, `kordinat_x`, `kordinat_y`) VALUES (uuid(),'DUMMY-JAKARTA UTARA 3','DUMMY-JAKARTA UATARA 1','440120','-6.141207','106.785681');
INSERT INTO `kelurahan`( `nama_kelurahan`, `alamat`, `kode_pos`, `kordinat_x`, `kordinat_y`) VALUES (uuid(),'DUMMY-JAKARTA UTARA 4','DUMMY-JAKARTA UATARA 1','440130','-6.151207','106.785681');
INSERT INTO `kelurahan`( `nama_kelurahan`, `alamat`, `kode_pos`, `kordinat_x`, `kordinat_y`) VALUES (uuid(),'DUMMY-JAKARTA UTARA 5','DUMMY-JAKARTA UATARA 1','440140','-6.161207','106.785681');
INSERT INTO `kelurahan`( `nama_kelurahan`, `alamat`, `kode_pos`, `kordinat_x`, `kordinat_y`) VALUES (uuid(),'DUMMY-JAKARTA UTARA 6','DUMMY-JAKARTA UATARA 1','440150','-6.171207','106.785681');
INSERT INTO `kelurahan`( `nama_kelurahan`, `alamat`, `kode_pos`, `kordinat_x`, `kordinat_y`) VALUES (uuid(),'DUMMY-JAKARTA UTARA 7','DUMMY-JAKARTA UATARA 1','440160','-6.181207','106.785681');

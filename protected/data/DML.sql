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

CREATE TABLE DT_INDICATOR(
dt_id int NOT NULL AUTO_INCREMENT,
idc_id varchar(255) not null,
kel_id varchar(255) not null,
dt_value varchar(255) not null,
dt_periode varchar(6) not null,
dt_last_update datetime not null,
PRIMARY KEY(dt_id),
FOREIGN KEY (idc_id) REFERENCES INDICATOR(idc_id),
FOREIGN KEY (kel_id) REFERENCES KELURAHAN(kel_id)
)



CREATE TABLE USER(
user_id varchar(255) not null,
username varchar(255) not null,
password varchar(500) not null,
level varchar(50) not null,
last_update date,
PRIMARY KEY (user_id));

CREATE TABLE CATEGORY(
ctg_id varchar(255) not null,
ctg_nama varchar(255) not null,
ctg_last_update datetime,
PRIMARY KEY (ctg_id));




<!-- insert user kelurahan -->
INSERT INTO jakut.`user` (user_id, username, password, `level`, last_update, privilege, email, no_hp) 
select uuid(), concat('kel_',lower(replace(kel_nama,' ','_'))),md5(lower(concat('kesos',replace(kel_nama,' ','_')))), 'kelurahan', now(), kel_id, 'kel_nama@goverment.go.id', ''
from kelurahan
order by kel_nama 



<!-- insert user Kecamatan -->
INSERT INTO jakut.`user` (user_id, username, password, `level`, last_update, privilege, email, no_hp) 
select uuid(), concat('kec_',lower(replace(kec_nama,' ','_'))) as username ,md5(lower(concat('kesos',replace(kec_nama,' ','_')))) as password, 'kecamatan', now(), kec_id, 'kec_nama@goverment.go.id', '021-222xxx'
from kecamatan
order by kec_nama 





INSERT INTO `kelurahan`( `nama_kelurahan`, `alamat`, `kode_pos`, `kordinat_x`, `kordinat_y`) VALUES (uuid(),'DUMMY-JAKARTA UTARA 1','DUMMY-JAKARTA UATARA 1','440100','-6.121207','106.785681');
INSERT INTO `kelurahan`( `nama_kelurahan`, `alamat`, `kode_pos`, `kordinat_x`, `kordinat_y`) VALUES (uuid(),'DUMMY-JAKARTA UTARA 2','DUMMY-JAKARTA UATARA 1','440110','-6.131207','106.785681');
INSERT INTO `kelurahan`( `nama_kelurahan`, `alamat`, `kode_pos`, `kordinat_x`, `kordinat_y`) VALUES (uuid(),'DUMMY-JAKARTA UTARA 3','DUMMY-JAKARTA UATARA 1','440120','-6.141207','106.785681');
INSERT INTO `kelurahan`( `nama_kelurahan`, `alamat`, `kode_pos`, `kordinat_x`, `kordinat_y`) VALUES (uuid(),'DUMMY-JAKARTA UTARA 4','DUMMY-JAKARTA UATARA 1','440130','-6.151207','106.785681');
INSERT INTO `kelurahan`( `nama_kelurahan`, `alamat`, `kode_pos`, `kordinat_x`, `kordinat_y`) VALUES (uuid(),'DUMMY-JAKARTA UTARA 5','DUMMY-JAKARTA UATARA 1','440140','-6.161207','106.785681');
INSERT INTO `kelurahan`( `nama_kelurahan`, `alamat`, `kode_pos`, `kordinat_x`, `kordinat_y`) VALUES (uuid(),'DUMMY-JAKARTA UTARA 6','DUMMY-JAKARTA UATARA 1','440150','-6.171207','106.785681');
INSERT INTO `kelurahan`( `nama_kelurahan`, `alamat`, `kode_pos`, `kordinat_x`, `kordinat_y`) VALUES (uuid(),'DUMMY-JAKARTA UTARA 7','DUMMY-JAKARTA UATARA 1','440160','-6.181207','106.785681');


 IP Address 185.28.20.22
Username u430336273 
Password = CT84e0npbFroNcOBRu
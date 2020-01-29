drop database if exists dbAutoPower;
create database dbAutoPower;
use dbAutoPower;

create table marque 
( 
	marqNum int(2) not null,
	marqNom varchar(60),
	primary key (marqNum)
);

create table type_vehi
(
	typeVehi int(2) not null,
	typeLib varchar(60),
	primary key (typeVehi)	
);

create table carburant
(
	carbuCode int(2) not null,
	carbuType varchar(60),
	primary key (carbuCode)
);

create table vehicule 
(
	vNum int(4) not null,
	vImmatriculation varchar(40) not null,
	vDateImmatriculation date not null,
	vKmCpt int(8) not null,
	vPrixPro int(9) not null,
	marqNum int(2) not null,
	vMod varchar(60) not null,
	typeVehi int(2) not null,
	carbuCode int(2) not null,
	vDateAjout date not null,
	vDesc varchar(255),
	vImg varchar(512),
	primary key (vNum),
	foreign key (marqNum) references marque(marqNum),
	foreign key (typeVehi) references type_vehi(typeVehi),
	foreign key (carbuCode) references carburant(carbuCode)
);

create table utilisateur
(
	uID int(3) not null AUTO_INCREMENT,
	uLogin varchar(30) not null,
	uMDP varchar(100) not null,
	uPrenom varchar(30) not null,
	uNom varchar(30) not null,
	uAddr varchar(100) not null,
	uVille varchar(100) not null,
	uCP int(5) not null,
	uDepart varchar(100) not null,
	uConc int(1) not null,
	uAdmin int(1) default 0,
	uActif boolean default false,
	uTel varchar(50) not null,
	primary key (uID)
);

create table client 
(
	uID int(3) not null AUTO_INCREMENT,
	cPrenom varchar(20) not null,
	primary key (cPrenom),
	foreign key (uID) references utilisateur(uID)
);

create table annonce 
(
	aNum int(3),
	aNom varchar(40) not null,
	vNum int(4) not null,
	uID int(3) not null AUTO_INCREMENT,
	primary key (aNum),
	foreign key (vNum) references vehicule(vnum),
	foreign key (uID) references utilisateur(uID)
);

create table concessionnaire
 (
 	uID int(3) not null AUTO_INCREMENT,
	concSiret int(5) not null,
	concRaisSoc varchar(60),
	primary key (concSiret),
	foreign key (uID) references utilisateur(uID)
);

create table contrat 
(
	contNum int(3) not null,
	contDateDepPrev date not null,
	contDateDepReelle date,
	contDateRetPrev date not null,
	contDateRetReelle date,
	contKmDep int(2) not null,
	contKmRet int(2),
	contDate date,
	contMontantAccompte int(2),
	primary key (contNum)
	
);

create table facture 
(
	facNum int not null,
	facDate date,
	facTotal int(2),
	contNum int(3) not null,
	primary key (facNum),
	foreign key (contNum) references contrat(contNum)
);

ALTER TABLE UTILISATEUR AUTO_INCREMENT = 0;

INSERT INTO marque
VALUES (0,"peugeot"),
(1,"renault"),
(2,"opel"),
(3,"citroen"),
(4,"volkswagen"),
(5,"mercedes"),
(6,"nissan"),
(7,"audi"),
(8,"bmw"),
(9,"ford"),
(10,"toyota"),
(11,"fiat"),
(12,"autre");

INSERT INTO carburant 
VALUES (0,"biodiesel"),
(1,"bioethanol"),
(2,"algocarburant"),
(3,"biogaz"),
(4,"lpg"),
(5,"e5"),
(6,"e10"),
(7,"e85"),
(8,"b7"),
(9,"b10"),
(10,"xtl"),
(11,"h2"),
(12,"gnc"),
(13,"gnl");

INSERT INTO type_vehi
VALUES (0,"berline"),
(1,"coupe"),
(2,"familiale"),
(3,"cabriolet"),
(4,"roadster"),
(5,"pickup"),
(6,"4x4"),
(7,"VUS"),
(8,"multiseg"),
(9,"minivan"),
(10,"sport");

INSERT INTO UTILISATEUR
VALUES (0, "admin@gmail.com", "$2y$10$9SKsqzjS8NMTiprHMjDDju7DX4vhaaoJRmnRz1rI7dbeCkmzOsvRq","admin","admin","admin","admin",11111,"admin",1,1,TRUE,"06 66 66 66 66");

/* MDP Admin : "admin" */

INSERT INTO concessionnaire (concSiret, concRaisSoc)
VALUES (1,"a");

DROP TRIGGER IF EXISTS vDateAj;
DELIMITER //

CREATE trigger vDateAj

BEFORE INSERT ON vehicule 
FOR EACH ROW
BEGIN 
	SET new.vDateAjout = curdate();
END //
DELIMITER ;

/*					*/

DROP TRIGGER IF EXISTS verifDateImm;
DELIMITER //

CREATE trigger verifDateImm

BEFORE INSERT ON vehicule 
FOR EACH ROW
BEGIN
	IF new.vDateImmatriculation > curdate() 
	THEN
	SET new.vDateImmatriculation = curdate();
	END IF;	
END //
DELIMITER ;
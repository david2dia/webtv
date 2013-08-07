DROP TABLE IF EXISTS pages CASCADE;
DROP TABLE IF EXISTS plannings CASCADE;
DROP TABLE IF EXISTS types CASCADE;
DROP TABLE IF EXISTS chaines CASCADE;
DROP TABLE IF EXISTS groupes CASCADE;
DROP TABLE IF EXISTS responsables CASCADE;
DROP TABLE IF EXISTS ci_sessions CASCADE;


CREATE TABLE ci_sessions (
	session_id      varchar(40)    	DEFAULT '0' NOT NULL,
	ip_address      varchar(16)    	DEFAULT '0' NOT NULL,
	user_agent      varchar(120)   	NOT NULL,
	last_activity   int        		DEFAULT 0 NOT NULL,
	user_data       text           	NOT NULL,

	PRIMARY KEY (session_id)
);

CREATE TABLE groupes (
	idgroupe		serial,
	nom 			text 	NOT NULL,
	parent			integer,
	description		text,
	logo			text,

	PRIMARY KEY (idgroupe),
	FOREIGN KEY (parent) REFERENCES groupes(idgroupe)
);

CREATE TABLE chaines (
	idchaine		serial,
	nom 			text 		NOT NULL,
	idgroupe 		integer 	NOT NULL,
	description		text,
	logo			text,
	responsable		text,
	responsablemail	text,
	activelogo 		boolean 	NOT NULL DEFAULT false,
	activeband 		boolean 	NOT NULL DEFAULT false,

	PRIMARY KEY (idchaine),
	FOREIGN KEY (idgroupe) REFERENCES groupes(idgroupe)
);

CREATE TABLE types (
	idtype  		serial,
	genre 			text 	NOT NULL,
	label 			text 	NOT NULL,

	PRIMARY KEY (idtype)
);

CREATE TABLE plannings (
	idplanning  	serial,
	datedebut 		Date 		DEFAULT '2012-12-30' NOT NULL,
	datefin 		Date 		DEFAULT '9999-12-30' NOT NULL,
	timedebut 		time 		DEFAULT '00:00:00' NOT NULL,
	timefin 		time 		DEFAULT '23:59:59' NOT NULL,
	hebdo 			text 		DEFAULT '1;2;3;4;5;6;7',

	PRIMARY KEY (idplanning)
);

CREATE TABLE pages (
	idpage  		serial,
	titre			text		NOT NULL,
	url 			text 		NOT NULL,
	temps			integer 	NOT NULL,
	idtype			integer 	NOT NULL,
	idchaine		integer 	NOT NULL,
	ordre			integer 	NOT NULL,
	idplanning 		integer 	DEFAULT '1' NOT NULL,
	public 			bool 		DEFAULT false NOT NULL,
	auteur			text		NOT NULL,
	datemodif		Date		NOT NULL,
	dateenr			Date		NOT NULL,

	PRIMARY KEY (idPage),
	FOREIGN KEY (idType) REFERENCES Types(idType),
	FOREIGN KEY (idChaine) REFERENCES Chaines(idChaine),
	FOREIGN KEY (idplanning) REFERENCES plannings(idplanning) ON DELETE SET DEFAULT
);

CREATE TABLE bandeau
(
  idbandeau serial NOT NULL,
  idchaine integer,
  titremessage text,
  message text,
  ordre integer,
  PRIMARY KEY (idbandeau),
  FOREIGN KEY (idchaine) REFERENCES chaines (idchaine)
);

CREATE TABLE Logs (
	idlogs  		serial,
	action			text 		NOT NULL,
	type			text 		NOT NULL,
	detail			text 		NOT NULL,
	feduid			text		NOT NULL,
	nom 			text 		NOT NULL,
	mail			text 		NOT NULL,
	date			Date		NOT NULL,

	PRIMARY KEY (idlogs)
);

--
-- Contenu des tables
--

INSERT INTO groupes (idgroupe, nom) VALUES
(DEFAULT, 'Test');

INSERT INTO chaines (idchaine, nom, idgroupe, description, logo, responsable, responsablemail) VALUES
(DEFAULT, 'Test', '1','', '', 'Responsable', 'mailde@oxylane.com');


INSERT INTO types (idtype, genre, label) VALUES
(DEFAULT, 'frame', 'Site Web'),
(DEFAULT, 'frame', 'Google Docs'),
(DEFAULT, 'frame', 'YouTube'),
(DEFAULT, 'frame', 'Youku');

INSERT INTO plannings (idplanning, datedebut, datefin, timedebut, timefin, hebdo) VALUES
(1, DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT);

START TRANSACTION;
DROP DATABASE IF EXISTS cts;
CREATE DATABASE cts;
USE cts;
-- ------- CREATING ADMINS ------- --
CREATE TABLE Admin (
	nomAdmin VARCHAR(255) NOT NULL,
	prenomAdmin VARCHAR(255) NOT NULL,
	dateCreationAdmin DATE,
	mailAdmin VARCHAR(64) NOT NULL,
	mdpAdmin VARCHAR(64) NOT NULL,
	apiKey BINARY(32),
	expirationApiKey DATE,
	CONSTRAINT pk_admin PRIMARY KEY (mailAdmin)
);
-- ------- CREATING TABLES ------- --
CREATE TABLE Contact (
	codeContact INT NOT NULL AUTO_INCREMENT,
	nomContact VARCHAR(255) NOT NULL,
	prenomContact VARCHAR(255) NOT NULL,
	dateNaissanceContact DATE NOT NULL,
	codePays INT NOT NULL,
	CONSTRAINT pk_contact PRIMARY KEY (codeContact)
);
CREATE TABLE Pays (
	codePays INT NOT NULL AUTO_INCREMENT,
	libellePays VARCHAR(255) NOT NULL,
	CONSTRAINT pk_pays PRIMARY KEY (codePays)
);
CREATE TABLE Cible (
	codeCible INT NOT NULL AUTO_INCREMENT,
	nomCible VARCHAR(255) NOT NULL,
	prenomCible VARCHAR(255) NOT NULL,
	dateNaissanceCible DATE NOT NULL,
	codePays INT NOT NULL,
	CONSTRAINT pk_cible PRIMARY KEY (codeCible)
);
CREATE TABLE Agent (
	codeAgent INT NOT NULL AUTO_INCREMENT,
	nomAgent VARCHAR(255) NOT NULL,
	prenomAgent VARCHAR(255) NOT NULL,
	dateNaissanceAgent DATE NOT NULL,
	codePays INT NOT NULL,
	CONSTRAINT pk_agent PRIMARY KEY (codeAgent)
);
CREATE TABLE Specialite (
	codeSpecialite INT NOT NULL AUTO_INCREMENT,
	libelleSpecialite VARCHAR(127) NOT NULL,
	codeTypeMission INT,
	descSpecialite TEXT,
	CONSTRAINT pk_specialite PRIMARY KEY (codeSpecialite)
);
CREATE TABLE Mission (
	codeMission INT NOT NULL AUTO_INCREMENT,
	titreMission VARCHAR(127) NOT NULL,
	descriptionMission TEXT,
	dateDebut DATE,
	dateFin DATE,
	codeStatutMission INT,
	codeTypeMission INT,
	codeSpecialite INT,
	CONSTRAINT pk_mission PRIMARY KEY (codeMission)
);
CREATE TABLE Statut (
	codeStatutMission INT NOT NULL AUTO_INCREMENT,
	libelleStatutMission VARCHAR(127) NOT NULL,
	CONSTRAINT pk_statut PRIMARY KEY (codeStatutMission)
);
CREATE TABLE TypeMission (
	codeTypeMission INT NOT NULL AUTO_INCREMENT,
	libelleTypeMission VARCHAR(127) NOT NULL,
	descTypeMission TEXT,
	CONSTRAINT pk_typemission PRIMARY KEY (codeTypeMission)
);
CREATE TABLE Planque (
	codePlanque INT NOT NULL AUTO_INCREMENT,
	adressePlanque VARCHAR(255) NOT NULL,
	codePays INT NOT NULL,
	codeTypePlanque INT NOT NULL,
	CONSTRAINT pk_planque PRIMARY KEY (codePlanque)
);
CREATE TABLE TypePlanque (
	codeTypePlanque INT NOT NULL AUTO_INCREMENT,
	libelleTypePlanque VARCHAR(127) NOT NULL,
	descTypePlanque TEXT,
	CONSTRAINT pk_typeplanque PRIMARY KEY (codeTypePlanque)
);
CREATE TABLE Aide (
	codeMission INT NOT NULL,
	codeContact INT NOT NULL,
	CONSTRAINT pk_aide PRIMARY KEY (codeMission, codeContact)
);
CREATE TABLE Visee (
	codeMission INT NOT NULL,
	codeCible INT NOT NULL,
	CONSTRAINT pk_visee PRIMARY KEY (codeMission, codeCible)
);
CREATE TABLE Specialisation (
	codeSpecialite INT NOT NULL,
	codeAgent INT NOT NULL,
	CONSTRAINT pk_specialisation PRIMARY KEY (codeSpecialite, codeAgent)
);
CREATE TABLE Execution (
	codeMission INT NOT NULL,
	codeAgent INT NOT NULL,
	CONSTRAINT pk_execution PRIMARY KEY (codeMission, codeAgent)
);
CREATE TABLE Abri (
	codeMission INT NOT NULL,
	codePlanque INT NOT NULL,
	CONSTRAINT pk_abri PRIMARY KEY (codeMission, codePlanque)
);
-- ------- ADDING FOREIGN KEYS ------- --
-- contact
ALTER TABLE Contact
ADD CONSTRAINT fk_contact_pays FOREIGN KEY (codePays) REFERENCES Pays (codePays) ON DELETE CASCADE ON UPDATE CASCADE;
-- cible
ALTER TABLE Cible
ADD CONSTRAINT fk_cible_pays FOREIGN KEY (codePays) REFERENCES Pays (codePays) ON DELETE CASCADE ON UPDATE CASCADE;
-- agent
ALTER TABLE Agent
ADD CONSTRAINT fk_agent_pays FOREIGN KEY (codePays) REFERENCES Pays (codePays) ON DELETE CASCADE ON UPDATE CASCADE;
-- mission
ALTER TABLE Mission
ADD CONSTRAINT fk_mission_statut FOREIGN KEY (codeStatutMission) REFERENCES Statut (codeStatutMission) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE Mission
ADD CONSTRAINT fk_mission_typemission FOREIGN KEY (codeTypeMission) REFERENCES TypeMission (codeTypeMission) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE Mission
ADD CONSTRAINT fk_mission_specialite FOREIGN KEY (codeSpecialite) REFERENCES Specialite (codeSpecialite) ON DELETE CASCADE ON UPDATE CASCADE;
-- planque
ALTER TABLE Planque
ADD CONSTRAINT fk_planque_pays FOREIGN KEY (codePays) REFERENCES Pays (codePays) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE Planque
ADD CONSTRAINT fk_planque_typeplanque FOREIGN KEY (codeTypePlanque) REFERENCES TypePlanque (codeTypePlanque) ON DELETE CASCADE ON UPDATE CASCADE;
-- specialité
ALTER TABLE Specialite
ADD CONSTRAINT fk_specialite_typemission FOREIGN KEY (codeTypeMission) REFERENCES TypeMission (codeTypeMission) ON DELETE CASCADE ON UPDATE CASCADE;
-- aide
ALTER TABLE Aide
ADD CONSTRAINT fk_aide_mission FOREIGN KEY (codeMission) REFERENCES Mission (codeMission);
ALTER TABLE Aide
ADD CONSTRAINT fk_aide_contact FOREIGN KEY (codeContact) REFERENCES Contact (codeContact);
-- visee
ALTER TABLE Visee
ADD CONSTRAINT fk_visee_mission FOREIGN KEY (codeMission) REFERENCES Mission (codeMission) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE Visee
ADD CONSTRAINT fk_visee_cible FOREIGN KEY (codeCible) REFERENCES Cible (codeCible) ON DELETE CASCADE ON UPDATE CASCADE;
-- specialisation
ALTER TABLE Specialisation
ADD CONSTRAINT fk_specialisation_specialite FOREIGN KEY (codeSpecialite) REFERENCES Specialite (codeSpecialite) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE Specialisation
ADD CONSTRAINT fk_specialisation_agent FOREIGN KEY (codeAgent) REFERENCES Agent (codeAgent) ON DELETE CASCADE ON UPDATE CASCADE;
-- execution
ALTER TABLE Execution
ADD CONSTRAINT fk_execution_mission FOREIGN KEY (codeMission) REFERENCES Mission (codeMission) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE Execution
ADD CONSTRAINT fk_execution_agent FOREIGN KEY (codeAgent) REFERENCES Agent (codeAgent) ON DELETE CASCADE ON UPDATE CASCADE;
-- abri
ALTER TABLE Abri
ADD CONSTRAINT fk_abri_mission FOREIGN KEY (codeMission) REFERENCES Mission (codeMission) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE Abri
ADD CONSTRAINT fk_abri_planque FOREIGN KEY (codePlanque) REFERENCES Planque (codePlanque) ON DELETE CASCADE ON UPDATE CASCADE;
-- pays
INSERT INTO Pays (libellePays)
VALUES ("Afghanistan"),
	("Albanie"),
	("Antarctique"),
	("Algérie"),
	("Samoa Américaines"),
	("Andorre"),
	("Angola"),
	("Antigua-et-Barbuda"),
	("Azerbaïdjan"),
	("Argentine"),
	("Australie"),
	("Autriche"),
	("Bahamas"),
	("Bahreïn"),
	("Bangladesh"),
	("Arménie"),
	("Barbade"),
	("Belgique"),
	("Bermudes"),
	("Bhoutan"),
	("Bolivie"),
	("Bosnie-Herzégovine"),
	("Botswana"),
	("Île Bouvet"),
	("Brésil"),
	("Belize"),
	("Territoire Britannique de l'Océan Indien"),
	("Îles Salomon"),
	("Îles Vierges Britanniques"),
	("Brunéi Darussalam"),
	("Bulgarie"),
	("Myanmar"),
	("Burundi"),
	("Bélarus"),
	("Cambodge"),
	("Cameroun"),
	("Canada"),
	("Cap-vert"),
	("Îles Caïmanes"),
	("République Centrafricaine"),
	("Sri Lanka"),
	("Tchad"),
	("Chili"),
	("Chine"),
	("Taïwan"),
	("Île Christmas"),
	("Colombie"),
	("Comores"),
	("Mayotte"),
	("République du Congo"),
	("République Démocratique du Congo"),
	("Îles Cook"),
	("Costa Rica"),
	("Croatie"),
	("Cuba"),
	("Chypre"),
	("République Tchèque"),
	("Bénin"),
	("Danemark"),
	("Dominique"),
	("République Dominicaine"),
	("Équateur"),
	("El Salvador"),
	("Guinée Équatoriale"),
	("Éthiopie"),
	("Érythrée"),
	("Estonie"),
	("Îles Féroé"),
	("Géorgie du Sud et les Îles Sandwich du Sud"),
	("Fidji"),
	("Finlande"),
	("Îles Åland"),
	("France"),
	("Guyane Française"),
	("Polynésie Française"),
	("Terres Australes Françaises"),
	("Djibouti"),
	("Gabon"),
	("Géorgie"),
	("Gambie"),
	("Territoire Palestinien Occupé"),
	("Allemagne"),
	("Ghana"),
	("Gibraltar"),
	("Kiribati"),
	("Grèce"),
	("Groenland"),
	("Grenade"),
	("Guadeloupe"),
	("Guam"),
	("Guatemala"),
	("Guinée"),
	("Guyana"),
	("Haïti"),
	("Îles Heard et Mcdonald"),
	("Honduras"),
	("Hong-Kong"),
	("Hongrie"),
	("Islande"),
	("Inde"),
	("Indonésie"),
	("République Islamique d'Iran"),
	("Iraq"),
	("Irlande"),
	("Israël"),
	("Italie"),
	("Côte d'Ivoire"),
	("Jamaïque"),
	("Japon"),
	("Kazakhstan"),
	("Jordanie"),
	("Kenya"),
	("République Populaire Démocratique de Corée"),
	("République de Corée"),
	("Koweït"),
	("Kirghizistan"),
	("République Démocratique Populaire Lao"),
	("Liban"),
	("Lesotho"),
	("Lettonie"),
	("Libéria"),
	("Jamahiriya Arabe Libyenne"),
	("Liechtenstein"),
	("Lituanie"),
	("Luxembourg"),
	("Macao"),
	("Madagascar"),
	("Malawi"),
	("Malaisie"),
	("Maldives"),
	("Mali"),
	("Malte"),
	("Martinique"),
	("Mauritanie"),
	("Maurice"),
	("Mexique"),
	("Monaco"),
	("Mongolie"),
	("République de Moldova"),
	("Montserrat"),
	("Maroc"),
	("Mozambique"),
	("Oman"),
	("Namibie"),
	("Nauru"),
	("Népal"),
	("Pays-Bas"),
	("Antilles Néerlandaises"),
	("Aruba"),
	("Nouvelle-Calédonie"),
	("Vanuatu"),
	("Nouvelle-Zélande"),
	("Nicaragua"),
	("Niger"),
	("Nigéria"),
	("Niué"),
	("Île Norfolk"),
	("Norvège"),
	("Îles Mariannes du Nord"),
	("Îles Mineures Éloignées des États-Unis"),
	("États Fédérés de Micronésie"),
	("Îles Marshall"),
	("Palaos"),
	("Pakistan"),
	("Panama"),
	("Papouasie-Nouvelle-Guinée"),
	("Paraguay"),
	("Pérou"),
	("Philippines"),
	("Pitcairn"),
	("Pologne"),
	("Portugal"),
	("Guinée-Bissau"),
	("Timor-Leste"),
	("Porto Rico"),
	("Qatar"),
	("Réunion"),
	("Roumanie"),
	("Fédération de Russie"),
	("Rwanda"),
	("Sainte-Hélène"),
	("Saint-Kitts-et-Nevis"),
	("Anguilla"),
	("Sainte-Lucie"),
	("Saint-Pierre-et-Miquelon"),
	("Saint-Vincent-et-les Grenadines"),
	("Saint-Marin"),
	("Sao Tomé-et-Principe"),
	("Arabie Saoudite"),
	("Sénégal"),
	("Seychelles"),
	("Sierra Leone"),
	("Singapour"),
	("Slovaquie"),
	("Viet Nam"),
	("Slovénie"),
	("Somalie"),
	("Afrique du Sud"),
	("Zimbabwe"),
	("Espagne"),
	("Sahara Occidental"),
	("Soudan"),
	("Suriname"),
	("Svalbard et Île Jan Mayen"),
	("Swaziland"),
	("Suède"),
	("Suisse"),
	("République Arabe Syrienne"),
	("Tadjikistan"),
	("Thaïlande"),
	("Togo"),
	("Tokelau"),
	("Tonga"),
	("Trinité-et-Tobago"),
	("Émirats Arabes Unis"),
	("Tunisie"),
	("Turquie"),
	("Turkménistan"),
	("Îles Turks et Caïques"),
	("Tuvalu"),
	("Ouganda"),
	("Ukraine"),
	("L'ex-République Yougoslave de Macédoine"),
	("Égypte"),
	("Royaume-Uni"),
	("Île de Man"),
	("République-Unie de Tanzanie"),
	("États-Unis"),
	("Îles Vierges des États-Unis"),
	("Burkina Faso"),
	("Uruguay"),
	("Ouzbékistan"),
	("Venezuela"),
	("Wallis et Futuna"),
	("Samoa"),
	("Yémen"),
	("Serbie-et-Monténégro"),
	("Zambie");
-- statut mission
INSERT INTO Statut (libelleStatutMission)
VALUES ("En attente"),
	("En cours"),
	("Échouée"),
	("Réussie");
-- type mission
INSERT INTO TypeMission (libelleTypeMission)
VALUES ("Surveillance"),
	("Assassinat"),
	("Infiltration"),
	("Sabotage"),
	("Contre-espionnage"),
	("Exfiltration"),
	("Kidnapping");
-- type planque
INSERT INTO TypePlanque (libelleTypePlanque)
VALUES ("Résidence"),
	("Bunker"),
	("Mobile"),
	("Placard");
-- spécialité
INSERT INTO Specialite (libelleSpecialite, codeTypeMission)
VALUES ("Armes blanches", 1),
	("Armes à feu", 2),
	("Explosifs", 3),
	("Corps à corps", 4),
	("Poisons", 5),
	("Chimie", 6),
	("Fabrication", 7),
	("Hacking", 1),
	("Cambriolage", 2),
	("Déguisement", 3),
	("Séduction", 4),
	("Interrogatoire", 5),
	("Conduite d'un véhicule", 6),
	("Traque", 7),
	("Analyse", 1),
	("Direction", 2);
-- ----- DONNÉES ALÉATOIRES ----- --
-- contact
INSERT INTO Contact (
		prenomContact,
		nomContact,
		dateNaissanceContact,
		codePays
	)
VALUES (
		"Amanda",
		"Wiitala",
		STR_TO_DATE("1987-01-19", "%Y-%m-%d"),
		76
	),
	(
		"Alban",
		"Marie",
		STR_TO_DATE("1946-08-01", "%Y-%m-%d"),
		155
	),
	(
		"Elijah",
		"Williams",
		STR_TO_DATE("1990-02-23", "%Y-%m-%d"),
		42
	),
	(
		"Rolf",
		"Hveding",
		STR_TO_DATE("1991-02-23", "%Y-%m-%d"),
		147
	),
	(
		"Chrisander",
		"Sigvartsen",
		STR_TO_DATE("1956-08-10", "%Y-%m-%d"),
		119
	),
	(
		"Aloys",
		"Van de Craats",
		STR_TO_DATE("1988-07-02", "%Y-%m-%d"),
		133
	),
	(
		"Katherine",
		"Holt",
		STR_TO_DATE("1987-11-18", "%Y-%m-%d"),
		211
	),
	(
		"Ortrud",
		"Rebmann",
		STR_TO_DATE("1988-11-09", "%Y-%m-%d"),
		200
	),
	(
		"Ariana",
		"Walker",
		STR_TO_DATE("1962-11-09", "%Y-%m-%d"),
		188
	),
	(
		"Liske",
		"Gerding",
		STR_TO_DATE("1974-11-21", "%Y-%m-%d"),
		194
	),
	(
		"Babür",
		"Akar",
		STR_TO_DATE("1971-11-24", "%Y-%m-%d"),
		84
	),
	(
		"Gilbert",
		"Scott",
		STR_TO_DATE("1990-09-06", "%Y-%m-%d"),
		149
	),
	(
		"Mariano",
		"Ibañez",
		STR_TO_DATE("1954-10-06", "%Y-%m-%d"),
		148
	),
	(
		"Victoria",
		"Christensen",
		STR_TO_DATE("1961-08-13", "%Y-%m-%d"),
		178
	),
	(
		"Clarisse",
		"Nguyen",
		STR_TO_DATE("1992-07-13", "%Y-%m-%d"),
		28
	);
-- cible
INSERT INTO Cible (
		prenomCible,
		nomCible,
		dateNaissanceCible,
		codePays
	)
VALUES (
		"Nico",
		"Lucas",
		STR_TO_DATE("1980-02-24", "%Y-%m-%d"),
		165
	),
	(
		"Wade",
		"Nguyen",
		STR_TO_DATE("1991-12-02", "%Y-%m-%d"),
		163
	),
	(
		"Katherine",
		"Watkins",
		STR_TO_DATE("1945-01-16", "%Y-%m-%d"),
		84
	),
	(
		"Amelia",
		"Brown",
		STR_TO_DATE("1996-12-20", "%Y-%m-%d"),
		12
	),
	(
		"Santelmo",
		"Teixeira",
		STR_TO_DATE("1963-03-16", "%Y-%m-%d"),
		153
	),
	(
		"Emre",
		"Keçeci",
		STR_TO_DATE("1948-11-14", "%Y-%m-%d"),
		47
	),
	(
		"Russell",
		"Carr",
		STR_TO_DATE("1997-07-17", "%Y-%m-%d"),
		56
	),
	(
		"Hasan",
		"Weiland",
		STR_TO_DATE("1995-07-18", "%Y-%m-%d"),
		169
	),
	(
		"Tibor",
		"Dittmann",
		STR_TO_DATE("1990-03-27", "%Y-%m-%d"),
		95
	),
	(
		"Ticira",
		"Pires",
		STR_TO_DATE("1973-09-24", "%Y-%m-%d"),
		141
	),
	(
		"Nevaeh",
		"Thomas",
		STR_TO_DATE("1977-02-02", "%Y-%m-%d"),
		12
	),
	(
		"Clément",
		"Renaud",
		STR_TO_DATE("1987-12-21", "%Y-%m-%d"),
		147
	),
	(
		"Aci",
		"Ferreira",
		STR_TO_DATE("1948-06-01", "%Y-%m-%d"),
		92
	),
	(
		"Silvio",
		"Lucas",
		STR_TO_DATE("1977-08-12", "%Y-%m-%d"),
		75
	),
	(
		"Victoria",
		"Simpson",
		STR_TO_DATE("1954-10-09", "%Y-%m-%d"),
		59
	);
-- agent
INSERT INTO Agent (
		prenomAgent,
		nomAgent,
		dateNaissanceAgent,
		codePays
	)
VALUES (
		"Alicia",
		"Macdonald",
		STR_TO_DATE("1995-11-02", "%Y-%m-%d"),
		96
	),
	(
		"Maurizio",
		"Mathieu",
		STR_TO_DATE("1951-10-10", "%Y-%m-%d"),
		160
	),
	(
		"Sari",
		"Wilmsen",
		STR_TO_DATE("1949-07-24", "%Y-%m-%d"),
		162
	),
	(
		"Topias",
		"Haapala",
		STR_TO_DATE("1978-03-13", "%Y-%m-%d"),
		198
	),
	(
		"Elma",
		"Frydenberg",
		STR_TO_DATE("1998-05-31", "%Y-%m-%d"),
		71
	),
	(
		"Ege",
		"Oraloglu",
		STR_TO_DATE("1955-03-23", "%Y-%m-%d"),
		192
	),
	(
		"Joel",
		"Kivela",
		STR_TO_DATE("1972-09-25", "%Y-%m-%d"),
		154
	),
	(
		"Eira",
		"Morken",
		STR_TO_DATE("1965-12-05", "%Y-%m-%d"),
		51
	),
	(
		"Eeli",
		"Wuori",
		STR_TO_DATE("1946-02-08", "%Y-%m-%d"),
		104
	),
	(
		"Rolf",
		"Dragland",
		STR_TO_DATE("1986-10-04", "%Y-%m-%d"),
		27
	),
	(
		"Chester",
		"Nichols",
		STR_TO_DATE("1977-04-05", "%Y-%m-%d"),
		115
	),
	(
		"Ugo",
		"Dumas",
		STR_TO_DATE("1979-01-09", "%Y-%m-%d"),
		154
	),
	(
		"Delphine",
		"Slawa",
		STR_TO_DATE("1995-08-29", "%Y-%m-%d"),
		116
	),
	(
		"Jade",
		"Roy",
		STR_TO_DATE("1978-09-06", "%Y-%m-%d"),
		18
	),
	(
		"Joel",
		"Armstrong",
		STR_TO_DATE("1971-06-26", "%Y-%m-%d"),
		35
	),
	(
		"Susie",
		"Silveira",
		STR_TO_DATE("1973-03-26", "%Y-%m-%d"),
		212
	);
-- planque
INSERT INTO Planque (adressePlanque, codePays, codeTypePlanque)
VALUES ("6728 22nd Ave, J1G 4U9 Springfield", 1, 1),
	(
		"8771 Rua Santos Dumont , 82490 Itaquaquecetuba",
		3,
		2
	),
	(
		"2583 Beco dos Namorados, 54110 São Vicente",
		4,
		2
	),
	("4898 Rue de L'Abbé-Migne, 89649 Nantes", 8, 2),
	("1940 Dwars Nieuwstraat, 77107 Eethen", 11, 4),
	("5304 Mølletoften, 24150 Viby J.", 14, 1),
	("4376 Eichenweg, 38426 Leer", 12, 1),
	(
		"6176 Calle del Prado, 93423 Santa Cruz de Tenerife",
		15,
		4
	),
	("3811 Østgaards gate, 5869 Jortveit", 16, 4),
	("9674 Rue de Gerland, 52632 Dijon", 17, 4),
	(
		"6872 Fatih Sultan Mehmet Cd, 47879 Gaziantep",
		18,
		2
	),
	("3726 Belcampohof, 74958 Maarsbergen", 20, 3),
	(
		"2024 Rue Denfert-Rochereau, 4901 Rekingen (Ag)",
		25,
		3
	),
	("7197 Broadway, X5 7TA Ripon", 27, 4),
	(
		"4921 South Western Arterial, 17553 Whangarei",
		29,
		2
	),
	(
		"9559 Rua São José , 95960 Santana de Parnaíba",
		33,
		4
	),
	("4749 Otavalankatu, 54295 Lahti", 35, 4),
	(
		"9140 Nordenskiöldinkatu, 16177 Enontekiö",
		36,
		3
	),
	("6790 Botany Road, 30687 Whangarei", 34, 3),
	("189 Lessingstraße, 30597 Wiehl", 40, 1),
	(
		"3612 Esplanade du 9 Novembre 1989, 61812 Amiens",
		43,
		1
	),
	("215 Place de L'Europe, 53101 Mulhouse", 48, 4),
	("3098 Cours Charlemagne, 63796 Pau", 50, 4),
	(
		"4084 Tulpenweg, 98143 Breisgau-Hochschwarzwald",
		55,
		2
	),
	("6819 Memorial Avenue, 51889 Whangarei", 57, 3),
	("7075 Jones Road, 59605 Edenderry", 60, 2),
	("6214 Atjehgouw, 48841 Oudenhoorn", 61, 4),
	("8689 Rua Dois, 81436 Franca", 62, 3),
	("9918 Skolevænget, 96624 Sundby", 64, 3),
	(
		"6369 Calle de Arturo Soria, 45504 Ciudad Real",
		68,
		3
	),
	("9407 White Swan Road, 49331 Masterton", 67, 4),
	("3036 Handelskade Noord, 22189 Barneveld", 72, 1),
	(
		"1581 Crawford Street, 72597 Christchurch",
		73,
		2
	),
	("4151 Coastal Highway, L7Q 7D7 Brockton", 74, 2),
	("1702 Komperwijkweg, 71493 Tonden", 84, 2),
	("1384 Talak Göktepe Cd, 75455 Gümüshane", 85, 3),
	(
		"3136 Rue de L'Abbé-Groult, 78070 Asnières-sur-Seine",
		86,
		1
	),
	("6879 Håndværkervej, 43690 Horsens", 87, 1),
	("3396 Arctic Way, W3A 3A0 Oakville", 88, 3),
	("7741 Rue Duquesne, 5368 Belfaux", 90, 2),
	("4344 The Drive, 35549 Carrigtwohill", 92, 3),
	("357 Ringstraße, 65805 Riedenburg", 89, 2),
	("2340 Kirchgasse, 99818 Gützkow", 99, 3),
	(
		"4592 Avenue de la Libération, 6016 Seegräben",
		102,
		4
	),
	("3480 Andersons Bay Road, 98819 Taupo", 107, 4),
	("1594 Eeuwselseweg, 45306 Onstwedde", 106, 2),
	("1921 Old Taupo Road, 17316 Greymouth", 108, 2),
	("8319 Avenida Brasil , 34734 Luziânia", 109, 4),
	("6481 Nelson Quay, 50135 Porirua", 119, 2),
	("2960 Highgate, 15878 Masterton", 124, 1),
	(
		"5749 Rue de L'Abbé-De-L'Épée, 5348 Bütschwil-Ganterschwil",
		123,
		3
	),
	("36 Taylor St, 57795 Chandler", 125, 1),
	(
		"9863 Queenstown Road, 56530 Palmerston North",
		128,
		4
	),
	(
		"7478 Rua Minas Gerais , 46920 Taboão da Serra",
		131,
		4
	),
	("4838 Mevlana Cd, 17337 Karabük", 142, 1),
	(
		"1877 Breslauer Straße, 44612 Herzberg am Harz",
		140,
		2
	),
	("9537 Kjølberggata, 5237 Odda", 150, 1),
	("3962 Necatibey Cd, 29301 Zonguldak", 163, 2),
	("9133 Rautatienkatu, 24158 Rusko", 161, 4),
	(
		"6102 Calle de Pedro Bosch, 99222 Barcelona",
		171,
		3
	),
	("3972 Rue de la Baleine, 9407 Tavannes", 175, 3),
	("699 Tevlingveien, 7430 Bryne", 177, 1),
	(
		"3559 Saint Aubyn Street, 94693 Greymouth",
		179,
		1
	),
	("1829 Symonds Street, 39934 Masterton", 178, 3),
	(
		"3323 Rue du Dauphiné, 4528 Chavannes-sur-Moudon",
		186,
		1
	),
	("7630 Fredrikinkatu, 55645 Lahti", 200, 3),
	(
		"2876 Rue du Cardinal-Gerlier, 44772 Champigny-sur-Marne",
		198,
		3
	),
	("9683 New Street, 87167 Roscrea", 204, 4),
	("3926 Friedhofstraße, 99054 Büdingen", 205, 3),
	("9782 Mill Road, I3 1NB Birmingham", 208, 2),
	(
		"5228 The Crescent, ZY1 4BU Wolverhampton",
		206,
		2
	),
	("5371 Rougsøvej, 47865 Aaborg Øst", 218, 2),
	("6337 Rue Abel-Ferry, 6634 Rümlingen", 216, 3),
	(
		"2752 Kapellenweg, 14716 Bad Blankenburg",
		219,
		3
	),
	(
		"8174 Waldstraße, 13001 Erlenbach am Main",
		220,
		3
	),
	("1358 Calle de Segovia, 11324 Orense", 221, 3),
	("3553 Bagdat Cd, 56584 Çankiri", 229, 3),
	("8166 Rue des Ecrivains, 13517 Mulhouse", 231, 2),
	("6532 Quai Charles-De-Gaulle, 1652 Gy", 238, 1);
-- spécialisation
INSERT INTO Specialisation (codeSpecialite, codeAgent)
VALUES (1, 1),
	(2, 2),
	(3, 3),
	(4, 4),
	(5, 5),
	(6, 6),
	(7, 7),
	(8, 8),
	(9, 9),
	(10, 10),
	(11, 11),
	(12, 12),
	(13, 13),
	(14, 14),
	(15, 15),
	(16, 16);
-- mission
INSERT INTO Mission (titreMission, descriptionMission, dateDebut, dateFin, codeStatutMission, codeTypeMission, codeSpecialite) VALUES
("Test", "Ceci est une mission test", "2020-01-01", "2021-01-01", 1, 1, 1);
INSERT INTO Visee (codeMission, codeCible) VALUES
(1, 4),
(1, 11);
INSERT INTO Abri (codeMission, codePlanque) VALUES
(1, 7);
INSERT INTO Execution (codeMission, codeAgent) VALUES
(1, 1);
COMMIT;
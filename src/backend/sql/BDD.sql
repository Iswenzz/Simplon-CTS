START TRANSACTION;
DROP DATABASE IF EXISTS cts;
CREATE DATABASE cts;
USE cts;
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
	libelleSpecialite VARCHAR(255) NOT NULL,
	CONSTRAINT pk_specialite PRIMARY KEY (codeSpecialite)
);
CREATE TABLE Mission (
	codeMission INT NOT NULL AUTO_INCREMENT,
	titreMission VARCHAR(255) NOT NULL,
	descriptionMission VARCHAR(255) NOT NULL,
	dateDebut DATE NOT NULL,
	dateFin DATE NOT NULL,
	codeStatutMission INT NOT NULL,
	codeTypeMission INT NOT NULL,
	codeSpecialite INT NOT NULL,
	CONSTRAINT pk_mission PRIMARY KEY (codeMission)
);
CREATE TABLE Statut (
	codeStatutMission INT NOT NULL AUTO_INCREMENT,
	libelleMission VARCHAR(255) NOT NULL,
	CONSTRAINT pk_statut PRIMARY KEY (codeStatutMission)
);
CREATE TABLE TypeMission (
	codeTypeMission INT NOT NULL AUTO_INCREMENT,
	libelleTypeMission VARCHAR(255) NOT NULL,
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
	libelleTypePlanque VARCHAR(255) NOT NULL,
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
ALTER TABLE Contact
ADD CONSTRAINT fk_contact_pays FOREIGN KEY (codePays) REFERENCES Pays (codePays);
ALTER TABLE Cible
ADD CONSTRAINT fk_cible_pays FOREIGN KEY (codePays) REFERENCES Pays (codePays);
ALTER TABLE Agent
ADD CONSTRAINT fk_agent_pays FOREIGN KEY (codePays) REFERENCES Pays (codePays);
ALTER TABLE Mission
ADD CONSTRAINT fk_mission_statut FOREIGN KEY (codeStatutMission) REFERENCES Statut (codeStatutMission);
ALTER TABLE Mission
ADD CONSTRAINT fk_mission_typemission FOREIGN KEY (codeTypeMission) REFERENCES TypeMission (codeTypeMission);
ALTER TABLE Mission
ADD CONSTRAINT fk_mission_specialite FOREIGN KEY (codeSpecialite) REFERENCES Specialite (codeSpecialite);
ALTER TABLE Planque
ADD CONSTRAINT fk_planque_pays FOREIGN KEY (codePays) REFERENCES Pays (codePays);
ALTER TABLE Planque
ADD CONSTRAINT fk_planque_typeplanque FOREIGN KEY (codeTypePlanque) REFERENCES TypePlanque (codeTypePlanque);
ALTER TABLE Aide
ADD CONSTRAINT fk_aide_mission FOREIGN KEY (codeMission) REFERENCES Mission (codeMission);
ALTER TABLE Aide
ADD CONSTRAINT fk_aide_contact FOREIGN KEY (codeContact) REFERENCES Contact (codeContact);
ALTER TABLE Visee
ADD CONSTRAINT fk_visee_mission FOREIGN KEY (codeMission) REFERENCES Mission (codeMission);
ALTER TABLE Visee
ADD CONSTRAINT fk_visee_cible FOREIGN KEY (codeCible) REFERENCES Cible (codeCible);
ALTER TABLE Specialisation
ADD CONSTRAINT fk_specialisation_specialite FOREIGN KEY (codeSpecialite) REFERENCES Specialite (codeSpecialite);
ALTER TABLE Specialisation
ADD CONSTRAINT fk_specialisation_agent FOREIGN KEY (codeAgent) REFERENCES Agent (codeAgent);
ALTER TABLE Execution
ADD CONSTRAINT fk_execution_mission FOREIGN KEY (codeMission) REFERENCES Mission (codeMission);
ALTER TABLE Execution
ADD CONSTRAINT fk_execution_agent FOREIGN KEY (codeAgent) REFERENCES Agent (codeAgent);
COMMIT;
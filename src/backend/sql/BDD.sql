START TRANSACTION;
DROP DATABASE IF EXISTS cts;
CREATE DATABASE cts;
USE cts;
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
	CONSTRAINT pk_specialite PRIMARY KEY (codeSpecialite)
);
CREATE TABLE Mission (
	codeMission INT NOT NULL AUTO_INCREMENT,
	titreMission VARCHAR(127) NOT NULL,
	descriptionMission TEXT NOT NULL,
	dateDebut DATE NOT NULL,
	dateFin DATE NOT NULL,
	codeStatutMission INT NOT NULL,
	codeTypeMission INT NOT NULL,
	codeSpecialite INT NOT NULL,
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
ADD CONSTRAINT fk_contact_pays FOREIGN KEY (codePays) REFERENCES Pays (codePays);
-- cible
ALTER TABLE Cible
ADD CONSTRAINT fk_cible_pays FOREIGN KEY (codePays) REFERENCES Pays (codePays);
-- agent
ALTER TABLE Agent
ADD CONSTRAINT fk_agent_pays FOREIGN KEY (codePays) REFERENCES Pays (codePays);
-- mission
ALTER TABLE Mission
ADD CONSTRAINT fk_mission_statut FOREIGN KEY (codeStatutMission) REFERENCES Statut (codeStatutMission);
ALTER TABLE Mission
ADD CONSTRAINT fk_mission_typemission FOREIGN KEY (codeTypeMission) REFERENCES TypeMission (codeTypeMission);
ALTER TABLE Mission
ADD CONSTRAINT fk_mission_specialite FOREIGN KEY (codeSpecialite) REFERENCES Specialite (codeSpecialite);
-- planque
ALTER TABLE Planque
ADD CONSTRAINT fk_planque_pays FOREIGN KEY (codePays) REFERENCES Pays (codePays);
ALTER TABLE Planque
ADD CONSTRAINT fk_planque_typeplanque FOREIGN KEY (codeTypePlanque) REFERENCES TypePlanque (codeTypePlanque);
-- aide
ALTER TABLE Aide
ADD CONSTRAINT fk_aide_mission FOREIGN KEY (codeMission) REFERENCES Mission (codeMission);
ALTER TABLE Aide
ADD CONSTRAINT fk_aide_contact FOREIGN KEY (codeContact) REFERENCES Contact (codeContact);
-- visee
ALTER TABLE Visee
ADD CONSTRAINT fk_visee_mission FOREIGN KEY (codeMission) REFERENCES Mission (codeMission);
ALTER TABLE Visee
ADD CONSTRAINT fk_visee_cible FOREIGN KEY (codeCible) REFERENCES Cible (codeCible);
-- specialisation
ALTER TABLE Specialisation
ADD CONSTRAINT fk_specialisation_specialite FOREIGN KEY (codeSpecialite) REFERENCES Specialite (codeSpecialite);
ALTER TABLE Specialisation
ADD CONSTRAINT fk_specialisation_agent FOREIGN KEY (codeAgent) REFERENCES Agent (codeAgent);
-- execution
ALTER TABLE Execution
ADD CONSTRAINT fk_execution_mission FOREIGN KEY (codeMission) REFERENCES Mission (codeMission);
ALTER TABLE Execution
ADD CONSTRAINT fk_execution_agent FOREIGN KEY (codeAgent) REFERENCES Agent (codeAgent);
-- abri
ALTER TABLE Abri
ADD CONSTRAINT fk_abri_mission FOREIGN KEY (codeMission) REFERENCES Mission (codeMission);
ALTER TABLE Abri
ADD CONSTRAINT fk_abri_planque FOREIGN KEY (codePlanque) REFERENCES Planque (codePlanque);
-- ------- ADDING JOB CONSTRAINTS ------- --
COMMIT;
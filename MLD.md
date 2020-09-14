# Projet Classé Top Secret

## Modèle conceptuel de données

[Document PDF](MCD.pdf)

## Modèle logique de données

### Relations :

- Contact (<u>codeContact</u>, nomContact, prénomContact, dateNaissanceContact, #codePays)
  
  - clé primaire :  codeContact
  
  - clés étrangères : Cible (codePays)
  
  - contraintes : 
  
  - dictionnaire des données :

| attribut | type | longueur |
| -------- | ---- | -------- |
|          |      |          |
|          |      |          |
|          |      |          |

- Cible (<u>codeCible</u>, nomCible, prénomCible, dateNaissanceCible, #codePays)
* clé primaire : 

* clés étrangères :

* contraintes :

* dictionnaire des données :
  
  | attribut | type | longueur |
  | -------- | ---- | -------- |
  |          |      |          |
  |          |      |          |
  |          |      |          |
- Agent (<u>codeAgent</u>, nomAgent, prénomAgent, dateNaissanceAgent, #codePays)
* clé primaire : 

* clés étrangères :

* contraintes :

* dictionnaire des données :
  
  | attribut | type | longueur |
  | -------- | ---- | -------- |
  |          |      |          |
  |          |      |          |
  |          |      |          |
- Spécialité (<u>codeSpécialité</u>, libelléSpécialité)
* clé primaire : 

* clés étrangères :

* contraintes :

* dictionnaire des données :
  
  | attribut | type | longueur |
  | -------- | ---- | -------- |
  |          |      |          |
  |          |      |          |
  |          |      |          |
- Pays (<u>codePays</u>, libelléPays)
* clé primaire : 

* clés étrangères :

* contraintes :

* dictionnaire des données :
  
  | attribut | type | longueur |
  | -------- | ---- | -------- |
  |          |      |          |
  |          |      |          |
  |          |      |          |
- Mission (<u>codeMission</u>, titreMission, descriptionMission, dateDébut, dateFin, #codeStatutMission, #codeTypeMission, #codeSpécialité)
* clé primaire : 

* clés étrangères :

* contraintes :

* dictionnaire des données :
  
  | attribut | type | longueur |
  | -------- | ---- | -------- |
  |          |      |          |
  |          |      |          |
  |          |      |          |
- Statut (<u>codeStatutMission</u>, libelléMission)
* clé primaire : 

* clés étrangères :

* contraintes :

* dictionnaire des données :
  
  | attribut | type | longueur |
  | -------- | ---- | -------- |
  |          |      |          |
  |          |      |          |
  |          |      |          |
- TypeMission (<u>codeTypeMission</u>, libelléTypeMission)
* clé primaire : 

* clés étrangères :

* contraintes :

* dictionnaire des données :
  
  | attribut | type | longueur |
  | -------- | ---- | -------- |
  |          |      |          |
  |          |      |          |
  |          |      |          |
- Planque (<u>codePlanque</u>, adressePlanque, #codePays, #typePlanque)
* clé primaire : 

* clés étrangères :

* contraintes :

* dictionnaire des données :
  
  | attribut | type | longueur |
  | -------- | ---- | -------- |
  |          |      |          |
  |          |      |          |
  |          |      |          |
- TypePlanque (codeTypePlanque, libelléTypePlanque)
* clé primaire : 

* clés étrangères :

* contraintes :

* dictionnaire des données :
  
  | attribut | type | longueur |
  | -------- | ---- | -------- |
  |          |      |          |
  |          |      |          |
  |          |      |          |

#### Relations supplémentaires dûes aux associations n-n :

- Aide (<u>#codeMission, #codeContact</u>)
* clé primaire : 

* clés étrangères :

* contraintes :

* dictionnaire des données :
  
  | attribut | type | longueur |
  | -------- | ---- | -------- |
  |          |      |          |
  |          |      |          |
  |          |      |          |
- Visée (<u>#codeMission, #codeCible</u>)
* clé primaire : 

* clés étrangères :

* contraintes :

* dictionnaire des données :
  
  | attribut | type | longueur |
  | -------- | ---- | -------- |
  |          |      |          |
  |          |      |          |
  |          |      |          |
- Spécialisation (<u>#codeSpécialité, #codeAgent</u>)
* clé primaire : 

* clés étrangères :

* contraintes :

* dictionnaire des données :
  
  | attribut | type | longueur |
  | -------- | ---- | -------- |
  |          |      |          |
  |          |      |          |
  |          |      |          |
- Exécution (<u>#codeMission, #codeAgent</u>)
* clé primaire : 

* clés étrangères :

* contraintes :

* dictionnaire des données :
  
  | attribut | type | longueur |
  | -------- | ---- | -------- |
  |          |      |          |
  |          |      |          |
  |          |      |          |

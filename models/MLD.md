# Projet Classé Top Secret

## Modèle conceptuel de données

[Document PDF](MCD.pdf)

## Modèle logique de données

### Relations :

- Contact [<u>codeContact</u>, nomContact, prénomContact, dateNaissanceContact, #codePays]
  
  - clé primaire :  codeContact
  
  - clés étrangères : Contact [codePays] ∈ Cible [codePays]
  
  - contraintes : Sur une mission, les contacts sont obligatoirement de la nationalité du pays de la mission.
  
  - dictionnaire des données :

| attribut             | type    | longueur |
| -------------------- | ------- | -------- |
| codeContact          | INT     |          |
| nomContact           | VARCHAR | 255      |
| prénomContact        | VARCHAR | 255      |
| dateNaissanceContact | DATE    |          |
| codePays             | INT     |          |

- Cible [<u>codeCible</u>, nomCible, prénomCible, dateNaissanceCible, #codePays]
  
  - clé primaire : codeCible
  
  - clés étrangères : Cible [codePays] ∈ Pays [codePays]
  
  - contraintes : Sur une mission, la ou les cibles ne peuvent pas avoir la même nationalité que le ou les agents.
  
  - dictionnaire des données :

| attribut           | type    | longueur |
| ------------------ | ------- | -------- |
| codeCible          | INT     |          |
| nomCible           | VARCHAR | 255      |
| prénomCible        | VARCHAR | 255      |
| dateNaissanceCible | DATE    |          |
| codePays           | INT     |          |

- Agent [<u>codeAgent</u>, nomAgent, prénomAgent, dateNaissanceAgent, #codePays]
  
  - clé primaire :  codeAgent
  
  - clés étrangères : Agent [codePays] ∈ Pays [codePays]
  
  - contraintes : Sur une mission, il faut assigner au moins 1 agent disposant de la spécialité requise.
  
  - dictionnaire des données :

| attribut             | type    | longueur |
| -------------------- | ------- | -------- |
| codeContact          | INT     |          |
| nomContact           | VARCHAR | 255      |
| prénomContact        | VARCHAR | 255      |
| dateNaissanceContact | DATE    |          |
| codePays             | INT     |          |

- Spécialité [<u>codeSpécialité</u>, libelléSpécialité]
  
  - clé primaire :  codeSpécialité
  
  - clés étrangères : aucune
  
  - contraintes : Sur une mission, il faut assigner au moins 1 agent disposant de la spécialité requise.
  
  - dictionnaire des données :

| attribut          | type    | longueur |
| ----------------- | ------- | -------- |
| codeSpécialité    | INT     |          |
| libelléSpécialité | VARCHAR | 127      |

- Pays [<u>codePays</u>, libelléPays]
  
  - clé primaire :  codePays
  
  - clés étrangères : aucune
  
  - contraintes :
    
    - Sur une mission, les contacts sont obligatoirement de la nationalité du pays de la mission.
    
    - Sur une mission, la ou les cibles ne peuvent pas avoir la même nationalité que le ou les agents.
    
    - Sur une mission, la planque est obligatoirement dans le même pays que la mission.
  
  - dictionnaire des données :

| attribut    | type    | longueur |
| ----------- | ------- | -------- |
| codePays    | INT     |          |
| libelléPays | VARCHAR | 255      |

- Mission [<u>codeMission</u>, titreMission, descriptionMission, dateDébut, dateFin, #codeStatutMission, #codeTypeMission, #codeSpécialité]
  
  - clé primaire : codeMission
  
  - clés étrangères : 
    
    - Mission [codeStatutMission] ∈ StatutMission [codeStatutMission]
    
    - Mission [codeTypeMission] ∈ TypeMission [codeTypeMission]
    
    - Mission [codeSpécialité] ∈ Spécialité [codeSpécialité]
  
  - contraintes :
    
    - Sur une mission, les contacts sont obligatoirement de la nationalité du pays de la mission.
    
    - Sur une mission, la ou les cibles ne peuvent pas avoir la même nationalité que le ou les agents.
    
    - Sur une mission, il faut assigner au moins 1 agent disposant de la spécialité requise.
    
    - Sur une mission, la planque est obligatoirement dans le même pays que la mission.
  
  - dictionnaire des données :

| attribut           | type    | longueur |
| ------------------ | ------- | -------- |
| codeMission        | INT     |          |
| titreMission       | VARCHAR | 127      |
| descriptionMission | TEXT    | 5        |
| dateDébut          | DATE    |          |
| dateDébut          | DATE    |          |
| codeStatutMission  | INT     |          |
| codeTypeMission    | INT     |          |
| codeSpécialité     | INT     |          |

- Statut [<u>codeStatutMission</u>, libelléStatutMission]
  
  - clé primaire :  codeStatutMission
  - clés étrangères : aucune
  - contraintes :  aucune
  - dictionnaire des données :

| attribut             | type    | longueur |
| -------------------- | ------- | -------- |
| codeStatutMission    | INT     |          |
| libelléStatutMission | VARCHAR | 127      |

- TypeMission [<u>codeTypeMission</u>, libelléTypeMission]
  
  - clé primaire :  codeTypeMission
  
  - clés étrangères : aucune
  
  - contraintes : aucune
  
  - dictionnaire des données : 

| attribut           | type    | longueur |
| ------------------ | ------- | -------- |
| codeTypeMission    | INT     |          |
| libelléTypeMission | VARCHAR | 127      |

- Planque [<u>codePlanque</u>, adressePlanque, #codePays, #codeTypePlanque]
  
  - clé primaire :  codePlanque
  
  - clés étrangères :
    
    - Planque [codePays] ∈ Pays [codePays]
    
    - Planque [codeTypePlanque] ∈ Planque [codeTypePlanque]
  
  - contraintes : aucune
  
  - dictionnaire des données :

| attribut        | type    | longueur |
| --------------- | ------- | -------- |
| codePlanque     | INT     |          |
| adressePlanque  | VARCHAR | 255      |
| codePays        | INT     |          |
| codeTypePlanque | INT     |          |

- TypePlanque [<u>codeTypePlanque</u>, libelléTypePlanque]
  
  - clé primaire : codeTypePlanque
  
  - clés étrangères : aucune
  
  - contraintes : aucune
  
  - dictionnaire des données :

| attribut           | type    | longueur |
| ------------------ | ------- | -------- |
| codeTypePlanque    | INT     |          |
| libelléTypePlanque | VARCHAR | 127      |

#### Relations supplémentaires dûes aux associations n-n :

- Aide [<u>#codeMission, #codeContact</u>]
  
  - clé primaire : codeMission, codeContact (composée)
  
  - clés étrangères :
    
    - Aide [codeMission] ∈ Mission [codeMission]
    
    - Aide [codeContact] ∈ Contact [codeContact]
  
  - contraintes : aucune
  
  - dictionnaire des données :

| attribut    | type | longueur |
| ----------- | ---- | -------- |
| codeMission | INT  |          |
| codeContact | INT  |          |

- Visée [<u>#codeMission, #codeCible</u>]
  
  - clé primaire : codeMission, codeCible (composée)
  
  - clés étrangères :
    
    - Visée [codeMission] ∈ Mission [codeMission]
    
    - Visée [codeCible] ∈ Cible [codeCible]
  
  - contraintes : aucune
  
  - dictionnaire des données :

| attribut    | type | longueur |
| ----------- | ---- | -------- |
| codeMission | INT  |          |
| codeCible   | INT  |          |

- Spécialisation [<u>#codeSpécialité, #codeAgent</u>]
  
  - clé primaire : codeSpécialité, codeAgent (composée)
  
  - clés étrangères :
    
    - Spécialisation [codeSpécialité] ∈ Spécialité [codeSpécialité]
    
    - Spécialisation [codeAgent] ∈ Agent [codeAgent]
  
  - contraintes : aucune
  
  - dictionnaire des données :

| attribut       | type | longueur |
| -------------- | ---- | -------- |
| codeSpécialité | INT  |          |
| codeAgent      | INT  |          |

- Exécution [<u>#codeMission, #codeAgent</u>]
  
  - clé primaire : codeMission, codeAgent
  
  - clés étrangères :
    
    - Exécution [codeMission] ∈ Mission [codeMission]
    
    - Exécution [codeAgent] ∈ Agent [codeAgent]
  
  - contraintes : aucune
  
  - dictionnaire des données :

| attribut    | type | longueur |
| ----------- | ---- | -------- |
| codeMission | INT  |          |
| codeAgent   | INT  |          |

create table PERSONNE(
    ID int,
    Nom varchar(30),
    Prenom varchar(30),
    PRIMARY key(ID)
);

create table JURY(
    NumJury int,
    login_ varchar(30),
    password_ varchar(30),
    PRIMARY key(NumJury)
);

create table GROUPE(
    NumGroupe int,
    NomProjet varchar(30),
    Lycee varchar(100),
    numSalle int,
    image_Projet varchar(100),
    PRIMARY key(NumGroupe)
);

create table PROFESSEUR(
    IDProf int,
    NumJury int,
    PRIMARY key(IDProf),
    FOREIGN KEY(NumJury) REFERENCES JURY(NumJury),
    FOREIGN KEY (IDProf) REFERENCES PERSONNE(ID)
);

create table ELEVE(
    IDEleve int,
    Filiere varchar(30),
    NumGroupe int,
    PRIMARY key(IDEleve),
    FOREIGN KEY (IDEleve) REFERENCES PERSONNE(ID),
    FOREIGN KEY(NumGroupe) REFERENCES GROUPE(NumGroupe)
);

create table HEURE(
    idHeure int,
    hDeb time,
    hFin time,
    PRIMARY key(idHeure)
);

create table NOTE(
    idNote int,
    prototype int,
    originalite int,
    DemarcheScientifique int,
    pluriDisciplinarite int,
    MaitriseScientifique  int,
    Communication int,
    PRIMARY key(idNote)
);

create table RECOMPENSE(
    idRecompense int,
    idGroupe int,
    NomCategorie varchar(30),
    FOREIGN KEY(idGroupe) REFERENCES GROUPE(NumGroupe),
    CONSTRAINT Pk_RECOMPENSE UNIQUE(idGroupe)
);

create table JUGE(
    idHeure int,
    NumJury int,
    NumGroupe int,
    numSalle int,
    FOREIGN KEY(NumJury) REFERENCES JURY(NumJury),
    FOREIGN KEY(NumGroupe) REFERENCES GROUPE(NumGroupe),
    FOREIGN KEY(idHeure) REFERENCES HEURE(idHeure),
    CONSTRAINT Pk_JUGE PRIMARY KEY(NumJury,NumGroupe,idHeure),
    CONSTRAINT Pk_Jury_groupe UNIQUE (NumJury,NumGroupe),
    CONSTRAINT PK_Heure_Salle UNIQUE (idHeure,numSalle),
    CONSTRAINT Pk_Groupe_Heure UNIQUE (NumGroupe,idHeure),
    CONSTRAINT Pk_Jury_Heure UNIQUE (NumJury,idHeure)
);

create table DONNE(
    NumJury int,
    NumGroupe int,
    idNote int,
    FOREIGN KEY(NumJury) REFERENCES JURY(NumJury),
    FOREIGN KEY(NumGroupe) REFERENCES GROUPE(NumGroupe),
    FOREIGN KEY(idNote) REFERENCES NOTE(idNote),
    CONSTRAINT Pk_DONNE PRIMARY KEY(NumJury,NumGroupe,idNote),
    CONSTRAINT Pk_Jury_groupe_Note UNIQUE (NumJury,NumGroupe)
);

create table ADMINISTRATEUR(
  login varchar(30),
  MotDePasse varchar(30),
  CONSTRAINT Pk_ADMNISTRATEUR PRIMARY KEY(login,MotDePasse)
);

create table OLYMPIADES(
  NumEdition int,
  LogOlympiades varchar(100),
  LogoSponsor varchar(100),
  LogoUPSTI varchar(100),
  datetimeOlymp datetime,
  BandeauPartenaires varchar(100),
  LogoIUT varchar(100),
  PRIMARY KEY(NumEdition)
);

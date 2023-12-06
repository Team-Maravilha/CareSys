CREATE TABLE utente (
  id_utente             SERIAL NOT NULL, 
  nome                  varchar(255) NOT NULL, 
  data_nascimento       date NOT NULL, 
  hora_nascimento       time NOT NULL, 
  genero                int NOT NULL, 
  tipo_documento        int NOT NULL, 
  num_cc                int NOT NULL UNIQUE, 
  data_validade_cc      date NOT NULL, 
  cod_validacao_cc      varchar(255) NOT NULL, 
  num_utente            int NOT NULL UNIQUE, 
  num_ident_seg_social  bigint NOT NULL UNIQUE, 
  num_ident_fiscal      int NOT NULL UNIQUE, 
  estado_civil          int NOT NULL, 
  situacao_profissional int NOT NULL, 
  profissao             varchar(255), 
  hab_escolares         varchar(255), 
  num_telemovel         int NOT NULL, 
  num_telefone          int, 
  email                 varchar(255), 
  obs_gerais            varchar(1000), 
  taxa_moderadora       int NOT NULL, 
  seguro_saude          int NOT NULL, 
  data_obito            timestamp,
  estado                int NOT NULL, 
  hashed_id             varchar(255) NULL, 
  data_criacao          timestamp NOT NULL, 
  PRIMARY KEY (id_utente));

CREATE TABLE tipos_documento (
  id_tipo_documento SERIAL NOT NULL, 
  nome              varchar(255) NOT NULL, 
  hashed_id         varchar(255) NULL,
  PRIMARY KEY (id_tipo_documento));

# CHANGE TIPO DE DOCUMENTO TO ID TIPO DE DOCUMENTO
ALTER TABLE utente DROP COLUMN tipo_documento;
ALTER TABLE utente ADD COLUMN id_tipo_documento int NOT NULL;
ALTER TABLE utente ADD CONSTRAINT FKTipoDocumento FOREIGN KEY (id_tipo_documento) REFERENCES tipos_documento (id_tipo_documento);
#ALLOW NULL
ALTER TABLE utente ALTER COLUMN hora_nascimento DROP NOT NULL;
ALTER TABLE utente ALTER COLUMN num_utente DROP NOT NULL;
ALTER TABLE utente ALTER COLUMN data_criacao SET DEFAULT NOW();
ALTER TABLE utente ALTER COLUMN num_utente DROP NOT NULL;
ALTER TABLE utente ALTER COLUMN estado SET DEFAULT ;

ALTER TABLE utente ALTER COLUMN num_ident_seg_social TYPE bigint USING num_ident_seg_social::bigint;

ALTER TABLE utente ADD COLUMN data_resposta timestamp;

ALTER TABLE utente ALTER COLUMN data_resposta DROP NOT NULL;

CREATE TABLE morada (
  id_morada           SERIAL NOT NULL, 
  id_utente           int NOT NULL, 
  morada              varchar(255) NOT NULL, 
  freguesia           varchar(255) NOT NULL, 
  cod_postal          varchar(255) NOT NULL, 
  num_porta           int, 
  andar               varchar(255), 
  id_concelho         int NOT NULL, 
  morada_preferencial int NOT NULL, 
  PRIMARY KEY (id_morada));
CREATE TABLE unidade_saude_familiar (
  id_usf             SERIAL NOT NULL, 
  nome               varchar(255) NOT NULL, 
  data_associacao    timestamp NOT NULL, 
  data_desassociacao timestamp, 
  PRIMARY KEY (id_usf));
CREATE TABLE descendente (
  id_utente             int NOT NULL, 
  id_descendente_utente int NOT NULL, 
  tipo_associacao       int NOT NULL, 
  data_associacao       timestamp NOT NULL, 
  PRIMARY KEY (id_utente, 
  id_descendente_utente));

  ALTER TABLE descendente ALTER COLUMN data_associacao SET DEFAULT NOW();

CREATE TABLE conjuge (
  id_casamento      int NOT NULL, 
  id_utente         int NOT NULL, 
  id_conjuge_utente int NOT NULL, 
  data_associacao   timestamp NOT NULL, 
  data_desasociacao timestamp, 
  PRIMARY KEY (id_casamento, 
  id_utente, 
  id_conjuge_utente));
CREATE TABLE medicacao_especial (
  id_medicacao_especial SERIAL NOT NULL, 
  motivo                varchar(255), 
  data_inicio           timestamp NOT NULL, 
  data_fim              timestamp NOT NULL, 
  data_criacao          timestamp NOT NULL, 
  id_utente             int NOT NULL, 
  PRIMARY KEY (id_medicacao_especial));
CREATE TABLE isencao (
  id_isencao   SERIAL NOT NULL, 
  motivo       varchar(255), 
  data_inicio  timestamp NOT NULL, 
  data_fim     timestamp NOT NULL, 
  data_criacao timestamp NOT NULL, 
  id_utente    int NOT NULL, 
  PRIMARY KEY (id_isencao));
CREATE TABLE comparticipacao_medicamentos (
  id_comparicipacao_medicamentos SERIAL NOT NULL, 
  motivo                         varchar(255), 
  data_inicio                    timestamp NOT NULL, 
  data_fim                       timestamp NOT NULL, 
  data_criacao                   timestamp NOT NULL, 
  id_utente                      int NOT NULL, 
  PRIMARY KEY (id_comparicipacao_medicamentos));
CREATE TABLE contacto_emergencia (
  id_contacto_emergencia   SERIAL NOT NULL, 
  nome_contacto_emergencia varchar(255) NOT NULL, 
  contacto_emergencia      varchar(255) NOT NULL, 
  data_associacao          timestamp NOT NULL, 
  id_utente                int NOT NULL, 
  PRIMARY KEY (id_contacto_emergencia));
CREATE TABLE medico (
  id_medico    SERIAL NOT NULL, 
  nome         varchar(255) NOT NULL, 
  data_criacao timestamp NOT NULL, 
  PRIMARY KEY (id_medico));

ALTER TABLE medico ALTER COLUMN data_criacao SET DEFAULT NOW();

CREATE TABLE medico_unidade_saude (
  id_medico_unidade_saude        SERIAL NOT NULL, 
  id_usf int NOT NULL, 
  id_medico                int NOT NULL, 
  PRIMARY KEY (id_medico_unidade_saude));
CREATE TABLE utente_medico (
  id_utente                          int NOT NULL, 
  id_associacao_medico_unidade_saude int NOT NULL);
CREATE TABLE pais (
  id_pais      SERIAL NOT NULL, 
  nome         varchar(255) NOT NULL, 
  codigo_alpha varchar(3) NOT NULL, 
  PRIMARY KEY (id_pais));
CREATE TABLE distrito (
  id_distrito_estado SERIAL NOT NULL, 
  nome               varchar(255) NOT NULL, 
  id_pais            int NOT NULL, 
  PRIMARY KEY (id_distrito_estado));
CREATE TABLE concelho (
  id_concelho        SERIAL NOT NULL, 
  nome               varchar(255) NOT NULL, 
  id_distrito_estado int NOT NULL, 
  PRIMARY KEY (id_concelho));


ALTER TABLE medico_unidade_saude ADD CONSTRAINT FKMédicoUnid494497 FOREIGN KEY (id_usf) REFERENCES unidade_saude_familiar (id_usf);
ALTER TABLE medico_unidade_saude ADD CONSTRAINT FKMédicoUnid322415 FOREIGN KEY (id_medico) REFERENCES medico (id_medico);
ALTER TABLE descendente ADD CONSTRAINT FKDescendent790432 FOREIGN KEY (id_utente) REFERENCES utente (id_utente);
ALTER TABLE conjuge ADD CONSTRAINT FKCônjuge477020 FOREIGN KEY (id_utente) REFERENCES utente (id_utente);
ALTER TABLE contacto_emergencia ADD CONSTRAINT FKContactoE778262 FOREIGN KEY (id_utente) REFERENCES utente (id_utente);
ALTER TABLE medicacao_especial ADD CONSTRAINT FKMedicação126533 FOREIGN KEY (id_utente) REFERENCES utente (id_utente);
ALTER TABLE isencao ADD CONSTRAINT FKIsenção307093 FOREIGN KEY (id_utente) REFERENCES utente (id_utente);
ALTER TABLE comparticipacao_medicamentos ADD CONSTRAINT FKCompartici195707 FOREIGN KEY (id_utente) REFERENCES utente (id_utente);
ALTER TABLE descendente ADD CONSTRAINT FKDescendent782020 FOREIGN KEY (id_descendente_utente) REFERENCES utente (id_utente);
ALTER TABLE conjuge ADD CONSTRAINT FKCônjuge424479 FOREIGN KEY (id_conjuge_utente) REFERENCES utente (id_utente);
ALTER TABLE utente_medico ADD CONSTRAINT FKUtenteMédi638462 FOREIGN KEY (id_utente) REFERENCES utente (id_utente);
ALTER TABLE utente_medico ADD CONSTRAINT FKUtenteMédi722703 FOREIGN KEY (id_associacao_medico_unidade_saude) REFERENCES medico_unidade_saude (id_medico_unidade_saude);
ALTER TABLE distrito ADD CONSTRAINT FKDistritoE566944 FOREIGN KEY (id_pais) REFERENCES pais (id_pais);
ALTER TABLE concelho ADD CONSTRAINT FKConcelho539315 FOREIGN KEY (id_distrito_estado) REFERENCES distrito (id_distrito_estado);
ALTER TABLE morada ADD CONSTRAINT FKMorada398007 FOREIGN KEY (id_concelho) REFERENCES concelho (id_concelho);
ALTER TABLE morada ADD CONSTRAINT FKMorada639710 FOREIGN KEY (id_utente) REFERENCES utente (id_utente);



-- SQLBook: Code
-- CREATE TRIIGER TO ADD UUID()
CREATE OR REPLACE FUNCTION add_uuid() RETURNS TRIGGER AS $$
BEGIN
  NEW.hashed_id = uuid_generate_v4();
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER add_uuid BEFORE INSERT ON utente FOR EACH ROW EXECUTE PROCEDURE add_uuid();


-- CHECK CC NUMBER IS UNIQUE
CREATE OR REPLACE FUNCTION check_cc_number(num_cc int) 
RETURNS BOOLEAN AS $$
BEGIN
  IF EXISTS (SELECT u.* FROM utente u WHERE u.num_cc = check_cc_number.num_cc) THEN
    RETURN FALSE; -- CC NUMBER ALREADY EXISTS
  ELSE
    RETURN TRUE; -- CC NUMBER DOESN'T EXIST
  END IF;
END;
$$ LANGUAGE plpgsql;


-- CHECN NUM_UTENTE IS UNIQUE
CREATE OR REPLACE FUNCTION check_num_utente(num_utente int)
RETURNS BOOLEAN AS $$
BEGIN
  IF EXISTS (SELECT u.* FROM utente u WHERE u.num_utente = check_num_utente.num_utente) THEN
    RETURN FALSE; -- NUM_UTENTE ALREADY EXISTS
  ELSE
    RETURN TRUE; -- NUM_UTENTE DOESN'T EXIST
  END IF;
END;
$$ LANGUAGE plpgsql;

  
-- CHECK NUM_IDENT_SEG_SOCIAL IS UNIQUE
CREATE OR REPLACE FUNCTION check_num_ident_seg_social(num_ident_seg_social int)
RETURNS BOOLEAN AS $$
BEGIN
  IF EXISTS (SELECT u.* FROM utente u WHERE u.num_ident_seg_social = check_num_ident_seg_social.num_ident_seg_social) THEN
    RETURN FALSE; -- NUM_IDENT_SEG_SOCIAL ALREADY EXISTS
  ELSE
    RETURN TRUE; -- NUM_IDENT_SEG_SOCIAL DOESN'T EXIST
  END IF;
END;
$$ LANGUAGE plpgsql;

-- CHECK NUM_IDENT_FISCAL IS UNIQUE
CREATE OR REPLACE FUNCTION check_num_ident_fiscal(num_ident_fiscal int)
RETURNS BOOLEAN AS $$
BEGIN
  IF EXISTS (SELECT u.* FROM utente u WHERE u.num_ident_fiscal = check_num_ident_fiscal.num_ident_fiscal) THEN
    RETURN FALSE; -- NUM_IDENT_FISCAL ALREADY EXISTS
  ELSE
    RETURN TRUE; -- NUM_IDENT_FISCAL DOESN'T EXIST
  END IF;
END;
$$ LANGUAGE plpgsql;


-- CHECK BIRTH DATE IS VALID
CREATE OR REPLACE FUNCTION check_birth_date(data_nascimento date)
RETURNS BOOLEAN AS $$
BEGIN
  IF data_nascimento > CURRENT_DATE THEN
    RETURN FALSE; -- BIRTH DATE IS IN THE FUTURE
  ELSE
    RETURN TRUE; -- BIRTH DATE IS VALID
  END IF;
END;
$$ LANGUAGE plpgsql;


-- CHECK CC VALIDITY DATE IS VALID
CREATE OR REPLACE FUNCTION check_cc_validity_date(data_validade_cc date)
RETURNS BOOLEAN AS $$
BEGIN
  IF data_validade_cc < CURRENT_DATE THEN
    RETURN FALSE; -- CC VALIDITY DATE IS IN THE PAST
  ELSE
    RETURN TRUE; -- CC VALIDITY DATE IS VALID
  END IF;
END;
$$ LANGUAGE plpgsql;

-- GET USER BY NUM UTENTE
CREATE OR REPLACE FUNCTION get_patient_by_num_utente(num_utente int)
RETURNS TABLE (
  hashed_id             varchar(255),
  nome                  varchar(255)
) AS $$
BEGIN
  IF EXISTS (SELECT u.* FROM utente u WHERE u.num_utente = get_patient_by_num_utente.num_utente) THEN
    RETURN QUERY SELECT u.hashed_id, u.nome FROM utente u WHERE u.num_utente = get_patient_by_num_utente.num_utente;
  ELSE
    RAISE EXCEPTION 'Utente nao encontrado';
  END IF;
END
$$ LANGUAGE plpgsql;


-- CREATE UTENTE
CREATE OR REPLACE FUNCTION criar_utente(
  nome                  varchar(255),
  genero                int,
  data_nascimento       date,
  id_tipo_documento     int,
  num_cc                int,
  cod_validacao_cc      varchar(4),
  data_validade_cc      date,
  num_ident_seg_social  int,
  num_ident_fiscal      int,
  num_utente_pai        int,
  num_utente_mae        int,
  estado_civil          int,
  situacao_profissional int,
  num_telemovel         int,
  taxa_moderadora       int,
  seguro_saude          int,
  pais                  int,
  distrito              varchar(255),
  concelho              varchar(255),
  freguesia             varchar(255),
  morada                varchar(255),
  cod_postal            varchar(255),
  numero_porta          int,
  hora_nascimento       time DEFAULT NULL,
  profissao             varchar(255) DEFAULT NULL,
  hab_escolares         varchar(255) DEFAULT NULL,
  num_telefone          int DEFAULT NULL,
  email                 varchar(255) DEFAULT NULL,
  andar                 varchar(255) DEFAULT NULL
) 
RETURNS INT AS $$
DECLARE
  id_utente_pai int;
  id_utente_mae int;
  id_morada int;
  id_utente_out int;
BEGIN
  -- CHECK IF Nome IS NULL
  IF nome IS NULL OR nome = '' THEN
    RAISE EXCEPTION 'O Nome é obrigatório';
  END IF;

  -- CHECK IF GENERO IS NULL
  IF genero IS NULL THEN
    RAISE EXCEPTION 'O Genero é obrigatório';
  END IF;

  -- CHECK IF DATA_NASCIMENTO IS NULL
  IF data_nascimento IS NULL THEN
    RAISE EXCEPTION 'A Data de nascimento é obrigatória';
  END IF;
  -- CHECK IF DATA_NASCIMENTO IS VALID
  IF NOT check_birth_date(data_nascimento) THEN
    RAISE EXCEPTION 'A Data de nascimento é inválida';
  END IF;

  -- CHECK IF ID_TIPO_DOCUMENTO IS NULL
  IF id_tipo_documento IS NULL THEN
    RAISE EXCEPTION 'O Tipo de documento é obrigatório';
  END IF;

  -- CHECK IF NUM_CC IS NULL
  IF NOT check_cc_number(num_cc) THEN
    RAISE EXCEPTION 'O Número de CC já se econtra registado';
  END IF;

  -- CHECK IF COD_VALIDACAO_CC IS NULL
  IF cod_validacao_cc IS NULL THEN
    RAISE EXCEPTION 'O Código de validação do CC é obrigatório';
  END IF;

  -- CHECK IF DATA_VALIDADE_CC IS NULL
  IF data_validade_cc IS NULL THEN
    RAISE EXCEPTION 'A Data de validade do CC é obrigatória';
  END IF;

  -- CHECK IF DATA_VALIDADE_CC IS VALID
  IF NOT check_cc_validity_date(data_validade_cc) THEN
    RAISE EXCEPTION 'A Data de validade do CC é inválida';
  END IF;

  -- CHECK IF NUM_IDENT_SEG_SOCIAL IS NULL
  IF NOT check_num_ident_seg_social(num_ident_seg_social) THEN
    RAISE EXCEPTION 'O Número de identificação da segurança social já se econtra registado';
  END IF;

  -- CHECK IF NUM_IDENT_FISCAL IS NULL
  IF NOT check_num_ident_fiscal(num_ident_fiscal) THEN
    RAISE EXCEPTION 'O Número de identificação fiscal já se econtra registado';
  END IF;

  -- CHECK IF NUM_UTENTE_PAI IS NULL
  IF num_utente_pai IS NOT NULL THEN
    -- CHECK IF NUM_UTENTE_PAI EXISTS
    IF check_num_utente(num_utente_pai) THEN
      RAISE EXCEPTION 'O Número de utente do pai não existe';
    ELSE 
      SELECT u.id_utente INTO id_utente_pai FROM utente u WHERE u.num_utente = num_utente_pai;
    END IF;
  ELSE
    id_utente_pai = NULL;
  END IF;

  -- CHECK IF NUM_UTENTE_MAE IS NULL
  IF num_utente_mae IS NOT NULL THEN
    -- CHECK IF NUM_UTENTE_MAE EXISTS
    IF check_num_utente(num_utente_mae) THEN
      RAISE EXCEPTION 'O Número de utente da mãe não existe';
    ELSE 
      SELECT u.id_utente INTO id_utente_mae FROM utente u WHERE u.num_utente = num_utente_mae;
    END IF;
  ELSE
    id_utente_mae = NULL;
  END IF;

  -- CHECK IF ESTADO_CIVIL IS NULL
  IF estado_civil IS NULL THEN
    RAISE EXCEPTION 'O Estado civil é obrigatório';
  END IF;

  -- CHECK IF SITUACAO_PROFISSIONAL IS NULL
  IF situacao_profissional IS NULL THEN
    RAISE EXCEPTION 'A Situação profissional é obrigatória';
  END IF;

  -- CHECK IF NUM_TELEMOVEL IS NULL
  IF num_telemovel IS NULL THEN
    RAISE EXCEPTION 'O Número de telemóvel é obrigatório';
  END IF;

  -- CHECK IF TAXA_MODERADORA IS NULL
  IF taxa_moderadora IS NULL THEN
    RAISE EXCEPTION 'A Taxa moderadora é obrigatória';
  END IF;

  -- CHECK IF SEGURO_SAUDE IS NULL
  IF seguro_saude IS NULL THEN
    RAISE EXCEPTION 'O Seguro de saúde é obrigatório';
  END IF;

  -- CHECK IF PAIS IS NULL
  IF pais IS NULL THEN
    RAISE EXCEPTION 'O País é obrigatório';
  END IF;

  -- CHECK IF DISTRITO IS NULL
  IF distrito IS NULL OR distrito = '' THEN
    RAISE EXCEPTION 'O Distrito é obrigatório';
  END IF;

  -- CHECK IF CONCELHO IS NULL
  IF concelho IS NULL OR concelho = '' THEN
    RAISE EXCEPTION 'O Concelho é obrigatório';
  END IF;

  -- CHECK IF FREGUESIA IS NULL
  IF freguesia IS NULL OR freguesia = '' THEN
    RAISE EXCEPTION 'A Freguesia é obrigatória';
  END IF;

  -- CHECK IF MORADA IS NULL
  IF morada IS NULL OR morada = '' THEN
    RAISE EXCEPTION 'A Morada é obrigatória';
  END IF;

  -- CHECK IF COD_POSTAL IS NULL
  IF cod_postal IS NULL OR cod_postal = '' THEN
    RAISE EXCEPTION 'O Código postal é obrigatório';
  END IF;

  -- CHECK IF NUMERO_PORTA IS NULL
  IF numero_porta IS NULL THEN
    RAISE EXCEPTION 'O Número de porta é obrigatório';
  END IF;

  -- CRIAR UTENTE
  INSERT INTO utente (
    nome,
    data_nascimento,
    hora_nascimento,
    genero,
    id_tipo_documento,
    num_cc,
    data_validade_cc,
    cod_validacao_cc,
    num_utente,
    num_ident_seg_social,
    num_ident_fiscal,
    estado_civil,
    situacao_profissional,
    profissao,
    hab_escolares,
    num_telemovel,
    num_telefone,
    email,
    taxa_moderadora,
    seguro_saude
  ) VALUES (
    nome,
    data_nascimento,
    hora_nascimento,
    genero,
    id_tipo_documento,
    num_cc,
    data_validade_cc,
    cod_validacao_cc,
    NULL,
    num_ident_seg_social,
    num_ident_fiscal,
    estado_civil,
    situacao_profissional,
    profissao,
    hab_escolares,
    num_telemovel,
    num_telefone,
    email,
    taxa_moderadora,
    seguro_saude
  ) RETURNING id_utente INTO id_utente_out;

  -- CRIAR MORADA
  id_morada = criar_morada(
      id_utente_out,
      morada,
      freguesia,
      cod_postal,
      numero_porta,
      concelho,
      distrito,
      pais,
      TRUE,
      andar
  );

  RETURN id_utente_out;
END;
$$ LANGUAGE plpgsql;

SELECT criar_utente(
  'João', -- nome
  1, -- genero
  '1999-01-01', -- data_nascimento
  1, -- id_tipo_documento
  12345678, -- num_cc
  '1234', -- cod_validacao_cc
  '2025-01-01', -- data_validade_cc
  123456789, -- num_ident_seg_social
  123456789, -- num_ident_fiscal
  1, -- num_utente_pai
  2, -- num_utente_mae
  1, -- estado_civil
  1, -- situacao_profissional
  123456789, -- num_telemovel
  1, -- taxa_moderadora
  1, -- seguro_saude
  1, -- pais
  'Porto', -- distrito
  'Porto', -- concelho
  'Paranhos', -- freguesia
  'Rua do ISEP', -- morada
  '4200-072', -- cod_postal
  '123', -- numero_porta
  '12:00:00', -- hora_nascimento
  'Estudante', -- profissao
  'Ensino Superior', -- hab_escolares
  123456789, -- num_telefone
  'joao@gmail.com' -- email
);
  



-- GET ALL UTENTES
CREATE OR REPLACE FUNCTION get_patients() 
RETURNS TABLE (
  id_utente             int, 
  nome                  varchar(255), 
  data_nascimento       date, 
  hora_nascimento       time, 
  genero                int, 
  num_cc                int, 
  data_validade_cc      date, 
  cod_validacao_cc      varchar(4), 
  num_utente            int, 
  num_ident_seg_social  int, 
  num_ident_fiscal      int, 
  estado_civil          int, 
  situacao_profissional int, 
  profissao             varchar(255), 
  hab_escolares         varchar(255), 
  num_telemovel         int, 
  num_telefone          int, 
  email                 varchar(255), 
  obs_gerais            varchar(1000), 
  taxa_moderadora       int, 
  seguro_saude          int, 
  data_obito            timestamp, 
  estado                int, 
  hashed_id             varchar(255), 
  data_criacao          timestamp,
  id_tipo_documento     int) AS $$
BEGIN
  RETURN QUERY SELECT * FROM utente;
END
$$ LANGUAGE plpgsql;



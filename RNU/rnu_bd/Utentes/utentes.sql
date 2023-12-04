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
CREATE OR REPLACE FUNCTION check_num_ident_seg_social(num_ident_seg_social bigint)
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

-- ADD DESCENDENT
CREATE OR REPLACE FUNCTION adicionar_descendente(
  id_utente_pai int,
  id_utente_filho int,
  tipo_associacao int
)
RETURNS BOOLEAN AS $$
BEGIN

  -- CHECK IF ID_UTENTE_PAI IS NULL
  IF NOT tipo_associacao IN (0, 1) THEN
    RAISE EXCEPTION 'O tipo de associação é inválido';
  END IF;

  -- CHECK IF ID_UTENTE_PAI IS NULL
  IF tipo_associacao=0 AND id_utente_pai IS NULL THEN
    RAISE EXCEPTION 'O id de utente do Pai é obrigatório';
  ELSEIF tipo_associacao=1 AND id_utente_pai IS NOT NULL THEN
    RAISE EXCEPTION 'O id de utente da Mãe é obrigatório';
  END IF;

  -- CHECK IF ID_UTENTE_PAI EXISTS
  IF NOT EXISTS (SELECT u.* FROM utente u WHERE u.id_utente = adicionar_descendente.id_utente_pai) THEN
    RAISE EXCEPTION 'O utente com o id % não existe', adicionar_descendente.id_utente_pai;
  END IF;

  -- CHECK IF ID_UTENTE_FILHO EXISTS
  IF NOT EXISTS (SELECT u.* FROM utente u WHERE u.id_utente = adicionar_descendente.id_utente_filho) THEN
    RAISE EXCEPTION 'O utente com o id % não existe', adicionar_descendente.id_utente_filho;
  END IF;

  -- CHECK IF ID_UTENTE_FILHO IS DESCENDENT OF ID_UTENTE_PAI
  IF EXISTS (SELECT d.* FROM descendente d WHERE d.id_utente = adicionar_descendente.id_utente_pai AND d.id_descendente_utente = adicionar_descendente.id_utente_filho) THEN
    RAISE EXCEPTION 'O utente com o id % já é descendente do utente com o id %', adicionar_descendente.id_utente_filho, adicionar_descendente.id_utente_pai;
  END IF;

  -- CHECK IF ID_UTENTE_PAI IS DESCENDENT OF ID_UTENTE_FILHO
  IF EXISTS (SELECT d.* FROM descendente d WHERE d.id_utente = adicionar_descendente.id_utente_filho AND d.id_descendente_utente = adicionar_descendente.id_utente_pai) THEN
    RAISE EXCEPTION 'O utente com o id % já é descendente do utente com o id %', adicionar_descendente.id_utente_pai, adicionar_descendente.id_utente_filho;
  END IF;

 -- ADD
  INSERT INTO descendente (
    id_utente,
    id_descendente_utente,
    tipo_associacao
  ) VALUES (
    adicionar_descendente.id_utente_pai,
    adicionar_descendente.id_utente_filho,
    adicionar_descendente.tipo_associacao
  );

  RETURN TRUE;
END
$$ LANGUAGE plpgsql;



-- CREATE UTENTE
CREATE OR REPLACE FUNCTION criar_utente(
  nome                  varchar(255),
  genero                int,
  data_nascimento       date,
  id_tipo_documento     int,
  num_cc                int,
  cod_validacao_cc      varchar(255),
  data_validade_cc      date,
  num_ident_seg_social  bigint,
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
    RAISE EXCEPTION 'A Data de Nascimento é obrigatória';
  END IF;
  -- CHECK IF DATA_NASCIMENTO IS VALID
  IF NOT check_birth_date(data_nascimento) THEN
    RAISE EXCEPTION 'A Data de nascimento é inválida';
  END IF;

  -- CHECK IF ID_TIPO_DOCUMENTO IS NULL
  IF id_tipo_documento IS NULL THEN
    RAISE EXCEPTION 'O Tipo de Documento é obrigatório';
  END IF;

  -- CHECK IF NUM_CC IS NULL
  IF num_cc IS NULL THEN
    RAISE EXCEPTION 'O Número de Documento é obrigatório';
  END IF;
  IF NOT check_cc_number(num_cc) THEN
    RAISE EXCEPTION 'O Número de Documento já se encontra registado';
  END IF;

  -- CHECK IF COD_VALIDACAO_CC IS NULL
  IF cod_validacao_cc IS NULL THEN
    RAISE EXCEPTION 'O Código de validação do Documento é obrigatório';
  END IF;

  -- CHECK IF DATA_VALIDADE_CC IS NULL
  IF data_validade_cc IS NULL THEN
    RAISE EXCEPTION 'A Data de validade do Documento é obrigatória';
  END IF;

  -- CHECK IF DATA_VALIDADE_CC IS VALID
  IF NOT check_cc_validity_date(data_validade_cc) THEN
    RAISE EXCEPTION 'A Data de validade do Documento é inválida';
  END IF;

  -- CHECK IF NUM_IDENT_SEG_SOCIAL IS NULL
  IF num_ident_seg_social IS NULL THEN
    RAISE EXCEPTION 'O Número de identificação da segurança social é obrigatório';
  END IF;
  IF NOT check_num_ident_seg_social(num_ident_seg_social) THEN
    RAISE EXCEPTION 'O Número de identificação da segurança social já se encontra registado';
  END IF;

  -- CHECK IF NUM_IDENT_FISCAL IS NULL
  IF num_ident_fiscal IS NULL THEN
    RAISE EXCEPTION 'O Número de identificação fiscal é obrigatório';
  END IF;
  IF NOT check_num_ident_fiscal(num_ident_fiscal) THEN
    RAISE EXCEPTION 'O Número de identificação fiscal já se encontra registado';
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

  -- CRIAR DESCENDENTE
  IF id_utente_pai IS NOT NULL THEN
    SELECT adicionar_descendente(
      id_utente_pai,
      id_utente_out,
      0
    );
  END IF;

    -- CRIAR DESCENDENTE
  IF id_utente_mae IS NOT NULL THEN
    SELECT adicionar_descendente(
      id_utente_mae,
      id_utente_out,
      1
    );
  END IF;

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

  
CREATE OR REPLACE FUNCTION ver_pedidos_utentes_tabela()
RETURNS TABLE (
  hashed_id             varchar(255),
  nome                  varchar(255),
  num_cc                int,
  num_ident_seg_social  bigint,
  num_ident_fiscal      int,
  pais                  varchar(255),
  distrito              varchar(255),
  concelho              varchar(255),
  data_pedido          timestamp
) AS $$
BEGIN

  RETURN QUERY SELECT 
      u.hashed_id,
      u.nome,
      u.num_cc,
      u.num_ident_seg_social,
      u.num_ident_fiscal,
      p.nome AS pais,
      d.nome AS distrito,
      c.nome AS concelho,
      u.data_criacao AS data_pedido
    FROM utente u
    INNER JOIN morada m ON m.id_utente = u.id_utente AND morada_preferencial = 1
    INNER JOIN concelho c ON c.id_concelho = m.id_concelho
    INNER JOIN distrito d ON d.id_distrito_estado = c.id_distrito_estado
    INNER JOIN pais p ON p.id_pais = d.id_pais
	WHERE u.estado=0;
END

$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION ver_info_utente(
  p_hashed_id varchar(255)
)
RETURNS TABLE (
  hashed_id             varchar(255),
  nome                  varchar(255),
  data_nascimento       date,
  hora_nascimento       time,
  genero                int,
  num_cc                int,
  data_validade_cc      date,
  cod_validacao_cc      varchar(255),
  num_utente            int,
  num_ident_seg_social  bigint,
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
  data_criacao          timestamp,
  data_registo          timestamp,
  id_tipo_documento     int,
  morada                json,
  pai                   json,
  mae                   json,
  descendentes          json,
  conjuge               json
) AS $$
DECLARE
  id_utente_out int;
BEGIN

  IF NOT EXISTS (SELECT u.* FROM utente u WHERE u.hashed_id = p_hashed_id) THEN
    RAISE EXCEPTION 'O utente com o hashed_id % não existe', p_hashed_id;
  ELSE 
    SELECT u.id_utente INTO id_utente_out FROM utente u WHERE u.hashed_id = p_hashed_id;
  END IF;

  RETURN QUERY SELECT 
      u.hashed_id,
      u.nome,
      u.data_nascimento,
      u.hora_nascimento,
      u.genero,
      u.num_cc,
      u.data_validade_cc,
      u.cod_validacao_cc,
      u.num_utente,
      u.num_ident_seg_social,
      u.num_ident_fiscal,
      u.estado_civil,
      u.situacao_profissional,
      u.profissao,
      u.hab_escolares,
      u.num_telemovel,
      u.num_telefone,
      u.email,
      u.obs_gerais,
      u.taxa_moderadora,
      u.seguro_saude,
      u.data_obito,
      u.estado,
      u.data_criacao,
      u.data_resposta,
      u.id_tipo_documento,
      json_build_object(
        'morada', m.morada,
        'freguesia', m.freguesia,
        'cod_postal', m.cod_postal,
        'numero_porta', m.num_porta,
        'andar', m.andar,
        'concelho', c.nome,
        'id_concelho', c.id_concelho,
        'distrito', d.nome,
        'id_distrito', d.id_distrito_estado,
        'pais', p.nome,
        'id_pais', p.id_pais
      ) AS morada,
      CASE WHEN u_pai.id_utente IS NULL THEN NULL ELSE (
        json_build_object(
          'hashed_id', u_pai.hashed_id,
          'nome', u_pai.nome,
          'num_utente', u_pai.num_utente,
          'num_cc', u_pai.num_cc,
          'num_ident_seg_social', u_pai.num_ident_seg_social,
          'num_ident_fiscal', u_pai.num_ident_fiscal,
          'data_nascimento', u_pai.data_nascimento,
          'genero', u_pai.genero,
          'estado_civil', u_pai.estado_civil,
          'num_telemovel', u_pai.num_telemovel,
          'num_telefone', u_pai.num_telefone,
          'estado', u_pai.estado,
          'data_criacao', u_pai.data_criacao,
          'id_tipo_documento', u_pai.id_tipo_documento
        )
      ) END AS pai,
      CASE WHEN u_mae.id_utente IS NULL THEN NULL ELSE (
        json_build_object(
          'hashed_id', u_mae.hashed_id,
          'nome', u_mae.nome,
          'num_utente', u_mae.num_utente,
          'num_cc', u_mae.num_cc,
          'num_ident_seg_social', u_mae.num_ident_seg_social,
          'num_ident_fiscal', u_mae.num_ident_fiscal,
          'data_nascimento', u_mae.data_nascimento,
          'genero', u_mae.genero,
          'estado_civil', u_mae.estado_civil,
          'num_telemovel', u_mae.num_telemovel,
          'num_telefone', u_mae.num_telefone,
          'estado', u_mae.estado,
          'data_criacao', u_mae.data_criacao,
          'id_tipo_documento', u_mae.id_tipo_documento
        )
      ) END AS mae,
      (
        SELECT json_agg(
          json_build_object(
            'hashed_id', u_d.hashed_id,
            'nome', u_d.nome,
            'num_utente', u_d.num_utente,
            'num_cc', u_d.num_cc,
            'num_ident_seg_social', u_d.num_ident_seg_social,
            'num_ident_fiscal', u_d.num_ident_fiscal,
            'data_nascimento', u_d.data_nascimento,
            'genero', u_d.genero,
            'estado_civil', u_d.estado_civil,
            'num_telemovel', u_d.num_telemovel,
            'num_telefone', u_d.num_telefone,
            'estado', u_d.estado,
            'data_criacao', u_d.data_criacao,
            'id_tipo_documento', u_d.id_tipo_documento,
            'tipo_associacao', d.tipo_associacao,
            'tipo_associacao_text', CASE WHEN d.tipo_associacao = 0 THEN 'Pai' ELSE 'Mãe' END
          )
        ) FROM descendente d
        INNER JOIN utente u_d ON u_d.id_utente = d.id_descendente_utente
        WHERE d.id_utente = id_utente_out
      ) AS descendentes,
      (
        SELECT json_agg(
          json_build_object(
            'hashed_id', u_c.hashed_id,
            'nome', u_c.nome,
            'num_utente', u_c.num_utente,
            'num_cc', u_c.num_cc,
            'num_ident_seg_social', u_c.num_ident_seg_social,
            'num_ident_fiscal', u_c.num_ident_fiscal,
            'data_nascimento', u_c.data_nascimento,
            'genero', u_c.genero,
            'estado_civil', u_c.estado_civil,
            'num_telemovel', u_c.num_telemovel,
            'num_telefone', u_c.num_telefone,
            'estado', u_c.estado,
            'data_criacao', u_c.data_criacao,
            'id_tipo_documento', u_c.id_tipo_documento,
            'data_associacao', c.data_associacao,
            'data_desassociacao', c.data_desassociacao,
            'estado_casamento', (
              CASE WHEN c.data_desassociacao IS NULL THEN 'Casado' ELSE 'Divorciado' END
            )
          )
        ) FROM conjuge c
        INNER JOIN utente u_c ON (u_c.id_utente = c.id_utente AND c.id_utente != id_utente_out) OR (u_c.id_utente = c.id_conjuge_utente AND c.id_conjuge_utente != id_utente_out)
        WHERE c.id_utente = id_utente_out OR c.id_conjuge_utente = id_utente_out
      ) AS conjuge
    FROM utente u
    INNER JOIN morada m ON m.id_utente = u.id_utente AND morada_preferencial = 1
    INNER JOIN concelho c ON c.id_concelho = m.id_concelho
    INNER JOIN distrito d ON d.id_distrito_estado = c.id_distrito_estado
    INNER JOIN pais p ON p.id_pais = d.id_pais
    LEFT JOIN descendente d_pai ON d_pai.id_descendente_utente = u.id_utente AND d_pai.tipo_associacao = 0
    LEFT JOIN utente u_pai ON u_pai.id_utente = d_pai.id_utente
    LEFT JOIN descendente d_mae ON d_mae.id_descendente_utente = u.id_utente AND d_mae.tipo_associacao = 1
    LEFT JOIN utente u_mae ON u_mae.id_utente = d_mae.id_utente
    WHERE u.id_utente = id_utente_out;
END
$$ LANGUAGE plpgsql;

-- GENERATE PATIENT NUMBER
CREATE OR REPLACE FUNCTION gerar_num_utente()
RETURNS INT AS $$
DECLARE
  num_utente_out int;
BEGIN
  -- GENERATE NUM_UTENTE RANDOMLY
  WHILE TRUE LOOP
    --ALWAYS 9 DIGITS
    num_utente_out = FLOOR(RANDOM() * 900000000) + 100000000;
    IF check_num_utente(num_utente_out) THEN
      EXIT;
    END IF;
  END LOOP;
  RETURN num_utente_out;
END
$$ LANGUAGE plpgsql;

-- ACCEPT PATIENT
CREATE OR REPLACE FUNCTION aceitar_utente(
  p_hashed_id varchar(255)
)
RETURNS BOOLEAN AS $$
DECLARE
  id_utente_out int;
  num_utente_out int;
BEGIN
  
    IF NOT EXISTS (SELECT u.* FROM utente u WHERE u.hashed_id = p_hashed_id) THEN
      RAISE EXCEPTION 'O utente com o hashed_id % não existe', p_hashed_id;
    ELSE 
      SELECT u.id_utente INTO id_utente_out FROM utente u WHERE u.hashed_id = p_hashed_id;
    END IF;
  
    -- CHECK IF NUM_UTENTE IS NULL
    IF EXISTS (SELECT u.* FROM utente u WHERE u.id_utente = id_utente_out AND u.num_utente IS NOT NULL) THEN
      RAISE EXCEPTION 'O utente com o hashed_id % já tem um número de utente atribuído', p_hashed_id;
    END IF;
  
    -- GENERATE NUM_UTENTE
    num_utente_out = gerar_num_utente();
  
    -- UPDATE UTENTE
    UPDATE utente SET
      num_utente = num_utente_out,
      estado = 1,
      data_resposta = NOW()
    WHERE id_utente = id_utente_out;
  
    RETURN TRUE;
  END
  $$ LANGUAGE plpgsql;

-- REJECT PATIENT
CREATE OR REPLACE FUNCTION rejeitar_utente(
  p_hashed_id varchar(255)
)
RETURNS BOOLEAN AS $$
DECLARE
  id_utente_out int;
BEGIN
  
    IF NOT EXISTS (SELECT u.* FROM utente u WHERE u.hashed_id = p_hashed_id) THEN
      RAISE EXCEPTION 'O utente com o hashed_id % não existe', p_hashed_id;
    ELSE 
      SELECT u.id_utente INTO id_utente_out FROM utente u WHERE u.hashed_id = p_hashed_id;
    END IF;
  
    -- CHECK IF NUM_UTENTE IS NULL
    IF EXISTS (SELECT u.* FROM utente u WHERE u.id_utente = id_utente_out AND u.num_utente IS NOT NULL) THEN
      RAISE EXCEPTION 'O utente com o hashed_id % já tem um número de utente atribuído', p_hashed_id;
    END IF;
  
    -- UPDATE UTENTE
    UPDATE utente SET
      estado = 2,
      data_resposta = NOW()
    WHERE id_utente = id_utente_out;
  
    RETURN TRUE;
  END
  $$ LANGUAGE plpgsql;


-- VER UTENTES DATATABLE
CREATE OR REPLACE FUNCTION ver_utentes_tabela()
RETURNS TABLE (
  hashed_id             varchar(255),
  nome                  varchar(255),
  num_cc                int,
  num_ident_seg_social  bigint,
  num_ident_fiscal      int,
  num_utente            int,
  pais                  varchar(255),
  distrito              varchar(255),
  concelho              varchar(255),
  nome_mae              varchar(255),
  nome_pai              varchar(255),
  nome_conjuge          varchar(255),
  data_registo          timestamp
) AS $$
BEGIN
  RETURN QUERY SELECT 
      u.hashed_id,
      u.nome,
      u.num_cc,
      u.num_ident_seg_social,
      u.num_ident_fiscal,
      u.num_utente,
      p.nome AS pais,
      d.nome AS distrito,
      c.nome AS concelho,
      u_mae.nome AS nome_mae,
      u_pai.nome AS nome_pai,
      u_conjuge.nome AS nome_conjuge,
      u.data_resposta AS data_registo
    FROM utente u
    INNER JOIN morada m ON m.id_utente = u.id_utente AND morada_preferencial = 1
    INNER JOIN concelho c ON c.id_concelho = m.id_concelho
    INNER JOIN distrito d ON d.id_distrito_estado = c.id_distrito_estado
    INNER JOIN pais p ON p.id_pais = d.id_pais
    LEFT JOIN descendente d_pai ON d_pai.id_descendente_utente = u.id_utente AND d_pai.tipo_associacao = 0
    LEFT JOIN utente u_pai ON u_pai.id_utente = d_pai.id_utente
    LEFT JOIN descendente d_mae ON d_mae.id_descendente_utente = u.id_utente AND d_mae.tipo_associacao = 1
    LEFT JOIN utente u_mae ON u_mae.id_utente = d_mae.id_utente
    LEFT JOIN conjuge c_u ON (c_u.id_utente = u.id_utente OR c_u.id_conjuge_utente = u.id_utente) AND c_u.data_desassociacao IS NULL
    LEFT JOIN utente u_conjuge ON (u_conjuge.id_utente = c_u.id_utente AND c_u.id_utente != u.id_utente) OR (u_conjuge.id_utente = c_u.id_conjuge_utente AND c_u.id_conjuge_utente != u.id_utente)
	WHERE u.estado=1;
END

$$ LANGUAGE plpgsql;


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
  cod_validacao_cc      varchar(255), 
  num_utente            int, 
  num_ident_seg_social  bigint, 
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


-- CHECK IF UTENTE IS MATIED
CREATE OR REPLACE FUNCTION check_utente_casado(hashed_id_in varchar(255) )
RETURNS BOOLEAN AS $$
DECLARE
  id_utente_out int;
BEGIN
  IF hashed_id_in IS NULL OR hashed_id_in = '' THEN
    RAISE EXCEPTION 'O hashed_id é obrigatório';
  END IF;

  IF NOT EXISTS (SELECT u.* FROM utente u WHERE u.hashed_id = hashed_id_in) THEN
    RAISE EXCEPTION 'O utente com o hashed_id % não existe', hashed_id_in;
  ELSE 
    SELECT u.id_utente INTO id_utente_out FROM utente u WHERE u.hashed_id = hashed_id_in;
  END IF;

  IF EXISTS (
    SELECT 
      u.* 
    FROM utente u 
    INNER JOIN conjuge c ON (c.id_utente = u.id_utente OR c.id_conjuge_utente = u.id_utente) AND c.data_desassociacao IS NULL
    WHERE u.id_utente = id_utente_out
  ) THEN
    RETURN TRUE;
  ELSE
    RETURN FALSE;
  END IF;
END
$$ LANGUAGE plpgsql;

-- MARRY UTENTE
CREATE OR REPLACE FUNCTION casar_utente(
  hashed_id_in varchar(255),
  hashed_id_conjuge_in varchar(255)
)
RETURNS BOOLEAN AS $$
DECLARE
  id_utente_out int;
  name_out varchar(255);
  id_utente_conjuge_out int;
  name_conjuge_out varchar(255);
BEGIN
  IF hashed_id_in IS NULL OR hashed_id_in = '' THEN
    RAISE EXCEPTION 'O hashed_id é obrigatório';
  END IF;

  IF hashed_id_conjuge_in IS NULL OR hashed_id_conjuge_in = '' THEN
    RAISE EXCEPTION 'O hashed_id do conjuge é obrigatório';
  END IF;

  IF NOT EXISTS (SELECT u.* FROM utente u WHERE u.hashed_id = hashed_id_in) THEN
    RAISE EXCEPTION 'O utente com o hashed_id % não existe', hashed_id_in;
  ELSE 
    SELECT u.id_utente, u.nome INTO id_utente_out, name_out FROM utente u WHERE u.hashed_id = hashed_id_in;
  END IF;

  IF NOT EXISTS (SELECT u.* FROM utente u WHERE u.hashed_id = hashed_id_conjuge_in) THEN
    RAISE EXCEPTION 'O utente com o hashed_id % não existe', hashed_id_conjuge_in;
  ELSE 
    SELECT u.id_utente, u.nome INTO id_utente_conjuge_out, name_conjuge_out FROM utente u WHERE u.hashed_id = hashed_id_conjuge_in;
  END IF;

  IF check_utente_casado(hashed_id_in) THEN
    RAISE EXCEPTION 'O utente % encontrasse casado', name_out;
  END IF;

  IF check_utente_casado(hashed_id_conjuge_in) THEN
    RAISE EXCEPTION 'O utente % encontrasse casado', name_conjuge_out;
  END IF;

  INSERT INTO conjuge (
    id_utente,
    id_conjuge_utente
  ) VALUES (
    id_utente_out,
    id_utente_conjuge_out
  );

  -- UPDATE UTENTE estado_civil
  UPDATE utente SET
    estado_civil = 2
  WHERE id_utente = id_utente_out;

  -- UPDATE UTENTE estado_civil
  UPDATE utente SET
    estado_civil = 2
  WHERE id_utente = id_utente_conjuge_out;

  RETURN TRUE;
END
$$ LANGUAGE plpgsql;

-- DIVORCIAR UTENTE
CREATE OR REPLACE FUNCTION divorciar_utente(
  hashed_id_in varchar(255)
)
RETURNS BOOLEAN AS $$
DECLARE
  id_utente_out int;
  name_out varchar(255);
  id_utente_conjuge_out int;
  name_conjuge_out varchar(255);
BEGIN
  IF hashed_id_in IS NULL OR hashed_id_in = '' THEN
    RAISE EXCEPTION 'O hashed_id é obrigatório';
  END IF;

  IF NOT EXISTS (SELECT u.* FROM utente u WHERE u.hashed_id = hashed_id_in) THEN
    RAISE EXCEPTION 'O utente com o hashed_id % não existe', hashed_id_in;
  ELSE 
    SELECT u.id_utente, u.nome INTO id_utente_out, name_out FROM utente u WHERE u.hashed_id = hashed_id_in;
  END IF;

  IF NOT check_utente_casado(hashed_id_in) THEN
    RAISE EXCEPTION 'O utente % não se encontra casado', name_out;
  END IF;

  SELECT c.id_conjuge_utente INTO id_utente_conjuge_out FROM conjuge c WHERE c.id_utente = id_utente_out AND c.data_desassociacao IS NULL;

  IF id_utente_conjuge_out = id_utente_out THEN
    SELECT c.id_utente INTO id_utente_conjuge_out FROM conjuge c WHERE c.id_conjuge_utente = id_utente_out AND c.data_desassociacao IS NULL;
  END IF;

  -- UPDATE CONJUGE
  UPDATE conjuge SET
    data_desassociacao = NOW()
  WHERE (id_utente = id_utente_out OR id_conjuge_utente = id_utente_out) AND data_desassociacao IS NULL;

  -- UPDATE UTENTE estado_civil
  UPDATE utente SET
    estado_civil = 4
  WHERE id_utente = id_utente_out;

  -- UPDATE UTENTE estado_civil
  UPDATE utente SET
    estado_civil = 4
  WHERE id_utente = id_utente_conjuge_out;

  RETURN TRUE;
END
$$ LANGUAGE plpgsql;

--Adicionar Contacto de Emergência
CREATE OR REPLACE FUNCTION adicionar_contacto_emergencia(
  hashed_id_in varchar(255),
  nome_contacto_emergencia_in varchar(255),
  contacto_emergencia_in varchar(255)
)
RETURNS BOOLEAN AS $$
DECLARE
  id_utente_out int;
  name_out varchar(255);
BEGIN
  IF hashed_id_in IS NULL OR hashed_id_in = '' THEN
    RAISE EXCEPTION 'O hashed_id é obrigatório';
  END IF;

  IF nome_contacto_emergencia_in IS NULL OR nome_contacto_emergencia_in = '' THEN
    RAISE EXCEPTION 'O nome do contacto de emergência é obrigatório';
  END IF;

  IF contacto_emergencia_in IS NULL THEN
    RAISE EXCEPTION 'O contacto de emergência é obrigatório';
  END IF;

  IF NOT EXISTS (SELECT u.* FROM utente u WHERE u.hashed_id = hashed_id_in) THEN
    RAISE EXCEPTION 'O utente com o hashed_id % não existe', hashed_id_in;
  ELSE 
    SELECT u.id_utente, u.nome INTO id_utente_out, name_out FROM utente u WHERE u.hashed_id = hashed_id_in;
  END IF;

  -- CHECK IF CONTACTO EMERGENCIA IS NULL
  IF EXISTS (SELECT c.* FROM contacto_emergencia c WHERE c.id_utente = id_utente_out AND c.nome_contacto_emergencia = nome_contacto_emergencia_in) THEN
    RAISE EXCEPTION 'O utente % já tem um contacto de emergência com o nome %', name_out, nome_contacto_emergencia_in;
  END IF;

  -- CHECK IF CONTACTO EMERGENCIA IS NULL
  IF EXISTS (SELECT c.* FROM contacto_emergencia c WHERE c.id_utente = id_utente_out AND c.contacto_emergencia = contacto_emergencia_in) THEN
    RAISE EXCEPTION 'O utente % já tem um contacto de emergência com o número %', name_out, contacto_emergencia_in;
  END IF;

  -- ADD
  INSERT INTO contacto_emergencia (
    id_utente,
    nome_contacto_emergencia,
    contacto_emergencia
  ) VALUES (
    id_utente_out,
    nome_contacto_emergencia_in,
    contacto_emergencia_in
  );

  RETURN TRUE;
END
$$ LANGUAGE plpgsql;

--Get Contactos de Emergência
CREATE OR REPLACE FUNCTION ver_contactos_emergencia(
  hashed_id_in varchar(255)
)
RETURNS TABLE (
  id_contacto_emergencia   int,
  nome_contacto_emergencia  varchar(255),
  contacto_emergencia       varchar(255),
  data_associacao              timestamp
) AS $$
DECLARE
  id_utente_out int;
  name_out varchar(255);
BEGIN
  IF hashed_id_in IS NULL OR hashed_id_in = '' THEN
    RAISE EXCEPTION 'O hashed_id é obrigatório';
  END IF;

  IF NOT EXISTS (SELECT u.* FROM utente u WHERE u.hashed_id = hashed_id_in) THEN
    RAISE EXCEPTION 'O utente com o hashed_id % não existe', hashed_id_in;
  ELSE 
    SELECT u.id_utente, u.nome INTO id_utente_out, name_out FROM utente u WHERE u.hashed_id = hashed_id_in;
  END IF;

  RETURN QUERY SELECT 
    c.id_contacto_emergencia,
    c.nome_contacto_emergencia,
    c.contacto_emergencia,
    c.data_associacao
  FROM contacto_emergencia c
  WHERE c.id_utente = id_utente_out;
END
$$ LANGUAGE plpgsql;

--Remover Contacto de Emergência
CREATE OR REPLACE FUNCTION remover_contacto_emergencia(
  id_contacto_emergencia_in int
)
RETURNS BOOLEAN AS $$
DECLARE
  id_utente_out int;
  name_out varchar(255);
BEGIN
  IF id_contacto_emergencia_in IS NULL THEN
    RAISE EXCEPTION 'O id_contacto_emergencia é obrigatório';
  END IF;

  IF NOT EXISTS (SELECT c.* FROM contacto_emergencia c WHERE c.id_contacto_emergencia = id_contacto_emergencia_in) THEN
    RAISE EXCEPTION 'O contacto de emergência com o id % não existe', id_contacto_emergencia_in;
  END IF;

  SELECT c.id_utente INTO id_utente_out FROM contacto_emergencia c WHERE c.id_contacto_emergencia = id_contacto_emergencia_in;

  -- REMOVE
  DELETE FROM contacto_emergencia WHERE id_contacto_emergencia = id_contacto_emergencia_in;

  RETURN TRUE;
END
$$ LANGUAGE plpgsql;

--Adicionar Medicação Especial
CREATE OR REPLACE FUNCTION adicionar_medicacao_especial(
  hashed_id_in varchar(255),
  motivo_in varchar(255),
  data_inicio_in date,
  data_fim_in date
)
RETURNS BOOLEAN AS $$
DECLARE
  id_utente_out int;
  name_out varchar(255);
BEGIN
  IF hashed_id_in IS NULL OR hashed_id_in = '' THEN
    RAISE EXCEPTION 'O hashed_id é obrigatório';
  END IF;

  IF motivo_in IS NULL OR motivo_in = '' THEN
    RAISE EXCEPTION 'O motivo é obrigatório';
  END IF;

  IF data_inicio_in IS NULL THEN
    RAISE EXCEPTION 'A data de início é obrigatória';
  END IF;

  IF data_fim_in IS NULL THEN
    RAISE EXCEPTION 'A data de fim é obrigatória';
  END IF;

  IF data_inicio_in > data_fim_in THEN
    RAISE EXCEPTION 'A data de início tem de ser anterior à data de fim';
  END IF;

  IF NOT EXISTS (SELECT u.* FROM utente u WHERE u.hashed_id = hashed_id_in) THEN
    RAISE EXCEPTION 'O utente com o hashed_id % não existe', hashed_id_in;
  ELSE 
    SELECT u.id_utente, u.nome INTO id_utente_out, name_out FROM utente u WHERE u.hashed_id = hashed_id_in;
  END IF;

  -- CHECK IF MEDICACAO ESPECIAL IS NULL
  IF EXISTS (SELECT m.* FROM medicacao_especial m WHERE m.id_utente = id_utente_out AND m.motivo = motivo_in) THEN
    RAISE EXCEPTION 'O utente % já tem uma medicação especial com o motivo %', name_out, motivo_in;
  END IF;

  -- ADD
  INSERT INTO medicacao_especial (
    id_utente,
    motivo,
    data_inicio,
    data_fim
  ) VALUES (
    id_utente_out,
    motivo_in,
    data_inicio_in,
    data_fim_in
  );

  RETURN TRUE;
END
$$ LANGUAGE plpgsql;

--Get Medicação Especial Utente
CREATE OR REPLACE FUNCTION ver_medicacao_especial(
  hashed_id_in varchar(255)
)
RETURNS TABLE (
  id_medicacao_especial   int,
  motivo                  varchar(255),
  data_inicio             date,
  data_fim                date,
  data_criacao            timestamp
) AS $$
DECLARE
  id_utente_out int;
  name_out varchar(255);
BEGIN
  IF hashed_id_in IS NULL OR hashed_id_in = '' THEN
    RAISE EXCEPTION 'O hashed_id é obrigatório';
  END IF;

  IF NOT EXISTS (SELECT u.* FROM utente u WHERE u.hashed_id = hashed_id_in) THEN
    RAISE EXCEPTION 'O utente com o hashed_id % não existe', hashed_id_in;
  ELSE 
    SELECT u.id_utente, u.nome INTO id_utente_out, name_out FROM utente u WHERE u.hashed_id = hashed_id_in;
  END IF;

  RETURN QUERY SELECT 
    m.id_medicacao_especial,
    m.motivo,
    m.data_inicio,
    m.data_fim,
    m.data_criacao
  FROM medicacao_especial m
  WHERE m.id_utente = id_utente_out;
END
$$ LANGUAGE plpgsql;

--Remover Medicação Especial
CREATE OR REPLACE FUNCTION remover_medicacao_especial(
  id_medicacao_especial_in int
)
RETURNS BOOLEAN AS $$
DECLARE
  id_utente_out int;
  name_out varchar(255);
BEGIN
  IF id_medicacao_especial_in IS NULL THEN
    RAISE EXCEPTION 'O id_medicacao_especial é obrigatório';
  END IF;

  IF NOT EXISTS (SELECT m.* FROM medicacao_especial m WHERE m.id_medicacao_especial = id_medicacao_especial_in) THEN
    RAISE EXCEPTION 'A medicação especial com o id % não existe', id_medicacao_especial_in;
  END IF;

  SELECT m.id_utente INTO id_utente_out FROM medicacao_especial m WHERE m.id_medicacao_especial = id_medicacao_especial_in;

  -- REMOVE
  DELETE FROM medicacao_especial WHERE id_medicacao_especial = id_medicacao_especial_in;

  RETURN TRUE;
END
$$ LANGUAGE plpgsql;

--Adicionar Isencao
CREATE OR REPLACE FUNCTION adicionar_isencao(
  hashed_id_in varchar(255),
  motivo_in varchar(255),
  data_inicio_in date,
  data_fim_in date
)
RETURNS BOOLEAN AS $$
DECLARE
  id_utente_out int;
  name_out varchar(255);
BEGIN
  IF hashed_id_in IS NULL OR hashed_id_in = '' THEN
    RAISE EXCEPTION 'O hashed_id é obrigatório';
  END IF;

  IF motivo_in IS NULL OR motivo_in = '' THEN
    RAISE EXCEPTION 'O motivo é obrigatório';
  END IF;

  IF data_inicio_in IS NULL THEN
    RAISE EXCEPTION 'A data de início é obrigatória';
  END IF;

  IF data_fim_in IS NULL THEN
    RAISE EXCEPTION 'A data de fim é obrigatória';
  END IF;

  IF data_inicio_in > data_fim_in THEN
    RAISE EXCEPTION 'A data de início tem de ser anterior à data de fim';
  END IF;

  IF NOT EXISTS (SELECT u.* FROM utente u WHERE u.hashed_id = hashed_id_in) THEN
    RAISE EXCEPTION 'O utente com o hashed_id % não existe', hashed_id_in;
  ELSE 
    SELECT u.id_utente, u.nome INTO id_utente_out, name_out FROM utente u WHERE u.hashed_id = hashed_id_in;
  END IF;

  -- CHECK IF ISENCAO IS NULL
  IF EXISTS (SELECT i.* FROM isencao i WHERE i.id_utente = id_utente_out AND i.motivo = motivo_in) THEN
    RAISE EXCEPTION 'O utente % já tem uma isenção com o motivo %', name_out, motivo_in;
  END IF;

  -- ADD
  INSERT INTO isencao (
    id_utente,
    motivo,
    data_inicio,
    data_fim
  ) VALUES (
    id_utente_out,
    motivo_in,
    data_inicio_in,
    data_fim_in
  );

  RETURN TRUE;
END
$$ LANGUAGE plpgsql;

--Get Isenções Utente
CREATE OR REPLACE FUNCTION ver_isencoes(
  hashed_id_in varchar(255)
)
RETURNS TABLE (
  id_isencao              int,
  motivo                  varchar(255),
  data_inicio             date,
  data_fim                date,
  data_criacao            timestamp
) AS $$
DECLARE
  id_utente_out int;
  name_out varchar(255);
BEGIN
  IF hashed_id_in IS NULL OR hashed_id_in = '' THEN
    RAISE EXCEPTION 'O hashed_id é obrigatório';
  END IF;

  IF NOT EXISTS (SELECT u.* FROM utente u WHERE u.hashed_id = hashed_id_in) THEN
    RAISE EXCEPTION 'O utente com o hashed_id % não existe', hashed_id_in;
  ELSE 
    SELECT u.id_utente, u.nome INTO id_utente_out, name_out FROM utente u WHERE u.hashed_id = hashed_id_in;
  END IF;

  RETURN QUERY SELECT 
    i.id_isencao,
    i.motivo,
    i.data_inicio,
    i.data_fim,
    i.data_criacao
  FROM isencao i
  WHERE i.id_utente = id_utente_out;
END
$$ LANGUAGE plpgsql;

--Remover Isenção
CREATE OR REPLACE FUNCTION remover_isencao(
  id_isencao_in int
)
RETURNS BOOLEAN AS $$
DECLARE
  id_utente_out int;
  name_out varchar(255);
BEGIN

  IF id_isencao_in IS NULL THEN
    RAISE EXCEPTION 'O id_isencao é obrigatório';
  END IF;

  IF NOT EXISTS (SELECT i.* FROM isencao i WHERE i.id_isencao = id_isencao_in) THEN
    RAISE EXCEPTION 'A isenção com o id % não existe', id_isencao_in;
  END IF;

  SELECT i.id_utente INTO id_utente_out FROM isencao i WHERE i.id_isencao = id_isencao_in;

  -- REMOVE
  DELETE FROM isencao WHERE id_isencao = id_isencao_in;

  RETURN TRUE;
END
$$ LANGUAGE plpgsql;

--Adicionar Comparticipação de Medicação
CREATE OR REPLACE FUNCTION adicionar_comparticipacao_medicamentos(
  hashed_id_in varchar(255),
  motivo_in varchar(255),
  data_inicio_in date,
  data_fim_in date
)
RETURNS BOOLEAN AS $$
DECLARE
  id_utente_out int;
  name_out varchar(255);
BEGIN
  IF hashed_id_in IS NULL OR hashed_id_in = '' THEN
    RAISE EXCEPTION 'O hashed_id é obrigatório';
  END IF;

  IF motivo_in IS NULL OR motivo_in = '' THEN
    RAISE EXCEPTION 'O motivo é obrigatório';
  END IF;

  IF data_inicio_in IS NULL THEN
    RAISE EXCEPTION 'A data de início é obrigatória';
  END IF;

  IF data_fim_in IS NULL THEN
    RAISE EXCEPTION 'A data de fim é obrigatória';
  END IF;

  IF data_inicio_in > data_fim_in THEN
    RAISE EXCEPTION 'A data de início tem de ser anterior à data de fim';
  END IF;

  IF NOT EXISTS (SELECT u.* FROM utente u WHERE u.hashed_id = hashed_id_in) THEN
    RAISE EXCEPTION 'O utente com o hashed_id % não existe', hashed_id_in;
  ELSE 
    SELECT u.id_utente, u.nome INTO id_utente_out, name_out FROM utente u WHERE u.hashed_id = hashed_id_in;
  END IF;

  -- CHECK IF COMPARTICIPACAO MEDICACAO IS NULL
  IF EXISTS (SELECT c.* FROM comparticipacao_medicamentos c WHERE c.id_utente = id_utente_out AND c.motivo = motivo_in) THEN
    RAISE EXCEPTION 'O utente % já tem uma comparticipação de medicação com o motivo %', name_out, motivo_in;
  END IF;

  -- ADD
  INSERT INTO comparticipacao_medicamentos (
    id_utente,
    motivo,
    data_inicio,
    data_fim
  ) VALUES (
    id_utente_out,
    motivo_in,
    data_inicio_in,
    data_fim_in
  );

  RETURN TRUE;
END
$$ LANGUAGE plpgsql;


--Get Comparticipações de Medicação Utente
CREATE OR REPLACE FUNCTION ver_comparticipacoes_medicacao(
  hashed_id_in varchar(255)
)
RETURNS TABLE (
  id_comparticipacao_medicamentos              int,
  motivo                  varchar(255),
  data_inicio             date,
  data_fim                date,
  data_criacao            timestamp
) AS $$
DECLARE
  id_utente_out int;
  name_out varchar(255);
BEGIN

  IF hashed_id_in IS NULL OR hashed_id_in = '' THEN
    RAISE EXCEPTION 'O hashed_id é obrigatório';
  END IF;
  
  IF NOT EXISTS (SELECT u.* FROM utente u WHERE u.hashed_id = hashed_id_in) THEN
    RAISE EXCEPTION 'O utente com o hashed_id % não existe', hashed_id_in; 
  ELSE 
    SELECT u.id_utente, u.nome INTO id_utente_out, name_out FROM utente u WHERE u.hashed_id = hashed_id_in; 
  END IF;

  RETURN QUERY SELECT 
    c.id_comparticipacao_medicamentos,
    c.motivo,
    c.data_inicio,
    c.data_fim,
    c.data_criacao
  FROM comparticipacao_medicamentos c
  WHERE c.id_utente = id_utente_out;
END
$$ LANGUAGE plpgsql;

--Remover Comparticipação de Medicação
CREATE OR REPLACE FUNCTION remover_comparticipacao_medicamentos(
  id_comparticipacao_medicamentos_in int
)
RETURNS BOOLEAN AS $$
DECLARE
  id_utente_out int;
  name_out varchar(255);
BEGIN
  
    IF id_comparticipacao_medicamentos_in IS NULL THEN
      RAISE EXCEPTION 'O id_comparticipacao_medicamentos é obrigatório';
    END IF;
  
    IF NOT EXISTS (SELECT c.* FROM comparticipacao_medicamentos c WHERE c.id_comparticipacao_medicamentos = id_comparticipacao_medicamentos_in) THEN
      RAISE EXCEPTION 'A comparticipação de medicação com o id % não existe', id_comparticipacao_medicamentos_in;
    END IF;
  
    SELECT c.id_utente INTO id_utente_out FROM comparticipacao_medicamentos c WHERE c.id_comparticipacao_medicamentos = id_comparticipacao_medicamentos_in;
  
    -- REMOVE
    DELETE FROM comparticipacao_medicamentos WHERE id_comparticipacao_medicamentos = id_comparticipacao_medicamentos_in;
  
    RETURN TRUE;
  END
  $$ LANGUAGE plpgsql;









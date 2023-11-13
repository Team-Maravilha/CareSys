-- SQLBook: Code

-- CHECK IF pais EXISTS
CREATE OR REPLACE FUNCTION verificar_se_pais_existe(id_pais int) RETURNS BOOLEAN AS $$
BEGIN
    IF EXISTS (SELECT p.* FROM pais p WHERE p.id_pais = verificar_se_pais_existe.id_pais) THEN
        RETURN TRUE; -- pais EXISTS
    ELSE
        RETURN FALSE; -- pais DOES NOT EXIST
    END IF;
END
$$ LANGUAGE plpgsql;

-- Check if pais EXISTS
CREATE OR REPLACE FUNCTION verificar_se_pais_existe_nome(nome varchar(255)) RETURNS BOOLEAN AS $$
BEGIN
    IF EXISTS (SELECT p.* FROM pais p WHERE p.nome = verificar_se_pais_existe_nome.nome) THEN
        RETURN TRUE; -- pais EXISTS
    ELSE
        RETURN FALSE; -- pais DOES NOT EXIST
    END IF;
END
$$ LANGUAGE plpgsql;

-- CHECK IF ALPHACODE EXISTS
CREATE OR REPLACE FUNCTION verificar_se_codigo_alpha_existe(codigo_alpha varchar(3)) RETURNS BOOLEAN AS $$
BEGIN
    IF EXISTS (SELECT p.* FROM pais p WHERE p.codigo_alpha = verificar_se_codigo_alpha_existe.codigo_alpha) THEN
        RETURN TRUE; -- ALPHACODE EXISTS
    ELSE
        RETURN FALSE; -- ALPHACODE DOES NOT EXIST
    END IF;
END
$$ LANGUAGE plpgsql;

-- CREATE pais
CREATE OR REPLACE FUNCTION criar_pais(
  nome varchar(255),
  codigo_alpha varchar(3)
)
RETURNS INT AS $$
DECLARE
  id_pais_out int;
BEGIN
    IF nome IS NULL OR nome = '' THEN
        RAISE EXCEPTION 'O nome do país é obrigatório';
    END IF;

    IF codigo_alpha IS NULL OR codigo_alpha = '' THEN
        RAISE EXCEPTION 'O código alpha do país é obrigatório';
    END IF;

    IF verificar_se_pais_existe_nome(nome) THEN
        RAISE EXCEPTION 'O país com o nome % já existe', nome;
    END IF;

    IF verificar_se_codigo_alpha_existe(codigo_alpha) THEN
        RAISE EXCEPTION 'O código alpha % já existe', codigo_alpha;
    END IF;

    INSERT INTO pais (nome, codigo_alpha) VALUES (nome, codigo_alpha) RETURNING id_pais INTO id_pais_out;

    RETURN id_pais_out;
END
$$ LANGUAGE plpgsql;

-- Check if distrito EXISTS in country
CREATE OR REPLACE FUNCTION verificar_se_distrito_existe_em_pais(nome varchar(255), id_pais int) 
RETURNS BOOLEAN AS $$
BEGIN
    IF EXISTS (SELECT d.* FROM distrito d WHERE d.nome = verificar_se_distrito_existe_em_pais.nome AND d.id_pais = verificar_se_distrito_existe_em_pais.id_pais) THEN
        RETURN TRUE; -- distrito EXISTS
    ELSE
        RETURN FALSE; -- distrito DOES NOT EXIST
    END IF;
END
$$ LANGUAGE plpgsql;

-- CHECK if distrito EXISTS in pais
CREATE OR REPLACE FUNCTION verificar_se_distrito_existe_em_pais_id(id_distrito int, id_pais int)
RETURNS BOOLEAN AS $$
BEGIN
    IF EXISTS (SELECT d.* FROM distrito d WHERE d.id_distrito_estado = verificar_se_distrito_existe_em_pais_id.id_distrito AND d.id_pais = verificar_se_distrito_existe_em_pais_id.id_pais) THEN
        RETURN TRUE; -- distrito EXISTS
    ELSE
        RETURN FALSE; -- distrito DOES NOT EXIST
    END IF;
END
$$ LANGUAGE plpgsql;


-- CREATE distrito
CREATE OR REPLACE FUNCTION criar_distrito(
  nome varchar(255),
  id_pais int
)
RETURNS INT AS $$
DECLARE
  id_distrito_out int;
BEGIN
    IF nome IS NULL OR nome = '' THEN
        RAISE EXCEPTION 'O nome do distrito é obrigatório';
    END IF;

    IF id_pais IS NULL THEN
        RAISE EXCEPTION 'O id do país é obrigatório';
    END IF;

    IF NOT verificar_se_pais_existe(id_pais) THEN
        RAISE EXCEPTION 'O país com o id % não existe', id_pais;
    END IF;

    IF verificar_se_distrito_existe_em_pais(nome, id_pais) THEN
        RAISE EXCEPTION 'O distrito com o nome % já existe no país com o nome %', nome, (SELECT p.nome FROM pais p WHERE p.id_pais = id_pais);
    END IF;

    INSERT INTO distrito (nome, id_pais) VALUES (nome, id_pais) RETURNING id_distrito_estado INTO id_distrito_out;

    RETURN id_distrito_out;
END
$$ LANGUAGE plpgsql;

-- Check if concelho EXISTS in distrito
CREATE OR REPLACE FUNCTION verificar_se_concelho_existe_em_distrito(nome varchar(255), id_distrito int)
RETURNS BOOLEAN AS $$
BEGIN
    IF EXISTS (SELECT c.* FROM concelho c WHERE c.nome = verificar_se_concelho_existe_em_distrito.nome AND c.id_distrito_estado = verificar_se_concelho_existe_em_distrito.id_distrito) THEN
        RETURN TRUE; -- concelho EXISTS
    ELSE
        RETURN FALSE; -- concelho DOES NOT EXIST
    END IF;
END
$$ LANGUAGE plpgsql;

-- CREATE concelho
CREATE OR REPLACE FUNCTION criar_concelho(
  nome varchar(255),
  id_distrito int,
  id_pais int
)
RETURNS INT AS $$
DECLARE
    id_concelho_out int;
BEGIN
    IF nome IS NULL OR nome = '' THEN
        RAISE EXCEPTION 'O nome do concelho é obrigatório';
    END IF;

    IF id_distrito IS NULL THEN
        RAISE EXCEPTION 'O id do distrito é obrigatório';
    END IF;

    IF NOT verificar_se_distrito_existe_em_pais_id(id_distrito, id_pais) THEN
        RAISE EXCEPTION 'O distrito com o id % não existe no país com o id %', id_distrito, id_pais;
    END IF;

    IF verificar_se_concelho_existe_em_distrito(nome, id_distrito) THEN
        RAISE EXCEPTION 'O concelho com o nome % já existe no distrito com o nome %', nome, (SELECT d.nome FROM distrito d WHERE d.id_distrito_estado = id_distrito);
    END IF;

    INSERT INTO concelho (nome, id_distrito_estado) VALUES (nome, id_distrito) RETURNING id_concelho INTO id_concelho_out;

    RETURN id_concelho_out;
END
$$ LANGUAGE plpgsql;

--CREATE morada
CREATE OR REPLACE FUNCTION criar_morada(
    id_utente int,
    morada varchar(255),
    freguesia varchar(255),
    cod_postal varchar(255),
    num_porta int,
    nome_concelho varchar(255),
    nome_distrito varchar(255),
    id_pais int,
    morada_preferencial boolean,
    andar varchar(255) DEFAULT NULL
)
RETURNS INT AS $$
DECLARE
    id_morada_out int;
    id_concelho_out int;
    id_distrito_out int;
BEGIN

    IF id_utente IS NULL THEN
        RAISE EXCEPTION 'O id do utente é obrigatório';
    END IF;

    IF NOT EXISTS (SELECT u.* FROM utente u WHERE u.id_utente = criar_morada.id_utente) THEN
        RAISE EXCEPTION 'O utente com o id % não existe', criar_morada.id_utente;
    END IF;

    IF morada IS NULL OR morada = '' THEN
        RAISE EXCEPTION 'A morada é obrigatória';
    END IF;

    IF freguesia IS NULL OR freguesia = '' THEN
        RAISE EXCEPTION 'A freguesia é obrigatória';
    END IF;

    IF cod_postal IS NULL OR cod_postal = '' THEN
        RAISE EXCEPTION 'O código postal é obrigatório';
    END IF;

    IF nome_concelho IS NULL OR nome_concelho = '' THEN
        RAISE EXCEPTION 'O nome do concelho é obrigatório';
    END IF;

    IF nome_distrito IS NULL OR nome_distrito = '' THEN
        RAISE EXCEPTION 'O nome do distrito é obrigatório';
    END IF;

    IF id_pais IS NULL THEN
        RAISE EXCEPTION 'O País é obrigatório';
    END IF;

    IF NOT verificar_se_pais_existe(id_pais) THEN
        RAISE EXCEPTION 'País não encontrado';
    END IF;

    IF NOT verificar_se_distrito_existe_em_pais(nome_distrito, id_pais) THEN
        -- CREATE distrito
        id_distrito_out = criar_distrito(nome_distrito, id_pais);
    ELSE
        id_distrito_out = (SELECT d.id_distrito_estado FROM distrito d WHERE d.nome = nome_distrito AND d.id_pais = criar_morada.id_pais);
    END IF;

    IF id_distrito_out IS NULL THEN
        RAISE EXCEPTION 'Occorreu um erro ao criar o distrito';
    END IF;

    IF NOT verificar_se_concelho_existe_em_distrito(nome_concelho, id_distrito_out) THEN
        -- CREATE concelho
        id_concelho_out = criar_concelho(nome_concelho, id_distrito_out, id_pais);
    ELSE
        id_concelho_out = (SELECT c.id_concelho FROM concelho c WHERE c.nome = nome_concelho AND c.id_distrito_estado = id_distrito_out);
    END IF;

    IF id_concelho_out IS NULL THEN
        RAISE EXCEPTION 'Occorreu um erro ao criar o concelho';
    END IF;

    INSERT INTO morada (id_utente, morada, freguesia, cod_postal, num_porta, andar, id_concelho, morada_preferencial) VALUES (id_utente, morada, freguesia, cod_postal, num_porta, andar, id_concelho_out, CAST(morada_preferencial AS INT)) RETURNING id_morada INTO id_morada_out;

    RETURN id_morada_out;
END
$$ LANGUAGE plpgsql;
    







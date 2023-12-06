/* 
CREATE TABLE unidade_saude_familiar (
  id_usf             SERIAL NOT NULL, 
  nome               varchar(255) NOT NULL, 
  data_associacao    timestamp NOT NULL, 
  data_desassociacao timestamp, 
  PRIMARY KEY (id_usf));

ALTER TABLE unidade_saude_familiar ALTER COLUMN data_associacao SET DEFAULT NOW();
*/

INSERT INTO unidade_saude_familiar (nome, data_associacao) VALUES ('USF de São João', '2018-01-01');
INSERT INTO unidade_saude_familiar (nome, data_associacao) VALUES ('USF de São Pedro', '2018-01-01');
INSERT INTO unidade_saude_familiar (nome, data_associacao) VALUES ('USF de São Tiago', '2018-01-01');
INSERT INTO unidade_saude_familiar (nome, data_associacao) VALUES ('USF de São José', '2018-01-01');
INSERT INTO unidade_saude_familiar (nome, data_associacao) VALUES ('USF de São Paulo', '2018-01-01');
INSERT INTO unidade_saude_familiar (nome, data_associacao) VALUES ('USF de São Francisco', '2018-01-01');
INSERT INTO unidade_saude_familiar (nome, data_associacao) VALUES ('USF de São Domingos', '2018-01-01');
INSERT INTO unidade_saude_familiar (nome, data_associacao) VALUES ('USF de São Miguel', '2018-01-01');
INSERT INTO unidade_saude_familiar (nome, data_associacao) VALUES ('USF de São Gabriel', '2018-01-01');
INSERT INTO unidade_saude_familiar (nome, data_associacao) VALUES ('USF de Martim Moniz', '2020-01-01');
INSERT INTO unidade_saude_familiar (nome, data_associacao) VALUES ('USF de Santa Maria', '2018-01-01');

CREATE OR REPLACE FUNCTION ver_unidades_saude_familiar() 
RETURNS TABLE (
    id_usf             int, 
    nome               varchar(255), 
    data_associacao    timestamp, 
    data_desassociacao timestamp) AS $$
BEGIN

    RETURN QUERY SELECT usf.* FROM unidade_saude_familiar usf WHERE usf.data_desassociacao IS NULL;

END;
$$ LANGUAGE plpgsql;
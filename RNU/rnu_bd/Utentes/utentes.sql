# CREATE TRIIGER TO ADD UUID()
CREATE OR REPLACE FUNCTION add_uuid() RETURNS TRIGGER AS $$
BEGIN
  NEW.hashed_id = uuid_generate_v4();
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER add_uuid BEFORE INSERT ON utente FOR EACH ROW EXECUTE PROCEDURE add_uuid();

# GET ALL UTENTES
CREATE OR REPLACE FUNCTION get_patients() 
RETURNS TABLE (
  id_utente             int, 
  nome                  varchar(255), 
  data_nascimento       date, 
  hora_nascimento       time, 
  genero                int, 
  tipo_documento        int, 
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
  data_criacao          timestamp) AS $$
BEGIN
  RETURN QUERY SELECT * FROM utente;
END
$$ LANGUAGE plpgsql;
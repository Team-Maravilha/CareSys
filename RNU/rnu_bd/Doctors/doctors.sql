/* 
 CREATE TABLE medico (
 id_medico    SERIAL NOT NULL, 
 nome         varchar(255) NOT NULL, 
 data_criacao timestamp NOT NULL, 
 PRIMARY KEY (id_medico));
 */

    INSERT INTO medico (nome) VALUES ('Dr. João');
    INSERT INTO medico (nome) VALUES ('Dr. António');
    INSERT INTO medico (nome) VALUES ('Dr. Manuel');
    INSERT INTO medico (nome) VALUES ('Dr. José');
    INSERT INTO medico (nome) VALUES ('Dras. Maria');
    INSERT INTO medico (nome) VALUES ('Dras. Ana');
    INSERT INTO medico (nome) VALUES ('Dras. Isabel');
    INSERT INTO medico (nome) VALUES ('Dras. Paula');
    INSERT INTO medico (nome) VALUES ('Dras. Carla');
    INSERT INTO medico (nome) VALUES ('Dras. Sofia');
    INSERT INTO medico (nome) VALUES ('Dras. Catarina');

    CREATE OR REPLACE FUNCTION ver_medicos() 
    RETURNS TABLE (
        id_medico int,
        nome varchar(255),
        data_criacao timestamp
    ) AS $$
    BEGIN
        RETURN QUERY SELECT * FROM medico;
    END;
    $$ LANGUAGE plpgsql;
    




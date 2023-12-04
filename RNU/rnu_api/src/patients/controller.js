const pool = require("../../db");

// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Utentes
 *   description: Gestão de Utentes
 */

/**
 * @swagger
 * /api/patients/table:
 *  get:
 *      tags: [Utentes]
 *      summary: Ver Todos os Utentes
 *      description: Retorna a Lista de Utentes
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const Get_Patients_Table = (req, res) => {
    pool.query("SELECT * FROM ver_utentes_tabela()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json({ 'recordsFiltered': results.rows.length, 'recordsTotal': results.rows.length, 'data': results.rows });
    });
}

/**
 * @swagger
 * /api/patients/patient/info:
 *  post:
 *      tags: [Utentes]
 *      summary: Ver Informação de um Utente
 *      description: Retorna a Informação de um Utente
 *      parameters:
 *          - in: body
 *            name: hashed_id
 *            required: true
 *            description: ID do Utente
 *            schema:
 *              type: object
 *              properties:
 *                  hashed_id:
 *                      type: string
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const Get_Patient_Info = (req, res) => {
    const hashed_id = req.params.hashed_id;
    pool.query("SELECT * FROM ver_info_utente($1)", [hashed_id], (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

/**
 * @swagger
 * /api/patients/patient/marry:
 *  post:
 *      tags: [Utentes]
 *      summary: Associar Cônjugue a um Utente
 *      description: Associa um Cônjugue a um Utente
 *      parameters:
 *          - in: body
 *            name: hashed_id
 *            required: true
 *            description: ID do Utente
 *            schema:
 *              type: object
 *              properties:
 *                  hashed_id:
 *                      type: string
 *          - in: body
 *            name: hashed_id_user
 *            required: true
 *            description: ID do Cônjugue
 *            schema:
 *              type: object
 *              properties:
 *                  hashed_id_user:
 *                      type: string
 *      responses:
 *          '201':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const Marry_Patient = (req, res) => {
    const { hashed_id, hashed_id_user } = req.body;
    pool.query("SELECT * FROM casar_utente($1, $2)", [hashed_id, hashed_id_user], (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(201).json({ "status": true, "message": "Cônjugue Associado ao Utente Com Sucesso!" });
    });
}

/**
 * @swagger
 * /api/patients/patient/divorce:
 *  post:
 *      tags: [Utentes]
 *      summary: Divorciar Utente
 *      description: Divorcia um Utente
 *      parameters:
 *          - in: body
 *            name: hashed_id
 *            required: true
 *            description: ID do Utente
 *            schema:
 *              type: object
 *              properties:
 *                  hashed_id:
 *                      type: string
 *      responses:
 *          '201':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const Divorce_Patient = (req, res) => {
const { hashed_id } = req.body;
    pool.query("SELECT * FROM divorciar_utente($1)", [hashed_id], (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(201).json({ "status": true, "message": "Utente Divorciado com Sucesso!" });
    });
}

/**
 * @swagger
 * /api/patients/patient/emergency_contact/add:
 *  post:
 *      tags: [Utentes]
 *      summary: Adicionar Contacto de Emergência
 *      description: Adiciona um Contacto de Emergência a um Utente
 *      parameters:
 *          - in: body
 *            name: hashed_id
 *            required: true
 *            description: ID do Utente
 *            schema:
 *              type: object
 *              properties:
 *                  hashed_id:
 *                      type: string
 *          - in: body
 *            name: nome
 *            required: true
 *            description: Nome do Contacto de Emergência
 *            schema:
 *              type: object
 *              properties:
 *                  nome:
 *                      type: string
 *          - in: body
 *            name: contacto
 *            required: true
 *            description: Contacto do Contacto de Emergência
 *            schema:
 *              type: object
 *              properties:
 *                  contacto:
 *                      type: string
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const Add_Patient_Emergency_Contact = (req, res) => {

    const { hashed_id, nome, contacto  } = req.body;
    pool.query("SELECT * FROM adicionar_contacto_emergencia($1, $2, $3)", [hashed_id, nome, contacto], (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

/**
 * @swagger
 * /api/patients/patient/emergency_contact:
 *  post:
 *      tags: [Utentes]
 *      summary: Ver Contactos de Emergência de um Utente
 *      description: Retorna os Contactos de Emergência de um Utente
 *      parameters:
 *          - in: body
 *            name: hashed_id
 *            required: true
 *            description: ID do Utente
 *            schema:
 *              type: object
 *              properties:
 *                  hashed_id:
 *                      type: string
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const Get_Patient_Emergency_Contacts = (req, res) => {
const hashed_id = req.params.hashed_id;
    pool.query("SELECT * FROM ver_contactos_emergencia($1)", [hashed_id], (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json({ 'recordsFiltered': results.rows.length, 'recordsTotal': results.rows.length, 'data': results.rows });
    });
}

const Delete_Patient_Emergency_Contact = (req, res) => {
    const id = req.params.id;
    pool.query("SELECT * FROM remover_contacto_emergencia($1)", [id], (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

module.exports = {
    Get_Patients_Table,
    Get_Patient_Info,
    Marry_Patient,
    Divorce_Patient,
    Add_Patient_Emergency_Contact,
    Get_Patient_Emergency_Contacts,
    Delete_Patient_Emergency_Contact
};

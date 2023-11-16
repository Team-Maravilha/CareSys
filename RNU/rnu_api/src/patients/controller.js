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
        res.status(200).json(results.rows);
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

module.exports = {
    Get_Patients_Table,
    Get_Patient_Info
};

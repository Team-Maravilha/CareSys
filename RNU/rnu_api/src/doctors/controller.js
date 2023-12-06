const pool = require("../../db");

// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Médicos
 *   description: Gestão de Médicos
 */

/**
 * @swagger
 * /api/patients/table:
 *  get:
 *      tags: [Médicos]
 *      summary: Ver Todos os Médicos
 *      description: Retorna a Lista de Todos os Médicos
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const Get_Doctors_List = (req, res) => {
    pool.query("SELECT * FROM ver_medicos()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

module.exports = {
    Get_Doctors_List
};

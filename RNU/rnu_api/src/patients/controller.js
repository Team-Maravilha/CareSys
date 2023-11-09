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
 * /api/patients/:
 *  get:
 *      tags: [Utentes]
 *      summary: Ver Todos os Utentes
 *      description: Retorna a Lista de Todos os Utentes
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */

const Get_Patients = (req, res) => {
    pool.query("SELECT * FROM get_patients()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
};

module.exports = {
    Get_Patients,
};

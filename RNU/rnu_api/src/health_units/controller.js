const pool = require("../../db");

// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Unidades de Saúde
 *   description: Gestão de Unidades de Saúde
 */

/**
 * @swagger
 * /api/patients/table:
 *  get:
 *      tags: [Unidades de Saúde]
 *      summary: Ver Todas as Unidades de Saúde
 *      description: Retorna a Lista de Todas as Unidades de Saúde
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const Get_HealthUnits_List = (req, res) => {
    pool.query("SELECT * FROM ver_unidades_saude_familiar()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

module.exports = {
    Get_HealthUnits_List
};

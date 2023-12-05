const pool = require("../../db");

const Get_All_Vacines = (req, res) => {
    pool.query("SELECT * FROM ver_vacinas()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

module.exports = {
    Get_All_Vacines,
};

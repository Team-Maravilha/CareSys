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

const Get_All_Patologies = (req, res) => {
    pool.query("SELECT * FROM ver_patologias()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

const Get_All_Medications = (req, res) => {
    pool.query("SELECT * FROM ver_medicamentos()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

const Get_All_Offices = (req, res) => {
    pool.query("SELECT * FROM ver_gabinetes()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

const Get_All_Exams = (req, res) => {
    pool.query("SELECT * FROM ver_exames()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

const Get_All_Specialities = (req, res) => {
    pool.query("SELECT * FROM ver_especialidades()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

const Get_All_Diagnosis = (req, res) => {
    pool.query("SELECT * FROM ver_diagnosticos()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

const Get_All_Consultations = (req, res) => {
    pool.query("SELECT * FROM ver_consultas()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

const Get_All_Consultations_for_DataTable = (req, res) => {
    pool.query("SELECT * FROM ver_consultas()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json({ data: results.rows, recordsTotal: results.rows.length, recordsFiltered: results.rows.length });
    });
}

const Get_Consultations_By_Utente = (req, res) => {
    const hashed_id_utente = req.params.hashed_id;
    pool.query("SELECT * FROM ver_consultas($1)", [hashed_id_utente], (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }

        res.status(200).json(results.rows);
    });
}

const Get_Consultations_By_Utente_for_DataTable = (req, res) => {
    const hashed_id_utente = req.params.hashed_id;
    pool.query("SELECT * FROM ver_consultas($1)", [hashed_id_utente], (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }

        res.status(200).json({ data: results.rows, recordsTotal: results.rows.length, recordsFiltered: results.rows.length });
    });
}

const Add_Consultation = (req, res) => {
    const { id_utente, id_gabinete, id_especialidade, id_medico, data_inicio, hora_inicio, tipo_consulta } = req.body;

    pool.query("SELECT adicionar_consulta($1, $2, $3, $4, $5, $6, $7)", [id_utente, id_gabinete, id_especialidade, id_medico, data_inicio, hora_inicio, tipo_consulta], (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }

        res.status(201).json({ status: true, message: "Consulta adicionada com sucesso!" })
    });
}








module.exports = {
    Get_All_Vacines,
    Get_All_Patologies,
    Get_All_Medications,
    Get_All_Offices,
    Get_All_Exams,
    Get_All_Specialities,
    Get_All_Diagnosis,
    Get_All_Consultations,
    Get_All_Consultations_for_DataTable,
    Get_Consultations_By_Utente,
    Get_Consultations_By_Utente_for_DataTable,
    Add_Consultation
};

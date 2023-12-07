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

const Get_Consultation_By_Id = async (req, res) => {
    const axios = require('axios').default;
    const { hashed_id_consulta } = req.params;
    try {
        const results = await new Promise((resolve, reject) => {
            pool.query("SELECT * FROM ver_consultas(null, null, null, null, $1)", [hashed_id_consulta], (error, results) => {
                if (error) {
                    reject(error);
                }
                resolve(results);
            });
        });

        let consultas = results.rows;

        // Load HealthUnits from Another API
        const healthUnitsResponse = await axios.get('http://localhost:4000/api/health_units/list');
        //CHECK CONNECTION ERROR
        if (healthUnitsResponse.error) {
            res.status(400).json({ error: 'Erro ao carregar unidades de saúde' });
        }
        const unidades_saude = healthUnitsResponse.data;

        // Load Doctors from Another API
        const doctorsResponse = await axios.get('http://localhost:4000/api/doctors/list');
        if (doctorsResponse.error) {
            res.status(400).json({ error: 'Erro ao carregar médicos' });
        }
        const medicos = doctorsResponse.data;

        // Load Patients from Another API
        const patientsResponse = await axios.get('http://localhost:4000/api/patients/table');
        if (patientsResponse.data.recordsTotal === 0) {
            res.status(400).json({ error: 'Erro ao carregar utentes' });
        }
        const utentes = patientsResponse.data.data;
    

        // Map over consultas and update with additional information
        consultas = consultas.map((consulta) => {
            const unidade_saude = unidades_saude.find(usf => usf.id_usf == consulta.id_unidade_saude);
            const medico = medicos.find(medico => medico.id_medico == consulta.id_medico);
            const utente = utentes.find(utente => utente.hashed_id == consulta.id_utente);

            if (!unidade_saude || !medico || !utente) {
                //REMOVE CONSULTA
                return null;
            }

            return {
                ...consulta,
                unidade_saude: unidade_saude.nome,
                medico: medico.nome,
                utente: utente.nome,
                num_utente: utente.num_utente
            };
        });

        // Remove null values from consultas
        consultas = consultas.filter(consulta => consulta !== null);


        res.status(200).json({ consultas });
    } catch (error) {
        res.status(400).json({ error: error.message });
    }
};

const Get_All_Consultations = async (req, res) => {
    const axios = require('axios').default;
    const { hashed_id, status, data_inicio, id_medico, hashed_id_consulta } = req.body;
    try {
        const results = await new Promise((resolve, reject) => {
            pool.query("SELECT * FROM ver_consultas($1, $2, $3, $4, $5)", [hashed_id, status, data_inicio, id_medico, hashed_id_consulta], (error, results) => {
                if (error) {
                    reject(error);
                } else {
                    resolve(results);
                }
            });
        });

        let consultas = results.rows;

        // Load HealthUnits from Another API
        const healthUnitsResponse = await axios.get('http://localhost:4000/api/health_units/list');
        //CHECK CONNECTION ERROR
        if (healthUnitsResponse.error) {
            res.status(400).json({ error: 'Erro ao carregar unidades de saúde' });
        }
        const unidades_saude = healthUnitsResponse.data;

        // Load Doctors from Another API
        const doctorsResponse = await axios.get('http://localhost:4000/api/doctors/list');
        if (doctorsResponse.error) {
            res.status(400).json({ error: 'Erro ao carregar médicos' });
        }
        const medicos = doctorsResponse.data;

        // Load Patients from Another API
        const patientsResponse = await axios.get('http://localhost:4000/api/patients/table');
        if (patientsResponse.data.recordsTotal === 0) {
            res.status(400).json({ error: 'Erro ao carregar utentes' });
        }
        const utentes = patientsResponse.data.data;
    

        // Map over consultas and update with additional information
        consultas = consultas.map((consulta) => {
            const unidade_saude = unidades_saude.find(usf => usf.id_usf == consulta.id_unidade_saude);
            const medico = medicos.find(medico => medico.id_medico == consulta.id_medico);
            const utente = utentes.find(utente => utente.hashed_id == consulta.id_utente);

            if (!unidade_saude || !medico || !utente) {
                //REMOVE CONSULTA
                return null;
            }

            return {
                ...consulta,
                unidade_saude: unidade_saude.nome,
                medico: medico.nome,
                utente: utente.nome,
                num_utente: utente.num_utente
            };
        });

        // Remove null values from consultas
        consultas = consultas.filter(consulta => consulta !== null);


        res.status(200).json({ consultas });
    } catch (error) {
        res.status(400).json({ error: error.message });
    }
};


const Get_All_Consultations_for_DataTable = async (req, res) => {
    const axios = require('axios').default;
    const { hashed_id, status, data_inicio, id_medico, hashed_id_consulta } = req.body;
    try {
        const results = await new Promise((resolve, reject) => {
            pool.query("SELECT * FROM ver_consultas($1, $2, $3, $4, $5)", [hashed_id, status, data_inicio, id_medico, hashed_id_consulta], (error, results) => {
                if (error) {
                    reject(error);
                } else {
                    resolve(results);
                }
            });
        });

        let consultas = results.rows;

        // Load HealthUnits from Another API
        const healthUnitsResponse = await axios.get('http://localhost:4000/api/health_units/list');
        //CHECK CONNECTION ERROR
        if (healthUnitsResponse.error) {
            res.status(400).json({ error: 'Erro ao carregar unidades de saúde' });
        }
        const unidades_saude = healthUnitsResponse.data;

        // Load Doctors from Another API
        const doctorsResponse = await axios.get('http://localhost:4000/api/doctors/list');
        if (doctorsResponse.error) {
            res.status(400).json({ error: 'Erro ao carregar médicos' });
        }
        const medicos = doctorsResponse.data;

        // Load Patients from Another API
        const patientsResponse = await axios.get('http://localhost:4000/api/patients/table');
        if (patientsResponse.data.recordsTotal === 0) {
            res.status(400).json({ error: 'Erro ao carregar utentes' });
        }
        const utentes = patientsResponse.data.data;
    

        // Map over consultas and update with additional information
        consultas = consultas.map((consulta) => {
            const unidade_saude = unidades_saude.find(usf => usf.id_usf == consulta.id_unidade_saude);
            const medico = medicos.find(medico => medico.id_medico == consulta.id_medico);
            const utente = utentes.find(utente => utente.hashed_id == consulta.id_utente);

            if (!unidade_saude || !medico || !utente) {
                //REMOVE CONSULTA
                return null;
            }

            return {
                ...consulta,
                unidade_saude: unidade_saude.nome,
                medico: medico.nome,
                utente: utente.nome,
                num_utente: utente.num_utente
            };
        });

        // Remove null values from consultas
        consultas = consultas.filter(consulta => consulta !== null);


        res.status(200).json({ data: consultas, recordsTotal: consultas.length, recordsFiltered: consultas.length });
    } catch (error) {
        res.status(400).json({ error: error.message });
    }
}

const Add_Consultation = (req, res) => {
    const { id_utente, id_unidade_saude, id_gabinete, id_especialidade, id_medico, data_inicio, hora_inicio, tipo_consulta } = req.body;

    pool.query("SELECT adicionar_consulta($1, $2, $3, $4, $5, $6, $7, $8)", [id_utente, id_unidade_saude, id_gabinete, id_especialidade, id_medico, data_inicio, hora_inicio, tipo_consulta], (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }

        res.status(201).json({ status: true, message: "Consulta adicionada com sucesso!" })
    });
}

const Do_Consultation = (req, res) => {
    const { hashed_id, problemas, obs_gerais, recomendacoes, tratamento, progresso, consentimento, autorizacao, diagnosticos_consulta, patologias_consulta, motivo } = req.body;

    pool.query("SELECT realizar_consulta($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11)", [hashed_id, problemas, obs_gerais, recomendacoes, tratamento, progresso, consentimento, autorizacao, diagnosticos_consulta, patologias_consulta, motivo], (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }

        res.status(201).json({ status: true, message: "Consulta realizada com sucesso!" })
    });
}

const Cancel_Consultation = (req, res) => {
    const { hashed_id } = req.body;

    pool.query("SELECT cancelar_consulta($1)", [hashed_id], (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }

        res.status(201).json({ status: true, message: "Consulta cancelada com sucesso!" })
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
    Get_Consultation_By_Id,
    Get_All_Consultations,
    Get_All_Consultations_for_DataTable,
    Add_Consultation,
    Do_Consultation,
    Cancel_Consultation
};

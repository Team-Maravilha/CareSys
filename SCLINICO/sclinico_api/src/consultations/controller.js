const pool = require("../../db");

// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Informação
 *   description: Gestão de Informação (Vacinas, Medicação, Exames, etc)
 */

/**
 * @swagger
 * tags:
 *   name: Consultas
 *   description: Gestão de Consultas
 */

/**
* @swagger
* /api/consultations/vacinas:
*  get:
*      tags: [Informação]
*      summary: Ver Todas as Vacinas
*      description: Retorna a Lista de Todas as Vacinas
*      responses:
*          '200':
*              description: Sucesso
*          '400':
*              description: Erro
*/
const Get_All_Vacines = (req, res) => {
    pool.query("SELECT * FROM ver_vacinas()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

/**
* @swagger
* /api/consultations/patologias:
*  get:
*      tags: [Informação]
*      summary: Ver Todas as Patologias
*      description: Retorna a Lista de Todas as Patologias
*      responses:
*          '200':
*              description: Sucesso
*          '400':
*              description: Erro
*/
const Get_All_Patologies = (req, res) => {
    pool.query("SELECT * FROM ver_patologias()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

/**
 * @swagger
 * /api/consultations/medicamentos:
 *  get:
 *     tags: [Informação]
 *     summary: Ver Todos os Medicamentos
 *     description: Retorna a Lista de Todos os Medicamentos
 *     responses:
 *      '200':
 *          description: Sucesso
 *      '400':
 *          description: Erro
*/
const Get_All_Medications = (req, res) => {
    pool.query("SELECT * FROM ver_medicamentos()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

/**
 * @swagger
 * /api/consultations/gabinetes:
 *  get:
 *     tags: [Informação]
 *     summary: Ver Todos os Gabinetes
 *     description: Retorna a Lista de Todos os Gabinetes
 *     responses:
 *      '200':
 *          description: Sucesso
 *      '400':
 *          description: Erro
*/
const Get_All_Offices = (req, res) => {
    pool.query("SELECT * FROM ver_gabinetes()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

/**
 * @swagger
 * /api/consultations/exames:
 *  get:
 *     tags: [Informação]
 *     summary: Ver Todos os Exames
 *     description: Retorna a Lista de Todos os Exames
 *     responses:
 *      '200':
 *          description: Sucesso
 *      '400':
 *          description: Erro
*/
const Get_All_Exams = (req, res) => {
    pool.query("SELECT * FROM ver_exames()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

/**
 * @swagger
 * /api/consultations/especialidades:
 *  get:
 *     tags: [Informação]
 *     summary: Ver Todas as Especialidades
 *     description: Retorna a Lista de Todas as Especialidades
 *     responses:
 *      '200':
 *          description: Sucesso
 *      '400':
 *          description: Erro
*/
const Get_All_Specialities = (req, res) => {
    pool.query("SELECT * FROM ver_especialidades()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

/**
 * @swagger
 * /api/consultations/diagnosticos:
 *  get:
 *     tags: [Informação]
 *     summary: Ver Todos os Diagnosticos
 *     description: Retorna a Lista de Todos os Diagnosticos
 *     responses:
 *      '200':
 *          description: Sucesso
 *      '400':
 *          description: Erro
*/
const Get_All_Diagnosis = (req, res) => {
    pool.query("SELECT * FROM ver_diagnosticos()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

/**
 * @swagger
 * /api/consultations/consulta/{hashed_id_consulta}:
 *  get:
 *     tags: [Consultas]
 *     summary: Ver Consulta por ID
 *     description: Retorna a Consulta com o ID especificado
 *     parameters:
 *      - in: path
 *        name: hashed_id_consulta
 *        required: true
 *        description: ID da Consulta
 *        schema:
 *          type: string
 *     responses:
 *      '200':
 *          description: Sucesso
 *      '400':
 *          description: Erro
*/
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

/**
 * @swagger
 * /api/consultations/consultas:
 *  post:
 *     tags: [Consultas]
 *     summary: Ver Consultas
 *     description: Retorna a Lista de Consultas
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *              hashed_id:
 *                  type: string
 *                  description: Hashed ID do Utente
 *              status:
 *                  type: string
 *                  description: Status da Consulta
 *              data_inicio:
 *                  type: string
 *                  description: Data de Inicio da Consulta
 *              id_medico:
 *                  type: integer
 *                  description: ID do Médico
 *              hashed_id_consulta:
 *                  type: string
 *                  description: Hashed ID da Consulta
 *     responses:
 *      '200':
 *          description: Sucesso
 *      '400':
 *          description: Erro
*/
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

/**
 * @swagger
 * /api/consultations/consultas/table:
 *  post:
 *     tags: [Consultas]
 *     summary: Ver Consultas para DataTable
 *     description: Retorna a Lista de Consultas para DataTable
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *              hashed_id:
 *                  type: string
 *                  description: Hashed ID do Utente
 *              status:
 *                  type: string
 *                  description: Status da Consulta
 *              data_inicio:
 *                  type: string
 *                  description: Data de Inicio da Consulta
 *              id_medico:
 *                  type: integer
 *                  description: ID do Médico
 *              hashed_id_consulta:
 *                  type: string
 *                  description: Hashed ID da Consulta
 *     responses:
 *      '200':
 *          description: Sucesso
 *      '400':
 *          description: Erro
*/
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

/**
 * @swagger
 * /api/consultations/consultas/adicionar:
 *  post:
 *     tags: [Consultas]
 *     summary: Adicionar Consulta
 *     description: Adiciona uma Consulta
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *              id_utente:
 *                  type: integer
 *                  description: ID do Utente
 *              id_unidade_saude:
 *                  type: integer
 *                  description: ID da Unidade de Saúde
 *              id_gabinete:
 *                  type: integer
 *                  description: ID do Gabinete
 *              id_especialidade:
 *                  type: integer
 *                  description: ID da Especialidade
 *              id_medico:
 *                  type: integer
 *                  description: ID do Médico
 *              data_inicio:
 *                  type: string
 *                  description: Data de Inicio da Consulta
 *              hora_inicio:
 *                  type: string
 *                  description: Hora de Inicio da Consulta
 *              tipo_consulta:
 *                  type: string
 *                  description: Tipo de Consulta
 *     responses:
 *      '201':
 *          description: Sucesso
 *      '400':
 *          description: Erro
*/
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

/**
 * @swagger
 * /api/consultations/consultas/realizar:
 *  post:
 *     tags: [Consultas]
 *     summary: Realizar Consulta
 *     description: Realiza uma Consulta
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *              hashed_id:
 *                  type: string
 *                  description: Hashed ID da Consulta
 *              problemas:
 *                  type: string
 *                  description: Problemas
 *              obs_gerais:
 *                  type: string
 *                  description: Observações Gerais
 *              recomendacoes:
 *                  type: string
 *                  description: Recomendações
 *              tratamento:
 *                  type: string
 *                  description: Tratamento
 *              progresso:
 *                  type: string
 *                  description: Progresso
 *              consentimento:
 *                  type: boolean
 *                  description: Consentimento
 *              autorizacao:
 *                  type: boolean
 *                  description: Autorização
 *              diagnosticos_consulta:
 *                  type: string
 *                  description: Diagnósticos da Consulta
 *              patologias_consulta:
 *                  type: string
 *                  description: Patologias da Consulta
 *              motivo:
 *                  type: string
 *                  description: Motivo da Consulta
 *     responses:
 *      '201':
 *          description: Sucesso
 *      '400':
 *          description: Erro
*/
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

/**
 * @swagger
 * /api/consultations/consultas/cancelar:
 *  post:
 *     tags: [Consultas]
 *     summary: Cancelar Consulta
 *     description: Cancela uma Consulta
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *              hashed_id:
 *                  type: string
 *                  description: Hashed ID da Consulta
 *     responses:
 *      '201':
 *          description: Sucesso
 *      '400':
 *          description: Erro
*/
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

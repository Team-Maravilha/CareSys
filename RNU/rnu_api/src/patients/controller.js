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
    res.status(200).json({ recordsFiltered: results.rows.length, recordsTotal: results.rows.length, data: results.rows });
  });
};
 
const Get_PatientID = (req, res) => {
  const num_utente = req.params.num_utente;
  pool.query("SELECT * FROM get_patient_info_by_num_utente($1)", [num_utente], (error, results) => {
    if (error) {
      res.status(400).json({ error: error.message });
      return;
    }
    res.status(200).json(results.rows);
  });
};

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
};

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
    res.status(201).json({ status: true, message: "Cônjugue Associado ao Utente Com Sucesso!" });
  });
};

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
    res.status(201).json({ status: true, message: "Utente Divorciado com Sucesso!" });
  });
};

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
  const { hashed_id, nome, contacto } = req.body;
  pool.query("SELECT * FROM adicionar_contacto_emergencia($1, $2, $3)", [hashed_id, nome, contacto], (error, results) => {
    if (error) {
      res.status(400).json({ error: error.message });
      return;
    }
    res.status(200).json(results.rows);
  });
};

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
    res.status(200).json({ recordsFiltered: results.rows.length, recordsTotal: results.rows.length, data: results.rows });
  });
};

/**
 * @swagger
 * /api/patients/patient/emergency_contact/delete:
 *  delete:
 *      tags: [Utentes]
 *      summary: Apagar Contacto de Emergência
 *      description: Apaga um Contacto de Emergência de um Utente
 *      parameters:
 *          - in: body
 *            name: id
 *            required: true
 *            description: ID do Contacto de Emergência
 *            schema:
 *              type: object
 *              properties:
 *                  id:
 *                      type: string
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const Delete_Patient_Emergency_Contact = (req, res) => {
  const id = req.params.id;
  pool.query("SELECT * FROM remover_contacto_emergencia($1)", [id], (error, results) => {
    if (error) {
      res.status(400).json({ error: error.message });
      return;
    }
    res.status(200).json(results.rows);
  });
};

/**
 * @swagger
 * /api/patients/patient/special_medication/add:
 *  post:
 *      tags: [Utentes]
 *      summary: Adicionar Medicação Especial
 *      description: Adiciona uma Medicação Especial a um Utente
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
 *            name: motivo
 *            required: true
 *            description: Motivo da Medicação Especial
 *            schema:
 *              type: object
 *              properties:
 *                  motivo:
 *                      type: string
 *          - in: body
 *            name: data_inicio
 *            required: true
 *            description: Data de Início da Medicação Especial
 *            schema:
 *              type: object
 *              properties:
 *                  data_inicio:
 *                      type: string
 *          - in: body
 *            name: data_fim
 *            required: true
 *            description: Data de Fim da Medicação Especial
 *            schema:
 *              type: object
 *              properties:
 *                  data_fim:
 *                      type: string
 *      responses:
 *          '201':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const Add_Patient_Special_Medication = (req, res) => {
  const { hashed_id, motivo, data_inicio, data_fim } = req.body;
  pool.query("SELECT * FROM adicionar_medicacao_especial($1, $2, $3, $4)", [hashed_id, motivo, data_inicio, data_fim], (error, results) => {
    if (error) {
      res.status(400).json({ error: error.message });
      return;
    }
    res.status(201).json({ status: true, message: "Medicação Especial adicionada ao Utente com Sucesso!" });
  });
};

/**
 * @swagger
 * /api/patients/patient/special_medication:
 *  post:
 *      tags: [Utentes]
 *      summary: Ver Medicação Especial de um Utente
 *      description: Retorna a Medicação Especial de um Utente
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
const Get_Patient_Special_Medication = (req, res) => {
  const hashed_id = req.params.hashed_id;
  pool.query("SELECT * FROM ver_medicacao_especial($1)", [hashed_id], (error, results) => {
    if (error) {
      res.status(400).json({ error: error.message });
      return;
    }

    res.status(200).json({ recordsFiltered: results.rows.length, recordsTotal: results.rows.length, data: results.rows });
  });
};

/**
 * @swagger
 * /api/patients/patient/special_medication/delete:
 *  delete:
 *      tags: [Utentes]
 *      summary: Apagar Medicação Especial
 *      description: Apaga uma Medicação Especial de um Utente
 *      parameters:
 *          - in: body
 *            name: id
 *            required: true
 *            description: ID da Medicação Especial
 *            schema:
 *              type: object
 *              properties:
 *                  id:
 *                      type: string
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const Delete_Patient_Special_Medication = (req, res) => {
  const id = req.params.id;
  pool.query("SELECT * FROM remover_medicacao_especial($1)", [id], (error, results) => {
    if (error) {
      res.status(400).json({ error: error.message });
      return;
    }
    res.status(200).json(results.rows);
  });
};

/**
 * @swagger
 * /api/patients/patient/exemption/add:
 *  post:
 *      tags: [Utentes]
 *      summary: Adicionar Isenção
 *      description: Adiciona uma Isenção a um Utente
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
 *            name: motivo
 *            required: true
 *            description: Motivo da Isenção
 *            schema:
 *              type: object
 *              properties:
 *                  motivo:
 *                      type: string
 *          - in: body
 *            name: data_inicio
 *            required: true
 *            description: Data de Início da Isenção
 *            schema:
 *              type: object
 *              properties:
 *                  data_inicio:
 *                      type: string
 *          - in: body
 *            name: data_fim
 *            required: true
 *            description: Data de Fim da Isenção
 *            schema:
 *              type: object
 *              properties:
 *                  data_fim:
 *                      type: string
 *      responses:
 *          '201':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const Add_Patient_Exemption = (req, res) => {
  const { hashed_id, motivo, data_inicio, data_fim } = req.body;
  pool.query("SELECT * FROM adicionar_isencao($1, $2, $3, $4)", [hashed_id, motivo, data_inicio, data_fim], (error, results) => {
    if (error) {
      res.status(400).json({ error: error.message });
      return;
    }
    res.status(201).json({ status: true, message: "Isenção adicionada ao Utente com Sucesso!" });
  });
};

/**
 * @swagger
 * /api/patients/patient/exemption:
 *  post:
 *      tags: [Utentes]
 *      summary: Ver Isenções de um Utente
 *      description: Retorna as Isenções de um Utente
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
const Get_Patient_Exemptions = (req, res) => {
  const hashed_id = req.params.hashed_id;
  pool.query("SELECT * FROM ver_isencoes($1)", [hashed_id], (error, results) => {
    if (error) {
      res.status(400).json({ error: error.message });
      return;
    }

    res.status(200).json({ recordsFiltered: results.rows.length, recordsTotal: results.rows.length, data: results.rows });
  });
};

/**
 * @swagger
 * /api/patients/patient/exemption/delete:
 *  delete:
 *      tags: [Utentes]
 *      summary: Apagar Isenção
 *      description: Apaga uma Isenção de um Utente
 *      parameters:
 *          - in: body
 *            name: id
 *            required: true
 *            description: ID da Isenção
 *            schema:
 *              type: object
 *              properties:
 *                  id:
 *                      type: string
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const Delete_Patient_Exemption = (req, res) => {
  const id = req.params.id;
  pool.query("SELECT * FROM remover_isencao($1)", [id], (error, results) => {
    if (error) {
      res.status(400).json({ error: error.message });
      return;
    }

    res.status(200).json(results.rows);
  });
};

/**
 * @swagger
 * /api/patients/patient/contribution/add:
 *  post:
 *      tags: [Utentes]
 *      summary: Adicionar Comparticipação
 *      description: Adiciona uma Comparticipação a um Utente
 *      parameters:
 *          - in: body
 *            name: hashed_id
 *            required: true
 *            description: ID do Utente
 *            schema:
 *              type: object
 *              properties:
 *                  id:
 *                      type: string
 *          - in: body
 *            name: motivo
 *            required: true
 *            description: Motivo da Comparticipação
 *            schema:
 *              type: object
 *              properties:
 *                  motivo:
 *                      type: string
 *          - in: body
 *            name: data_inicio
 *            required: true
 *            description: Data de Início da Comparticipação
 *            schema:
 *              type: object
 *              properties:
 *                  data_inicio:
 *                      type: string
 *          - in: body
 *            name: data_fim
 *            required: true
 *            description: Data de Fim da Comparticipação
 *            schema:
 *              type: object
 *              properties:
 *                  data_fim:
 *                      type: string
 *      responses:
 *          '201':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const Add_Patient_Contribution = (req, res) => {
  const { hashed_id, motivo, data_inicio, data_fim } = req.body;
  pool.query("SELECT * FROM adicionar_comparticipacao_medicamentos($1, $2, $3, $4)", [hashed_id, motivo, data_inicio, data_fim], (error, results) => {
    if (error) {
      res.status(400).json({ error: error.message });
      return;
    }
    res.status(201).json({ status: true, message: "Comparticipação Medicação adicionada ao Utente com Sucesso!" });
  });
};

/**
 * @swagger
 * /api/patients/patient/contribution:
 *  post:
 *      tags: [Utentes]
 *      summary: Ver Comparticipações de um Utente
 *      description: Retorna as Comparticipações de um Utente
 *      parameters:
 *          - in: body
 *            name: hashed_id
 *            required: true
 *            description: ID do Utente
 *            schema:
 *              type: object
 *              properties:
 *                  id:
 *                      type: string
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const Get_Patient_Contributions = (req, res) => {
  const hashed_id = req.params.hashed_id;
  pool.query("SELECT * FROM ver_comparticipacoes_medicamentos($1)", [hashed_id], (error, results) => {
    if (error) {
      res.status(400).json({ error: error.message });
      return;
    }

    res.status(200).json({ recordsFiltered: results.rows.length, recordsTotal: results.rows.length, data: results.rows });
  });
};

/**
 * @swagger
 * /api/patients/patient/contribution/delete:
 *  delete:
 *      tags: [Utentes]
 *      summary: Apagar Comparticipação
 *      description: Apaga uma Comparticipação de um Utente
 *      parameters:
 *          - in: body
 *            name: id
 *            required: true
 *            description: ID da Comparticipação
 *            schema:
 *              type: object
 *              properties:
 *                  id:
 *                      type: string
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const Delete_Patient_Contribution = (req, res) => {
  const id = req.params.id;
  pool.query("SELECT * FROM remover_comparticipacao_medicamentos($1)", [id], (error, results) => {
    if (error) {
      res.status(400).json({ error: error.message });
      return;
    }

    res.status(200).json(results.rows);
  });
};

module.exports = {
  Get_Patients_Table,
  Get_Patient_Info,
  Get_PatientID,
  Marry_Patient,
  Divorce_Patient,
  Add_Patient_Emergency_Contact,
  Get_Patient_Emergency_Contacts,
  Delete_Patient_Emergency_Contact,
  Add_Patient_Special_Medication,
  Get_Patient_Special_Medication,
  Delete_Patient_Special_Medication,
  Add_Patient_Exemption,
  Get_Patient_Exemptions,
  Delete_Patient_Exemption,
  Add_Patient_Contribution,
  Get_Patient_Contributions,
  Delete_Patient_Contribution,
};

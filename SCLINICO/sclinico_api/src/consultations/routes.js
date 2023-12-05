const { Router } = require('express');
const controller = require('./controller');

const router = Router();

router.get('/vacinas', controller.Get_All_Vacines);
router.get('/patologias', controller.Get_All_Patologies);
router.get('/medicamentos', controller.Get_All_Medications);
router.get('/gabinetes', controller.Get_All_Offices);
router.get('/exames', controller.Get_All_Exams);
router.get('/especialidades', controller.Get_All_Specialities);
router.get('/diagnosticos', controller.Get_All_Diagnosis);

router.get('/consultas', controller.Get_All_Consultations);
router.get('/consultas/table', controller.Get_All_Consultations_for_DataTable);
router.get('/consultas/utente/:hashed_id', controller.Get_Consultations_By_Utente);
router.get('/consultas/utente/table/:hashed_id', controller.Get_Consultations_By_Utente_for_DataTable);

router.post('/consultas/adicionar', controller.Add_Consultation);


module.exports = router;
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

router.post('/consultas', controller.Get_All_Consultations);
router.post('/consultas/table', controller.Get_All_Consultations_for_DataTable);

router.post('/consultas/adicionar', controller.Add_Consultation);


module.exports = router;
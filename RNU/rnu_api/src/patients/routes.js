const { Router } = require('express');
const controller = require('./controller');

const router = Router();

router.get('/table', controller.Get_Patients_Table)

router.get('/patient/info/:hashed_id', controller.Get_Patient_Info)

module.exports = router;
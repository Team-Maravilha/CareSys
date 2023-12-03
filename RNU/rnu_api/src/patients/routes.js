const { Router } = require('express');
const controller = require('./controller');

const router = Router();

router.get('/table', controller.Get_Patients_Table)

router.get('/patient/info/:hashed_id', controller.Get_Patient_Info)

router.post('/patient/emergency_contacts/add', controller.Add_Patient_Emergency_Contact)

router.get('/patient/emergency_contacts/:hashed_id', controller.Get_Patient_Emergency_Contacts)

module.exports = router;
const { Router } = require('express');
const controller = require('./controller');

const router = Router();

router.get('/table', controller.Get_Patients_Table)

router.get('/num_utente/:num_utente', controller.Get_PatientID)

router.get('/patient/info/:hashed_id', controller.Get_Patient_Info)

router.post('/patient/marry', controller.Marry_Patient)

router.post('/patient/divorce', controller.Divorce_Patient)

router.post('/patient/emergency_contacts/add', controller.Add_Patient_Emergency_Contact)

router.get('/patient/emergency_contacts/:hashed_id', controller.Get_Patient_Emergency_Contacts)

router.delete('/patient/emergency_contacts/delete/:id', controller.Delete_Patient_Emergency_Contact)

router.post('/patient/special_medication/add', controller.Add_Patient_Special_Medication)

router.get('/patient/special_medication/:hashed_id', controller.Get_Patient_Special_Medication)

router.delete('/patient/special_medication/delete/:id', controller.Delete_Patient_Special_Medication)

router.post('/patient/exemption/add', controller.Add_Patient_Exemption)

router.get('/patient/exemption/:hashed_id', controller.Get_Patient_Exemptions)

router.delete('/patient/exemption/delete/:id', controller.Delete_Patient_Exemption)

router.post('/patient/contribution/add', controller.Add_Patient_Contribution)

router.get('/patient/contribution/:hashed_id', controller.Get_Patient_Contributions)

router.delete('/patient/contribution/delete/:id', controller.Delete_Patient_Contribution)

module.exports = router;
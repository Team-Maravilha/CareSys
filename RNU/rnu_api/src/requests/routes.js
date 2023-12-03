const { Router } = require('express');
const controller = require('./controller');

const router = Router();

router.get('/', controller.Get_Requests);

router.post('/create', controller.Create_Request)

router.get('/table', controller.Get_Patients_Requests_Table)

router.get('/count', controller.Get_Patients_Requests_Counter)

router.post('/accept', controller.Accept_Patient_Request)

router.post('/reject', controller.Reject_Patient_Request)

module.exports = router;
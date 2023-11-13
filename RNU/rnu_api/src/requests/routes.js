const { Router } = require('express');
const controller = require('./controller');

const router = Router();

router.get('/', controller.Get_Requests);

router.post('/create', controller.Create_Request)

router.get('/table', controller.Get_Patients_Requests_Table)

router.get('/count', controller.Get_Patients_Requests_Counter)

module.exports = router;
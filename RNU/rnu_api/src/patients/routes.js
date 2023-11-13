const { Router } = require('express');
const controller = require('./controller');

const router = Router();

router.get('/table', controller.Get_Patients_Table)

module.exports = router;
const { Router } = require('express');
const controller = require('./controller');

const router = Router();

router.get('/', controller.Get_Patients);

module.exports = router;
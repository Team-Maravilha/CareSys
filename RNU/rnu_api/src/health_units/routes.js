const { Router } = require('express');
const controller = require('./controller');

const router = Router();

router.get('/list', controller.Get_HealthUnits_List)

module.exports = router;
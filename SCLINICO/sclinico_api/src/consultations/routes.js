const { Router } = require('express');
const controller = require('./controller');

const router = Router();

router.get('/vacinas', controller.Get_All_Vacines);

module.exports = router;
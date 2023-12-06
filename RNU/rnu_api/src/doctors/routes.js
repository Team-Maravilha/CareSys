const { Router } = require('express');
const controller = require('./controller');

const router = Router();

router.get('/list', controller.Get_Doctors_List)

module.exports = router;
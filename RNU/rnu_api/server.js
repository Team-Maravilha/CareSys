require("dotenv").config();

const express = require("express");
const cors = require("cors");
const swaggerJsDoc = require("swagger-jsdoc");
const swaggerUi = require("swagger-ui-express");

const requestsRoutes = require("./src/requests/routes");
const patientsRoutes = require("./src/patients/routes");

const app = express();
const port = 4000;
const swaggerOptions = {
    swaggerDefinition: {
        openapi: "3.0.0",
        info: {
            title: "CareSys | RNU",
            description: "Registo Nacional de Utentes <p> Desenvolvido por: João Correia, Rui Cruz e Thays Souza",
            contact: {
                name: "João Correia | Rui Cruz | Thays Souza",
            },
            version: "1.0.0",
            servers: ["http://localhost:4000/"],
        },
    },
    apis: ["src/*/*.js"],
};
const swaggerDocs = swaggerJsDoc(swaggerOptions);

app.use("/api-doc", swaggerUi.serve, swaggerUi.setup(swaggerDocs));
app.use(cors());
app.use(express.json());


app.get("/", (req, res) => {
    res.send("Bem-Vindo(a) à API do CareSys | RNU");
});

app.use("/api/requests", requestsRoutes);

app.use("/api/patients", patientsRoutes);

app.listen(port, () => console.log(`Servidor ativo na porta: ${port}`));

require("dotenv").config();

const express = require("express");
const cors = require("cors");
const swaggerJsDoc = require("swagger-jsdoc");
const swaggerUi = require("swagger-ui-express");

const app = express();
const port = 4001;
const swaggerOptions = {
    swaggerDefinition: {
        openapi: "3.0.0",
        info: {
            title: "CareSys | SCLINICO",
            description: "Sistema de Apoio Hospitalar <p> Desenvolvido por: João Correia, Rui Cruz e Thays Souza",
            contact: {
                name: "João Correia | Rui Cruz | Thays Souza",
            },
            version: "1.0.0",
            servers: ["http://localhost:4001/"],
        },
    },
    apis: ["src/*/*.js"],
};
const swaggerDocs = swaggerJsDoc(swaggerOptions);

app.use("/api-doc", swaggerUi.serve, swaggerUi.setup(swaggerDocs));
app.use(cors());
app.use(express.json());


app.get("/", (req, res) => {
    res.send("Bem-Vindo(a) à API do CareSys | SCLINICO");
});


app.listen(port, () => console.log(`Servidor ativo na porta: ${port}`));

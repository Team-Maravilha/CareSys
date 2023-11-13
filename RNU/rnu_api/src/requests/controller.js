const pool = require("../../db");

// Definir as tags da Documentação
/**
 * @swagger
 * tags:
 *   name: Pedidos
 *   description: Gestão de Pedidos
 */

// Definir os Schemas
/**
 * @swagger
 * components:
 *  schemas:
 *    Utente:
 *      type: object
 *      required:
 *        - nome
 *        - genero
 *        - data_nascimento
 *        - id_tipo_documento
 *        - num_cc
 *        - cod_validacao_cc
 *        - data_validade_cc
 *        - num_ident_seg_social
 *        - num_ident_fiscal
 *        - num_utente_pai
 *        - num_utente_mae
 *        - estado_civil
 *        - situacao_profissional
 *        - profissao
 *        - hab_escolares
 *        - num_telemovel
 *        - num_telefone
 *        - email
 *        - pais
 *        - distrito
 *        - concelho
 *        - freguesia
 *        - morada
 *        - cod_postal
 *        - numero_porta
 *        - andar
 *        - taxa_moderadora
 *        - seguro_saude
 *      properties:
 *        nome:
 *          type: string
 *          description: Nome do Utente
 *        genero:
 *          type: string
 *          description: G�nero do Utente
 *        data_nascimento:
 *          type: string
 *          description: Data de Nascimento do Utente
 *        id_tipo_documento:
 *          type: integer
 *          description: ID do Tipo de Documento do Utente
 *        num_cc:
 *          type: integer
 *          description: N�mero do Cart�o de Cidad�o do Utente
 *        cod_validacao_cc:
 *          type: integer
 *          description: C�digo de Valida��o do Cart�o de Cidad�o do Utente
 *        data_validade_cc:
 *          type: string
 *          description: Data de Validade do Cart�o de Cidad�o do Utente
 *        num_ident_seg_social:
 *          type: integer
 *          description: N�mero de Identifica��o da Seguran�a Social do Utente
 *        num_ident_fiscal:
 *          type: integer
 *          description: N�mero de Identifica��o Fiscal do Utente
 *        num_utente_pai:
 *          type: integer
 *          description: N�mero de Utente do Pai do Utente
 *        num_utente_mae:
 *          type: integer
 *          description: N�mero de Utente da M�e do Utente
 *        estado_civil:
 *          type: string
 *          description: Estado Civil do Utente
 *        situacao_profissional:
 *          type: string
 *          description: Situa��o Profissional do Utente
 *        profissao:
 *          type: string
 *          description: Profiss�o do Utente
 *        hab_escolares:
 *          type: string
 *          description: Habilita��es Escolares do Utente
 *        num_telemovel:
 *          type: integer
 *          description: N�mero de Telem�vel do Utente
 *        num_telefone:
 *          type: integer
 *          description: N�mero de Telefone do Utente
 *        email:
 *          type: string
 *          description: Email do Utente
 *        pais:
 *          type: string
 *          description: Pa�s do Utente
 *        distrito:
 *          type: string
 *          description: Distrito do Utente
 *        concelho:
 *          type: string
 *          description: Concelho do Utente
 *        freguesia:
 *          type: string
 *          description: Freguesia do Utente
 *        morada:
 *          type: string
 *          description: Morada do Utente
 *        cod_postal:
 *          type: string
 *          description: C�digo Postal do Utente
 *        numero_porta:
 *          type: integer
 *          description: N�mero da Porta do Utente
 *        andar:
 *          type: integer
 *          description: Andar do Utente
 *        taxa_moderadora:
 *          type: integer
 *          description: Taxa Moderadora do Utente
 *        seguro_saude:
 *          type: string
 *          description: Seguro de Sa�de do Utente
 *      example:
 *        nome: Jo�o Correia
 *        genero: Masculino
 *        data_nascimento: 1999-12-12
 *        id_tipo_documento: 1
 *        num_cc: 12345678
 *        cod_validacao_cc: 123
 *        data_validade_cc: 2025-12-12
 *        num_ident_seg_social: 123456789
 *        num_ident_fiscal: 123456789
 *        num_utente_pai: 123456789
 *        num_utente_mae: 123456789
 *        estado_civil: Solteiro
 *        situacao_profissional: Estudante
 *        profissao: Estudante
 *        hab_escolares: Licenciatura
 *        num_telemovel: 123456789
 *        num_telefone: 123456789
 *        email: ''
 *        pais: Portugal
 *        distrito: Porto
 *        concelho: Porto
 *        freguesia: Paranhos
 *        morada: Rua do ISEP
 *        cod_postal: 1234-123
 *        numero_porta: 123
 *        andar: 1
 *        taxa_moderadora: 5
 *        seguro_saude: Multicare
 */


/**
 * @swagger
 * /api/requests/:
 *  get:
 *      tags: [Pedidos]
 *      summary: Ver Todos os Utentes
 *      description: Retorna a Lista de Todos os Utentes
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */

const Get_Requests = (req, res) => {
    pool.query("SELECT * FROM get_patients()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
};

/**
 * @swagger
 * /api/requests/create:
 *  post:
 *      tags: [Pedidos]
 *      summary: Submeter Novo Pedido
 *      description: Submete o novo pedido e devolve a resposta de Sucesso ou o Erro em questão
 *      responses:
 *          '201':
 *              description: O seu pedido foi submetido com Sucesso!
 *          '400':
 *              description: Erro + Informação do Sistema
 */
const Create_Request = (req, res) => {
    const { nome, genero, data_nascimento, hora_nascimento, id_tipo_documento, num_cc, cod_validacao_cc, data_validade_cc, num_ident_seg_social, num_ident_fiscal, num_utente_pai, num_utente_mae, estado_civil, situacao_profissional, profissao, hab_escolares, num_telemovel, num_telefone, email, pais, distrito, concelho, freguesia, morada, cod_postal, num_porta, andar, taxa_moderadora, seguro_saude } = req.body;
    pool.query("SELECT * FROM criar_utente($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16, $17, $18, $19, $20, $21, $22, $23, $24, $25, $26, $27, $28, $29)", [nome, genero, data_nascimento, id_tipo_documento, num_cc, cod_validacao_cc, data_validade_cc, num_ident_seg_social, num_ident_fiscal, num_utente_pai, num_utente_mae, estado_civil, situacao_profissional, num_telemovel, taxa_moderadora, seguro_saude, pais, distrito, concelho, freguesia, morada, cod_postal, num_porta, hora_nascimento, profissao, hab_escolares, num_telefone, email, andar], (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(201).json({ "status": true, "message": "O seu pedido foi submetido com Sucesso!" });
    });
}

/**
 * @swagger
 * /api/requests/table:
 *  get:
 *      tags: [Pedidos]
 *      summary: Ver Todos os Pedidos de Utentes
 *      description: Retorna a Lista de Pedidos de Utentes
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const Get_Patients_Requests_Table = (req, res) => {
    pool.query("SELECT * FROM ver_pedidos_utentes_tabela()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

/**
 * @swagger
 * /api/requests/count:
 *  get:
 *      tags: [Pedidos]
 *      summary: Ver Número de Pedidos de Utentes
 *      description: Retorna o Número de Pedidos de Utentes
 *      responses:
 *          '200':
 *              description: Sucesso
 *          '400':
 *              description: Erro
 */
const Get_Patients_Requests_Counter = (req, res) => {
    pool.query("SELECT * FROM ver_pedidos_utentes_contador()", (error, results) => {
        if (error) {
            res.status(400).json({ error: error.message });
            return;
        }
        res.status(200).json(results.rows);
    });
}

module.exports = {
    Get_Requests,
    Create_Request,
    Get_Patients_Requests_Table,
    Get_Patients_Requests_Counter
};

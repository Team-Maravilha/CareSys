<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/api/api.php") ?>
<?php
if (isset($_GET["id"])) {
    $consultation_hashed_id = $_GET["id"];
} else {
    header("Location: pages/office/consultas/lista");
}
$api = new Api();
$consultation = $api->fetch("consultations/consulta", null, $consultation_hashed_id);
$consultation_info = $consultation["response"]["consultas"][0];
?>

<body id="kt_app_body" data-kt-app-header-fixed-mobile="true" data-kt-app-toolbar-enabled="true" class="app-default">
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/header.php") ?>
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/toolbar.php") ?>
                <div class="app-container container-xxl">
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <div class="d-flex flex-column flex-column-fluid">
                            <div id="kt_app_content" class="app-content">


                                <!-- Content Here -->
                                <div class="card card-flush shadow mb-5">
                                    <div class="card-body pt-10 px-20">
                                        <h3>Consulta - <?php echo ' ' . $consultation_info["utente"] . ' (' . $consultation_info["nome_especialidade"] . ')' ?></h3>
                                        <div class="separator separator-dashed my-5"></div>
                                        <div class="row">
                                            <div class="col-6">

                                                <table class="table table-borderless align-middle fw-bolder fs-6 gy-7 gs-7 mb-5">
                                                    <tbody>
                                                        <tr class="border-bottom border-gray-200">
                                                            <td class="text-gray-600">Utente</td>
                                                            <td class="text-gray-800"><?php echo $consultation_info["utente"] ?></td>
                                                        </tr>
                                                        <tr class="border-bottom border-gray-200">
                                                            <td class="text-gray-600">Número Utente</td>
                                                            <td class="text-gray-800"><?php echo $consultation_info["num_utente"] ?></td>
                                                        </tr>
                                                        <tr class="border-bottom border-gray-200">
                                                            <td class="text-gray-600">Data</td>
                                                            <td class="text-gray-800">
                                                                <?php
                                                                $date = new DateTime($consultation_info["data_inicio"]);
                                                                echo $date->format('d/m/Y');
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr class="border-bottom border-gray-200">
                                                            <td class="text-gray-600">Hora</td>
                                                            <td class="text-gray-800">
                                                                <?php
                                                                $date = new DateTime($consultation_info["hora_inicio"]);
                                                                echo $date->format('H:i');
                                                                ?>h
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                            <div class="col-6">

                                                <table class="table table-borderless align-middle fw-bolder fs-6 gy-7 gs-7 mb-5">
                                                    <tbody>
                                                        <tr class="border-bottom border-gray-200">
                                                            <td class="text-gray-600">Unidade de Saúde</td>
                                                            <td class="text-gray-800">
                                                                <?php echo $consultation_info["unidade_saude"] ?>
                                                            </td>
                                                        </tr>
                                                        <tr class="border-bottom border-gray-200">
                                                            <td class="text-gray-600">Médico</td>
                                                            <td class="text-gray-800">
                                                                <?php echo $consultation_info["medico"] ?>
                                                            </td>
                                                        </tr>
                                                        <tr class="border-bottom border-gray-200">
                                                            <td class="text-gray-600">Especialidade</td>
                                                            <td class="text-gray-800">
                                                                <?php echo $consultation_info["nome_especialidade"] ?>
                                                            </td>
                                                        </tr>
                                                        <tr class="border-bottom border-gray-200">
                                                            <td class="text-gray-600">Gabinete</td>
                                                            <td class="text-gray-800">
                                                                <?php echo $consultation_info["numero_gabinete"] . ' - ' . $consultation_info["nome_gabinete"] ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Start New Form for Consultation -->
                                <div class="separator separator-dotted separator-content border-dark my-15"><span class="h1 w-50">Informação da Consulta</span></div>
                                <form id="form-consultation" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                                    <div class="row mb-6">

                                        <div class="col-6">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Motivo/Queixas da Consulta</label>
                                            <textarea class="form-control form-control-lg form-control-solid" disabled rows="4" name="motivo"><?php echo $consultation_info["motivo"] ?></textarea>
                                        </div>
                                        <div class="col-6">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Problemas do Utente</label>
                                            <textarea class="form-control form-control-lg form-control-solid" disabled rows="4" name="problemas"><?php echo $consultation_info["problemas"] ?></textarea>
                                        </div>

                                        <div class="col-12">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Observações Gerais</label>
                                            <textarea class="form-control form-control-lg form-control-solid" disabled rows="3" name="obs_gerais"><?php echo $consultation_info["obs_gerais"] ?></textarea>
                                        </div>

                                        <div class="col-6">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Recomendações</label>
                                            <textarea class="form-control form-control-lg form-control-solid" disabled rows="4" name="recomendacoes"><?php echo $consultation_info["recomendacoes"] ?></textarea>
                                        </div>
                                        <div class="col-6">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Tratamento</label>
                                            <textarea class="form-control form-control-lg form-control-solid" disabled rows="4" name="tratamento"><?php echo $consultation_info["tratamento"] ?></textarea>
                                        </div>

                                        <div class="col-12">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Progresso Utente</label>
                                            <textarea class="form-control form-control-lg form-control-solid" disabled rows="3" name="progresso"><?php echo $consultation_info["progresso"] ?></textarea>
                                        </div>

                                        <div class="col-6">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Diagnósticos</label>
                                            <ul>
                                                <?php foreach ($consultation_info["diagnosticos_consulta"] as $key => $value) { ?>
                                                    <li><span class="fw-semibold fs-6"><?php echo $value["cod_geral"] . ' - ' . $value["nome"] ?></span></li><br>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="col-6">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Patologias</label>
                                            <ul>
                                                <?php foreach ($consultation_info["patologias_consulta"] as $key => $value) { ?>
                                                    <li><span class="fw-semibold fs-6"><?php echo $value["codigo"] . ' - ' . $value["nome"] ?></span></li><br>
                                                <?php } ?>
                                            </ul>
                                        </div>

                                        <div class="col-12 mt-6">
                                            <div class="form-check form-check-custom form-check-success form-check-solid my-2">
                                                <input class="form-check-input" name="consentimento" type="checkbox" <?php if ($consultation_info["consentimento"] === 1) {
                                                                                                                            echo "checked";
                                                                                                                        } else; ?> />
                                                <label class="form-check-label" for="">
                                                    Consente o Tratamento Médico
                                                </label>
                                            </div>

                                            <div class="form-check form-check-custom form-check-success form-check-solid my-2">
                                                <input class="form-check-input" name="consentimento" type="checkbox" <?php if ($consultation_info["autorizacao"] === 1) {
                                                                                                                            echo "checked";
                                                                                                                        } else; ?> />
                                                <label class="form-check-label" for="">
                                                    Autoriza Partilha de Informação Médica
                                                </label>
                                            </div>
                                        </div>

                                </form>
                                <!-- End Content Here -->

                            </div>
                        </div>
                        <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/footer.php") ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/foo.php") ?>

</body>

</html>
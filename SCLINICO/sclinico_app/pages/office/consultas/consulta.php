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

$patologias = $api->fetch("consultations/patologias", null, null);
$patologias_list = $patologias["response"];

$diagnosticos = $api->fetch("consultations/diagnosticos", null, null);
$diagnosticos_list = $diagnosticos["response"];

$medicacao = $api->fetch("consultations/medicamentos", null, null);
$medicacao_list = $medicacao["response"];

$exames = $api->fetch("consultations/exames", null, null);
$exames_list = $exames["response"];

$vacinas = $api->fetch("consultations/vacinas", null, null);
$vacinas_list = $vacinas["response"];

$page_name = "CareSys | SCLINICO - Consulta - " . $consultation_info["utente"];
?>

<style>
    .select2-search.select2-search--inline {
        flex: 1 1 !important;
    }
</style>

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
                                <div class="separator separator-dotted separator-content border-dark my-15"><span class="h1 w-25">Dados da Consulta</span></div>
                                <form id="form-consultation" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                                    <div class="row mb-6">

                                        <div class="col-6">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Motivo/Queixas da Consulta</label>
                                            <textarea class="form-control form-control-lg form-control-solid" rows="4" name="motivo" placeholder="Preencha o Motivo/Queixas do Utente"></textarea>
                                        </div>
                                        <div class="col-6">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Problemas do Utente</label>
                                            <textarea class="form-control form-control-lg form-control-solid" rows="4" name="problemas" placeholder="Preencha com os Problemas do Utente"></textarea>
                                        </div>

                                        <div class="col-12">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Observações Gerais</label>
                                            <textarea class="form-control form-control-lg form-control-solid" rows="3" name="obs_gerais" placeholder="Preencha com as Observações Gerais"></textarea>
                                        </div>

                                        <div class="col-6">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Recomendações</label>
                                            <textarea class="form-control form-control-lg form-control-solid" rows="4" name="recomendacoes" placeholder="Preencha com as Recomendações"></textarea>
                                        </div>
                                        <div class="col-6">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Tratamento</label>
                                            <textarea class="form-control form-control-lg form-control-solid" rows="4" name="tratamento" placeholder="Preencha com o Tratamento"></textarea>
                                        </div>

                                        <div class="col-12">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Progresso Utente</label>
                                            <textarea class="form-control form-control-lg form-control-solid" rows="3" name="progresso" placeholder="Preencha com o Progresso do Utente"></textarea>
                                        </div>

                                        <div class="col-6">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Diagnósticos</label>
                                            <select class="form-select form-select-solid" name="diagnostico" multiple data-control="select2" data-placeholder="Selecione o(s) Diagnóstico(s)">
                                                <option></option>
                                                <?php foreach ($diagnosticos_list as $key => $value) { ?>
                                                    <option value="<?php echo $value["id_diagnostico"] ?>"><?php echo $value["cod_geral"] . ' - ' . $value["nome"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Patologias</label>
                                            <select class="form-select form-select-solid" name="patologias" multiple data-control="select2" data-placeholder="Selecione a(s) Patologia(s)">
                                                <option></option>
                                                <?php foreach ($patologias_list as $key => $value) { ?>
                                                    <option value="<?php echo $value["id_patologia"] ?>"><?php echo $value["codigo"] . ' - ' . $value["nome"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="separator separator-dotted separator-content border-dark my-15"><span class="h1 w-25">Prescrições</span></div>

                                        <div class="col-4">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Medicação</label>
                                            <select class="form-select form-select-solid" name="medicacao" multiple data-control="select2" data-placeholder="Selecione a(s) Medicação(s)">
                                                <option></option>
                                                <?php foreach ($medicacao_list as $key => $value) { ?>
                                                    <option value="<?php echo $value["id_medicamento"] ?>"><?php echo $value["codigo"] . ' - ' . $value["nome"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="col-4">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Exames</label>
                                            <select class="form-select form-select-solid" name="exames" multiple data-control="select2" data-placeholder="Selecione o(s) Exame(s)">
                                                <option></option>
                                                <?php foreach ($exames_list as $key => $value) { ?>
                                                    <option value="<?php echo $value["id_exame"] ?>"><?php echo $value["codigo"] . ' - ' . $value["nome"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="col-4">
                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Vacinas</label>
                                            <select class="form-select form-select-solid" name="vacinas" multiple data-control="select2" data-placeholder="Selecione a(s) Vacina(s)">
                                                <option></option>
                                                <?php foreach ($vacinas_list as $key => $value) { ?>
                                                    <option value="<?php echo $value["id_vacina"] ?>"><?php echo $value["codigo"] . ' - ' . $value["nome"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="col-12 mt-6">
                                            <div class="form-check form-check-custom form-check-success form-check-solid my-2">
                                                <input class="form-check-input" name="consentimento" type="checkbox" value="1" checked />
                                                <label class="form-check-label" for="">
                                                    Consente o Tratamento Médico
                                                </label>
                                            </div>

                                            <div class="form-check form-check-custom form-check-success form-check-solid my-2">
                                                <input class="form-check-input" name="autorizacao" type="checkbox" value="1" checked />
                                                <label class="form-check-label" for="">
                                                    Autoriza Partilha de Informação Médica
                                                </label>
                                            </div>
                                        </div>

                                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                                            <button type="reset" class="btn btn-light btn-active-light-primary me-2">Cancelar</button>
                                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Guardar Consulta</button>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("form-consultation");
            form.addEventListener("submit", doAppointment);

            const api_url = "http://localhost:4001/api/";
            const path = "consultations/consultas/";

            function doAppointment() {
                event.preventDefault();

                var form = document.getElementById("form-consultation");

                const formData = {
                    hashed_id: '<?php echo $consultation_hashed_id ?>',
                    motivo: form.motivo.value,
                    problemas: form.problemas.value,
                    obs_gerais: form.obs_gerais.value,
                    recomendacoes: form.recomendacoes.value,
                    tratamento: form.tratamento.value,
                    progresso: form.progresso.value,
                    diagnosticos_consulta: form.diagnostico.value,
                    patologias_consulta: form.patologias.value,
                    consentimento: form.consentimento.checked ? 1 : 0,
                    autorizacao: form.autorizacao.checked ? 1 : 0,
                };

                // Get values form a select2 with mutiple select and convert to json
                var diagnostico = $("#form-consultation select[name='diagnostico']").val();
                var patologias = $("#form-consultation select[name='patologias']").val();

                var diagnosticos_JSON = '';
                var patologias_JSON = '';

                // join the multiple diagnosticos with comma
                if (diagnostico != null) {
                    diagnosticos_JSON = diagnostico.join();
                }
                // join the multiple patologias with comma
                if (patologias != null) {
                    patologias_JSON = patologias.join();
                }

                formData.diagnosticos_consulta = '{'+ diagnosticos_JSON + '}';
                formData.patologias_consulta = '{'+ patologias_JSON + '}';


                fetch(api_url + path + "realizar", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(formData),
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status) {
                            Swal.fire({
                                icon: "success",
                                title: "Sucesso!",
                                text: data.message,
                                buttonsStyling: false,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    const confirmButton = Swal.getConfirmButton();
                                    confirmButton.blur();
                                },
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                },
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "lista";
                                }
                            });
                        } else {
                            console.log(JSON.stringify(formData)),
                                Swal.fire({
                                    icon: "error",
                                    title: "Ocorreu um Erro!",
                                    text: data.error,
                                    confirmButtonText: "Voltar a Marcação",
                                    buttonsStyling: false,
                                    customClass: {
                                        confirmButton: "btn btn-danger",
                                    },
                                });
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                    });
            }
        });
    </script>

</body>

</html>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>
<?php $page_name = "Adicionar Nova Consulta" ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/api/api.php") ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/api/rnu_api.php") ?>
<?php
$api = new Api();
$rnuapi = new RnuApi();

$offices = $api->fetch("consultations/gabinetes", null, null);
$offices_list = $offices["response"];

$specialities = $api->fetch("consultations/especialidades", null, null);
$specialities_list = $specialities["response"];

$patients = $rnuapi->fetch("patients/table", null, null);
$patients_list = $patients["response"]["data"];

$doctors = $rnuapi->fetch("doctors/list", null, null);
$doctors_list = $doctors["response"];

$health_unit = $rnuapi->fetch("health_units/list", null, null);
$health_unit_list = $health_unit["response"];
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
                                <div class="card mb-5 mb-xl-10">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                                        <!--begin::Card title-->
                                        <div class="card-title m-0">
                                            <h3 class="fw-bold m-0">Adicionar Nova Consulta</h3>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--begin::Card header-->
                                    <!--begin::Content-->
                                    <div id="kt_account_settings_profile_details" class="collapse show">
                                        <!--begin::Form-->
                                        <form id="form-add-appointment" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                                            <!--begin::Card body-->
                                            <div class="card-body border-top p-9">

                                                <div class="row mb-6">

                                                    <div class="col-12 col-lg-3">
                                                        <label class="col-lg-12 col-form-label required fw-semibold fs-6">Utente</label>
                                                        <select class="form-select form-select-solid" name="utente" data-control="select2" data-placeholder="Selecione o Utente">
                                                            <option></option>
                                                            <?php foreach ($patients_list as $key => $value) { ?>
                                                                <option value="<?php echo $value["hashed_id"] ?>"><?php echo $value["nome"] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-12 col-lg-3">
                                                        <label class="col-lg-12 col-form-label required fw-semibold fs-6">Médico</label>
                                                        <select class="form-select form-select-solid" name="medico" data-control="select2" data-placeholder="Selecione o Médico">
                                                            <option></option>
                                                            <?php foreach ($doctors_list as $key => $value) { ?>
                                                                <option value="<?php echo $value["id_medico"] ?>"><?php echo $value["nome"] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-12 col-lg-4">
                                                        <label class="col-lg-12 col-form-label required fw-semibold fs-6">Unidade de Saúde</label>
                                                        <select class="form-select form-select-solid" name="unidade_saude" data-control="select2" data-placeholder="Selecione a Unidade de Saúde">
                                                            <option></option>
                                                            <?php foreach ($health_unit_list as $key => $value) { ?>
                                                                <option value="<?php echo $value["id_usf"] ?>"><?php echo $value["nome"] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-12 col-lg-2">
                                                        <label class="col-lg-12 col-form-label required fw-semibold fs-6">Tipo Consulta</label>
                                                        <select class="form-select form-select-solid" name="tipo_consulta" data-control="select2" data-placeholder="Selecione o Tipo de Consulta">
                                                            <option></option>
                                                            <option value="0">Urgência</option>
                                                            <option value="1">Rotina</option>
                                                            <option value="2">Acompanhamento</option>
                                                        </select>
                                                    </div>
                                                   
                                                    <div class="col-12 col-lg-4">
                                                        <label class="col-lg-12 col-form-label required fw-semibold fs-6">Gabinete</label>
                                                        <select class="form-select form-select-solid" name="gabinete" data-control="select2" data-placeholder="Selecione o Gabinete">
                                                            <option></option>
                                                            <?php foreach ($offices_list as $key => $value) { ?>
                                                                <option value="<?php echo $value["id_gabinete"] ?>"><?php echo $value["numero"] . ' - ' . $value["nome"] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-12 col-lg-4">
                                                        <label class="col-lg-12 col-form-label required fw-semibold fs-6">Especialidade</label>
                                                        <select class="form-select form-select-solid" name="especialidade" data-control="select2" data-placeholder="Selecione a Especialidade">
                                                            <option></option>
                                                            <?php foreach ($specialities_list as $key => $value) { ?>
                                                                <option value="<?php echo $value["id_especialidade"] ?>"><?php echo $value["codigo"] . ' - ' . $value["nome"] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-12 col-lg-2">
                                                        <label class="col-lg-12 col-form-label required fw-semibold fs-6">Data da Consulta</label>
                                                        <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                            <input class="form-control form-control-solid" autocomplete="off" placeholder="Data da Consulta" id="data_inicio" />
                                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-12 col-lg-2">
                                                        <label class="col-lg-12 col-form-label required fw-semibold fs-6">Hora Inicio da Consulta</label>
                                                        <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                            <input class="form-control form-control-solid" placeholder="Hora de Inicio da Consulta" id="hora_inicio" />
                                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <!--end::Card body-->
                                            <!--begin::Actions-->
                                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                <button type="reset" class="btn btn-light btn-active-light-primary me-2">Cancelar</button>
                                                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Criar Consulta</button>
                                            </div>
                                            <!--end::Actions-->
                                            <input type="hidden">
                                        </form>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Content-->
                                </div>


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
        $("#data_inicio").flatpickr();
        flatpickr("#data_inicio", {
            dateFormat: "Y-m-d",
            locale: "pt",
            allowInput: true,
        });
        $("#hora_inicio").flatpickr({
            enableTime: true,
            noCalendar: true,
            time_24hr: true,
            dateFormat: "H:i",
            minuteIncrement: 1,
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("form-add-appointment");
            form.addEventListener("submit", insertappointment);

            const api_url = "http://localhost:4001/api/";
            const path = "consultations/consultas/";

            function insertappointment() {
                event.preventDefault();

                var form = document.getElementById("form-add-appointment");

                const formData = {
                    id_utente: form.utente.value,
                    id_medico: form.medico.value,
                    id_unidade_saude: form.unidade_saude.value,
                    id_gabinete: form.gabinete.value,
                    id_especialidade: form.especialidade.value,
                    tipo_consulta: form.tipo_consulta.value,
                    data_inicio: form.data_inicio.value,
                    hora_inicio: form.hora_inicio.value,
                };


                fetch(api_url + path + "adicionar", {
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
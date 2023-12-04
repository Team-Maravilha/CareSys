<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>

<body id="kt_app_body" data-kt-app-header-fixed-mobile="true" data-kt-app-toolbar-enabled="true" class="app-default">
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/toolbar.php") ?>
                <div class="app-container container-xxxl">
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <div class="d-flex flex-column flex-column-fluid">
                            <div id="kt_app_content" class="app-content">


                                <!-- Content Here -->

                                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start  container-xxxl ">
                                    <div class="content flex-row-fluid" id="kt_content">
                                        <div class="card container-xxxl">
                                            <div class="card-body">

                                                <div class="text-center mb-15">
                                                    <h3 class="fs-2hx text-gray-900 mb-5">Faça já o seu Pedido!</h3>

                                                    <div class="fs-5 text-muted fw-semibold">
                                                        Realize o preenchimento do campos de forma devida, para que o <br> seu pedido de criação de Nº de Utente possa ser avaliado. <br>
                                                    </div>
                                                </div>


                                                <form id="form-register-patient" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">

                                                    <div class="row mb-6">
                                                        <div class="col-12 col-lg-6">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Nome Completo</label>
                                                            <input type="text" name="nome" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Nome Completo" value="">
                                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                                        </div>
                                                        <div class="col-12 col-lg-2">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Género</label>
                                                            <select class="form-select form-select-solid" name="genero" data-control="select2" data-hide-search="true" data-placeholder="Selecione um Género">
                                                                <option></option>
                                                                <option value="1">Masculino</option>
                                                                <option value="2">Feminino</option>
                                                                <option value="0">Outro</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-2">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Data de Nascimento</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input class="form-control form-control-solid" name="data_nascimento" placeholder="Selecione uma Data" id="data_nascimento" />
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-2">
                                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Hora de Nascimento</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input class="form-control form-control-solid" name="hora_nascimento" placeholder="Selecione uma Hora" id="hora_nascimento" />
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6">
                                                        <div class="col-12 col-lg-3">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Tipo Documento</label>
                                                            <select class="form-select form-select-solid" name="id_tipo_documento" data-control="select2" data-hide-search="true" data-placeholder="Selecione um Tipo de Documento">
                                                                <option></option>
                                                                <option value="1">Cartão de Cidadão</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-3">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Número Documento</label>
                                                            <input type="text" name="num_cc" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Número do Documento" value="">
                                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                                        </div>
                                                        <div class="col-12 col-lg-2 ">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Código Validação</label>
                                                            <input type="text" name="cod_validacao_cc" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Código Validação" value="">
                                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                                        </div>
                                                        <div class="col-12 col-lg-2">
                                                            <label class="col-lg-12 col-form-label required required fw-semibold fs-6">Data de Validade do Documento</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input class="form-control form-control-solid" name="data_validade_cc" placeholder="Selecione uma Data de Validade" id="data_validade_cc" />
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-2">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Número Segurança Social</label>
                                                            <input type="text" name="num_ident_seg_social" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Número Segurança Social" value="">
                                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6">
                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Número de Identificação Fiscal</label>
                                                            <input type="text" name="num_ident_fiscal" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Número de Identificação Fiscal" value="">
                                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                                        </div>
                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Número de Utente do Pai</label>
                                                            <input type="text" name="num_utente_pai" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Número de Utente do Pai" value="">
                                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                                        </div>
                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Número de Utente da Mãe</label>
                                                            <input type="text" name="num_utente_mae" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Número de Utente da Mãe" value="">
                                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6">
                                                        <div class="col-12 col-lg-2">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Estado Civil</label>
                                                            <select class="form-select form-select-solid" name="estado_civil" data-control="select2" data-hide-search="true" data-placeholder="Selecione um Estado">
                                                                <option></option>
                                                                <option value="1">Solteiro(a)</option>
                                                                <option value="2">Casado(a)</option>
                                                                <option value="3">União de Facto</option>
                                                                <option value="4">Divorciado(a)</option>
                                                                <option value="5">Viúvo(a)</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-2">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Situação Profissional</label>
                                                            <select class="form-select form-select-solid" name="situacao_profissional" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma Situação Profissional">
                                                                <option></option>
                                                                <option value="1">Estudante</option>
                                                                <option value="2">Desempregado(a)</option>
                                                                <option value="3">Empregado(a)</option>
                                                                <option value="4">Reformado(a)</option>
                                                                <option value="5">Outra</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Profissão</label>
                                                            <input type="text" name="profissao" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Profissão" value="">
                                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                                        </div>
                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Habilitações Literárias</label>
                                                            <input type="text" name="hab_escolares" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Habilitações Literárias" value="">
                                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6">
                                                        <div class="col-12 col-lg-2">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Contacto Telemóvel</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input type="text" name="num_telemovel" class="form-control form-control-lg form-control-solid" placeholder="Número para Contacto Móvel" value="">
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-2">
                                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Contacto Telefónico</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input type="text" name="num_telefone" class="form-control form-control-lg form-control-solid" placeholder="Número para Contacto Fixo" value="">
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-4">
                                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Contacto Email</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input type="email" name="email" class="form-control form-control-lg form-control-solid" placeholder="Email para Contacto" value="">
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-2">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Isento Taxa Moderadora</label>
                                                            <div class="col-lg-12 fv-row form-switch fv-plugins-icon-container">
                                                                <input class="form-check-input " type="checkbox" value="1" name="taxa_moderadora" id="taxa_moderadora" />
                                                                <label class="form-check-label" for="taxa_moderadora">
                                                                    Sim
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-2">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Seguro de Saúde</label>
                                                            <div class="col-lg-12 fv-row form-switch fv-plugins-icon-container">
                                                                <input class="form-check-input " type="checkbox" value="1" name="seguro_saude" id="seguro_saude" />
                                                                <label class="form-check-label" for="seguro_saude">
                                                                    Sim
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6">
                                                        <div class="col-12 col-lg-3">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">País</label>
                                                            <select class="form-select form-select-solid" name="pais" data-control="select2" data-hide-search="true" data-placeholder="Selecione um País">
                                                                <option></option>
                                                                <option value="1">Portugal</option>
                                                                <option value="2">Outro</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-3">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Distrito</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input type="text" name="distrito" class="form-control form-control-lg form-control-solid" placeholder="Distrito" value="">
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-3">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Concelho</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input type="text" name="concelho" class="form-control form-control-lg form-control-solid" placeholder="Concelho" value="">
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-3">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Freguesia</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input type="text" name="freguesia" class="form-control form-control-lg form-control-solid" placeholder="Freguesia" value="">
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6">
                                                        <div class="col-12 col-lg-6">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Morada</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input type="text" name="morada" class="form-control form-control-lg form-control-solid" placeholder="Morada" value="">
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-2">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Código-Postal</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input type="text" name="cod_postal" class="form-control form-control-lg form-control-solid" placeholder="Código-Postal" value="">
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-2">
                                                            <label class="col-lg-12 col-form-label required fw-semibold fs-6">Número da Porta</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input type="number" name="num_porta" class="form-control form-control-lg form-control-solid" placeholder="Número da Porta" value="">
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-2">
                                                            <label class="col-lg-12 col-form-label fw-semibold fs-6">Andar</label>
                                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                                <input type="text" name="andar" class="form-control form-control-lg form-control-solid" placeholder="Andar" value="">
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <p style="color: red !important">* Campos de Preenchimento Obrigatório</p>

                                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                        <button type="reset" class="btn btn-light btn-active-light-primary me-2">Cancelar</button>
                                                        <button type="submit" class="btn btn-primary" id="send_request">Submeter</button>
                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

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
        $("#data_nascimento").flatpickr();
        $("#hora_nascimento").flatpickr();
        $("#data_validade_cc").flatpickr();

        flatpickr("#data_nascimento", {
            dateFormat: "Y-m-d",
            locale: "pt",
            allowInput: true,
            maxDate: "today",
        });

        flatpickr("#data_validade_cc", {
            dateFormat: "Y-m-d",
            locale: "pt",
            allowInput: true,
            minDate: "today",
        });

        flatpickr("#hora_nascimento", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            locale: "pt",
            allowInput: true,
            time_24hr: true
        });

        const inputZipCode = document.querySelector(`[name="cod_postal"]`);
        Inputmask({
            mask: "9999-999",
            placeholder: "_",
            showMaskOnHover: true,
            showMaskOnFocus: true,
        }).mask(inputZipCode);

        const numCC = document.querySelector(`[name="num_cc"]`);
        Inputmask({
            mask: "99999999",
            showMaskOnHover: true,
            showMaskOnFocus: true,
        }).mask(numCC);

        const cod_validacao_cc = document.querySelector(`[name="cod_validacao_cc"]`);
        Inputmask({
            mask: "9 AA9",
            showMaskOnHover: true,
            showMaskOnFocus: true,
        }).mask(cod_validacao_cc);

        const num_ident_seg_social = document.querySelector(`[name="num_ident_seg_social"]`);
        Inputmask({
            mask: "99999999999",
            showMaskOnHover: true,
            showMaskOnFocus: true,
        }).mask(num_ident_seg_social);

        const num_ident_fiscal = document.querySelector(`[name="num_ident_fiscal"]`);
        Inputmask({
            mask: "999999999",
            showMaskOnHover: true,
            showMaskOnFocus: true,
        }).mask(num_ident_fiscal);

        const num_utente_pai = document.querySelector(`[name="num_utente_pai"]`);
        Inputmask({
            mask: "999999999",
            showMaskOnHover: true,
            showMaskOnFocus: true,
        }).mask(num_utente_pai);

        const num_utente_mae = document.querySelector(`[name="num_utente_mae"]`);
        Inputmask({
            mask: "999999999",
            showMaskOnHover: true,
            showMaskOnFocus: true,
        }).mask(num_utente_mae);

        const num_telemovel = document.querySelector(`[name="num_telemovel"]`);
        Inputmask({
            mask: "999999999",
            showMaskOnHover: true,
            showMaskOnFocus: true,
        }).mask(num_telemovel);
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("form-register-patient");
            form.addEventListener("submit", createPatient);

            const api_url = "http://localhost:4000/api/";
            const path = "requests/";

            function createPatient() {
                event.preventDefault();

                var form = document.getElementById("form-register-patient");

                const formData = new FormData(form);

                var object = {};
                formData.forEach(function(value, key) {
                    object[key] = value;
                });
                // Verificar se o object[key] é "" se for alterar para null
                for (var key in object) {
                    if (object[key] == "") {
                        object[key] = null;
                    }
                }
                // Verificar se existe a key taxa moderada, senão inserir como 0
                if (!object.hasOwnProperty("taxa_moderadora")) {
                    object["taxa_moderadora"] = 0;
                }
                // Verificar se existe a key seguro saude, senão inserir como 0
                if (!object.hasOwnProperty("seguro_saude")) {
                    object["seguro_saude"] = 0;
                }
                // Adicionar ao FormData
                formData.append('taxa_moderadora', object['taxa_moderadora']);
                formData.append('seguro_saude', object['seguro_saude']);

                var formDataInfo = JSON.stringify(object);

                fetch(api_url + path + "create", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: formDataInfo,
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status) {
                            Swal.fire({
                                icon: "success",
                                title: "Sucesso!",
                                html: "O seu pedido foi submetido com sucesso! <br> Entraremos em contacto o mais breve possível!",
                                buttonsStyling: false,
                                allowOutsideClick: false,
                                showConfirmButton: true,
                                confirmButtonText: 'Confirmar!',
                                didOpen: () => {
                                    const confirmButton = Swal.getConfirmButton();
                                    confirmButton.blur();
                                },
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                },
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Ocorreu um Erro!",
                                text: data.error,
                                confirmButtonText: "Voltar a Edição",
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
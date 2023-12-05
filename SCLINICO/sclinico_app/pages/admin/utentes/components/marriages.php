<?php
$patient_marriages = $patient_info["response"]["0"]["conjuge"];

$utentes = $api->fetch("patients/table", null, null);
$utentes_lista = $utentes["response"]["data"];
?>
<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Histórico de Cônjuges</h3>
        </div>
    </div>

    <div>
        <a data-bs-toggle="modal" data-bs-target="#modal-marry" class="btn btn-light-primary d-flex align-items-center lh-1 float-end mt-2 me-2">
            <i class="ki-outline ki-plus fs-2"></i>Adicionar
        </a>
    </div>
    <div class="card-body">
        <!--begin::Table-->
        <div id="kt_table_widget_5_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-3 dataTable no-footer" id="kt_table_widget_5_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-150px sorting" tabindex="0" aria-controls="kt_table_widget_5_table" rowspan="1" colspan="1">Nome</th>
                            <th class="text-end pe-3 min-w-100px sorting_disabled" rowspan="1" colspan="1">Nº Utente</th>
                            <th class="text-end pe-3 min-w-100px sorting_disabled" tabindex="0" aria-controls="kt_table_widget_5_table" rowspan="1" colspan="1">Nº CC</th>
                            <th class="text-end pe-3 min-w-100px sorting" tabindex="0" aria-controls="kt_table_widget_5_table" rowspan="1" colspan="1">Data Casamento</th>
                            <th class="text-end pe-3 min-w-100px sorting" tabindex="0" aria-controls="kt_table_widget_5_table" rowspan="1" colspan="1">Data Divorcio</th>
                            <th class="text-end pe-0 min-w-80px sorting_disabled" tabindex="0" aria-controls="kt_table_widget_5_table" rowspan="1" colspan="1">Estado</th>
                            <th class="text-end pe-0 min-w-50px" tabindex="0" aria-controls="kt_table_widget_5_table" rowspan="1" colspan="1">Ações</th>
                        </tr>
                    </thead>

                    <tbody class="fw-bold text-gray-600">

                        <?php if (isset($patient_marriages)) { ?>

                            <?php foreach ($patient_marriages as $key => $value) { ?>
                                <tr class="odd">
                                    <td><a class="text-gray-900 text-hover-primary"><?php echo $value["nome"] ?></a></td>

                                    <td class="text-end"><?php echo $value["num_utente"] ?></td>

                                    <td class="text-end"><?php echo $value["num_cc"] ?></td>

                                    <td class="text-end"><?php echo (new DateTime($value["data_associacao"]))->format("d/m/Y"); ?></td>

                                    <td class="text-end"><?php if ($value["data_desassociacao"] != null) {
                                                                echo (new DateTime($value["data_desassociacao"]))->format("d/m/Y");
                                                            } else {
                                                                echo "-";
                                                            } ?></td>

                                    <td class="text-end">
                                        <span class="badge py-3 px-4 fs-7 text-white badge-primary"><?php echo $value["estado_casamento"] ?></span>
                                    </td>

                                    <td class="text-end">
                                        <?php if ($value["estado_casamento"] === "Casado") { ?>
                                            <a class="btn btn-sm btn-danger" onclick="divorce()">Divorciar</a>
                                        <?php } else {
                                            echo "-";
                                        } ?>
                                    </td>
                                </tr>
                            <?php } ?>

                        <?php } else { ?>
                            <tr>
                                <td colspan="7" class="text-center">
                                    <p>Sem Informação de Cônjuges</p>
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div>
                <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"></div>
            </div>
        </div>
        <!--end::Table-->
    </div>
</div>

<!-- Modal for marry Patient -->
<div class="modal fade" id="modal-marry" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="modal-marry-header">
                <h3 class="fw-bold">Adicionar Novo Cônjuge ao Utente - <?php echo $patient_info_data["nome"] ?></h3>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="las la-times fs-1"></i>
                </div>
            </div>

            <div class="modal-body mx-5 mx-xl-15 my-7">
                <form id="modal-marry-form" class="form" action="#">
                    <div class="d-flex flex-column me-n7 pe-7" id="modal-marry-form-scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#modal-marry-header" data-kt-scroll-wrappers="#modal-marry-form-scroll" data-kt-scroll-offset="350px" style="max-height: 91px;">
                        <div class="row g-6">

                            <div class="col-12">
                                <div class="fv-row">
                                    <label class="required fw-semibold fs-6">Selecione um Utente</label>
                                    <select class="form-select form-select-solid" name="id_utente" data-dropdown-parent="#modal-marry" data-control="select2" data-placeholder="Selecione o Utente para Associar" data-allow-clear="true">
                                        <option></option>
                                        <?php foreach ($utentes_lista as $key => $value) {
                                            if ($value["hashed_id"] != $hashed_id) { ?>
                                                <option value="<?php echo $value["hashed_id"] ?>">
                                                    <?php echo $value["nome"] . " (NºUtente: " . $value["num_utente"] . ")" ?>
                                                </option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="text-center pt-15">
                        <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3">Cancelar</button>
                        <button type="submit" class="btn btn-light-primary">
                            <span class="indicator-label">Associar</span>
                            <span class="indicator-progress">Por Favor Aguarde...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const api_url = "http://localhost:4000/api/";
    const path = "patients/";

    var divorce = () => {
        Swal.fire({
            title: 'Divorciar Utente',
            text: "Tem a certeza que pretende divorciar o Utente?",
            icon: 'error',
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: 'Sim, divorciar!',
            cancelButtonText: 'Não, cancelar!',
            reverseButtons: true,
            buttonsStyling: false,
            allowOutsideClick: false,
            didOpen: () => {
                const confirmButton = Swal.getConfirmButton();
                confirmButton.blur();
            },
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-active-light-warning",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'A divorciar o utente!',
                    text: 'Por favor aguarde...',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading()
                    },
                });
                fetch(api_url + path + "patient/divorce", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            hashed_id: "<?php echo $hashed_id ?>"
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === true) {
                            Swal.fire({
                                title: 'Utente divorciado com sucesso!',
                                text: 'A redirecionar para o Utente...',
                                icon: 'success',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                willOpen: () => {
                                    Swal.showLoading()
                                },
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            Swal.fire({
                                title: 'Erro ao divorciar o utente!',
                                text: data.message,
                                icon: 'error',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                willOpen: () => {
                                    Swal.showLoading()
                                },
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Erro ao divorciar o utente!',
                            text: 'Por favor tente novamente...',
                            icon: 'error',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            willOpen: () => {
                                Swal.showLoading()
                            },
                        });
                        setTimeout(() => {
                                location.reload();
                            },
                            1500);
                    });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                toastr.warning('Cancelou a operação que realizava!', 'Cancelado!');
            }
        })
    }
</script>

<script>
    const form = document.getElementById("modal-marry-form");
    form.addEventListener("submit", MarryPatient);

    const api_url2 = "http://localhost:4000/api/";
    const path2 = "patients/patient/marry";

    function MarryPatient() {
        event.preventDefault();
        var form = document.getElementById("modal-marry-form");


        const formData = {
            hashed_id: "<?php echo $hashed_id ?>",
            hashed_id_user: form.id_utente.value,
        };


        fetch(api_url2 + path2, {
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
</script>
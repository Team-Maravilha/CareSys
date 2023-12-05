<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Comparticipação Medicação</h3>
        </div>
    </div>

    <div class="card-body">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-md-between flex-wrap mb-5 gap-4">
            <div class="d-flex align-items-center position-relative my-1 mb-2 mb-md-0">
                <span class="svg-icon svg-icon-1 position-absolute ms-5">
                    <i class="ki-outline ki-magnifier fs-2"></i>
                </span>
                <input type="text" data-datatable-action="search" class="form-control form-control-solid w-250px ps-15" placeholder="Pesquisar...">
            </div>

            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-md-end gap-3">
                <button type="button" class="btn btn-icon btn-active-light-primary lh-1" data-datatable-action="sync" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" title="Sincronizar tabela">
                    <i class="ki-outline ki-arrows-circle fs-2"></i>
                </button>
                <button type="button" class="btn btn-light-primary d-flex align-items-center lh-1" data-bs-toggle="modal" data-bs-target="#modal-add-contribution">
                    <i class="ki-outline ki-plus fs-2"></i>Adicionar
                </button>

            </div>
        </div>

        <div class="table-responsive">
            <table id="datatable_special_medication" class="table align-middle gs-0 gy-4">
                <thead>
                    <tr class="fw-bold text-muted bg-light">
                        <th class="ps-4 fs-6 min-w-250px rounded-start" data-priority="1">Motivo</th>
                        <th class="ps-4 fs-6 min-w-100px rounded-start" data-priority="2">Data Início</th>
                        <th class="ps-4 fs-6 min-w-100px rounded-start" data-priority="3">Data Fim</th>
                        <th class="ps-4 fs-6 min-w-100px rounded-start" data-priority="4">Data Criação</th>
                        <th class="pe-4 fs-6 min-w-50px text-sm-end rounded-end" data-priority="7">Ações</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-contribution" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="modal-add-contribution-header">
                <h2 class="fw-bold">Adicionar Comparticipação Medicação</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-modal-action="cancel">
                    <i class="las la-times fs-1"></i>
                </div>
            </div>

            <div class="modal-body mx-5 mx-xl-15 my-7">
                <form id="modal-add-contribution-form" class="form" action="#">
                    <div class="d-flex flex-column me-n7 pe-7" id="modal-add-contribution-form-scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#modal-add-contribution-header" data-kt-scroll-wrappers="#modal-add-contribution-form-scroll" data-kt-scroll-offset="350px" style="max-height: 91px;">
                        <div class="row g-6">

                            <div class="col-12">
                                <div class="fv-row">
                                    <label for="modal-add-contribution-form-motivo" class="required fw-semibold fs-6 mb-2">Motivo</label>
                                    <input type="text" name="motivo" id="modal-add-contribution-form-motivo" class="form-control form-control-solid mb-3 mb-lg-0" value="" placeholder="Motivo da Comparticipação Medicação">
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="col-lg-12 col-form-label required fw-semibold fs-6">Data de Início</label>
                                <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                    <input class="form-control form-control-solid" name="data_inicio" placeholder="Selecione uma Data" id="data_inicio" />
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="col-lg-12 col-form-label required fw-semibold fs-6">Data de Fim</label>
                                <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                    <input class="form-control form-control-solid" name="data_fim" placeholder="Selecione uma Data" id="data_fim" />
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-modal-action="cancel">Cancelar</button>
                        <button type="button" class="btn btn-light-primary" data-modal-action="submit">
                            <span class="indicator-label">Adicionar</span>
                            <span class="indicator-progress">Aguarde...
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
    $("#data_inicio").flatpickr();
    $("#data_fim").flatpickr();

    flatpickr("#data_inicio", {
        dateFormat: "Y-m-d",
        locale: "pt",
        allowInput: true,
    });

    flatpickr("#data_fim", {
        dateFormat: "Y-m-d",
        locale: "pt",
        allowInput: true,
        minDate: "today",
    });
</script>

<script>
    var datatableServerSide = (function() {
        var table
        var dt

        var initDatatable = () => {
            dt = $("#datatable_special_medication").DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-PT.json",
                },
                searchDelay: 1000,
                processing: true,
                serverSide: false,
                responsive: true,
                order: [
                    [0, "asc"]
                ],
                lengthMenu: [10, 25, 50, 75, 100],
                stateSave: false,
                ajax: {
                    url: "http://localhost:4000/api/patients/patient/contribution/<?php echo $hashed_id ?>",
                    type: "GET",
                },
                columns: [{
                        data: "motivo"
                    },
                    {
                        data: "data_inicio"
                    },
                    {
                        data: "data_fim"
                    },
                    {
                        data: "data_criacao"
                    },
                    {
                        data: null
                    }
                ],
                columnDefs: [{
                        targets: 0,
                        render: (data, type, row) => {
                            return `
                        <span class="fw-bold fs-6 text-gray-800">
                                                            ${data}
                                                    </span>
                        `
                        },
                    },
                    {
                        targets: 1,
                        orderable: true,
                        render: (data, type, row) => {
                            var date = new Date(row.data_inicio);
                            var day = date.getDate();
                            var month = date.getMonth() + 1;
                            var year = date.getFullYear();
                            var formattedDate = (day < 10 ? "0" + day : day) + "/" + (month < 10 ? "0" + month : month) + "/" + year;
                            return `
                            <div class="d-inline-flex align-items-center">                                
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="text-dark fw-bold text-hover-primary mb-1 fs-6 lh-sm">${formattedDate}</span>
                                </div>
                            </div>
                        `
                        }
                    },
                    {
                        targets: 2,
                        orderable: true,
                        render: (data, type, row) => {
                            var date = new Date(row.data_fim);
                            var day = date.getDate();
                            var month = date.getMonth() + 1;
                            var year = date.getFullYear();
                            var formattedDate2 = (day < 10 ? "0" + day : day) + "/" + (month < 10 ? "0" + month : month) + "/" + year;
                            return `
                            <div class="d-inline-flex align-items-center">                                
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="text-dark fw-bold text-hover-primary mb-1 fs-6 lh-sm">${formattedDate2}</span>
                                </div>
                            </div>
                        `
                        }
                    },
                    {
                        targets: 3,
                        orderable: true,
                        render: (data, type, row) => {
                            var date = new Date(row.data_criacao);
                            var day = date.getDate();
                            var month = date.getMonth() + 1;
                            var year = date.getFullYear();
                            var formattedDate3 = (day < 10 ? "0" + day : day) + "/" + (month < 10 ? "0" + month : month) + "/" + year;
                            return `
                            <div class="d-inline-flex align-items-center">                                
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="text-dark fw-bold text-hover-primary mb-1 fs-6 lh-sm">${formattedDate3}</span>
                                </div>
                            </div>
                        `
                        }
                    },
                    {
                        targets: -1,
                        orderable: false,
                        className: "text-sm-end",
                        render: (data, type, row) => {
                            return `
                            <div class="d-flex justify-content-end flex-shrink-0 me-6">
                                <button type="button" class="btn btn-icon btn-sm btn-light-danger d-flex align-items-center lh-1" data-element-id="${row.id_comparticipacao_medicamentos}" data-element-action="delete">
                                    <i class="ki-duotone ki-trash fs-1 ">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                    </i>
                                </button>
                            </div>
                        `
                        },
                    },
                ],
            })

            table = dt.$

            dt.on("draw", () => {})
        }

        var handleSyncDatatable = () => {
            const syncButton = document.querySelector(`[data-datatable-action="sync"]`)
            if (!syncButton) {
                toastr.error("Não foi possível encontrar o botão de sincronização.")
                return
            }

            syncButton.addEventListener("click", (e) => {
                e.preventDefault()
                dt.ajax.reload()
            })
        }

        var handleSearchDatatable = () => {
            const filterSearch = document.querySelector(`[data-datatable-action="search"]`)
            filterSearch.addEventListener("keyup", (e) => dt.search(e.target.value).draw())
        }

        var handleAddEmergencyContact = () => {
            const modal = document.querySelector("#modal-add-contribution");
            const form = document.querySelector("#modal-add-contribution-form");
            const validator = FormValidation.formValidation(form, {
                fields: {
                    "motivo": {
                        validators: {
                            notEmpty: {
                                message: "Motivo é obrigatório"
                            }
                        }
                    },
                    "data_inicio": {
                        validators: {
                            notEmpty: {
                                message: "Data de Início é obrigatória"
                            }
                        }
                    },
                    "data_fim": {
                        validators: {
                            notEmpty: {
                                message: "Data de Fim é obrigatória"
                            }
                        }
                    },
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            });

            const modalSubmit = form.querySelector(`[data-modal-action="submit"]`);
            modalSubmit.addEventListener("click", (e) => {
                e.preventDefault();

                if (validator) {
                    validator.validate().then((status) => {
                        if (status === "Valid") {
                            modalSubmit.setAttribute("data-kt-indicator", "on");
                            modalSubmit.disabled = true;

                            const formData = new FormData(form);
                            formData.append("hashed_id", "<?php echo $hashed_id ?>");

                            console.log(formData);

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

                            const options = {
                                method: "POST",
                                body: JSON.stringify(object),
                                headers: {
                                    "Content-Type": "application/json",
                                },
                            };

                            fetch("http://localhost:4000/api/patients/patient/contribution/add", options)
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
                                                $("#modal-add-contribution").modal("hide");
                                                dt.ajax.reload()
                                                modalSubmit.removeAttribute("data-kt-indicator");
                                                modalSubmit.disabled = false;
                                                handleResetAddForm();
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
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                modalSubmit.removeAttribute("data-kt-indicator");
                                                modalSubmit.disabled = false;
                                            }
                                        });
                                    }
                                })
                                .catch((error) => {
                                    console.error("Error:", error);
                                });
                        }
                    });
                }
            });

            $(modal).find(`[data-modal-action="cancel"]`).on("click", () => {
                Swal.fire({
                    text: "Tem a certeza que deseja cancelar?",
                    title: "Cancelar?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Sim, cancelar!",
                    cancelButtonText: "Não, voltar",
                    reverseButtons: true,
                    allowOutsideClick: false,
                    didOpen: () => {
                        const confirmButton = Swal.getConfirmButton();
                        confirmButton.blur();
                    },
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        handleResetAddForm();
                        $(modal).modal("hide");
                    }
                });

            });
        };

        var handleResetAddForm = () => {
            const modal = document.querySelector("#modal-add-contribution");
            const form = document.querySelector("#modal-add-contribution-form");

            modal.addEventListener("hidden.bs.modal", () => {
                form.reset();
            });
        };

        var handleDeleteEmergencyContact = () => {
            const deleteButton = document.querySelector(`[data-element-action="delete"]`)
            $("#datatable_special_medication").on("click", "[data-element-action='delete']", function(e) {
                e.preventDefault();
                const button = e.currentTarget;
                const id = button.getAttribute("data-element-id");

                Swal.fire({
                    text: "Tem a certeza que deseja eliminar?",
                    title: "Eliminar?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Sim, eliminar!",
                    cancelButtonText: "Não, voltar",
                    reverseButtons: true,
                    allowOutsideClick: false,
                    didOpen: () => {
                        const confirmButton = Swal.getConfirmButton();
                        confirmButton.blur();
                    },
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const options = {
                            method: "DELETE",
                            headers: {
                                "Content-Type": "application/json",
                            },
                        };

                        fetch(`http://localhost:4000/api/patients/patient/contribution/delete/${id}`, options)
                            .then((response) => {
                                response.text().then((json) => {
                                    json = JSON.parse(json);

                                    toastr.options = {
                                        positionClass: "toastr-top-right",
                                        preventDuplicates: true
                                    }

                                    if (response.status === 200) {

                                        toastr.success('Comparticipação Medicação eliminada com sucesso!') // show response from the php script.
                                        dt.ajax.reload()

                                    } else if (response.status === 400) {
                                        toastr.error(json.error);
                                    } else {
                                        toastr.error("Ocorreu um erro!");
                                    }
                                });
                            })
                            .catch((error) => {
                                console.error(error);
                            });
                    }
                });
            });
        };

        return {
            init: () => {
                initDatatable()
                handleSyncDatatable()
                handleSearchDatatable()
                handleAddEmergencyContact()
                handleDeleteEmergencyContact()
            },
        }
    })()

    window.addEventListener("DOMContentLoaded", () => {
        datatableServerSide.init()
    })
</script>
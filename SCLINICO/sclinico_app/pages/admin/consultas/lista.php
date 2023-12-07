<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/api/rnu_api.php") ?>
<?php
$rnuapi = new RnuApi();

$doctors = $rnuapi->fetch("doctors/list", null, null);
$doctors_list = $doctors["response"];

$page_name = "CareSys | SCLINICO - Consultas";
?>

<body id="kt_app_body" data-kt-app-header-fixed-mobile="true" data-kt-app-toolbar-enabled="true" class="app-default">
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/header.php") ?>
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/toolbar.php") ?>
                <div class="app-container container-xxxl">
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <div class="d-flex flex-column flex-column-fluid">
                            <div id="kt_app_content" class="app-content">


                                <!-- Content Here -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-md-between flex-wrap mb-5 gap-4">
                                            <div class="d-flex align-items-center position-relative my-1 mb-2 mb-md-0">
                                                <span class="svg-icon svg-icon-1 position-absolute ms-5">
                                                    <i class="ki-outline ki-magnifier fs-2"></i>
                                                </span>
                                                <input type="text" data-datatable-action="search" class="form-control form-control-solid w-250px ps-15" placeholder="Pesquisar...">

                                                <div class="d-flex align-items-center gap-2 ms-2">
                                                    <button class="btn btn-icon btn-light" id="prev-date"><i class="las la-angle-left"></i></button>
                                                    <div class="d-flex align-items-center position-relative">
                                                        <span class="position-absolute ms-5 lh-1">
                                                            <i class="ki-outline ki-calendar fs-2"></i>
                                                        </span>
                                                        <input type="text" data-datatable-action="date" class="form-control form-control-solid w-200px ps-15" value="" placeholder="dd/mm/aaaa">
                                                    </div>
                                                    <button class="btn btn-icon btn-light" id="next-date"><i class="las la-angle-right"></i></button>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-md-end gap-3">
                                                <!-- Sincronizar Tabela -->
                                                <button type="button" class="btn btn-icon btn-active-light-primary lh-1" data-datatable-action="sync" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" title="Sincronizar tabela">
                                                    <i class="ki-outline ki-arrows-circle fs-2"></i>
                                                </button>

                                                <!-- Filtros Tabela -->
                                                <button type="button" class="btn btn-light-warning d-flex align-items-center lh-1 gap-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    <i class="ki-outline ki-filter fs-2 p-0 m-0"></i>
                                                    Filtros
                                                </button>
                                                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="toolbar-filter">
                                                    <div class="px-7 py-5">
                                                        <div class="fs-4 text-dark fw-bold">Opções de Filtro</div>
                                                    </div>

                                                    <div class="separator border-gray-200"></div>

                                                    <div class="px-7 py-5">
                                                        <div class="mb-0">
                                                            <label class="form-label fs-5 fw-semibold mb-3">Médico</label>

                                                            <select class="form-select form-select-solid" id="medic" data-datatable-filter="medic">
                                                                <option value="all" selected>Todos</option>
                                                                <?php foreach ($doctors_list as $key => $value) { ?>
                                                                    <option value="<?php echo $value["id_medico"]; ?>" data-image="<?php echo $default_avatar ?>"><?php echo $value["nome"] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="px-7 py-5">
                                                        <div class="mb-0">
                                                            <label class="form-label fs-5 fw-semibold mb-3">Estado Consulta</label>

                                                            <select class="form-select form-select-solid" id="status" data-datatable-filter="status">
                                                                <option value="all" selected>Todos</option>
                                                                <option value="0" data-color="#7239ea">Pendente</option>
                                                                <option value="2" data-color="#50cd89">Concluída</option>
                                                                <option value="1" data-color="#ffc700">Em Curso</option>
                                                                <option value="3" data-color="#181C32">Cancelada</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="separator border-gray-200"></div>
                                                    <div class="px-7 py-5">
                                                        <div class="d-flex justify-content-end">
                                                            <!-- <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-datatable-action="reset-filter">Resetar</button> -->
                                                            <button type="submit" class="btn btn-light-primary" data-kt-menu-dismiss="true" data-datatable-action="filter">Aplicar</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="datatable" class="table align-middle gs-0 gy-4">
                                                <thead>
                                                    <tr class="fw-bold text-muted bg-light">
                                                        <th class="ps-4 fs-6 min-w-150px rounded-start" data-priority="1">Médico</th>
                                                        <th class="ps-4 fs-6 min-w-150px" data-priority="2">Utente</th>
                                                        <th class="ps-4 fs-6 min-w-150px" data-priority="3">Unidade de Saúde</th>
                                                        <th class="ps-4 fs-6 min-w-100px" data-priority="4">Especialidade</th>
                                                        <th class="ps-4 fs-6 min-w-100px" data-priority="5">Gabinete</th>
                                                        <th class="ps-4 fs-6 min-w-100px" data-priority="6">Hora</th>
                                                        <th class="ps-4 fs-6 min-w-80px" data-priority="7">Estado</th>
                                                        <th class="pe-4 fs-6 min-w-50px text-sm-end rounded-end" data-priority="8">Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
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
        const select2OptionFormat = (item) => {
            if (!item.id) return item.text;
            const imgUrl = item.element.getAttribute("data-image");
            const color = item.element.getAttribute("data-color");
            if (!imgUrl && !color) return item.text;

            const span = document.createElement("span");
            let template = "";

            span.setAttribute("class", "d-flex align-items-center");

            if (imgUrl) {
                template += `<img src="<?php echo $link_home ?>${imgUrl}" class="rounded w-20px h-20px me-2 border border-body" alt="..." style="object-fit: cover;" >`;
                template += item.text;
            } else if (color) template += `<span class="badge text-white" style="background-color: ${color};">${item.text}</span>`;

            span.innerHTML = template;
            return $(span);
        };

        window.addEventListener("DOMContentLoaded", () => {
            $("#medic").select2({
                placeholder: "Selecione um médico",
                allowClear: true,
                width: "100%",
                templateSelection: select2OptionFormat,
                templateResult: select2OptionFormat
            });

            $("#status").select2({
                placeholder: "Selecione um estado",
                allowClear: true,
                width: "100%",
                templateSelection: select2OptionFormat,
                templateResult: select2OptionFormat
            });
        });
    </script>

    <script>
        var datatableServerSide = (function() {
            var table
            var dt

            var initDatatable = () => {
                dt = $("#datatable").DataTable({
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
                        url: "http://localhost:4001/api/consultations/consultas/table",
                        type: "POST",
                        contentType: "application/json",
                        data: () => {
                            return JSON.stringify({
                                'data_inicio': moment(document.querySelector(`input[data-datatable-action="date"]`).value, "DD/MM/YYYY").format("YYYY-MM-DD"),
                                'status': document.querySelector('select[data-datatable-filter="status"]').value === "all" ? null : document.querySelector('select[data-datatable-filter="status"]').value,
                                'id_medico': document.querySelector('select[data-datatable-filter="medic"]').value === "all" ? null : document.querySelector('select[data-datatable-filter="medic"]').value
                            });
                        }
                    },
                    columns: [{
                            data: "id_medico"
                        },
                        {
                            data: "id_utente"
                        },
                        {
                            data: "id_consulta"
                        },
                        {
                            data: "id_especialidade"
                        },
                        {
                            data: "id_gabinete"
                        },
                        {
                            data: "hora_inicio"
                        },
                        {
                            data: "status_descricao"
                        },
                        {
                            data: null
                        }
                    ],
                    columnDefs: [{
                            targets: 0,
                            orderable: true,
                            render: (data, type, row) => {
                                return `
									<div class="d-inline-flex align-items-center">                                
										<div class="d-flex justify-content-center flex-column">
											<span class="text-dark fw-bold text-hover-primary mb-1 fs-6 lh-sm">${row.medico}</span>
										</div>
									</div>
								`
                            },
                        },
                        {
                            targets: 1,
                            orderable: true,
                            render: (data, type, row) => {
                                return `
									<div class="d-inline-flex align-items-center">                                
										<div class="d-flex justify-content-center flex-column">
										<span class="mb-1 fs-6 lh-sm">${row.utente}</span>
										</div>
									</div>
								`;

                            },
                        },
                        {
                            targets: 2,
                            orderable: true,
                            render: (data, type, row) => {
                                return `
									<div class="d-inline-flex align-items-center">                                
										<div class="d-flex justify-content-center flex-column">
										<span class="mb-1 fs-6 lh-sm">${row.unidade_saude}</span>
										</div>
									</div>
								`;

                            },
                        },
                        {
                            targets: 3,
                            orderable: true,
                            render: (data, type, row) => {
                                return `
									<div class="d-inline-flex align-items-center">                                
										<div class="d-flex justify-content-center flex-column">
										<span class="mb-1 fs-6 lh-sm">${row.nome_especialidade}</span>
										</div>
									</div>
								`;

                            },
                        },
                        {
                            targets: 4,
                            orderable: true,
                            render: (data, type, row) => {
                                return `
									<div class="d-inline-flex align-items-center">                                
										<div class="d-flex justify-content-center flex-column">
										<span class="mb-1 fs-6 lh-sm">${row.numero_gabinete}</span>
										</div>
									</div>
								`;

                            },
                        },
                        {
                            targets: 5,
                            orderable: true,
                            render: (data, type, row) => {

                                const formattedHour = moment(row.hora_inicio, "HH:mm:ss").format("HH:mm");
                                const formattedDate = moment(row.data_inicio).format('DD/MM/YYYY');

                                return `
									<div class="d-inline-flex align-items-center">                                
										<div class="d-flex justify-content-center flex-column">
											<span class="mb-1 fs-6 lh-sm">${formattedDate + ' - ' + formattedHour +'h'}</span>
										</div>
									</div>
								`;
                            },
                        },
                        {
                            targets: 6,
                            orderable: true,
                            render: (data, type, row) => {
                                if (row.status === 0) {
                                    return `
                            <div class="d-inline-flex align-items-center">                                
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="badge badge-info px-2 py-2">Pendente</span>
                                </div>
                            </div>
                        `
                                } else if (row.status === 1) {
                                    return `<div class="d-inline-flex align-items-center">                                
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="badge badge-success px-2 py-2">Em Curso</span>
                                </div>
                            </div>
                        `
                                } else if (row.status === 2) {
                                    return `<div class="d-inline-flex align-items-center">                                
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="badge badge-warning px-2 py-2">Concluído</span>
                                </div>
                            </div>
                        `
                                } else if (row.status === 3) {
                                    return `<div class="d-inline-flex align-items-center">                                
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="badge badge-dark px-2 py-2">Cancelada</span>
                                </div>
                            </div>
                        `
                                }
                            },
                        },
                        {
                            targets: -1,
                            orderable: false,
                            className: "text-sm-end",
                            render: (data, type, row) => {
                                if (row.status === 0) {
                                    return `
									<div>
                                        <button type="button" data-id="${row.hashed_id}" data-name="${row.utente}" data-datatable-action="cancel-row" class="btn btn-icon btn-bg-light btn-color-danger btn-active-light-danger rounded w-35px h-35px"><i class="ki-outline ki-information-3 fs-2"></i></button>
                                    </div>
								`;
                                } else if (row.status === 2) {
                                    return `
									<div>
										<a href="ver?id=${row.hashed_id}" class="btn btn-icon btn-bg-light btn-color-primary btn-active-light-primary rounded w-35px h-35px me-1"><i class="ki-outline ki-eye fs-2"></i></a>
                                    </div>
                                `;
                                } else {
                                    return `-`;
                                }
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

            var handleDeleteRows = () => {
                $("#datatable").on("click", "[data-datatable-action='cancel-row']", (e) => {
                    e.preventDefault()
                    const button = e.currentTarget
                    const parent = button.closest("tr")
                    const name = button.getAttribute("data-name")

                    Swal.fire({
                        icon: "error",
                        title: "Cancelar Consulta",
                        text: "Tem a certeza que deseja Cancelar a Consulta do Utente (" + name + ") ?",
                        showCancelButton: true,
                        buttonsStyling: false,
                        cancelButtonText: "Não, voltar",
                        confirmButtonText: "Sim, cancelar",
                        reverseButtons: true,
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
                            const id = button.getAttribute("data-id")

                            const data = {
                                hashed_id: id
                            }

                            const options = {
                                method: "POST",
                                body: JSON.stringify(data),
                                headers: {
                                    "Content-Type": "application/json",
                                },
                            }

                            fetch("http://localhost:4001/api/consultations/consultas/cancelar", options)
                                .then((response) => {
                                    response.text().then((json) => {
                                        json = JSON.parse(json)

                                        toastr.options = {
                                            positionClass: "toastr-top-right",
                                            preventDuplicates: true,
                                        }

                                        if (response.status === 201) {
                                            if (json.status === true) {
                                                toastr.success(json.message)
                                                dt.ajax.reload()
                                            }
                                        } else if (response.status === 401) {
                                            toastr.error(json.error)
                                        } else {
                                            toastr.error(json.error)
                                        }
                                    })
                                })
                                .catch((error) => {
                                    console.error(error)
                                })
                        }
                    })
                })
            }

            var handleDateFilter = () => {
                const inputDate = document.querySelector(`input[data-datatable-action="date"]`);
                const nextDate = document.querySelector("#next-date");
                const prevDate = document.querySelector("#prev-date");

                $(inputDate).flatpickr({
                    dateFormat: "d/m/Y",
                    locale: "pt",
                    disableMobile: true,
                    allowInput: true,
                    allowClear: false,
                    defaultDate: new Date()
                });

                inputDate.addEventListener("change", (e) => dt.ajax.reload());

                nextDate.addEventListener("click", (e) => {
                    const date = moment(inputDate.value, "DD/MM/YYYY");
                    date.add(1, "days");
                    inputDate.value = date.format("DD/MM/YYYY");
                    inputDate.dispatchEvent(new Event("change"));
                });
                prevDate.addEventListener("click", (e) => {
                    const date = moment(inputDate.value, "DD/MM/YYYY");
                    date.subtract(1, "days");
                    inputDate.value = date.format("DD/MM/YYYY");
                    inputDate.dispatchEvent(new Event("change"));
                });
            };

            var handleFilterDatatable = () => {
                const filterButton = document.querySelector(`[data-datatable-action="filter"]`);

                filterButton.addEventListener("click", () => {
                    dt.ajax.reload()
                });
            };

            return {
                init: () => {
                    initDatatable()
                    handleSyncDatatable()
                    handleSearchDatatable()
                    handleDeleteRows()
                    handleDateFilter()
                    handleFilterDatatable()
                },
            }
        })()

        window.addEventListener("DOMContentLoaded", () => {
            datatableServerSide.init()
        })
    </script>

</body>

</html>
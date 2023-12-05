<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>
<?php
$page_name = "CareSys | RNU - Todos os Utentes";
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
											</div>

											<div class="d-flex flex-column flex-sm-row align-items-center justify-content-md-end gap-3">
												<button type="button" class="btn btn-icon btn-active-light-primary lh-1" data-datatable-action="sync" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" title="Sincronizar tabela">
													<i class="ki-outline ki-arrows-circle fs-2"></i>
												</button>

											</div>
										</div>

										<div class="table-responsive">
											<table id="datatable" class="table align-middle gs-0 gy-4">
												<thead>
													<tr class="fw-bold text-muted bg-light">
														<th class="ps-4 fs-6 min-w-250px rounded-start" data-priority="1">Nome</th>
														<th class="ps-4 fs-6 min-w-100px rounded-start" data-priority="2">Nº Utente</th>
														<th class="ps-4 fs-6 min-w-120px rounded-start" data-priority="3">Nº Documento</th>
														<th class="ps-4 fs-6 min-w-150px rounded-start" data-priority="4">Nº Seg. Social</th>
														<th class="ps-4 fs-6 min-w-150px rounded-start" data-priority="5">Nº Ide. Fiscal</th>
														<th class="ps-4 fs-6 min-w-100px rounded-start" data-priority="6">País</th>
														<th class="ps-4 fs-6 min-w-100px rounded-start" data-priority="7">Data Aceitação</th>
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
						url: "http://localhost:4000/api/patients/table",
						type: "GET",
					},
					columns: [{
							data: "nome"
						},
						{
							data: "num_utente"
						},
						{
							data: "num_cc"
						},
						{
							data: "num_ident_seg_social"
						},
						{
							data: "num_ident_fiscal"
						},
						{
							data: "pais"
						},
						{
							data: "data_registo"
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
                                <a class="cursor-pointer" href="ficha_utente?id=${row.hashed_id}">
                                    <span class="text-dark fw-bold text-hover-primary mb-1 fs-6 lh-sm">${row.nome}</span>
                                    </a>
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
                                    <span class="text-dark fw-bold text-hover-primary mb-1 fs-6 lh-sm">${row.num_utente}</span>
                                </div>
                            </div>
                        `
							},
						},
						{
							targets: 2,
							orderable: true,
							render: (data, type, row) => {
								return `
                            <div class="d-inline-flex align-items-center">                                
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="text-dark fw-bold text-hover-primary mb-1 fs-6 lh-sm">${row.num_cc}</span>
                                </div>
                            </div>
                        `
							},
						},
						{
							targets: 3,
							orderable: true,
							render: (data, type, row) => {
								return `
                            <div class="d-inline-flex align-items-center">                                
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="text-dark fw-bold text-hover-primary mb-1 fs-6 lh-sm">${row.num_ident_seg_social}</span>
                                </div>
                            </div>
                        `
							},
						},
						{
							targets: 4,
							orderable: true,
							render: (data, type, row) => {
								return `
                            <div class="d-inline-flex align-items-center">                                
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="text-dark fw-bold text-hover-primary mb-1 fs-6 lh-sm">${row.num_ident_fiscal}</span>
                                </div>
                            </div>
                        `
							}
						},
						{
							targets: 5,
							orderable: true,
							render: (data, type, row) => {
								if (row.pais === "Portugal") {
									return `
                            <div class="d-inline-flex align-items-center">                                
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="badge badge-success px-2 py-2">${row.pais}</span>
                                </div>
                            </div>
                        `
								} else if (row.type === "Outro") {
									return `<div class="d-inline-flex align-items-center">                                
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="badge badge-warning px-2 py-2">${row.pais}</span>
                                </div>
                            </div>
                        `
								}
							}
						},
						{
							targets: 6,
							orderable: true,
							render: (data, type, row) => {
								var date = new Date(row.data_registo);
								var day = date.getDate();
								var month = date.getMonth() + 1;
								var year = date.getFullYear();
								var formattedDate = (day < 10 ? "0" + day : day) + "/" + (month < 10 ? "0" + month : month) + "/" + year + " - " + (date.getHours() < 10 ? "0" + date.getHours() : date.getHours()) + ":" + (date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes() + "h");
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
							targets: -1,
							orderable: false,
							className: "text-sm-end",
							render: (data, type, row) => {
								return `
                            <div>
                                <a href="ficha_utente?id=${row.hashed_id}" class="btn btn-icon btn-bg-light btn-color-primary btn-active-light-primary rounded w-35px h-35px me-1"><i class="ki-outline ki-information-2 fs-2"></i></a>
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

			return {
				init: () => {
					initDatatable()
					handleSyncDatatable()
					handleSearchDatatable()
				},
			}
		})()

		window.addEventListener("DOMContentLoaded", () => {
			datatableServerSide.init()
		})
	</script>

</body>

</html>
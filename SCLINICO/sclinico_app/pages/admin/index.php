<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>

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
								<div class="row">

									<div class="col-12 mb-xl-10">
										<!--begin::Lists Widget 19-->
										<div class="card card-flush h-xl-100">
											<!--begin::Heading-->
											<div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px" style="background-image:url('<?php echo $link_home ?>assets/media/svg/shapes/abstract-2.svg')" data-bs-theme="light">
												<!--begin::Title-->
												<h3 class="card-title align-items-start flex-column text-green pt-15">
													<span class="fw-bold fs-2x mb-3 text-green">Olá, Admin SCLINICO</span>
													<div class="fs-4 text-green">
														<span class="fs-5 text-muted">Unidade de Saúde: <span class="fw-bold text-green">Unidade de Saúde Familiar de Famalicão</span></span><br>
													</div>
												</h3>
												<!--end::Title-->
											</div>
											<!--end::Heading-->
											<!--begin::Body-->
											<div class="card-body mt-n20">
												<div class="position-relative" style="margin-top: -9rem!important;">
													<div class="row g-3 g-lg-6">
														<div class="col-8">
														</div>

														<div class="col-2">
															<a href="consultas/nova">
																<div class="bg-primary bg-opacity-10 rounded-2 px-6 py-5">
																	<div class="symbol symbol-30px me-5 mb-8">
																		<span class="symbol-label">
																			<i class="ki-outline bg-primary bg-opacity-5 ki-calendar-add fs-2hx text-primary"></i>
																		</span>
																	</div>
																	<div class="m-0">
																		<span class="text-gray-700 fw-bolder d-block fs-3 lh-1 mb-1">Nova Consulta
																		</span>
																	</div>
																</div>
															</a>
														</div>

														<div class="col-2">
															<a href="consultas/lista">
																<div class="bg-primary bg-opacity-10 rounded-2 px-6 py-5">
																	<div class="symbol symbol-30px me-5 mb-8">
																		<span class="symbol-label">
																			<i class="ki-outline bg-primary bg-opacity-5 ki-document fs-2hx text-primary"></i>
																		</span>
																	</div>
																	<div class="m-0">
																		<span class="text-gray-700 fw-bolder d-block fs-3 lh-1 mb-1">Consultas
																		</span>
																	</div>
																</div>
															</a>
														</div>

													</div>
													<!--end::Row-->
												</div>
												<!--end::Stats-->
											</div>
											<!--end::Body-->
										</div>
										<!--end::Lists Widget 19-->
									</div>

								</div>

								<div class="row">

									<div class="col-sm-6 col-xl-3 mb-xl-10">
										<div class="card h-lg-100">
											<div class="card-body d-flex justify-content-between align-items-start flex-column">
												<div class="m-0">
													<i class="ki-outline ki-capsule fs-2hx text-primary"></i>
												</div>
												<div class="d-flex flex-column my-7">
													<span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2"><?php echo $variavel1 = rand(150, 350); ?></span>
													<div class="m-0">
														<span class="fw-semibold fs-6 text-gray-400">Medicação Total Prescrita</span>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-sm-6 col-xl-3 mb-xl-10">
										<div class="card h-lg-100">
											<div class="card-body d-flex justify-content-between align-items-start flex-column">
												<div class="m-0">
													<i class="ki-outline ki-document fs-2hx text-primary"></i>
												</div>
												<div class="d-flex flex-column my-7">
													<span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2"><?php echo $variavel2 = rand(150, 300); ?></span>
													<div class="m-0">
														<span class="fw-semibold fs-6 text-gray-400">Exames Totais Prescritos</span>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-sm-6 col-xl-3 mb-xl-10">
										<div class="card h-lg-100">
											<div class="card-body d-flex justify-content-between align-items-start flex-column">
												<div class="m-0">
													<i class="ki-outline ki-syringe  fs-2hx text-primary"></i>
												</div>
												<div class="d-flex flex-column my-7">
													<span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2"><?php echo $variavel3 = rand(50, 140); ?></span>
													<div class="m-0">
														<span class="fw-semibold fs-6 text-gray-400">Vacinas Totais Administradas</span>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-sm-6 col-xl-3 mb-xl-10">
										<div class="card h-lg-100">
											<div class="card-body d-flex justify-content-between align-items-start flex-column">
												<div class="m-0">
													<i class="ki-outline ki-pill fs-2hx text-primary"></i>
												</div>
												<div class="d-flex flex-column my-7">
													<span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2"><?php echo $variavel4 = rand(150, 450); ?></span>
													<div class="m-0">
														<span class="fw-semibold fs-6 text-gray-400">Pedidos Medicação Totais</span>
													</div>
												</div>
											</div>
										</div>
									</div>

									<span class="text-end text-muted">* dados ilustrativos</span>
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
		// Select elements
		const target = document.getElementById('kt_clipboard_4');
		const button = target.nextElementSibling;

		// Init clipboard -- for more info, please read the offical documentation: https://clipboardjs.com/
		clipboard = new ClipboardJS(button, {
			target: target,
			text: function() {
				return target.innerHTML;
			}
		});

		// Success action handler
		clipboard.on('success', function(e) {
			var checkIcon = button.querySelector('.ki-check');
			var copyIcon = button.querySelector('.ki-copy');

			// Exit check icon when already showing
			if (checkIcon) {
				return;
			}

			// Create check icon
			checkIcon = document.createElement('i');
			checkIcon.classList.add('ki-duotone');
			checkIcon.classList.add('ki-check');
			checkIcon.classList.add('fs-2x');

			// Append check icon
			button.appendChild(checkIcon);

			// Highlight target
			const classes = ['text-success', 'fw-boldest'];
			target.classList.add(...classes);

			// Highlight button
			button.classList.add('btn-success');

			// Hide copy icon
			copyIcon.classList.add('d-none');

			// Revert button label after 3 seconds
			setTimeout(function() {
				// Remove check icon
				copyIcon.classList.remove('d-none');

				// Revert icon
				button.removeChild(checkIcon);

				// Remove target highlight
				target.classList.remove(...classes);

				// Remove button highlight
				button.classList.remove('btn-success');
			}, 3000)
		});
	</script>

</body>

</html>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/head.php") ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/api/api.php") ?>
<?php
$api = new Api();
if (isset($_GET["id"])) {
    $hashed_id = $_GET["id"];
} else {
    header("Location: pages/admin/pedidos/lista");
}
$patient_info = $api->fetch("patients/patient/info", null, $hashed_id);
$patient_info_data = $patient_info["response"]["0"]
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
                                <?php
                                if ($patient_info["status"] === false) {
                                    echo '<script>toastr.error("Erro ao obter Dados do Pedido!", "Erro!");;
                                    setTimeout(() => {
                                        window.location.href = "./lista";
                                      }, 650);
                                    </script>';
                                    exit;
                                } else if ($patient_info["status"] === true) {
                                    echo '<script>toastr.success("Dados do Pedido Obtidos com Sucesso!", "Sucesso!");</script>';
                                }
                                ?>

                                <div class="card mb-5 mb-xl-10">
                                    <div class="card-body pt-9 pb-0">
                                        <div class="d-flex flex-wrap flex-sm-nowrap">
                                            <div class="me-7 mb-4">
                                                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                                    <img src="<?php echo $default_avatar ?>" alt="image">
                                                </div>
                                            </div>

                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                                    <div class="d-flex flex-column">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <a class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?php echo $patient_info_data["nome"] ?></a>
                                                        </div>

                                                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                                <i class="ki-outline ki-sms fs-4 me-1"></i><?php echo isset($patient_info_data["email"]) ? $patient_info_data["email"] : "N/A" ?></a>
                                                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                                <i class="ki-outline ki-phone fs-4 me-1"></i><?php echo $patient_info_data["num_telemovel"] ?></a>
                                                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                                                <i class="ki-outline ki-information-2 fs-4 me-1"></i>
                                                                <?php echo (new DateTime($patient_info_data["data_criacao"]))->format("d/m/Y - H:i") . "h"; ?>
                                                        </div>
                                                        <span class="badge badge-info me-2">Em Análise</span>
                                                        <?php if ($patient_info_data["genero"] === 1) { ?>
                                                            <span class="badge badge-warning me-2">Masculino</span>
                                                        <?php } else if ($patient_info_data["genero"] === 2) { ?>
                                                            <span class="badge badge-warning me-2">Feminino</span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-warning me-2">Outro</span>
                                                        <?php } ?>

                                                        <?php if ($patient_info_data["taxa_moderadora"] === 1) { ?>
                                                            <span class="badge badge-success me-2">Com Isenção Taxa Moderadora</span>
                                                        <?php } else if ($patient_info_data["taxa_moderadora"] === 0) { ?>
                                                            <span class="badge badge-danger me-2">Sem Isenção Taxa Moderadora</span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-light-dark me-2">Sem Informação Taxa Moderadora</span>
                                                        <?php } ?>

                                                        <?php if ($patient_info_data["seguro_saude"] === 1) { ?>
                                                            <span class="badge badge-success me-2">Com Seguro de Saúde</span>
                                                        <?php } else if ($patient_info_data["seguro_saude"] === 0) { ?>
                                                            <span class="badge badge-danger me-2">Sem Seguro de Saúde</span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-light-dark me-2">Sem Informação Seguro de Saúde</span>
                                                        <?php } ?>

                                                    </div>

                                                    <div class="d-flex my-4">

                                                        <a class="btn btn-sm btn-success me-3" onclick="acceptRequest()">Aceitar Pedido</a>
                                                        <a class="btn btn-sm btn-danger me-3" onclick="rejectRequest()">Rejeitar Pedido</a>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                                            <li class="nav-item mt-2">
                                                <a class="nav-link text-active-primary ms-0 me-10 py-5 active">
                                                    Informação do Pedido</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                                    <div class="card-header cursor-pointer">
                                        <div class="card-title m-0">
                                            <h3 class="fw-bold m-0">Informação do Pedido</h3>
                                        </div>
                                    </div>

                                    <div class="card-body p-9">
                                        <div class="row">
                                            <div class="col-6">

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Nome Completo</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["nome"] ?></span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Género</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800">
                                                            <?php if ($patient_info_data["genero"] === 1) { ?>
                                                                Masculino
                                                            <?php } else if ($patient_info_data["genero"] === 2) { ?>
                                                                Feminino
                                                            <?php } else { ?>
                                                                Outro
                                                            <?php } ?>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Data de Nascimento</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo (new DateTime($patient_info_data["data_nascimento"]))->format("d/m/Y"); ?></span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Email</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo isset($patient_info_data["email"]) ? $patient_info_data["email"] : "N/A" ?></span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Número Telemóvel</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo isset($patient_info_data["num_telemovel"]) ? $patient_info_data["num_telemovel"] : "N/A" ?></span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Número Telefone</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo isset($patient_info_data["num_telefone"]) ? $patient_info_data["num_telefone"] : "N/A" ?></span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Número Documento</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["num_cc"] . " " . $patient_info_data["cod_validacao_cc"] ?></span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Data Validade do Documento</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo (new DateTime($patient_info_data["data_validade_cc"]))->format("d/m/Y"); ?></span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Número Identificação Fiscal</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["num_ident_fiscal"] ?></span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Número Segurança Social</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["num_ident_seg_social"] ?></span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Pai</label>
                                                    <div class="col-lg-7">
                                                        <a class="text-hover-primary" href="<?php echo isset($patient_info_data["pai"]["hashed_id"]) ? "ficha_pedido?id=" . $patient_info_data["pai"]["hashed_id"] : "javascript:void(0);" ?>"><span class="text-hover-primary fw-bold fs-6 text-gray-800"><i class="ki-outline ki-profile-user text-black fw-bold fs-4 me-1"></i><?php echo isset($patient_info_data["pai"]["nome"]) ? $patient_info_data["pai"]["nome"] : "N/A" ?></span></a>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Mãe</label>
                                                    <div class="col-lg-7">
                                                        <a class="text-hover-primary" href="<?php echo isset($patient_info_data["mae"]["hashed_id"]) ? "ficha_pedido?id=" . $patient_info_data["mae"]["hashed_id"] : "javascript:void(0);" ?>"><span class="text-hover-primary fw-bold fs-6 text-gray-800"><i class="ki-outline ki-profile-user text-black fw-bold fs-4 me-1"></i><?php echo isset($patient_info_data["mae"]["nome"]) ? $patient_info_data["mae"]["nome"] : "N/A" ?></span></a>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-6">

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Estado Civil</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800">
                                                            <?php if ($patient_info_data["estado_civil"] === 1) { ?>
                                                                Solteiro(a)
                                                            <?php } else if ($patient_info_data["estado_civil"] === 2) { ?>
                                                                Casado(a)
                                                            <?php } else if ($patient_info_data["estado_civil"] === 3) { ?>
                                                                União de Facto
                                                            <?php } else if ($patient_info_data["estado_civil"] === 4) { ?>
                                                                Divorciado(a)
                                                            <?php } else if ($patient_info_data["estado_civil"] === 5) { ?>
                                                                Viúvo(a)
                                                            <?php } ?>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Situação Profissional</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800">
                                                            <?php if ($patient_info_data["situacao_profissional"] === 1) { ?>
                                                                Estudante
                                                            <?php } else if ($patient_info_data["situacao_profissional"] === 2) { ?>
                                                                Desempregado(a)
                                                            <?php } else if ($patient_info_data["situacao_profissional"] === 3) { ?>
                                                                Empregado(a)
                                                            <?php } else if ($patient_info_data["situacao_profissional"] === 4) { ?>
                                                                Reformado(a)
                                                            <?php } else if ($patient_info_data["situacao_profissional"] === 5) { ?>
                                                                Outra
                                                            <?php } ?>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Profissão</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo isset($patient_info_data["profissao"]) ? $patient_info_data["profissao"] : "N/A" ?></span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Hablitações Escolares</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo isset($patient_info_data["hab_escolares"]) ? $patient_info_data["hab_escolares"] : "N/A" ?></span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">País</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["morada"]["pais"] ?></span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Distrito</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["morada"]["distrito"] ?></span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Concelho</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["morada"]["concelho"] ?></span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Freguesia</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["morada"]["freguesia"] ?></span>
                                                    </div>
                                                </div>


                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Morada</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800">
                                                            <?php echo $patient_info_data["morada"]["morada"] . ' ' . $patient_info_data["morada"]["numero_porta"] . ' ' . $patient_info_data["morada"]["andar"]
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Código-Postal</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo $patient_info_data["morada"]["cod_postal"] ?></span>
                                                    </div>
                                                </div>

                                                <div class="row mb-7">
                                                    <label class="col-lg-5 fw-semibold text-muted">Pedido submetido em:</label>
                                                    <div class="col-lg-7">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo (new DateTime($patient_info_data["data_criacao"]))->format("d/m/Y - H:i") . "h"; ?></span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <pre>
                                <!-- <?php print_r($patient_info_data) ?> -->
                                </pre>
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
        // Swalfire to accept the request and send a fetch for the api
        const api_url = "http://localhost:4000/api/";
        const path = "requests/";

        var acceptRequest = () => {
            Swal.fire({
                title: 'Aceitar Pedido do Utente',
                text: "Tem a certeza que pretende aceitar o pedido do Utente?",
                icon: 'success',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Sim, aceitar!',
                cancelButtonText: 'Não, cancelar!',
                reverseButtons: true,
                buttonsStyling: false,
                allowOutsideClick: false,
                didOpen: () => {
                    const confirmButton = Swal.getConfirmButton();
                    confirmButton.blur();
                },
                customClass: {
                    confirmButton: "btn fw-bold btn-success",
                    cancelButton: "btn fw-bold btn-active-light-warning",
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'A aceitar o pedido!',
                        text: 'Por favor aguarde...',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading()
                        },
                    });
                    fetch(api_url + path + "accept", {
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
                                    title: 'Pedido aceite com sucesso!',
                                    text: 'A redirecionar para a lista de pedidos...',
                                    icon: 'success',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    willOpen: () => {
                                        Swal.showLoading()
                                    },
                                });
                                setTimeout(() => {
                                    window.location = "<?php echo $link_home ?>pages/admin/pedidos/lista";
                                }, 1500);
                            } else {
                                Swal.fire({
                                    title: 'Erro ao aceitar o pedido!',
                                    text: data.message,
                                    icon: 'error',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    willOpen: () => {
                                        Swal.showLoading()
                                    },
                                });
                                setTimeout(() => {
                                    window.location = "<?php echo $link_home ?>pages/admin/pedidos/lista";
                                }, 1500);
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                title: 'Erro ao aceitar o pedido!',
                                text: 'Por favor tente novamente...',
                                icon: 'error',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                willOpen: () => {
                                    Swal.showLoading()
                                },
                            });
                            setTimeout(() => {
                                    window.location.href = "<?php echo $link_home ?>pages/admin/pedidos/lista";
                                },
                                1500);
                        });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    toastr.warning('Cancelou a operação que realizava!', 'Cancelado!');
                }
            })
        }

        var rejectRequest = () => {
            Swal.fire({
                title: 'Rejeitar Pedido do Utente',
                text: "Tem a certeza que pretende rejeitar o pedido do Utente?",
                icon: 'error',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Sim, rejeitar!',
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
                        title: 'A rejeitar o pedido!',
                        text: 'Por favor aguarde...',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading()
                        },
                    });
                    fetch(api_url + path + "reject", {
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
                                    title: 'Pedido rejeitado com sucesso!',
                                    text: 'A redirecionar para a lista de pedidos...',
                                    icon: 'success',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    willOpen: () => {
                                        Swal.showLoading()
                                    },
                                });
                                setTimeout(() => {
                                    window.location = "<?php echo $link_home ?>pages/admin/pedidos/lista";
                                }, 1500);
                            } else {
                                Swal.fire({
                                    title: 'Erro ao rejeitar o pedido!',
                                    text: data.message,
                                    icon: 'error',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    willOpen: () => {
                                        Swal.showLoading()
                                    },
                                });
                                setTimeout(() => {
                                    window.location = "<?php echo $link_home ?>pages/admin/pedidos/lista";
                                }, 1500);
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                title: 'Erro ao rejeitar o pedido!',
                                text: 'Por favor tente novamente...',
                                icon: 'error',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                willOpen: () => {
                                    Swal.showLoading()
                                },
                            });
                            setTimeout(() => {
                                    window.location.href = "<?php echo $link_home ?>pages/admin/pedidos/lista";
                                },
                                1500);
                        });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    toastr.warning('Cancelou a operação que realizava!', 'Cancelado!');
                }
            })
        }

    </script>

</body>

</html>
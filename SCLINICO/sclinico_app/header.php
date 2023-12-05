<!--begin::Header-->
<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: false, lg: true}" data-kt-sticky-name="app-header-sticky" data-kt-sticky-offset="{default: false, lg: '300px'}">
    <!--begin::Header container-->
    <div class="app-container container-xxl d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
        <!--begin::Header mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-color-gray-600 btn-active-color-primary w-35px h-35px" id="kt_app_header_menu_toggle">
                <i class="ki-outline ki-abstract-14 fs-2"></i>
            </div>
        </div>
        <!--end::Header mobile toggle-->

        <?php if ($_SESSION["active_role"] === "Admin") { ?>
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
            <a href="<?php echo $link_home ?>pages/admin/index" ?>
                <img alt="Logo" src="<?php echo $link_home ?>assets/media/uploads/sclinico/logo_sclinico.png" class="h-10px d-lg-none" />
                <img alt="Logo" src="<?php echo $link_home ?>assets/media/uploads/sclinico/logo_sclinico.png" class="h-30px d-none d-lg-inline app-sidebar-logo-default theme-light-show" />
            </a>
        </div>
        <?php } ?>

        <?php if ($_SESSION["active_role"] === "Office") { ?>
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
            <a href="<?php echo $link_home ?>pages/office/index" ?>
                <img alt="Logo" src="<?php echo $link_home ?>assets/media/uploads/sclinico/logo_sclinico.png" class="h-10px d-lg-none" />
                <img alt="Logo" src="<?php echo $link_home ?>assets/media/uploads/sclinico/logo_sclinico.png" class="h-30px d-none d-lg-inline app-sidebar-logo-default theme-light-show" />
            </a>
        </div>
        <?php } ?>


        <!--begin::Header wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">

            <?php if ($_SESSION["active_role"] === "Admin") { ?>
                <!--Admin NavBar-->
                <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">


                    <div class="menu menu-rounded menu-active-bg menu-state-primary menu-column menu-lg-row menu-title-gray-700 menu-icon-gray-500 menu-arrow-gray-500 menu-bullet-gray-500 my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">

                        <!-- Inicio -->
                        <div class="menu-item here show menu-here-bg me-0 me-lg-2">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <a href="<?php echo $link_home; ?>pages/admin/index"><span class="menu-title">Início</span></a>
                                <span class="menu-arrow d-lg-none"></span>
                            </span>
                            <!--end:Menu link-->
                        </div>

                        <!-- Nova Consulta -->
                        <div class="menu-item here show menu-here-bg me-0 me-lg-2">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <a href="<?php echo $link_home; ?>pages/admin/consultas/nova"><span class="menu-title">Nova Consulta</span></a>
                                <span class="menu-arrow d-lg-none"></span>
                            </span>
                            <!--end:Menu link-->
                        </div>

                        <!-- Consulta -->
                        <div class="menu-item here show menu-here-bg me-0 me-lg-2">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <a href="<?php echo $link_home; ?>pages/admin/consultas/lista"><span class="menu-title">Consulta</span></a>
                                <span class="menu-arrow d-lg-none"></span>
                            </span>
                            <!--end:Menu link-->
                        </div>

                    </div>

                </div>
                <!--Admin NavBar-->
            <?php } ?>

            <?php if ($_SESSION["active_role"] === "Office") { ?>
                <!-- Doctor NavBar -->
                <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                    <div class="menu menu-rounded menu-active-bg menu-state-primary menu-column menu-lg-row menu-title-gray-700 menu-icon-gray-500 menu-arrow-gray-500 menu-bullet-gray-500 my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">

                        <!-- Inicio -->
                        <div class="menu-item here show menu-here-bg me-0 me-lg-2">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <a href="<?php echo $link_home; ?>pages/office/index"><span class="menu-title">Início</span></a>
                                <span class="menu-arrow d-lg-none"></span>
                            </span>
                            <!--end:Menu link-->
                        </div>

                        <!-- Pedidos -->
                        <div class="menu-item here show menu-here-bg me-0 me-lg-2">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <a href="<?php echo $link_home; ?>pages/office/consultas/lista"><span class="menu-title">Consultas</span></a>
                                <span class="menu-arrow d-lg-none"></span>
                            </span>
                            <!--end:Menu link-->
                        </div>

                    </div>

                </div>

            <?php } ?>

            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">
                <!--begin::Search-->
                <div class="d-flex align-items-center align-items-stretch mx-4">

                </div>
                <!--end::Search-->

                <!--begin::Chat-->
                <div class="app-navbar-item ms-1 ms-lg-5">

                </div>
                <!--end::Chat-->
                <!--begin::User menu-->
                <div class="app-navbar-item ms-3 ms-lg-5" id="kt_header_user_menu_toggle">
                    <!--begin::Menu wrapper-->
                    <div class="cursor-pointer symbol symbol-35px symbol-md-45px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <img class="symbol symbol-circle symbol-35px symbol-md-45px" src="<?php echo $_SESSION["avatar_path"] ?>" alt="user" />
                    </div>
                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-300px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5">
                                    <img alt="Logo" src="<?php echo $_SESSION["avatar_path"] ?>" />
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center">
                                        <?php if ($_SESSION["active_role"] == "Admin") {
                                            echo '<span class="badge badge-light-success fw-bold fs-8 px-2 py-1 mb-1">Administrador</span>';
                                        } else if ($_SESSION["active_role"] == "Office") {
                                            echo '<span class="badge badge-light-info fw-bold fs-8 px-2 py-1 mb-1">Médico</span>';
                                        }
                                        ?>
                                    </div>
                                    <div class="fw-bold d-flex align-items-center fs-5"><?php echo $_SESSION["name"]; ?></div>
                                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7"><?php echo $_SESSION["email"]; ?></a>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->

                        <?php if (count($_SESSION['roles']) > 1) { ?>
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="<?php echo $link_home ?>" class="menu-link px-5">Trocar de Conta</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu separator-->
                            <div class="separator my-2"></div>
                            <!--end::Menu separator-->
                        <?php } ?>


                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="<?php echo $link_home ?>pages/auth/logout" class="menu-link px-5">Terminar Sessão</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::User account menu-->
                    <!--end::Menu wrapper-->
                </div>
                <!--end::User menu-->
                <!--begin::Header menu toggle-->
                <!--end::Header menu toggle-->
            </div>
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
</div>
<!--end::Header-->
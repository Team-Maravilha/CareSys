<?php
$patient_marriages = $patient_info_data = $patient_info["response"]["0"]["conjuge"];
?>
<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Histórico de Cônjuges</h3>
        </div>
    </div>

    <div>
        <a href="add" class="btn btn-light-primary d-flex align-items-center lh-1 float-end mt-2 me-2">
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
                            <th class="text-end pe-3 min-w-100px sorting_disabled" rowspan="1" colspan="1" aria-label="Product ID" style="width: 124.562px;">Nº Utente</th>
                            <th class="text-end pe-3 min-w-150px sorting_disabled" tabindex="0" aria-controls="kt_table_widget_5_table" rowspan="1" colspan="1">Nº CC</th>
                            <th class="text-end pe-3 min-w-100px sorting" tabindex="0" aria-controls="kt_table_widget_5_table" rowspan="1" colspan="1">Data Casamento</th>
                            <th class="text-end pe-3 min-w-100px sorting" tabindex="0" aria-controls="kt_table_widget_5_table" rowspan="1" colspan="1">Data Divorcio</th>
                            <th class="text-end pe-0 min-w-75px sorting_disabled" tabindex="0" aria-controls="kt_table_widget_5_table" rowspan="1" colspan="1">Estado</th>
                            <th class="text-end pe-0 min-w-50px" tabindex="0" aria-controls="kt_table_widget_5_table" rowspan="1" colspan="1">Ações</th>
                        </tr>
                    </thead>

                    <tbody class="fw-bold text-gray-600">

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
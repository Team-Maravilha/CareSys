<div class="modal fade" id="modal-edit-good" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="modal-edit-good-header">
                <h2 class="fw-bold">Editar Família de Matérias Primas</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-modal-action="cancel">
                    <i class="las la-times fs-1"></i>
                </div>
            </div>

            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="modal-edit-good-form" class="form" action="#">
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="modal-edit-good-form-scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#modal-edit-good-header" data-kt-scroll-wrappers="#modal-edit-good-form-scroll" data-kt-scroll-offset="350px" style="max-height: 91px;">
                        <div class="row g-6">

                            <div class="col-12">
                                <div class="fv-row">
                                    <label for="modal-edit-good-form-name" class="required fw-semibold fs-6 mb-2">Nome da Família de Matérias Primas</label>
                                    <input type="text" name="name" id="modal-edit-good-form-name" class="form-control form-control-solid mb-3 mb-lg-0" value="" placeholder="Nome (Ex: Aluminios)">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="fv-row">
                                    <label for="modal-edit-good-form-status" class="required fw-semibold fs-6 mb-2">Estado</label>
                                    <select name="status" id="modal-edit-good-form-status" class="form-select form-select-solid mb-3 mb-lg-0">
                                        <option value="1">Ativo</option>
                                        <option value="0">Inativo</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-modal-action="cancel">Cancelar</button>
                        <button type="button" class="btn btn-light-primary" data-modal-action="submit">
                            <span class="indicator-label">Editar</span>
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
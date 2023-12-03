<div class="modal fade" id="modal-add-emergency-contact" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="modal-add-emergency-contact-header">
                <h2 class="fw-bold">Adicionar Contacto de Emergência</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-modal-action="cancel">
                    <i class="las la-times fs-1"></i>
                </div>
            </div>

            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="modal-add-emergency-contact-form" class="form" action="#">
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="modal-add-emergency-contact-form-scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#modal-add-emergency-contact-header" data-kt-scroll-wrappers="#modal-add-emergency-contact-form-scroll" data-kt-scroll-offset="350px" style="max-height: 91px;">
                        <div class="row g-6">
                            
                            <div class="col-12">
                                <div class="fv-row">
                                    <label for="modal-add-emergency-contact-form-nome" class="required fw-semibold fs-6 mb-2">Nome do contacto de emergência</label>
                                    <input type="text" name="nome" id="modal-add-emergency-contact-form-nome" class="form-control form-control-solid mb-3 mb-lg-0" value="" placeholder="Nome Completo">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="fv-row">
                                    <label for="modal-add-emergency-contact-form-contacto" class="required fw-semibold fs-6 mb-2">Número de contacto</label>
                                    <input type="number" name="contacto" id="modal-add-emergency-contact-form-contacto" class="form-control form-control-solid mb-3 mb-lg-0" value="" placeholder="123456789">
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
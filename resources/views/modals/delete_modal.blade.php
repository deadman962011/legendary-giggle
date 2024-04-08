<!-- delete Modal -->
<div id="delete-modal" class="modal fade">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <p class="mt-1 fs-14">{{ __('Are you sure to delete this?') }}</p>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-styled btn-base-3" data-dismiss="modal" data-bs-dismiss="modal" id="close-button">{{ __('Cancel') }}</button>
                <button type="submit" href="" id="deleteModalBtn" class="btn btn-danger">{{ __('Delete') }}</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

<div class="modal fade editFileName" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rename File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= route('rename') ?>" method="post" id="update-file-name-form">
                    @csrf
                    <input type="hidden" name="fileId">
                    <div class="form-group">
                        <input required type="text" class="form-control" name="fileName" placeholder="Enter file name">
                        <span class="text-danger error-text file_name_error"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-success">Save Changes</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>

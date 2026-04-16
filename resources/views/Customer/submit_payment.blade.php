<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Submit Payment</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="form-group">
        <label for="exampleInputFile">Payment Receipt</label>
        <div class="input-group col-4">
            <div class="custom-file">
                <input type="file" class="custom-file-input" accept="image/*" name="image" id="image" onchange="previewImage(event)">
                <label class="custom-file-label" for="image" id="imageLabel">Choose file</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <img id="imagePreview" src="" alt="Image Preview" style="max-width: 200px;">
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="saveAddressChanges">Save changes</button>
</div>
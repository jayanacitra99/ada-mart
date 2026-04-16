<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Create Address</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="addressForm">
        <div class="form-group">
            <label for="recipientName">Recipient Name</label>
            <input type="text" class="form-control" id="recipientName" placeholder="Enter recipient name">
        </div>
        <div class="form-group">
            <label for="phoneNumber">Phone Number</label>
            <input type="text" class="form-control" id="phoneNumber" placeholder="Enter phone number">
        </div>
        <div class="form-group">
            <label for="fullAddress">Full Address</label>
            <input type="text" class="form-control" id="fullAddress" placeholder="Enter full address">
        </div>
        <div class="row">
            <div class="form-group col-6">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" placeholder="Enter city">
            </div>
            <div class="form-group col-6">
                <label for="postalCode">Postal Code</label>
                <input type="text" class="form-control" id="postalCode" placeholder="Enter postal code">
            </div>
        </div>
        <div class="form-group">
            <label for="additionalInfo">Additional Info</label>
            <input type="text" class="form-control" id="additionalInfo" placeholder="Enter additional info">
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="setDefault">
            <label class="form-check-label" for="setDefault">Set as Default</label>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="addNewAddress">Save changes</button>
</div>

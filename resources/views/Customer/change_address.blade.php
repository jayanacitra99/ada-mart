<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Select Address</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="addressForm">
        @foreach($addresses as $address)
            <div class="form-check">
                <input class="form-check-input" type="radio" name="address" id="address{{$address->id}}" value="{{$address->id}}" {{$address_id == $address->id ? 'checked':''}}>
                <label class="form-check-label" for="address{{$address->id}}">
                    {{$address->recipient_name}} - {{$address->combined_address}}
                </label>
            </div>
        @endforeach
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="saveAddressChanges">Save changes</button>
</div>
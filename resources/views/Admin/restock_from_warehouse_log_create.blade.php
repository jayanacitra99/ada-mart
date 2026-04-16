<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Unpack Product - {{$product->name}}</h3>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- form start -->
                <form method="post" action="{{url('admin/restock-from-warehouse-logs')}}">
                    @csrf
                    <div class="table-responsive">
                        <table class="table no-border" id="form_add_unit">
                            <thead>
                                <tr>
                                    <th>Open Product</th>
                                    <th>Amount</th>
                                    <th>Convert To</th>
                                    <th>Received Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="col-3">
                                        <select class="custom-select" name="opened_product" id="opened_product" onchange="disableSelectedOption('opened_product', this.value)">
                                            <option value="">-- Choose Unit --</option>
                                            @foreach ($unit_types as $unit_type)
                                                <option value="{{$unit_type->id}}">{{$unit_type->unit_type.' | '.$unit_type->quantity}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="col-3">
                                        <input type="number" min="1" class="form-control" id="opened" name="opened" value="{{old('opened')}}">
                                    </td>
                                    <td class="col-3">
                                        <select class="custom-select" name="converted_product" id="converted_product" onchange="disableSelectedOption('converted_product', this.value)">
                                            <option value="">-- Choose Unit --</option>
                                            @foreach ($unit_types as $unit_type)
                                                <option value="{{$unit_type->id}}">{{$unit_type->unit_type.' | '.$unit_type->quantity}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="col-3">
                                        <input type="number" min="1" class="form-control" id="received" name="received" value="{{old('received')}}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    {{-- <button type="button" class="btn btn-primary" onclick="submitForm()">Submit</button> --}}
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
<!-- /.col -->
</div>
<!-- /.row -->
<script>
    function disableSelectedOption(dropdownId, selectedValue) {
        var otherDropdownId = dropdownId === 'opened_product' ? 'converted_product' : 'opened_product';
        var otherDropdown = document.getElementById(otherDropdownId);

        // Enable all options first
        for (var i = 0; i < otherDropdown.options.length; i++) {
            otherDropdown.options[i].disabled = false;
        }

        // Disable the selected option
        if (selectedValue) {
            for (var i = 0; i < otherDropdown.options.length; i++) {
                if (otherDropdown.options[i].value == selectedValue) {
                    otherDropdown.options[i].disabled = true;
                    break;
                }
            }
        }
    }
</script>
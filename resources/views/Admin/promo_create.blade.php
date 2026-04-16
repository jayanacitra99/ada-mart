@extends('Admin.layout')
@section('title')
    Create Promo
@endsection
@section('styles')
<!-- daterange picker -->
<link rel="stylesheet" href="{{asset('')}}adminlte/plugins/daterangepicker/daterangepicker.css">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add New Promo</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('admin/promos')}}">All Promos</a></li>
                  <li class="breadcrumb-item active">Add New Promos</li>
                </ol>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Add Promo</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- form start -->
                    <form method="post" action="{{url('admin/promos/')}}">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col">
                                    <label for="name">Promo Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
                                </div>
                                <div class="form-group col">
                                    <label for="promo_code">Promo Code</label>
                                    <input type="text" class="form-control" id="promo_code" name="promo_code" maxLength="8" value="{{old('promo_code')}}">
                                </div>
                                <div class="form-group col">
                                    <label>Date and time range:</label>
                  
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                      </div>
                                      <input type="text" class="form-control float-right" name="valid_date" id="valid_date">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>Type</label>
                                    <select class="custom-select" name="type" id="type" onchange="checkType()">
                                      <option value="voucher"  {{old('type') == 'voucher'? 'selected':''}}>Voucher</option>
                                      <option value="discount" {{old('type') == 'discount'? 'selected':''}}>Discount</option>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <div>
                                        <label for="amount">{{ old('type') == 'discount' ? 'Percentage (%)' : 'Amount' }}</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend" id="amount_symbol_voucher">
                                              <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input type="number" class="form-control" min="1" id="amount" name="amount" value="{{old('amount')}}">
                                            <div class="input-group-append" id="amount_symbol_discount">
                                                <span class="input-group-text"> % </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col">
                                    <div id="max_amount_field">
                                        <label for="max_amount">Max Amount</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input type="number" class="form-control" min="1" id="max_amount" name="max_amount" value="{{old('max_amount')}}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
    
@endsection
@section('end_scripts')
<!-- date-range-picker -->
<script src="{{asset('')}}adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<script>
    $(document).ready(function(){
        $('#valid_date').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            locale: {
            format: 'MM/DD/YYYY hh:mm'
            }
        })
    })
    function checkType(){
        var typeSelect = document.getElementById('type');
        var maxAmountField = document.getElementById('max_amount_field');
        var amountInput = document.getElementById('amount');
        var amountSymbolVoucher = document.getElementById('amount_symbol_voucher');
        var amountSymbolDiscount = document.getElementById('amount_symbol_discount');
        var amountLabel = document.querySelector('[for="amount"]');
        var maxAmountInput = document.getElementById('max_amount');
        
        if (typeSelect.value === 'voucher') {
            maxAmountField.style.display = 'none';
            amountSymbolDiscount.style.display = 'none';
            amountSymbolVoucher.style.display = 'block';
            amountInput.removeAttribute('max');
            amountInput.setAttribute('placeholder', 'Amount');
            amountLabel.textContent = 'Amount';
            maxAmountInput.setAttribute('disabled', 'disabled');
        } else {
            maxAmountField.style.display = 'block';
            amountSymbolDiscount.style.display = 'block';
            amountSymbolVoucher.style.display = 'none';
            amountInput.setAttribute('max', '100');
            amountInput.setAttribute('placeholder', 'Percentage (%)');
            amountLabel.textContent = 'Percentage (%)';
            maxAmountInput.removeAttribute('disabled');
        }
    }
    checkType();
</script>
@endsection
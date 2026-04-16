<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shipping Receipt - Order ID: {{$shipping->order_id}}</title>
    <style>
        /* CSS for the main container */
        .container {
            margin: 0 auto;
            font-family: Arial, sans-serif;
            max-width: 600px; /* Maximum width for better readability on larger screens */
        }
        /* CSS for the header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        /* CSS for the logo */
        .logo {
            height: 60px;
            width: 60px;
            flex-shrink: 0; /* Prevent logo from shrinking */
        }
        /* CSS for the title container */
        .title-container {
            text-align: center;
            flex-grow: 1; /* Expand to fill available space */
            margin-left: 20px; /* Add space between logo and title */
        }
        /* CSS for the title */
        .title {
            margin: 0; /* Reset margin */
        }
        /* CSS for the customer and shipping info container */
        .info-container {
            display: flex;
            justify-content: space-between; /* Space items evenly */
            margin-bottom: 20px;
        }
        /* CSS for customer info */
        .customer-info {
            flex-grow: 1; /* Expand to fill available space */
        }
        /* CSS for shipping info */
        .shipping-info {
            flex-grow: 1; /* Expand to fill available space */
            margin-left: 20px; /* Add space between customer and shipping info */
        }
        /* CSS for the table */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        /* CSS for table headers */
        .invoice-table th {
            background-color: #f2f2f2;
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        /* CSS for table data */
        .invoice-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        /* CSS for the total row */
        .total-row {
            font-weight: bold;
        }
        /* CSS for the checkbox */
        .checkbox-label {
            display: inline-block;
            margin-right: 10px;
        }

        /* CSS for the table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        /* CSS for table data */
        .info-table td {
            padding: 8px;
            text-align: left;
            width: 25%; /* Each column takes 25% of the table width */
        }
        /* Additional CSS for table headers */
        .info-table th {
            padding: 8px;
            text-align: left;
            width: 25%; /* Each column takes 25% of the table width */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                {{-- <img src="{{asset('adamart-logo.png')}}" alt="AdaMart Logo" class="logo"> --}}
            </div>
            <div class="title-container">
                <h2 class="title">Shipping Receipt</h2>
                <p>Order ID: {{$shipping->order_id}}</p>
            </div>
        </div>
        <div class="info-container">
            <table class="info-table">
                <tr>
                    <td><strong>Name:</strong></td>
                    <td>{{$customer?->recipient_name ?? '-'}}</td>
                    <td><strong>Shipping Number:</strong></td>
                    <td>{{$shipping->shipping_number}}</td>
                </tr>
                <tr>
                    <td><strong>Phone:</strong></td>
                    <td>{{$customer?->recipient_phone_number ?? '-'}}</td>
                    <td><strong>Type:</strong></td>
                    <td>
                        <label class="checkbox-label">
                            <input type="checkbox" disabled {{ $shipping->type === 'pick-up' ? 'checked' : '' }}> Pick-Up
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" disabled {{ $shipping->type === 'delivery' ? 'checked' : '' }}> Delivery
                        </label>
                    </td>
                </tr>
                <tr>
                    <td><strong>Destination:</strong></td>
                    <td>{{$customer?->combined_address ?? '-'}}</td>
                    <td><strong>From :</strong></td>
                    <td>AdaMart</td>
                </tr>
            </table>
        </div>        
        
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Unit Type</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderDetails as $item)
                    <tr>
                        <td>{{$item->productDetail->product->name}}</td>
                        <td>{{$item->productDetail->unit_type}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>Rp. {{$item->subtotal}}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3">Total:</td>
                    <td>Rp. {{$order->total}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .email-container {
            width: 100%;
            background-color: #ffffff;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding-bottom: 30px;
        }

        .header img {
            max-width: 150px;
        }

        .greeting {
            font-size: 18px;
            color: #333333;
            margin-bottom: 10px;
        }

        .order-details {
            background-color: #f8f8f8;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .order-details h3 {
            margin-top: 0;
            color: #333333;
        }

        .order-details ul {
            list-style-type: none;
            padding-left: 0;
            margin: 0;
        }

        .order-details ul li {
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .order-details ul li:last-child {
            border-bottom: none;
        }

        .total {
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
        }

        .table-container {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table-container th,
        .table-container td {
            border: 1px solid #e0e0e0;
            padding: 12px 15px;
            text-align: left;
        }

        .table-container th {
            background-color: #f8f8f8;
            color: #333333;
        }

        .footer {
            background-color: #333333;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
        }

        .footer a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="email-container">
        <div class="header">
            <h2>Order Confirmation - Invoice</h2>
        </div>

        <div class="greeting">
            <p>Dear {{ $order->user->first_name }},</p>
            <p>Thank you for shopping with us! We are pleased to confirm that your order has been successfully placed.</p>
        </div>

        <div class="order-details">
            <h3>Order Details</h3>
            <ul>
                <li><strong>Order Number:</strong> {{ $order->order_number }}</li>
                <li><strong>Total Amount:</strong> {{ number_format($order->total_amount, 2) }}</li>
                <li><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</li>
                <li><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</li>
            </ul>

            <h3>Order Items</h3>
            <table class="table-container">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price (Each)</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->title }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 2) }}</td>
                        <td>{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="total">
            <p><strong>Total Payment:</strong> ${{ number_format($order->total_amount, 2) }}</p>
        </div>

        <div class="footer">
            <p>We will notify you once your order is shipped. If you have any questions, feel free to contact us at <a href="mailto:support@yourwebsite.com">support@unkouneko.com</a>.</p>
            <p>&copy; {{ date('Y') }} Unko Uneko. All rights reserved.</p>
        </div>
    </div>

</body>

</html>
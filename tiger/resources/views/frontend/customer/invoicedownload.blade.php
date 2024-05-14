
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<!-- Favicon -->
		<link rel="icon" href="./images/favicon.png" type="image/x-icon" />

		<!-- Invoice styling -->
		<style>
			body {
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				text-align: center;
				color: #777;
			}

			body h1 {
				font-weight: 300;
				margin-bottom: 0px;
				padding-bottom: 0px;
				color: #000;
			}

			body h3 {
				font-weight: 300;
				margin-top: 10px;
				margin-bottom: 20px;
				font-style: italic;
				color: #555;
			}

			body a {
				color: #06f;
			}

			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
				border-collapse: collapse;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table>
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title">
									<img src="https://i.postimg.cc/Ssv87dv9/tiger.jpg" />
								</td>

								<td>
									The Mart Ltd<br />
									Mohammadpur, kaderabadhaujing, road 5,<br />
									01409246962,
                                    shakilrafi1030@gmail.com
								</td>
							</tr>
						</table>
					</td>
				</tr>
                 @php
                     $bill = App\Models\Billing::where('order_id', $order_id)->first();
                     $ship = App\Models\Shipping::where('order_id', $order_id)->first();
                     $order = App\Models\Order::where('order_id', $order_id)->first();
                     $orderproducts = App\Models\Orderproduct::where('order_id', $order_id)->get();
                 @endphp
				<tr class="information">
					<td colspan="2">

                <div class="main" style="display: flex; justify-content:space-between;">
                    <div class="div">
                        Bill To:{{$bill->fname}} <br />
                        {{$bill->address}}<br />
                        {{$bill->email}}<br />
                        {{$bill->rel_to_country->name}}, {{$bill->rel_to_city->name}} {{$bill->zip}}
                    </div>
                    <br>
                    <div class="div">
                        Ship To:{{$ship->ship_fname}} <br />
                        {{$ship->ship_address}}<br />
                        {{$ship->ship_email}}<br />
                        {{$ship->rel_to_country->name}}, {{$ship->rel_to_city->name}} {{$ship->ship_zip}}
                    </div>
                    <br>
                <div>
                    <h5>INVOICE: {{$order_id}}<br /></h5>
                <h5>Date of Invoice: {{$bill->created_at->format('d-m-Y')}}<br /></h5>
                </div>
                </div>

				<tr class="heading">
					<td>Payment Method</td>
					<td>{{$order->payment_method}}</td>
				</tr>

				<tr class="heading">
					<td>Item</td>
					<td>Price</td>
				</tr>

				@foreach($orderproducts as $orderproduct)
                    <tr class="item">
                        <td>{{$orderproduct->rel_to_product->product_name}}</td>
                        <td>{{$orderproduct->price.' '.'x'.' '.'quan'.' '.$orderproduct->quantity}}</td>
                    </tr>
                    @endforeach
                    <tr class="item last">
                        <td>Sub Total</td>
                        <td>{{$order->sub_total}}</td>
                    </tr>

				<tr class="item last">
					<td>Discount</td>
					<td>{{$order->discount}}</td>
				</tr>

				<tr class="item last">
					<td>Charge</td>
					<td>{{$order->charge}}</td>
				</tr>

				<tr class="total">
                    <td>Total</td>
					<td>Total: {{$order->total}}</td>
				</tr>
			</table>
		</div>
	</body>
</html>


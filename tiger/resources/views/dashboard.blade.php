@extends('layouts.admin')

@section('content')
<h2>WellCome To Dashboard, <strong class="text-success">{{Auth::user()->name}}</strong></h2>

<div class="row mt-5">
<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <h3>Total Order</h3>
        </div>
        <div class="card-body">
            <div>
                <canvas id="myChart"></canvas>
              </div>
        </div>
    </div>
</div>
<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <h3>Total Sales Amount</h3>
        </div>
        <div class="card-body">
            <div>
                <canvas id="myChart2"></canvas>
              </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('footer_script')
<script>
    const ctx = document.getElementById('myChart');

    var order_date = {{Js::from($total_date_info)}}
    var total_order = {{Js::from($total_order_info)}}

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: order_date,
        datasets: [{
          label: 'total order',
          data: total_order,
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

// sales
    const ctx2 = document.getElementById('myChart2');

    var total_sale = {{Js::from($total_sale_info)}}
    var sale_date = {{Js::from($sale_date_info)}}

    new Chart(ctx2, {
      type: 'pie',
      data: {
        labels: sale_date,
        datasets: [{
          label: 'total sale',
          data: total_sale,
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Food Cart</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table table-hover">
                    <thead class="thead">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Food Name</th>
                        <th scope="col">Price (Php)</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Amount</th>
                      </tr>
                    </thead>
                      <tbody>
                        @php $c = 0; $alltotal=0; $orderid = 0;@endphp
                        @if(count($foods) > 0)
                          @foreach($foods as $food)
                            <tr id="tr{{$food->menuitemsid}}">
                              @php $c++; $orderid = $food->orderid; @endphp
                              <td>{{$c}}</td>
                              <td>{{$food->foodname}}</td>
                              <td>{{$food->amount}}</td>
                              <td>{{$food->quantity}}</td>
                              <td>{{number_format(($food->quantity * $food->amount),2)}}</td>
                              @php $alltotal= $alltotal + ($food->quantity * $food->amount); @endphp
                          @endforeach
                        @else
                        <tr>
                          <td colspan="5">NO ITEMS ON THE CART</td>
                        </tr>
                        @endif
                      </tbody>
                    </table>
                    @foreach($orders as $order)
                    <table class="table">
                      <tbody>
                        <tr>
                          <td width="80%">Subtotal (Php)</td>
                          <td width="20%">{{number_format($order->subtotal,2)}}</td>
                        </tr>
                        <tr>
                          <td width="80%">Discount
                          </td>
                          <td width="20%" id="tddisc">{{number_format($order->discount,2)}}</td>

                        </tr>
                        <tr>
                          <td width="80%">Tax VAT 12% (Php)</td>
                          <td width="20%" id="taxdue">{{number_format(($order->total *0.12), 2)}}</td>
                        </tr>
                        <tr>
                          <td width="80%">Total Due (Php)
                          <td width="20%" id="tddue">{{number_format($order->total,2)}}</td>
                        </tr>
                      </tbody>
                    </table>
                    @endforeach
                </div>
            </div>
        </div>
        <hr>
    </div>
</div>
@endsection
<script type="text/javascript">

</script>

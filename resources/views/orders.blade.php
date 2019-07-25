@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Manage Orders</div>
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
                        <th scope="col">Order Date</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Tax</th>
                        <th scope="col">Total Due</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                      <tbody>
                        @if($orders)
                          @foreach($orders as $order)
                            <tr>
                              <td>{{$order->id}}</td>
                              <td>{{$order->created_at}}</td>
                              <td>{{$order->subtotal}}</td>
                              <td>{{$order->discount}}</td>
                              <td>{{number_format(($order->total * 0.12), 2)}}</td>
                              <td>{{$order->total}}</td>
                              <td> <a href="{{url('order')}}/{{$order->id}}">View</a> </td>
                            </tr>

                          @endforeach
                        @endif

                      </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
<script type="text/javascript">

</script>

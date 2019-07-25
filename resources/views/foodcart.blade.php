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
                              <td> <button type="button" name="delbutton" class="btn btn-danger" onclick="delItem('{{$orderid}}','{{$food->menuitemsid}}')">X</i></button> </td>
                            </tr>
                          @endforeach
                        @else
                        <tr>
                          <td colspan="5">NO ITEMS ON THE CART</td>
                        </tr>
                        @endif
                      </tbody>
                    </table>
                    <form class="" action="{{url('saveorder')}}" method="post">
                      {{ csrf_field() }}
                      <input type="text" name="txtorderid" id="txtorderid" value="{{$orderid}}" hidden>
                    <table class="table">
                      <tbody>
                        <tr>
                          <td width="80%">Subtotal (Php) <input type="text" name="txtstotal" id="txtstotal" value="{{$alltotal}}" hidden></td>
                          <td width="20%">{{number_format($alltotal,2)}}</td>
                        </tr>
                        <tr>
                          <td width="80%">Discount
                            <input type="text" name="txtdiscval" id="txtdiscval" value="0.00" hidden>
                            <input type="text" name="couponcode" id="couponcode" placeholder="coupon code">
                            <button type="button" name="button" onclick="getCoupon('{{$alltotal}}')"> Enter </button>
                            <p class="text-info" id="codemsgok" style="display:none"> Valid Code </p>
                            <p class="text-danger" id="codemsgerror" style="display:none"> Invalid Coupon </p>
                          </td>
                          <td width="20%" id="tddisc">0.00</td>

                        </tr>
                        <tr>
                          <td width="80%">Tax VAT 12% (Php)</td>
                          <td width="20%" id="taxdue">{{$alltotal * 0.12}}</td>
                        </tr>
                        <tr>
                          <td width="80%">Total Due (Php)
                            <input type="text" name="txttotal" id="txttotal" value="{{$alltotal}}" hidden></td>
                          <td width="20%" id="tddue">{{$alltotal}}</td>
                        </tr>
                      </tbody>
                    </table>
                    <button type="submit" name="button">Check Out</button>

                  </form>
                </div>
            </div>
        </div>
        <hr>
    </div>
</div>
@endsection
<script type="text/javascript">
  function delItem(oid, mid)
  {
    var r = confirm("Are you sure that you want to delete?");
    if (r == true) {
      //txt = "You pressed OK!";
      $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
            type: 'POST',
            url: '/order/delItem',
            data: {
                '_token': $('input[name=_token]').val(),
                'menuid':mid,
                'orderid':oid
            },
            success: function(data){
                // console.log(data);
                //alert("Item has been deleted to your cart.");
                $("tr#tr"+mid).remove();
                setTimeout("location.reload(true);",1000);
            },
            error:function(data)
            {
               //console.log(data);
               alert(data);
            }
        });
      }
  }
  function getCoupon(stotal)
  {
    code = document.getElementById('couponcode').value;
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
          type: 'POST',
          url: '/coupon/get',
          data: {
              '_token': $('input[name=_token]').val(),
              'code':code,
          },
          success: function(data){
              console.log(data);
              var disc = 0;
              if(data.length > 0){

                for (var i = 0; i < data.length; i++) {
                      disc=data[i].discount;
                }
                alert("Coupon Discount "+disc+"%");
                //document.getElementById('discval').value = disc.toString();
                document.getElementById('txtdiscval').value = (stotal * (disc/100)).toFixed(2).toString();
                document.getElementById('txttotal').value = (stotal - (stotal * (disc/100))).toFixed(2).toString();
                // document.getElementById('tddisc').firstChild.data = (stotal * (disc/100)).toString();
                // var tddisc = document.getElementById('tddisc');
                // var text = document.createTextNode((stotal * (disc/100)).toString());
                // tddisc.textContent(text);
                tddisc.textContent  = (stotal * (disc/100)).toFixed(2).toString();
                //
                // var tddue = document.getElementById('tddue');
                // var text2 = document.createTextNode(stotal - (stotal * (disc/100)).toString());
                // tddue.textContent(text2);
                tddue.textContent = (stotal - (stotal * (disc/100))).toFixed(2).toString();
                //
                // var taxdue = document.getElementById('taxdue');
                // var text3 = document.createTextNode(((stotal - (stotal * (disc/100)))*0.12).toString());
                taxdue.textContent = ((stotal - (stotal * (disc/100))) * 0.12).toFixed(2).toString();
              }else{
                //document.getElementById('discval').value = disc.toString();
                document.getElementById('txtdiscval').value = (stotal * (disc/100)).toFixed(2).toString();
                document.getElementById('txttotal').value = (stotal - (stotal * (disc/100))).toFixed(2).toString();
                // document.getElementById('tddisc').firstChild.data = (stotal * (disc/100)).toString();
                // var tddisc = document.getElementById('tddisc');
                // var text = document.createTextNode((stotal * (disc/100)).toString());
                // tddisc.textContent(text);
                tddisc.textContent  = (stotal * (disc/100)).toFixed(2).toString();
                //
                // var tddue = document.getElementById('tddue');
                // var text2 = document.createTextNode(stotal - (stotal * (disc/100)).toString());
                // tddue.textContent(text2);
                tddue.textContent = (stotal - (stotal * (disc/100))).toFixed(2).toString();
                //
                // var taxdue = document.getElementById('taxdue');
                // var text3 = document.createTextNode(((stotal - (stotal * (disc/100)))*0.12).toString());
                taxdue.textContent = ((stotal - (stotal * (disc/100))) * 0.12).toFixed(2).toString();
                alert('Invalid Coupon');
              }
          },
          error:function(data)
          {
             //console.log(data);
             alert('Error accessing to DB.');
          }
      });

  }
</script>

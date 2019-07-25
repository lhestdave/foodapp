@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <form class="" action="" method="post">
        {{ csrf_field() }}
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Burgers</div>
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
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                      <tbody>
                      @if(count($burgers) > 0)
                        @foreach($burgers as $br)
                          <tr>
                            <td>{{$br->id}}</td>
                            <td>{{$br->foodname}}</td>
                            <td>{{ number_format($br->amount,2) }}</td>
                            <td> <input type="number" name="qty{{$br->id}}" id="qty{{$br->id}}" min="1" value="1"> </td>
                            <td> <button type="button" name="button" class="btn btn-primary" onclick="addToCart('{{$br->id}}','{{$br->amount}}')">Add to Cart</button> </td>
                          </tr>
                        @endforeach
                      @endif
                      </tbody>
                    </table>

                </div>
            </div>
        </div>
        <br>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Beverages</div>

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
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                      <tbody>
                      @if(count($bevs) > 0)
                        @foreach($bevs as $bev)
                          <tr>
                            <td>{{$bev->id}}</td>
                            <td>{{$bev->foodname}}</td>
                            <td>{{ number_format($bev->amount,2) }}</td>
                            <td> <input type="number" name="qty{{$br->id}}" id="qty{{$bev->id}}" min="1" value="1"> </td>
                            <td> <button type="button" name="button" class="btn btn-primary" onclick="addToCart('{{$bev->id}}','{{$bev->amount}}')">Add to Cart</button> </td>
                          </tr>
                        @endforeach
                      @endif
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Combo Meals</div>

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
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                      <tbody>
                      @if(count($cmeals) > 0)
                        @foreach($cmeals as $cm)
                          <tr>
                            <td>{{$cm->id}}</td>
                            <td>{{$cm->foodname}}</td>
                            <td>{{ number_format($cm->amount,2) }}</td>
                            <td> <input type="number" name="qty{{$br->id}}" id="qty{{$cm->id}}" min="1" value="1"> </td>
                            <td> <button type="button" name="button" class="btn btn-primary" onclick="addToCart('{{$cm->id}}','{{$cm->amount}}')">Add to Cart</button> </td>
                          </tr>
                        @endforeach
                      @endif
                      </tbody>
                    </table>
                </div>
            </div>
        </div>

      </form>
    </div>
</div>
@endsection
<script type="text/javascript">
  function addToCart(id, price)
  {
    qty = document.getElementById('qty'+id).value;
    if(qty > 0){

      $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
            type: 'POST',
            url: '/order/savemenu',
            data: {
                '_token': $('input[name=_token]').val(),
                'menuid':id,
                'qty':qty,
                'price':price
            },
            success: function(data){
                //console.log(data);
                alert("Item has been added to your cart.");
            },
            error:function(data)
            {
               //console.log(data);
               alert(data);
            }
        });



    }else{
      alert("Error Quantity");
    }

  }
  function getJoid(id)
  {
    var joid = id;
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
          type: 'POST',
          url: '/jo/gettask',
          data: {
              '_token': $('input[name=_token]').val(),
              'joid':joid,
          },
          success: function(data){
              //console.log(data);
              $("tr.trtask").remove();
              var markup = '';
              for (var i = 0; i < data.length; i++) {
                if(data[i].tsid == 6){
                  markup += '<tr class="trtask"><td >'+(i+1)+'</td><td>'+data[i].taskname+'</td><td >'+data[i].leadtime+'</td><td >'+data[i].amount+'</td><td>['+data[i].name+']:'+data[i].state+'<br>'+data[i].created_at+'</td><td>'+
                  '<button class="btn btn-outline-primary my-2 my-sm-0 btn-sm taskstatus" data-toggle="modal" data-target="#updateTaskModal" type="button" onclick="gettaskStatus('+data[i].tid+','+data[i].tsid+')" rel="tooltip" title="Update Status" disabled><span class="fas fa-edit"></span></button>'+
                  '</td></tr>';
                }else{
                  markup += '<tr class="trtask"><td >'+(i+1)+'</td><td>'+data[i].taskname+'</td><td >'+data[i].leadtime+'</td><td >'+data[i].amount+'</td><td>['+data[i].name+']:'+data[i].state+'<br>'+data[i].created_at+'</td><td>'+
                  '<button class="btn btn-outline-primary my-2 my-sm-0 btn-sm taskstatus" data-toggle="modal" data-target="#updateTaskModal" type="button" onclick="gettaskStatus('+data[i].tid+','+data[i].tsid+')" rel="tooltip" title="Update Status" ><span class="fas fa-edit"></span></button>'+
                  '</td></tr>';
                }
              }
              $("table tbody #tbody"+joid).append(markup);

          },
          error:function(data)
          {
             console.log(data);
          }
      });
  }
</script>

@extends('admin.master')
@section('title', 'Quản lí đơn hàng')
@section('main')
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="panel panel-primary">
            <div class="panel-heading text-center">Quản lí đơn hàng</div>
            <div class="panel-body">
                <form action="{{route('order.search')}}" id="search-order">
                    <input type="text" name="user_name" placeholder="Tìm kiếm khách hàng...">
                    <input type="text" name="order_id" placeholder="Nhập mã hóa đơn...">
                    <button type="submit" class="btn btn-primary" style="line-height:1" name="search" title="Search"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
                <div class="bootstrap-table">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="margin-top:20px;">				
                            <thead>
                                <th>Mã hóa đơn</th>
                                <th>Mã khách hàng</th>
                                <th>Tên khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Ngày mua hàng</th>
                                <th>Tùy chọn</th>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>

                                    <td width="10%">{{$order->id}}</td>
                                    <td width="10%">{{$order->user_id}}</td>
                                    <td width="20%">{{$order->user_name}}</td>
                                    <td width="20%"width="10%">{{number_format($order->total, 0, '.','.')}} VND</td>
                                    <td width="20%">{{$order->created_at}}</td>
                                    <td width="20%">
                                        <a href="{{route('order.detail', $order->id)}}" class="btn btn-primary">Xem chi tiet</a>
                                        &nbsp;
                                        <a href="{{route('order.delete')}}" class="btn btn-danger delete-order" order_id="{{$order->id}}">Xoa</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            {{$orders->links()}}
                        </table>							
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div><!--/.row-->
    
@endsection



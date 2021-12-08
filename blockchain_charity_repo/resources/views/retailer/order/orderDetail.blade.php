@extends('admin.master')
@section('title', 'Quản lí đơn hàng')
@section('main')
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="panel panel-primary">
            <div class="panel-heading text-center">Chi tiết đơn hàng</div>
            <div class="panel-body">
                
                <div class="bootstrap-table">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="margin-top:20px;">				
                            <thead>
                                <tr class="bg-primary">
                                    <th width="10%">Mã hóa đơn</th>
                                    <th width="20%">Tên Sản phẩm</th>
                                    <th width="20%">Giá sản phẩm</th>
                                    <th width="10%">Số lượng</th>
                                    <th width="20%">Tổng tiền</th>
                                    <th width="20%">Ngày mua hàng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                <tr>
                                    <td>{{$item->order->id}}</td>
                                    <td>{{ucwords($item->product_name)}}</td>
                                    <td>{{number_format($item->price, '0', '.','.')}} VNĐ</td>
                                    <td>
                                       {{$item->quantity}}
                                    </td>
                                    <td>{{number_format($item->total, '0', '.','.')}} VND</td>
                                    <td>
                                       {{$item->created_at}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>							
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div><!--/.row-->
    
@endsection
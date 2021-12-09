@extends('retailer.master')
@section('title', 'Danh sách sản phẩm')
@section('main')
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">

            <div class="panel panel-primary">
                <div class="panel-heading">Danh sách sản phẩm</div>
                <div class="panel-body">
                    <div class="bootstrap-table">
                        <div class="table-responsive">
                            <a href="{{ route('retailer.product.create') }}" class="btn btn-primary">Thêm sản phẩm</a>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 offset-md-6">
                                    <form action="{{ route('retailer.product.list') }}" id="search-order">
                                        <input type="text" name="key_word" placeholder="Tìm kiếm sản phẩm...">
                                        <button type="submit" class="btn btn-primary" style="line-height:1" name="search"
                                            title="Search"><i class="fa fa-search" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </div>
                            <table class="table table-bordered" style="margin-top:20px;">
                                <thead>
                                    <tr class="bg-primary">
                                        <th>ID</th>
                                        <th width="30%">Tên Sản phẩm</th>
                                        <th>Giá sản phẩm</th>
                                        <th width="20%">Ảnh sản phẩm</th>
                                        <th>Nhãn hàng</th>
                                        <th>Tùy chọn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $pro)
                                        <tr>
                                            <td>{{ $pro->id }}</td>
                                            <td>{{ ucwords($pro->product_name) }}</td>
                                            <td>{{ number_format($pro->price) }} VNĐ</td>
                                            <td>
                                                <img width="200px" src="{{ asset($pro->image) }}" class="thumbnail">
                                            </td>
                                            <td>{{ $pro->category_name }}</td>
                                            <td>
                                                <a href="{{ route('retailer.product.edit', $pro->id) }}"
                                                    class="btn btn-warning"><i class="fa fa-pencil"
                                                        aria-hidden="true"></i> Sửa</a>
                                                <a href="{{ route('retailer.product.delete', $pro->id) }}"
                                                    class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>
                                                    Xóa</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{ $products->links() }}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <!--/.row-->

@endsection
@section('scripts')
    @if (Session::has('message'))
        <script>
            toastr.success(" {{ Session::get('message') }} ");
        </script>
    @endif
@endsection

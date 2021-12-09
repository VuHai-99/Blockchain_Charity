@extends('retailer.master')
@section('title', 'Thêm sản phẩm')
@section('main')
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">

            <div class="panel panel-primary">
                <div class="panel-heading">Thêm sản phẩm</div>
                <div class="panel-body">
                    <form method="post" action="{{ route('retailer.product.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if (Session::has('success'))
                            <p class="text-success">{{ Session::get('success') }}</p>
                        @endif
                        <div class="row" style="margin-bottom:40px">
                            <div class="col-xs-8">
                                <div class="form-group">
                                    <label>Tên sản phẩm</label>
                                    <input required type="text" name="product_name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Loại hàng hóa</label>
                                    <select name="category_id" class="form-control">
                                        <option value="0" disabled selected>Chọn loại hàng hóa</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Ảnh sản phẩm</label>
                                    <input required id="img" type="file" name="image" class="form-control hidden"
                                        onchange="changeImg(this)">
                                    <img id="avatar" class="thumbnail" width="300px"
                                        src="{{ asset('backend/img/new_seo-10-512.png') }}">
                                </div>
                                @error('image')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="form-group">
                                    <label>Giá sản phẩm</label>
                                    <input required type="number" name="price" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Số lượng</label>
                                    <input type="number" name="quantity" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Hiển thị</label>
                                    <select required name="display" class="form-control">
                                        <option value="1">Hiển thị</option>
                                        <option value="0">Không hiển thị</option>
                                    </select>
                                </div>
                                <input type="submit" name="submit" value="Thêm" class="btn btn-primary">
                                <a href="#" class="btn btn-danger">Hủy bỏ</a>
                            </div>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <!--/.row-->
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @if (Session::has('create_sucessful'))
        <script>
            toastr.success(" {{ Session::get('create_sucessful') }} ");
        </script>
    @endif
@endsection

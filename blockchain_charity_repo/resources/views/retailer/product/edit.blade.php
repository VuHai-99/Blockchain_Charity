@extends('retailer.master')
@section('title', 'Sửa sản phẩm')
@section('main')
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">

            <div class="panel panel-primary">
                <div class="panel-heading">Sửa sản phẩm</div>
                <div class="panel-body">
                    <form method="post" action="{{ route('retailer.product.update', $product->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row" style="margin-bottom:40px">
                            <div class="col-xs-8">
                                <div class="form-group">
                                    <label>Tên sản phẩm</label>
                                    <input type="text" name="product_name"
                                        value="{{ old('product_name', $product->product_name) }}" class="form-control">
                                    @error('product_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Loại hàng hóa</label>
                                    <select name="category_id" class="form-control">
                                        <option value="0" disabled>Chọn loại hàng hóa</option>
                                        @foreach ($categories as $catogory)
                                            <option value="{{ $catogory->id }}" @if (old('category_id', $product->catogory_id) == $catogory->id) selected @endif>
                                                {{ $catogory->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Ảnh sản phẩm</label>
                                    <input id="img" type="file" name="image" value="{{ old('image', $product->image) }}"
                                        class="form-control hidden" onchange="changeImg(this)">
                                    <img id="avatar" class="thumbnail" width="300px"
                                        src="{{ asset(old('image', $product->image)) }}">

                                    @error('image')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Giá sản phẩm</label>
                                    <input type="number" name="price" value="{{ old('price', $product->price) }}"
                                        class="form-control">
                                    @error('price')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Số lượng</label>
                                    <input type="number" name="quantity" value="{{ old('quantty', $product->quantity) }}"
                                        class="form-control" required>
                                    @error('quantity')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Hiển thị</label>
                                    <select name="display" class="form-control">
                                        <option value="1" @if ($product->display == 1) selected @endif>Hiển thị</option>
                                        <option value="0" @if ($product->display == 0) selected @endif>Không hiển thị</option>
                                    </select>
                                </div>
                                <button type="submit" name="submit" value="Thêm" class="btn btn-primary">Sửa</button>
                                <button type="reset" class="btn btn-danger"><a
                                        href="{{ route('retailer.product.list') }}"></a>Hủy bỏ</button>
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

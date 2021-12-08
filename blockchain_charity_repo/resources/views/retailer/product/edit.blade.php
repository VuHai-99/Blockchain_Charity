@extends('admin.master')
@section('title', 'Sửa sản phẩm')
@section('main')
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="panel panel-primary">
            <div class="panel-heading">Sửa sản phẩm</div>
            <div class="panel-body">
                <form method="post" action="{{route('product.update', $product->id)}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row" style="margin-bottom:40px">
                        <div class="col-xs-8">
                           
                            <div class="form-group">
                                <label>Mã sản phẩm</label>
                                <input  type="text" name="pro_id" value="{{$product->id}}" class="form-control">
                            </div>
                            @error('pro_id')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                            <div class="form-group" >
                                <label>Tên sản phẩm</label>
                                <input  type="text" name="name" value="{{$product->name}}" class="form-control">
                            </div>
                            <div class="form-group" >
                                <label>Nhãn hàng</label>
                                <select  name="brand_id" class="form-control">
                                    <option value="0" disabled>Chọn nhãn hàng</option>
                                    @foreach ($brands as $brand)
                                    <option value="{{$brand->id}}" @if($product->brand_id == $brand->id) selected @endif>{{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" >
                                <label>Ảnh sản phẩm</label>
                                <input  id="img" type="file" name="image" value="{{$product->image}}" class="form-control hidden" onchange="changeImg(this)">
                                <img id="avatar" class="thumbnail" width="300px" src="{{asset('products/'.$product->image)}}">
                            </div>
                            
                            <div class="form-group" >
                                <label>Giá sản phẩm</label>
                                <input  type="number" name="price" value="{{$product->price}}" class="form-control">
                            </div>
                            <div class="form-group" >
                                <label>Thời gian bảo hành (Tháng)</label>
                                <input  type="number" value="{{$product->warranty}}" name="warranty" class="form-control">
                            </div>
                            <div class="form-group" >
                                <label>Khuyến mãi (%)</label>
                                <input  type="number" name="promotion" value="{{$product->promotion}}" class="form-control">
                            </div>
                            <div class="form-group" >
                                <label>Miêu tả</label>
                                <textarea  name="description" class="ckeditor">{!!$product->description!!}</textarea>
                                <script type="text/javascript">
                                    var editor = CKEDITOR.replace('description',{
                                        language:'vi',
                                        filebrowserImageBrowseUrl: "{{asset('ckfinder/ckfinder.html?Type=Images')}}",
                                        filebrowserFlashBrowseUrl: "{{asset('ckfinder/ckfinder.html?Type=Flash')}}",
                                        filebrowserImageUploadUrl: "{{asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images')}}",
                                        filebrowserFlashUploadUrl: "{{asset('public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash')}}",
                                    });
                                </script>
                                
                            </div>
                            <div class="form-group" >
                                <label>Trạng thái</label>
                                <select  name="status" class="form-control">
                                    <option value="1" @if($product->status == 1) selected @endif>Còn hàng</option>
                                    <option value="0" @if($product->status == 0) selected @endif>Hết hàng</option>
                                </select>
                            </div>
                            
                            <div class="form-group" >
                                <label>Hiển thị</label>
                                <select  name="display" class="form-control">
                                    <option value="1" @if($product->display == 1) selected @endif>Hiển thị</option>
                                    <option value="0" @if($product->display == 0) selected @endif>Không hiển thị</option>
                                </select>
                            </div>
                            <div class="form-group" >
                                <label>Sản phẩm nổi bật</label><br>
                                Có: <input type="radio" @if($product->featured == 1)  checked @endif name="featured" value="1">
                                Không: <input type="radio" @if($product->featured == 0)  checked @endif  name="featured" value="0">
                            </div>
                            <button type="submit" name="submit" value="Thêm" class="btn btn-primary">Sửa</button>
                            <button type="reset" class="btn btn-danger">Hủy bỏ</button>
                        </div>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div><!--/.row-->
@endsection
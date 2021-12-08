@extends('admin.master')
@section('title', 'Thêm sản phẩm')
@section('main')
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="panel panel-primary">
            <div class="panel-heading">Thêm sản phẩm</div>
            <div class="panel-body">
                <form method="post" action="{{route('product.store')}}" enctype="multipart/form-data">
                    @csrf
                    @if(Session::has('success'))
                    <p class="text-success">{{Session::get('success')}}</p>
                    @endif
                    <div class="row" style="margin-bottom:40px">
                        <div class="col-xs-8">
                            @error('pro_id')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                            <div class="form-group">
                                <label>Mã sản phẩm</label>
                                <input type="text" name="pro_id" placeholder="Nhập mã sản phẩm..." class="form-control">
                            </div>
                            <div class="form-group" >
                                <label>Tên sản phẩm</label>
                                <input required type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group" >
                                <label>Nhãn hàng</label>
                                <select  name="brand_id" class="form-control">
                                    <option value="0" disabled selected>Chọn nhãn hàng</option>
                                    @foreach ($brands as $brand)
                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="form-group" >
                                <label>Ảnh sản phẩm</label>
                                <input required id="img" type="file" name="image" class="form-control hidden" onchange="changeImg(this)">
                                <img id="avatar" class="thumbnail" width="300px" src="{{asset('backend/img/new_seo-10-512.png')}}">
                            </div>
                            @error('image')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                            <div class="form-group">
                                <label>Chọn ảnh mô tả</label>
                                <input type="file" name="files[]" multiple>
                            </div>
                            @error('files.*')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                            <div class="form-group" >
                                <label>Giá sản phẩm</label>
                                <input required type="number" name="price" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Số lượng</label>
                                <input type="number" name="quantity" class="form-control" required>
                            </div>
                            <div class="form-group" >
                                <label>Thời gian bảo hành (Tháng)</label>
                                <input required type="number" name="warranty" class="form-control">
                            </div>
                            <div class="form-group" >
                                <label>Khuyến mãi</label>
                                <input required type="number" name="promotion" class="form-control">
                            </div>
                            <div class="form-group" >
                                <label>Miêu tả</label>
                                <textarea required name="description" class="ckeditor"></textarea>
                                <script type="text/javascript">
                                    var editor = CKEDITOR.replace('description',{
                                        language:'vi',
                                        filebrowserImageBrowseUrl: "{{asset('backend/ckfinder/ckfinder.html?Type=Images')}}",
                                        filebrowserFlashBrowseUrl: "{{asset('backend/ckfinder/ckfinder.html?Type=Flash')}}",
                                        filebrowserImageUploadUrl: "{{asset('backend/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images')}}",
                                        filebrowserFlashUploadUrl: "{{asset('backend/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash')}}",
                                    });
                                </script>
                                
                            </div>
                            
                            <div class="form-group" >
                                <label>Hiển thị</label>
                                <select required name="display" class="form-control">
                                    <option value="1">Hiển thị</option>
                                    <option value="0">Không hiển thị</option>
                                </select>
                            </div>
                            <div class="form-group" >
                                <label>Sản phẩm nổi bật</label><br>
                                Có: <input type="radio" name="featured" value="1">
                                Không: <input type="radio" checked name="featured" value="0">
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
</div><!--/.row-->
@endsection
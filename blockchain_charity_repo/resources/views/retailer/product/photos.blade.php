@extends('admin.master')
@section('title', 'Ảnh mô tả')
@section('main')
    <a href="{{route('product.show')}}"> << Quay lại danh sách</a>
    <h3 class="text-center text-dark">{{$product->name}}</h3>
    <br>
    <div class="img-main text-center">
        <img width="300px" src="{{asset('products/'.$product->image)}}" alt="">
    </div>
    <h3>Ảnh mô tả</h3>
    <div class="img-description row">
        @foreach ($product->photo as $img)          
        <div class="img-item col-xs-12 col-md-4 col-lg-3">
            <img width="150px" src="{{asset('products/'. $img->image)}}" alt="">
            <br><br>
            <a href="{{route('product.deletePhoto', $img->id)}}" photo_id ={{$img->id}} class="btn btn-primary link-delete-photo">Xóa ảnh</a>
        </div>
        @endforeach
    </div>
    <br><br>
    <hr>
    <form id="form-add-photo" action="{{route('product.addPhotos', $product->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Thêm ảnh</label>
            <input type="file" name="file" id="add-photo" onchange="submit()">
        </div>
    </form>
    
@endsection
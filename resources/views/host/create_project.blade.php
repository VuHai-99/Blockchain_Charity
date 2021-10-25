@extends('layouts.default')

@section('page-name', 'Thêm dự án')
@section('content')
    <div class="row wrap-form">
        <form action="{{ asset(route('host.store.project')) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="project-name">Tên dự án</label>
                <input type="text" name="name" id="project-name" {{ old('name') }} class="form-control"
                    placeholder="Nhập tên dự án ...">
                @error('name')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="date-start">Ngày bắt đầu</label>
                <input type="text" name="date_start" id="date-start" value="{{ old('date_start') }}" class="form-control"
                    placeholder="Ngày bắt đầu dự án (d-m-Y) ...">
                @error('date_start')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="date-end">Ngày kết thúc</label>
                <input type="text" name="date_end" id="date-end" {{ old('date_end') }} class="form-control"
                    placeholder="Ngày kết thúc dự án (d-m-Y) ...">
                @error('date_end')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label>Mô tả dự án</label>
                <textarea name="description" cols="30" rows="10" class="ckeditor"></textarea>
                <script type="text/javascript">
                    var editor = CKEDITOR.replace('description', {
                        language: 'vi',
                        filebrowserImageBrowseUrl: "../../theme/libs/ckfinder/ckfinder.html?Type=Images",
                        filebrowserFlashBrowseUrl: "../../theme/libs/ckfinder/ckfinder.html?Type=Flash",
                        filebrowserImageUploadUrl: "../../theme/libs/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images",
                        filebrowserFlashUploadUrl: "../../theme/libs/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash",
                    });
                </script>
                @error('description')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Thêm </button>
            </div>
        </form>
    </div>
@endsection

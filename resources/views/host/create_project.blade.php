@extends('layouts.default')

@section('page-name', 'Thêm dự án')
@section('content')
    <div class="row wrap-form">
        <form onSubmit="App.createCampaign(); return false">

            <div class="form-group">
                <label for="project_name">Tên dự án</label>
                <input type="text" name="project_name" id="project_name" {{ old('name') }} class="form-control"
                    placeholder="Nhập tên dự án ...">
                @error('name')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="minimum_contribution">Số tiền ủng hộ tối thiểu</label>
                <input type="text" name="minimum_contribution" id="minimum_contribution" value="{{ old('minimum_contribution') }}" class="form-control"
                    placeholder="Số tiền ủng hộ tối thiểu (wei)...">
                @error('minimum_contribution')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="date_start">Ngày bắt đầu</label>
                <input type="text" name="date_start" id="date_start" value="{{ old('date_start') }}" class="form-control"
                    placeholder="Ngày bắt đầu dự án (d-m-Y) ...">
                @error('date_start')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="date_end">Ngày kết thúc</label>
                <input type="text" name="date_end" id="date_end" {{ old('date_end') }} class="form-control"
                    placeholder="Ngày kết thúc dự án (d-m-Y) ...">
                @error('date_end')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label>Mô tả dự án</label>
                <textarea name="description" id="description" cols="30" rows="10" class="ckeditor"></textarea>
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

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ asset('js/bn.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/host_create_project_blockchain.js') }}"></script>
<!-- <script src="{{ asset('js/contract.js') }}"></script> -->
<script src="{{ asset('js/web3.min.js') }}"></script>
<script src="{{ asset('js/truffle-contract.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript" src="{{ asset('js/laroute.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@stack('scripts')

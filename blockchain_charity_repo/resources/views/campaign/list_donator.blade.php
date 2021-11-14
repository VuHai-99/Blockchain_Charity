@extends('layouts.default')

@section('title', 'Chi tiết dự án')

@section('css')
    <link rel="stylesheet" href="{{asset('css/campaign_donator.css')}}">
@endsection
@section('content')
<div class="list-project table-responsive">
    <h4 class="text-center">Danh sách các nhà hỗ trợ dự án xây nhà cho đồng bào lũ lụt</h4>
    <table class="table table-bordered table-hover" width="80%">
        <thead>
            <th width="10%">STT</th>
            <th width="30%">Họ và tên</th>
            <th width="15%">Ngày quyên góp</th>
            <th width="15%">Số tiền tham gia</th>
        </thead>
        @for ($i = 1; $i <= 20; $i++)
            <tr>
                <td>{{ $i }}</td>
                <td><a href="" class="donator-name">Phạm Văn Thiện</a></td>
                <td>{{$i}}-10-2020</td>
                <td>{{$i}}0</td>
            </tr>
        @endfor

        <tbody>

        </tbody>
    </table>
</div>
@endsection

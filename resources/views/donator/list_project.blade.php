@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/host_list_project.css') }}">
@endsection
@section('page-name', 'Danh sách sự kiện')
@section('content')
    <div class="row create-project">
        <button class="btn">Donate</button>
    </div>
    <div class="list-project table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <th width="10%">Mã dự án</th>
                <th>Tên dự án</th>
                <th width="15%">Ngày tham gia</th>
                <th width="15%">Số tiền tham gia</th>
            </thead>
            @for ($i = 1; $i <= 6; $i++)
                <tr>
                    <td>EV{{ $i }}</td>
                    <td>Quỹ trái tim cho em</td>
                    <td>18-10-2020</td>
                    <td>300</td>
                </tr>
            @endfor

            <tbody>

            </tbody>
        </table>
    </div>
@endsection

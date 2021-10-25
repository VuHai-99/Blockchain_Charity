@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/host_list_project.css') }}">
@endsection
@section('page-name', 'Danh sách sự kiện')
@section('content')
    <div class="row create-project">
        <button class="btn">Create Project</button>
    </div>
    <div class="list-project table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <th>Mã dự án</th>
                <th>Tên dự án</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th width="10%">Số người quyên góp</th>
                <th>Số tiền</th>
                <th>Action</th>
            </thead>
            @for ($i = 1; $i <= 6; $i++)
                <tr>
                    <td>EV{{ $i }}</td>
                    <td>Quỹ trái tim cho em</td>
                    <td>18-10-2020</td>
                    <td>20-3-2021</td>
                    <td>300</td>
                    <td>{{ number_format(2000000) }}</td>
                    <td>
                        <a href=""><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        &nbsp;
                        <a href=""><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>
            @endfor

            <tbody>

            </tbody>
        </table>
    </div>
@endsection

@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/host_list_project.css') }}">
@endsection
@section('page-name', 'Danh sách sự kiện')
@section('content')
    <div class="list-project table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <th>Tên dự án</th>
                <th>Người tổ chức</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Trạng thái</th>
                <th>Action</th>
            </thead>
            @for ($i = 1; $i <= 5; $i++)
                <tr>
                    <td>Xây trường cho trẻ em vùng cao</td>
                    <td>Vũ Hải</td>
                    <td>18-11-2021</td>
                    <td>10-3-2022</td>
                    <td class="approved">Approved</td>
                    <td>
                        <a href="">
                            <i class="fa fa-unlock" aria-hidden="true"></i>
                        </a>
                        &nbsp;
                        <a href=""><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        &nbsp;
                        <a href=""><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>
            @endfor
            @for ($i = 1; $i <= 5; $i++)
                <tr>
                    <td>Xây nhà chống lũ hỗ trợ miền Trung</td>
                    <td>Phạm Văn Thiện</td>
                    <td>18-10-2020</td>
                    <td>20-3-2021</td>
                    <td class="un-approved">UnApproved</td>
                    <td>
                        <a href="">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </a>
                        &nbsp;
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

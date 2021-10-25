@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/host_list_project.css') }}">
@endsection
@section('page-name', 'Danh sách nhà từ thiện')
@section('content')
    <div class="list-host table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <th>Tên Host</th>
                <th>Ngày đăng kí</th>
                <th>Trạng thái</th>
                <th>Action</th>
            </thead>
            @for ($i = 1; $i <= 5; $i++)
                <tr>
                    <td>Phạm Thiện {{ $i }}</td>
                    <td>18-11-2021</td>
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
                    <td>Kiều Tùng {{ $i }}</td>
                    <td>18-10-2020</td>
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

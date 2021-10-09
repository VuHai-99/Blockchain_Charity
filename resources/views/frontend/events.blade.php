@extends('frontend.default')

@section('title', 'Sự kiện')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/frontend_event.css') }}">
@endsection

@section('content')
    <div class="search row">
        <div class="form-search col-4">
            <div class="input-group-prepend">
                <button id="button-addon2" type="submit" class="btn btn-link text-warning"><i
                        class="fa fa-search"></i></button>
            </div>
            <input type="text" name="search" id="" class="form-control "
                placeholder="Nhập tên dự án hoặc tên người tổ chức...">
        </div>
    </div>
    <div class="list-events">
        <div class="event-happend">
            <div class="event-item row">
                <div class="image">
                    <img src="https://tuyengiao.vn/Uploads/2021/9/20/29/tu-viec-thien-nguyen-cua-cac-nghe-si-den-chuyen-minh-bach-trong-sao-ke.jpg"
                        alt="">
                </div>
                <div class="information">
                    <div class="host">
                        Người tổ chức: Phạm Văn Thiện
                    </div>
                    <div class="descripton">
                        Dự án thiện nguyện được thành lập với mục đích cứu trợ cho nhân dân
                        miền Trung bị ảnh hưởng nặng nề trong cơn bão số 10 vừa qua. Với sự ủng hộ của rất nhiều mạnh thường
                        quân trong và ngoài nước
                    </div>
                    <div class="plan">
                        <p class="date-start">Người bắt đầu: 08-09-2020</p>
                        <p class="date-end">Ngày kết thúc: 20-11-2020</p>
                        <p class="coin">Số tiền hiện tại: 1.000.000.000 VNĐ</p>
                    </div>
                </div>
            </div>
            <div class="event-item row">
                <div class="image">
                    <img src="https://tuyengiao.vn/Uploads/2021/9/20/29/tu-viec-thien-nguyen-cua-cac-nghe-si-den-chuyen-minh-bach-trong-sao-ke.jpg"
                        alt="">
                </div>
                <div class="information">
                    <div class="host">
                        Người tổ chức: Phạm Văn Thiện
                    </div>
                    <div class="descripton">
                        Dự án thiện nguyện được thành lập với mục đích cứu trợ cho nhân dân
                        miền Trung bị ảnh hưởng nặng nề trong cơn bão số 10 vừa qua. Với sự ủng hộ của rất nhiều mạnh thường
                        quân trong và ngoài nước
                    </div>
                    <div class="plan">
                        <p class="date-start">Người bắt đầu: 08-09-2020</p>
                        <p class="date-end">Ngày kết thúc: 20-11-2020</p>
                        <p class="coin">Số tiền hiện tại: 1.000.000.000 VNĐ</p>
                    </div>
                </div>
            </div>
            <div class="event-item row">
                <div class="image">
                    <img src="https://tuyengiao.vn/Uploads/2021/9/20/29/tu-viec-thien-nguyen-cua-cac-nghe-si-den-chuyen-minh-bach-trong-sao-ke.jpg"
                        alt="">
                </div>
                <div class="information">
                    <div class="host">
                        Người tổ chức: Phạm Văn Thiện
                    </div>
                    <div class="descripton">
                        Dự án thiện nguyện được thành lập với mục đích cứu trợ cho nhân dân
                        miền Trung bị ảnh hưởng nặng nề trong cơn bão số 10 vừa qua. Với sự ủng hộ của rất nhiều mạnh thường
                        quân trong và ngoài nước
                    </div>
                    <div class="plan">
                        <p class="date-start">Người bắt đầu: 08-09-2020</p>
                        <p class="date-end">Ngày kết thúc: 20-11-2020</p>
                        <p class="coin">Số tiền hiện tại: 1.000.000.000 VNĐ</p>
                    </div>
                </div>
            </div>
            <div class="event-item row">
                <div class="image">
                    <img src="https://tuyengiao.vn/Uploads/2021/9/20/29/tu-viec-thien-nguyen-cua-cac-nghe-si-den-chuyen-minh-bach-trong-sao-ke.jpg"
                        alt="">
                </div>
                <div class="information">
                    <div class="host">
                        Người tổ chức: Phạm Văn Thiện
                    </div>
                    <div class="descripton">
                        Dự án thiện nguyện được thành lập với mục đích cứu trợ cho nhân dân
                        miền Trung bị ảnh hưởng nặng nề trong cơn bão số 10 vừa qua. Với sự ủng hộ của rất nhiều mạnh thường
                        quân trong và ngoài nước
                    </div>
                    <div class="plan">
                        <p class="date-start">Người bắt đầu: 08-09-2020</p>
                        <p class="date-end">Ngày kết thúc: 20-11-2020</p>
                        <p class="coin">Số tiền hiện tại: 1.000.000.000 VNĐ</p>
                    </div>
                </div>
            </div>
            <div class="event-item row">
                <div class="image">
                    <img src="https://tuyengiao.vn/Uploads/2021/9/20/29/tu-viec-thien-nguyen-cua-cac-nghe-si-den-chuyen-minh-bach-trong-sao-ke.jpg"
                        alt="">
                </div>
                <div class="information">
                    <div class="host">
                        Người tổ chức: Phạm Văn Thiện
                    </div>
                    <div class="descripton">
                        Dự án thiện nguyện được thành lập với mục đích cứu trợ cho nhân dân
                        miền Trung bị ảnh hưởng nặng nề trong cơn bão số 10 vừa qua. Với sự ủng hộ của rất nhiều mạnh thường
                        quân trong và ngoài nước
                    </div>
                    <div class="plan">
                        <p class="date-start">Người bắt đầu: 08-09-2020</p>
                        <p class="date-end">Ngày kết thúc: 20-11-2020</p>
                        <p class="coin">Số tiền hiện tại: 1.000.000.000 VNĐ</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="event-upcoming">
            <ul>
                <li class="text">DỰ ÁN SẮP DIỄN RA</li>
                <li class="event">
                    <a href="">Dự án thiện nguyện hỗ trợ trẻ em vùng cao xây dựng trường học</a>
                </li>
                <li class="event">
                    <a href="">Dự án trái tim cho em: hỗ trợ trẻ em có hoàn cảnh khó khăn chữa bệnh
                        tim
                    </a>
                </li>
                <li class="event">
                    <a href="">Dự án trái tim cho em: hỗ trợ trẻ em có hoàn cảnh khó khăn chữa bệnh
                        tim</a>
                </li>
                <li class="event">
                    <a href="">Dự án trái tim cho em: hỗ trợ trẻ em có hoàn cảnh khó khăn chữa bệnh
                        tim</a>
                </li>
                <li class="event">
                    <a href="">Dự án trái tim cho em: hỗ trợ trẻ em có hoàn cảnh khó khăn chữa bệnh
                        tim</a>
                </li>
            </ul>
        </div>
    </div>
@endsection

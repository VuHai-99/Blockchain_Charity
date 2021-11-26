@extends('layouts.default')

@section('title', 'Chi tiết dự án')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/project_detail.css') }}">
@endsection

@section('id_custom', 'backend')

@section('content')
    <div class="row">
        <div class="information col-md-8">
            <div class="featured">
                <div class="wrap-image">
                    <img src="https://danviet.mediacdn.vn/2020/10/21/thuy-tien-1603245101017901488132.jpg" alt="">
                    <p class="title mt-1"> <i>{{$campaign->name}}</i></p>
                </div>
                <div class="description">
                    <p>
                        Đợt mưa bão tháng 10/2020, nhiều địa phương ở khu vực miền Trung đã gánh chịu thiệt hại nặng nề về
                        người và
                        tài sản.
                        Chia sẻ khó khăn, hoạn nạn với đồng bào miền Trung, người dân cả nước và kiều bào ở nước ngoài đã
                        quyên góp,
                        ủng hộ rất lớn về mặt vật chất; trong đó có việc ca sĩ Thủy Tiên đã đến một số nơi để trao hỗ trợ từ
                        thiện
                        do những
                        tấm lòng hảo tâm đóng góp đến tận tay người dân. Việc làm này của ca sĩ Thủy Tiên ban đầu được nhiều
                        người
                        khen ngợi.
                    </p>
                    <p>
                        Dự án được các mạnh thường quân trong và ngoài nước ủng hộ rất nhiệt tình. Đến nay số tiền quyên góp
                        đã đạt
                        được gần
                        100 tỉ đồng. Trong những ngày vừa qua, ca sĩ Thủy Tiên đã đến rất nhiều địa bàn tại trung tâm lũ
                        miền Trung
                        để trao
                        tận tay số tiền hỗ trợ đến bà con.
                    </p>
                </div>
            </div>
            <div class="detail-item">
                <div class="wrap-image">
                    <img src="https://znews-photo.zadn.vn/w660/Uploaded/lce_jwqqc/2020_10_16/12_1.jpg" alt="">
                    <p class="title"> <i>Hình ảnh Thủy Tiên trao quà hỗ trợ đến tận tay người dân ở huyện An Lão,
                            Quảng
                            Trị</i>
                </div>
                </p>
                <div class="description">
                    <p>
                        Địa điểm tiếp theo được đoàn từ thiện ghé tới là huyện An Lão ở Quảng Trị, một trong những nơi chịu
                        ảnh
                        hưởng nặng nề trong đợt lũ vừa rồi.
                        Trong chuyến từ thiện này số tiền được trao đến tay người dân tại đây là hơn 12 tỉ đồng cùng với một
                        số
                        3 nhà dân được hỗ trợ để làm lại.
                    </p>
                    <div class="wrap-image">
                        <img src="https://ngolongnd.net/wp-content/uploads/2021/09/ngolongnd_sao-ke-tai-khoan-ngan-hang-la-gi.jpg"
                            alt="">
                        <p class="title"><i>Ảnh sao kê chi tiết các khoản từ thiện tại huyện An Lão</i></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="donator col-md-4">
            <div class="coin">
                <span class="coin-donated">{{$campaign->current_balance}} (wei)</span>/ {{$campaign->target_contribution_amount}}(wei)
                <div class="goal">
                    <div class="coin-current"></div>
                </div>
                <br>
                <div class="number-donator">
                    <span class="number">300 donations</span>
                    <span class="amount">$2000 to go</span>
                </div>
                <div class="triangle triangle_bottom triangle_white">

                </div>
            </div>
            <form method="POST" action="{{ route('donatorws.donate.campaign') }}">
                @csrf
                <div class="btn-donate">
                    <input placeholder="Amount of donation" id="donation_amount" name="donation_amount">
                    <input id="campaign_address" name="campaign_address" value="{{$campaign->campaign_address}}" hidden>
                    <input id="user_address" name="user_address" value="{{Auth::user()->user_address}}" hidden>
                    @error('donation_amount')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                    <button class="btn">DONATE NOW</button>
                </div>
            </form>
            <div class="list-donator">
                <div class="title">
                    <div class="donate-once">
                        <a href="">Top Donator</a>
                    </div>
                    <div class="donate-monthly">
                        <a href="">Donate Monthly</a>
                    </div>
                </div>
                <ul class="list-donator-item">
                    @for ($i = 0; $i < 15; $i++)
                        <li class="item">
                            <div class="money"> ${{ 10 * (15 - $i) }} coins</div>
                            <div class="donator-name">Phạm Văn Thiện</div>
                            <div class="next">
                                <a href=""><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                            </div>
                        </li>
                    @endfor
                    <li class="read-more"> <a href="{{ route('campaign.donator') }}">Xem chi tiết</a></li>
                </ul>
            </div>
        </div>
    </div>

    <hr>
    <h4 class="text-reference">Các sự kiện liên quan</h4>
    <div class="reference">
        <div class="event-reference col-3">
            <a href="">
                <div class="wrap-image">
                    <img src="https://media-cdn.laodong.vn/Storage/NewsPortal/2020/10/14/844930/Thuy-Tien-2.jpg"
                        alt="Thủy Tiên từ thiện tại Quảng Trị">
                </div>
            </a>
            <p class="title">Hỗ trợ đồng bào ở Nghệ An gặp lũ lụt năm 2020</p>
        </div>
        <div class="event-reference col-3">
            <a href="">
                <div class="wrap-image">
                    <img src="https://media-cdn.laodong.vn/Storage/NewsPortal/2020/10/14/844930/Thuy-Tien-2.jpg"
                        alt="Thủy Tiên từ thiện tại Đà Nẵng">
                </div>
            </a>
            <p class="title">Hỗ trợ đồng bào ở Nghệ An gặp lũ lụt năm 2020</p>
        </div>
        <div class="event-reference col-3">
            <a href="">
                <div class="wrap-image">
                    <img src="https://media-cdn.laodong.vn/Storage/NewsPortal/2020/10/14/844930/Thuy-Tien-2.jpg"
                        alt="Thủy Tiên từ thiện tại Quảng Bình">
                </div>
            </a>
            <p class="title">Hỗ trợ đồng bào ở Nghệ An gặp lũ lụt năm 2020</p>
        </div>
        <div class="event-reference col-3">
            <a href="">
                <div class="wrap-image">
                    <img src="https://media-cdn.laodong.vn/Storage/NewsPortal/2020/10/14/844930/Thuy-Tien-2.jpg"
                        alt="Thủy Tiên từ thiện tại Hà Tĩnh">
                </div>
            </a>
            <p class="title">Hỗ trợ đồng bào ở Nghệ An gặp lũ lụt năm 2020</p>
        </div>
    </div>
@endsection

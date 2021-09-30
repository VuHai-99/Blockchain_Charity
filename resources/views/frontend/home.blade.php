@extends('frontend.default')

@section('title', 'Home')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
    <div class="row home-page">
        <div class="main">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Necessitatibus repellat debitis inventore repudiandae!
                Consequuntur consectetur molestias nobis maxime quis optio cupiditate voluptates ullam asperiores!
                Ipsam pariatur ducimus velit saepe natus.Eius magni dolor voluptate beatae, sequi corporis sit alias rem
                amet, maxime totam voluptas eligendi
                omnis in iure nulla repellendus sint facere distinctio labore nam officiis vero minus. Quasi, expedita.
            </p>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Necessitatibus repellat debitis inventore repudiandae!
                Consequuntur consectetur molestias nobis maxime quis optio cupiditate voluptates ullam asperiores!
                Ipsam pariatur ducimus velit saepe natus.Eius magni dolor voluptate beatae, sequi corporis sit alias rem
                amet, maxime totam voluptas eligendi
                omnis in iure nulla repellendus sint facere distinctio labore nam officiis vero minus. Quasi, expedita.
            </p>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Necessitatibus repellat debitis inventore repudiandae!
                Consequuntur consectetur molestias nobis maxime quis optio cupiditate voluptates ullam asperiores!
                Ipsam pariatur ducimus velit saepe natus.Eius magni dolor voluptate beatae, sequi corporis sit alias rem
                amet, maxime totam voluptas eligendi
                omnis in iure nulla repellendus sint facere distinctio labore nam officiis vero minus. Quasi, expedita.
            </p>

        </div>
        <div class="image">
            <img src="{{ asset('images/saving.png') }}" alt="">
            <div class="hand">
                <img src="{{ asset('images/handsaving.webp') }}" alt="">
            </div>
        </div>
        <div class="donate">
            <div class="line"></div>
            <div class="box">
                DONATE
            </div>
            <div class="img-hand">
                <img src="{{ asset('images/hands.webp') }}" alt="">
            </div>
        </div>
    </div>
@endsection

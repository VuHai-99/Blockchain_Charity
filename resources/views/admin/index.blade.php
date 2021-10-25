@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/style_template.css') }}">
@endsection
@section('page-name', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-blue panel-widget ">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <svg class="glyph stroked bag">

                        </svg>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large">120</div>
                        <div class="text-muted">Project Approved</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-orange panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-2 col-lg-4 widget-left">
                        <svg class="glyph stroked empty-message">
                            <use xlink:href="#stroked-empty-message"></use>
                        </svg>
                    </div>
                    <div class="col-sm-10 col-lg-8 widget-right">
                        <div class="large">52</div>
                        <div class="text-muted">Project UnApproved</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-teal panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-2 col-lg-4 widget-left">
                        <svg class="glyph stroked male-user">
                            <use xlink:href="#stroked-male-user"></use>
                        </svg>
                    </div>
                    <div class="col-sm-10 col-lg-8 widget-right">
                        <div class="large">24</div>
                        <div class="text-muted">Host Approved</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-red panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-2 col-lg-4 widget-left">
                        <svg class="glyph stroked app-window-with-content">
                            <use xlink:href="#stroked-app-window-with-content"></use>
                        </svg>
                    </div>
                    <div class="col-sm-10 col-lg-8 widget-right">
                        <div class="large">50</div>
                        <div class="text-muted">Host UnApproved</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

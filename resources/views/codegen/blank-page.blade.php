@extends('lenna-admin::layouts/left-sidebar-admin')

@section('title','我是翁先生')

@section('head')
    {{-- 自定義 HTML/CSS 資源 --}}

@endsection

@section('content')
    @php
        $breadcrumb = [
            (object) [
                'url'       => '',
                'active'    => false,
                'name'      => '測試頁面'
            ],
            (object) [
                'url'       => '',
                'active'    => true,
                'name'      => '當前頁面'
            ]
        ];
        $title = "hello";
    @endphp
    <x-lara-adm-header-breadcrumb :title="$title" :breadcrumb="$breadcrumb"></x-lara-adm-header-breadcrumb>

    {{-- 自定義網站內容 --}}
@endsection




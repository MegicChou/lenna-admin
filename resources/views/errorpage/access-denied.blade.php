@extends('lenna-admin::layouts/left-sidebar-admin')

@section('title',__('lenna-admin::errors.access.denied'))

@section('head')
    {{-- 自定義 HTML/CSS 資源 --}}

@endsection

@section('content')
    @php
        $breadcrumb = [
            (object) [
                'url'       => '',
                'active'    => false,
                'name'      => 'Home'
            ],
            (object) [
                'url'       => '',
                'active'    => true,
                'name'      => __('lenna-admin::errors.access.denied')
            ]
        ];
        $title = __('lenna-admin::errors.access.denied');
    @endphp
    <x-lara-adm-header-breadcrumb :title="$title" :breadcrumb="$breadcrumb"></x-lara-adm-header-breadcrumb>

    {{-- 自定義網站內容 --}}
    <!-- Main content -->
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-danger">403</h2>

            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Something went wrong.</h3>

                <p>
                    {{ __('lenna-admin::errors.access.denied.view') }}
                    <a href="javascript:window.history.back();">{{ __('lenna-admin::common.back.to.previous') }}</a>
                </p>

            </div>
        </div>
        <!-- /.error-page -->
    </section>
    <!-- /.content -->
@endsection





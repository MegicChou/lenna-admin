@extends('lenna-admin::layouts/left-sidebar-admin')

@section('title',__('lenna-admin::role.admin.role.permission.name'))

@section('head')

@endsection

@section('content')
    @php
        $breadcrumb = [
            (object) [
                'url'       => route('admin.role.create'),
                'active'    => false,
                'name'      => __('lenna-admin::role.admin.name')
            ],
            (object) [
                'url'       => route('admin.role.permission.index',['roleId' => $roleId]),
                'active'    => true,
                'name'      => __('lenna-admin::role.admin.role.permission.name')
            ],
        ];
        $title =  __('lenna-admin::role.admin.role.permission.name');
    @endphp
    <x-lara-adm-header-breadcrumb :title="$title" :breadcrumb="$breadcrumb"></x-lara-adm-header-breadcrumb>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('lenna-admin::role.admin.role.permission.name') }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.role.permission.edit',[$roleId]) }}" method="post">
                                @csrf
                                {{ method_field("PATCH") }}
                                @can('admin.role.permission.edit')
                                <button type="submit" class="btn btn-primary">{{ __('lenna-admin::common.save') }}</button>
                                @endcan
                                <hr />
                                @foreach($featureCatalogGrid as $itemCatalog)
                                    @php
                                    $divRowStyle = "";
                                    if ($itemCatalog->isSuperuser) {
                                        $divRowStyle = "display:none;";
                                    }
                                    @endphp
                                    <div class="row" style="{{ $divRowStyle }}">

                                        <div class="col-md-12">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        @if (config('admin.localization', false))
                                                            {{ __($itemCatalog->catalogLangName) }}
                                                        @else
                                                            {{ $itemCatalog->catalogName }}
                                                        @endif
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <ul class="list-group">
                                                        @foreach($itemCatalog->item as $itemPermission)
                                                            {{-- 判斷是否已經勾選 --}}
                                                            @php
                                                                $checked = "";
                                                                if ($itemPermission->enabled) {
                                                                    $checked = "checked";
                                                                }
                                                            @endphp
                                                            {{-- 判斷是否為超級使用者 如果是改用 hidden 顯示 並跳過該項目顯示 --}}
                                                            @if ($itemPermission->isSuperuser)
                                                                <input type="hidden" name="permission[]" value="{{ $itemPermission->permissionName }}" {{$checked}}>
                                                                @continue
                                                            @endif
                                                            <li class="list-group-item">
                                                                <label>
                                                                    <input type="checkbox" name="permission[]" value="{{ $itemPermission->permissionName }}" {{$checked}}>
                                                                    @if (config('admin.localization', false))
                                                                        {{ __($itemPermission->langName) }}
                                                                    @else
                                                                        {{ $itemPermission->name }}
                                                                    @endif
                                                                </label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </form>
                        </div>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
@endsection





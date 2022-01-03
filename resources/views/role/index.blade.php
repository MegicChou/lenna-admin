@extends('lenna-admin::layouts/left-sidebar-admin')

@section('title',__('lenna-admin::role.admin.name'))

@section('head')

@endsection

@section('content')
    @php
        $breadcrumb = [
            (object) [
                'url'       => route('admin.role.create'),
                'active'    => true,
                'name'      => __('lenna-admin::role.admin.name')
            ],
        ];
        $title = __('lenna-admin::role.admin.name');
    @endphp
    <x-lara-adm-header-breadcrumb :title="$title" :breadcrumb="$breadcrumb"></x-lara-adm-header-breadcrumb>


    <link rel="stylesheet" href="{{ asset("vendor/lenna/AdminLTE/plugins/jstree/themes/default/style.css") }}">
    <script src="{{ asset("vendor/lenna/AdminLTE/plugins/jstree/jstree.js") }}"></script>
    <div class="modal" tabindex="-1" role="dialog" id="modelAppend">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('lenna-admin::role.modal.append.title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.role.create') }}" method="POST" id="formAppend">
                    {{ method_field("POST") }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">{{ __('lenna-admin::role.name') }}</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('lenna-admin::common.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('lenna-admin::common.append') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modelEdit">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('lenna-admin::role.modal.edit.title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="formEdit">
                    {{ method_field("PATCH") }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">{{ __('lenna-admin::role.name') }}</label>
                            <input type="text" class="form-control" name="name" id="editRoleName">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('lenna-admin::common.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('lenna-admin::common.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modelMenuEdit">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('lenna-admin::menu.modal.title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="formMenuEdit">
                    {{ method_field("PATCH") }}
                    <div class="modal-body">
                        <div id="menuEditForm">

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('lenna-admin::common.close') }}</button>
                        <button type="button" class="btn btn-primary" onclick="submitRoleMenu()">{{ __('lenna-admin::common.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('lenna-admin::role.admin.name') }}</h3>
                        </div>
                        <div class="card-body">
                            @can(['admin.role.create'])
                            <button type="button" onclick="modelAppend()" class="btn btn-primary">{{ __('lenna-admin::common.append') }}</button>
                            @endcan
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td>{{ __('lenna-admin::role.name') }}</td>
                                    <td>{{ __('lenna-admin::common.action') }}</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($result as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                @can(['admin.role.menu.edit','admin.role.menu.list'])
                                                <button type="button" class="btn btn-secondary" onclick="modelMenu({{ $item->id }})">選單</button>
                                                @endcan
                                                @can(['admin.role.permission.index'])
                                                <button type="button" class="btn btn-secondary" onclick="javascript:location.href='{{ route('admin.role.permission.index',[$item->id]) }}'">權限</button>
                                                @endcan
                                                @can(['admin.role.edit'])
                                                <button type="button" class="btn btn-secondary" onclick="modelEdit({{$item->id}})">{{ __('lenna-admin::common.edit') }}</button>
                                                @endcan
                                                @can(['admin.role.destroy'])
                                                <button type="button" class="btn btn-secondary" onclick="actionDestroy({{$item->id}})">{{ __('lenna-admin::common.destroy') }}</button>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset("vendor/lenna/AdminLTE/plugins/jquery-validation/jquery.validate.min.js") }}"></script>
    <script src="{{ asset("vendor/lenna/AdminLTE/plugins/jquery-validation/localization/messages_zh_TW.min.js") }}"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function modelAppend() {
            $('#modelAppend').modal("show");
        }

        function modelMenu(roleId) {
            // https://www.aiwalls.com/javascript%E7%B7%A8%E7%A8%8B%E6%95%99%E5%AD%B8/25/40445.html
            let submitUrl = "{{ route('admin.role.menu.edit',['']) }}/" + roleId;
            $('#formMenuEdit').attr("action",submitUrl);
            $('#menuEditForm').jstree("destroy");
            $('#menuEditForm').data('jstree', false).empty();
            // @see https://www.itread01.com/content/1547911105.html
            $('#menuEditForm').jstree(
                {
                    "plugins" : [ "wholerow", "checkbox" ],
                    "core" : {
                        "data":{
                            "url": "{{ route('admin.role.menu.index',[""]) }}/" + roleId
                        },
                        "themes":{
                            "icons":false
                        }
                    },
                    "checkbox" : {
                        "keep_selected_style" : false
                    }
                }
            );
            $('#modelMenuEdit').modal('show');
        }

        function submitRoleMenu() {
            // 抓取所有已經勾選節點資料
            // https://stackoverflow.com/questions/18268306/how-to-get-checked-nodes-in-jquery-jstree/26732396
            let checkedMenu = $('#menuEditForm').jstree(true).get_selected();
            let submitUrl   = $('#formMenuEdit').attr("action");

            $.ajax({
                url: submitUrl,
                method: "POST",
                data: {
                    _method: "PATCH",
                    menuIds: checkedMenu
                },
                success: function () {
                    Swal.fire({
                        title: "{{ __('lenna-admin::role.ajax.success') }}",
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false
                    })
                    $('#modelMenuEdit').modal('hide');
                }
            });
        }

        function modelEdit(id) {
            let editUrl = "{{ route('admin.role.update',['']) }}/" + id;
            let fetchDataUrl = "{{ route('admin.role.find',['']) }}/" + id;

            $.ajax({
                url: fetchDataUrl,
                method: "GET",
                success: function (data) {
                    // console.debug(data);
                    $("#formEdit").attr("action", editUrl);
                    $("#editRoleName").val(data.result.name);
                    $('#modelEdit').modal("show");
                }
            });
        }

        $('#formAppend').validate({
            submitHandler: function (form) {
                console.log("action: " + $(form).attr("action"));
                $.ajax({
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    method: "POST",
                    success: function () {
                        Swal.fire({
                            title: "{{ __('lenna-admin::role.ajax.success') }}",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        })
                        setTimeout(function () {
                            location.reload();
                        },3000);
                    },
                    error: function() {

                    }
                })
            }
        })

        $('#formEdit').validate({
            submitHandler: function (form) {
                console.log("action: " + $(form).attr("action"));
                $.ajax({
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    method: "POST",
                    success: function () {
                        Swal.fire({
                            title: "{{ __('lenna-admin::role.ajax.success') }}",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        })
                        $('#modelEdit').modal("hide");
                        setTimeout(function () {
                            location.reload();
                        },3000);
                    },
                    error: function() {

                    }
                })
            }
        })

        function actionDestroy(id) {
            if (confirm("Sure?")) {
                $.ajax({
                    url: '{{ route("admin.role.destroy",['']) }}/'+id,
                    method: "DELETE",
                    success: function () {
                        Swal.fire({
                            title: "{{ __('lenna-admin::role.ajax.success') }}",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        })
                        setTimeout(function () {
                            location.reload();
                        },3000);
                    },
                    error: function() {

                    }
                })
            }
        }
    </script>
@endsection




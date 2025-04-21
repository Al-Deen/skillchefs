@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <div class="page-content">

        {{-- bradecrumb Area S t a r t --}}
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <h4 class="bradecrumb-title mb-1">{{ $data['title'] }}</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('common.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ $data['title'] }}</a></li>
                            <li class="breadcrumb-item">{{ ___('common.edit') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-header">
                <h4>{{ ___('common.edit') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', @$data['user']->id) }}" enctype="multipart/form-data" method="post"
                    id="visitForm">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('common.name') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('name') is-invalid @enderror" name="name"
                                        value="{{ @$data['user']->name }}" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('common.Enter Name') }}">
                                    @error('name')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">{{ ___('common.email') }} <span
                                            class="fillable">*</span></label>
                                    <input type="email" name="email"
                                        class="form-control ot-input @error('email') is-invalid @enderror"
                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                        placeholder="{{ ___('common.enter_your_email') }}"
                                        value="{{ @$data['user']->email }}">
                                    <div id="emailHelp" class="form-text">
                                        {{ ___('users_roles.we_ll_never_share_your_email_with_anyone_else') }}
                                    </div>
                                    @error('email')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label ">{{ ___('common.password') }}
                                        <span class="fillable"></span></label>
                                    <input type="password" name="password"
                                        class="form-control ot-input @error('password') is-invalid @enderror"
                                        id="exampleInputPassword1" placeholder="{{ ___('common.enter_your_password') }}"
                                        value="">
                                    @error('password')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ ___('common.phone_number') }} <span
                                            class="fillable">*</span></label>
                                    <input type="text" name="phone"
                                        class="form-control ot-input @error('phone') is-invalid @enderror"
                                        placeholder="{{ ___('common.enter_your_phone_number') }}"
                                        value="{{ @$data['user']->phone }}">
                                    @error('phone')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="mb-3">

                                        {{-- File Uplode --}}
                                        <label class="form-label" for="inputImage">{{ ___('common.image') }}</label>
                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text" placeholder="{{ ___('common.image') }}" readonly="" id="placeholder">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary" for="fileBrouse">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control" name="image" id="fileBrouse" accept="image/*">
                                            </button>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12">

                                    {{-- Status --}}
                                    <label for="validationServer04" class="form-label">{{ ___('common.status') }} <span class="fillable">*</span></label>

                                    <select class="nice-select niceSelect bordered_style wide @error('status') is-invalid @enderror"
                                    name="status" id="validationServer04"
                                    aria-describedby="validationServer04Feedback">

                                        <option value="{{ App\Enums\Status::ACTIVE }}"
                                            {{ @$data['user']->status == App\Enums\Status::ACTIVE ? 'selected' : '' }}>
                                            {{ ___('common.active') }}
                                        </option>
                                        <option value="{{ App\Enums\Status::INACTIVE }}"
                                            {{ @$data['user']->status == App\Enums\Status::INACTIVE ? 'selected' : '' }}>
                                            {{ ___('common.inactive') }}
                                        </option>
                                    </select>
                                    @error('status')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="role-permisssion-control ">
                                <div class="row">
                                    <div class="col-md-12 mb-10">
                                        {{-- Status --}}
                                        <label for="validationServer04 " class="form-label mb-10">{{ ___('users_roles.roles') }}</label>

                                        <select class="nice-select niceSelect bordered_style wide @error('role') is-invalid @enderror change-role"
                                        name="role" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                            <option value="">{{ ___('users_roles.select_role') }}</option>
                                            @foreach ($data['roles'] as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ $role->id == $data['user']->role_id ? 'selected' : '' }}>
                                                    {{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>
                                </div>
                                <!-- table content start  -->
                                <div class="table-container scroll-table2-active pt-16">
                                    <!-- table container start  -->
                                    <div class="table-responsive">
                                        <!-- table start  -->
                                        <table class="ot-basic-table ot-table-bg" id="permissions-table">
                                            <thead>
                                                <th class="user_roles_border border-0 text-capitalize">{{ ___('users_roles.module_module_links') }}</th>
                                                <th class="user_roles_permission border-0 text-capitalize">{{ ___('users_roles.Permissions') }}</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['permissions'] as $permission)
                                                    <tr>
                                                        <td>{{ ___('users_roles.'.$permission->attribute) }}</td>
                                                        <td>
                                                            <div class="permission-list-td">
                                                                @foreach ($permission->keywords as $key => $keyword)
                                                                    <div class="input-check-radio">
                                                                        <div class="form-check d-flex align-items-center">
                                                                            @if ($keyword != '')
                                                                                <input type="checkbox"
                                                                                    class="form-check-input mt-0 mr-4 read common-key"
                                                                                    name="permissions[]"
                                                                                    value="{{ $keyword }}"
                                                                                    id="{{ $keyword }}"
                                                                                    {{ in_array($keyword, @$data['user']->permissions ?? []) ? 'checked' : '' }}>
                                                                                <label class="custom-control-label"
                                                                                    for="{{ $keyword }}">{{ ___('users_roles.'.$key) }}</label>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <!-- table end  -->
                                    </div>
                                    <!-- table container end  -->
                                </div>
                                <!-- table content end -->
                            </div>

                        </div>

                        <div class="col-md-12 mt-24">
                            <div class="text-end">
                                <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                    </span>{{ ___('common.update') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

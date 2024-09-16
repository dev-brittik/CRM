@extends('layouts.admin')

@section('content')
    <div class="ol-card radius-8px print-d-none">
        <div class="ol-card-body my-3 py-3 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ 'Manage role' }}
                </h4>
                <button onclick="rightCanvas('{{ route(get_current_user_role() . '.roles.create') }}', 'Create role')"
                    class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add new') }}</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Start Admin area -->
    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <div class="row">
                        @foreach ($roles as $role)
                            <div class="col-4">
                                <h6>{{ $role->title }}</h6>
                                <div class="d-flex flex-column gap-2 pt-3">
                                    @php
                                        $assigned_permissions = $role->permissions
                                            ? json_decode($role->permissions, true)
                                            : [];
                                        $permissions = \App\Models\Permission::get();
                                    @endphp

                                    @foreach ($permissions as $permission)
                                        <div class="form-check form-check-radio">
                                            <input type="checkbox" id="{{ $role->slug }}-{{ $permission->id }}"
                                                class="form-check-input" @if (in_array($permission->id, $assigned_permissions)) checked @endif
                                                onchange="ajaxCall('{{ route(get_current_user_role() . '.store.permissions', [$role->id, $permission->id]) }}')">

                                            <label
                                                class="form-check-label-checkbox text-capitalize sub-title fw-medium w-100"
                                                for="{{ $role->slug }}-{{ $permission->id }}">{{ $permission->title }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Admin area -->
@endsection

@include('ajax')
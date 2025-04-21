<li class="sidebar-menu-item">
    <a class="parent-item-content has-arrow">
        <i class="las la-building"></i> <span class="on-half-expanded">{{ ___('backend_sidebar.Organization') }}</span>
        <span class="badge badge-danger text-white">{{ ___('addon.Addon') }}</span>
    </a>
    <!-- second layer child menu list start  -->
    <ul class="child-menu-list">
        {{-- Start requested organization --}}
        @if (hasPermission('organization_request_list'))
            <li class="sidebar-menu-item {{ set_menu(['organization.admin.requests']) }}">
                <a
                    href="{{ route('organization.admin.requests') }}">{{ ___('organization.Requested Organization') }}</a>
            </li>
        @endif
        {{-- End requested organization --}}
        {{-- Start suspended organization --}}
        @if (hasPermission('organization_suspend_list'))
            <li class="sidebar-menu-item {{ set_menu(['organization.admin.suspends']) }}">
                <a
                    href="{{ route('organization.admin.suspends') }}">{{ ___('organization.Suspended Organization') }}</a>
            </li>
        @endif
        {{-- End suspended organization --}}
        {{-- Start organization list --}}
        @if(hasPermission('organization_read'))
        <li class="sidebar-menu-item {{ set_menu(['organization.admin.index', 'admin/organization/edit/*']) }}">
            <a href="{{ route('organization.admin.index') }}">{{ ___('organization.Organization List') }}</a>
        </li>
        @endif
        {{-- End organization create --}}
        {{-- Start organization create --}}
        @if(hasPermission('organization_create'))
        <li class="sidebar-menu-item {{ set_menu(['organization.admin.create']) }}">
            <a href="{{ route('organization.admin.create') }}">{{ ___('organization.Create Organization') }}</a>
        </li>
        @endif
        {{-- End organization create --}}
    </ul>
</li>

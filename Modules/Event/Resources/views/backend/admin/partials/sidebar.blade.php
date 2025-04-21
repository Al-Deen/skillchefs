<li class="sidebar-menu-item {{ set_menu(['event*']) }}">
    <a class="parent-item-content has-arrow">
        <i class="las la-calendar-plus"></i>
        <span class="on-half-expanded">{{ ___('event.Event') }}</span>
        <span class="badge badge-danger text-white">{{ ___('addon.Addon') }}</span>
    </a>
    <ul class="child-menu-list">
        @if (hasPermission('requested_event_list'))
            <li class="sidebar-menu-item {{ set_menu(['event.admin.requested_event']) }}">
                <a href="{{ route('event.admin.requested_event') }}">{{ ___('event.Requested Events') }}</a>
            </li>
        @endif
        @if (hasPermission('approved_event_list'))
            <li class="sidebar-menu-item {{ set_menu(['event.admin.approved_event','event.admin.create','admin/event/manage/edit*','admin/event/index*']) }}">
                <a href="{{ route('event.admin.approved_event') }}">{{ ___('event.Approved Events') }}</a>
            </li>
        @endif
        @if (hasPermission('rejected_event_list'))
            <li class="sidebar-menu-item {{ set_menu(['event.admin.rejected_event']) }}">
                <a href="{{ route('event.admin.rejected_event') }}">{{ ___('event.Rejected Events') }}</a>
            </li>
        @endif
        @if (hasPermission('event_category_read'))
            <li class="sidebar-menu-item {{ set_menu(['event.category.index']) }}">
                <a href="{{ route('event.category.index') }}">{{ ___('event.Event Category') }}</a>
            </li>
        @endif
        @if (hasPermission('purchase_booking'))
            <li class="sidebar-menu-item {{ set_menu(['event.admin.purchase_booking', 'event.admin.purchase_booking.participants']) }}">
                <a href="{{ route('event.admin.purchase_booking') }}">{{ ___('event.Sale Events') }}</a>
            </li>
        @endif
    </ul>
</li>

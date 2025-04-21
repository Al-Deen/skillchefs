<li class="sidebar-menu-item">
    <a class="parent-item-content has-arrow">
        <i class="las la-hand-holding-usd"></i>
        <span class="on-half-expanded">{{ ___('offline.Offline Payment') }}</span>
    </a>
    <!-- second layer child menu list start  -->
    <ul class="child-menu-list">
        @if (hasPermission('offline_payment_settings'))
            <li class="sidebar-menu-item {{ set_menu(['admin.offline_payment.settings']) }}">
                <a href="{{ route('admin.offline_payment.settings') }}">{{ ___('offline.Settings') }}</a>
            </li>
        @endif
        @if (hasPermission('course_enroll_approval'))
            <li class="sidebar-menu-item {{ set_menu(['admin.course.enroll.approval']) }}">
                <a href="{{ route('admin.course.enroll.approval') }}">{{ ___('offline.Course') }}</a>
            </li>
        @endif
        @if (module('Event') && hasPermission('event_enroll_approval'))
            <li class="sidebar-menu-item {{ set_menu(['admin.event.enroll.approval']) }}">
                <a href="{{ route('admin.event.enroll.approval') }}">{{ ___('offline.Event') }}</a>
            </li>
        @endif
        @if (module('Subscription') && hasPermission('package_enroll_approval'))
            <li class="sidebar-menu-item {{ set_menu(['admin.package.enroll.approval']) }}">
                <a href="{{ route('admin.package.enroll.approval') }}">{{ ___('offline.package') }}</a>
            </li>
        @endif
    </ul>
</li>

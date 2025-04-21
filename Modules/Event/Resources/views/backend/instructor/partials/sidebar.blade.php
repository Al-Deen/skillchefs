<li class="list has-children {{ is_active(['instructor.event.index', 'instructor.event.registered'], 'open show') }}">
    <a href="javascript:void(0)" class="single">
        <i class="ri-calendar-2-line"></i>
        {{ ___('event.Events') }}
    </a>
    <ul class="submenu">
        <li class="list {{ is_active(['instructor.event.index'], 'selected') }}">
            <a href="{{ route('instructor.event.index') }}" class="child-single">
                {{ ___('event.My Events') }}
            </a>
        </li>
        <li class="list {{ is_active(['instructor.event.registered'], 'selected') }}">
            <a href="{{ route('instructor.event.registered') }}" class="child-single">
                {{ ___('event.Registered Events') }}
            </a>
        </li>
    </ul>
</li>

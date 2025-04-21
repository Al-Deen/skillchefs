<!-- profile menu mobile start -->
<div class="profile-content">
    <div class="profile-menu-mobile">
        <button class="btn-menu-mobile" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptionsMenuMobile" aria-controls="offcanvasWithBothOptionsMenuMobile">
            <span class="icon"><i class="fa-solid fa-bars"></i></span>
        </button>
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptionsMenuMobile">
            <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    <span class="icon"><i class="fa-solid fa-xmark"></i></span>
                </button>
            </div>
            <div class="offcanvas-body">
                <!-- profile menu start -->
                <div class="profile-menu">
                    <!-- profile menu head start -->
                    <div class="profile-menu-head">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="body">
                                    <h5 class="title">{{ @$data['title'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- profile menu head end -->
                    <!-- profile menu body start -->
                    <div class="profile-menu-body">
                        <nav>
                            <ul class="nav flex-column">
                                <li class="nav-item dropdown">
                                    <a class="nav-link {{ menu_active_by_url(route('event.admin.edit', [$data['event']->id])) }}"
                                        href="{{ route('event.admin.edit', [$data['event']->id]) }}">
                                        {{ ___('common.General') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  {{ menu_active_by_url(route('event.admin.speaker.index', [$data['event']->id])) }}"
                                        href="{{ route('event.admin.speaker.index', [$data['event']->id]) }}">
                                        {{ ___('Instructor.Speakers') }}
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link  {{ menu_active_by_url(route('event.admin.organizer.index', [$data['event']->id])) }}"
                                        href="{{ route('event.admin.organizer.index', [$data['event']->id]) }}">
                                        {{ ___('Instructor.Organizers') }}
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link  {{ menu_active_by_url(route('event.admin.schedule.index', [$data['event']->id]), route('event.admin.schedules_timeline.index', [$data['event']->id])) }}"
                                        href="{{ route('event.admin.schedule.index', [$data['event']->id]) }}">
                                        {{ ___('Instructor.Schedules') }}
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!-- profile menu body end -->
                </div>
                <!-- profile menu end -->
            </div>
        </div>
    </div>
</div>

<!-- profile menu mobile end -->
<div class="new-profile-content">
    <div class="profile-menu">
        <div class="table-basic table-content mb-24">
            <div class="card">
                <div class="card-body">
                    <div class="profile-menu-head">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="body">
                                    <h5 class="title text-capitalize">{{ @$data['title'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- profile menu body start -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-basic table-content">
                    <div class="card mb-3 bg-gray">
                        <div class="card-body p-2 pb-0">
                            <nav>
                                <ul class="nav nav-pills">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link {{ menu_active_by_url(route('event.admin.edit', [$data['event']->id])) }}"
                                            href="{{ route('event.admin.edit', [$data['event']->id]) }}">
                                            {{ ___('common.General') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link  {{ menu_active_by_url(route('event.admin.speaker.index', [$data['event']->id])) }}"
                                            href="{{ route('event.admin.speaker.index', [$data['event']->id]) }}">
                                            {{ ___('Instructor.Speakers') }}
                                        </a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link  {{ menu_active_by_url(route('event.admin.organizer.index', [$data['event']->id])) }}"
                                            href="{{ route('event.admin.organizer.index', [$data['event']->id]) }}">
                                            {{ ___('Instructor.Organizers') }}
                                        </a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link  {{ menu_active_by_url(route('event.admin.schedule.index', [$data['event']->id]))}}"
                                            href="{{ route('event.admin.schedule.index', [$data['event']->id]) }}">
                                            {{ ___('Instructor.Schedules') }}
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- profile menu body end -->
    </div>
</div>

<div class="col-xl-12 col-lg-12 col-md-6 col-sm-2">
    <div class="multiStep-wrapper  border-bottom table-responsive">
        <div class="multiStep-wrapper-flex">
            <div class="multiStep-wrapper-left h-calc radius-8">
                <ul class="step-list-wrapper list-style-none d-flex ">
                    @if (hasPermission('course_curriculum'))
                        <li class="single-step-list-step tab1 current-items">
                            <span
                                class="single-multiStep-request-list-item-number {{ url()->current() === route('course.edit', [$data['course']->id, 'content']) ? 'active' : '' }}">
                                <a class="single-wrap"
                                    href="{{ route('course.edit', [$data['course']->id, 'content']) }}">
                                    <i class="las la-dice"></i>
                                    <span>{{ ___('course.Content') }}</span>
                                </a>
                            </span>
                        </li>
                    @endif
                    @if (hasPermission('course_assignment_list'))
                    <li class="single-step-list-step tab2">
                        <span
                            class="single-multiStep-request-list-item-number {{ url()->current() === route('course.edit', [$data['course']->id, 'assignment']) || url()->current() === route('course.edit', [$data['course']->id, 'assignment-create']) || (@$data['assignment'] && url()->current() === route('course.assignment.edit', [@$data['assignment']->id])) ? 'active' : '' }} ">
                            <a class="single-wrap"
                                href="{{ route('course.edit', [$data['course']->id, 'assignment']) }}">
                                <i class="las la-dice"></i>
                                <span>{{ ___('course.Assignment') }}</span>
                            </a>
                        </span>
                    </li>
                    @endif
                    @if (hasPermission('course_noticeboard_list'))
                    <li class="single-step-list-step tab3">
                        <span
                            class="single-multiStep-request-list-item-number {{ url()->current() === route('course.edit', [$data['course']->id, 'noticeboard']) || url()->current() === route('course.edit', [$data['course']->id, 'noticeboard-create']) || (@$data['noticeboard'] && url()->current() === route('course.noticeboard.edit', [@$data['noticeboard']->id])) ? 'active' : '' }} ">
                            <a class="single-wrap"
                                href="{{ route('course.edit', [$data['course']->id, 'noticeboard']) }}">
                                <i class="las la-dice"></i>
                                <span>{{ ___('course.NoticeBoard') }}</span>
                            </a>
                        </span>
                    </li>
                    @endif

                    <li class="single-step-list-step tab4 ">
                        <span
                            class="single-multiStep-request-list-item-number {{ url()->current() === route('course.edit', [$data['course']->id, 'general']) ? 'active' : '' }} ">
                            <a class="single-wrap" href="{{ route('course.edit', [$data['course']->id, 'general']) }}">
                                <i class="las la-dice"></i>
                                <span>{{ ___('course.General') }}</span>
                            </a>
                        </span>
                    </li>
                    <li class="single-step-list-step tab5">
                        <span
                            class="single-multiStep-request-list-item-number {{ url()->current() === route('course.edit', [$data['course']->id, 'requirements']) ? 'active' : '' }} ">
                            <a class="single-wrap"
                                href="{{ route('course.edit', [$data['course']->id, 'requirements']) }}">
                                <i class="las la-dice"></i>
                                <span>{{ ___('course.Requirements') }}</span>
                            </a>
                        </span>
                    </li>
                    <li class="single-step-list-step tab6">
                        <span
                            class="single-multiStep-request-list-item-number {{ url()->current() === route('course.edit', [$data['course']->id, 'price']) ? 'active' : '' }} ">
                            <a class="single-wrap" href="{{ route('course.edit', [$data['course']->id, 'price']) }}">
                                <i class="las la-dice"></i>
                                <span>{{ ___('course.Price') }}</span>
                            </a>
                        </span>
                    </li>
                    <li class="single-step-list-step tab7">
                        <span
                            class="single-multiStep-request-list-item-number {{ url()->current() === route('course.edit', [$data['course']->id, 'media']) ? 'active' : '' }} ">
                            <a class="single-wrap" href="{{ route('course.edit', [$data['course']->id, 'media']) }}">
                                <i class="las la-dice"></i>
                                <span>{{ ___('course.Media') }}</span>
                            </a>
                        </span>
                    </li>
                    <li class="single-step-list-step tab8">
                        <span
                            class="single-multiStep-request-list-item-number {{ url()->current() === route('course.edit', [$data['course']->id, 'seo']) ? 'active' : '' }} ">
                            <a class="single-wrap" href="{{ route('course.edit', [$data['course']->id, 'seo']) }}">
                                <i class="las la-dice"></i>
                                <span>{{ ___('course.SEO') }}</span>
                            </a>
                        </span>
                    </li>
                    <li class="single-step-list-step tab9">
                        <span
                            class="single-multiStep-request-list-item-number {{ url()->current() === route('course.edit', [$data['course']->id, 'complete']) ? 'active' : '' }} ">
                            <a class="single-wrap"
                                href="{{ route('course.edit', [$data['course']->id, 'complete']) }}">
                                <i class="las la-dice"></i>
                                <span>{{ ___('course.Complete') }}</span>
                            </a>
                        </span>
                    </li>
                </ul>
            </div>


        </div>
    </div>
</div>

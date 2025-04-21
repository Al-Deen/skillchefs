<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <a href="{{ route('dashboard') }}">
                <img id="sidebar_full_logo" class="full-logo logo_custom setting-image w-100"
                    src="{{ @showImage(setting('light_logo'), 'logo.png') }}" alt="img" />
                <img class="half-logo" src="{{ showImage(setting('favicon'), 'favicon.png') }}" alt="img" />
            </a>
        </div>
        <button class="close-toggle sidebar-toggle arrow-toggle-btn">
            <i class="las la-angle-double-left"></i>
        </button>
    </div>


    {{-- Sidebar Menu --}}
    <div class="sidebar-menu sidebar_scrollbar_active" id="sidebar_scroll">

        <div class="sidebar-menu-section">
            <!-- parent menu list start  -->
            <ul class="sidebar-dropdown-menu parent-menu-list">
                <li class="sidebar-menu-item {{ set_menu(['dashboard*']) }}">
                    <a href="{{ route('dashboard') }}" class="parent-item-content">
                        <i class="las la-home"></i>
                        <span class="on-half-expanded">{{ ___('backend_sidebar.dashboard') }}</span>
                    </a>
                </li>
                @if (hasPermission('user_read') || hasPermission('role_read'))
                    <li class="sidebar-menu-item">
                        <a class="parent-item-content has-arrow">
                            <i class="las la-user-tag"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.Staffs') }}</span>
                        </a>

                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">
                            @if (hasPermission('role_read'))
                                <li class="sidebar-menu-item {{ set_menu(['roles*']) }}">
                                    <a href="{{ route('roles.index') }}">{{ ___('users_roles.roles') }}</a>
                                </li>
                            @endif
                            @if (hasPermission('user_read'))
                                <li class="sidebar-menu-item {{ set_menu(['users*']) }}">
                                    <a href="{{ route('users.index') }}">{{ ___('users_roles.users') }}</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- start Ai  --}}
                @if (hasPermission('ai_support'))
                    <li class="sidebar-menu-item {{ set_menu(['admin.ai-support.index']) }}">
                        <a href="{{ route('admin.ai-support.index') }}" class="parent-item-content">
                            <i class="las la-sms"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.AI_Support') }}</span>
                        </a>
                    </li>
                @endif
                {{-- end Ai  --}}

                {{-- start Course  --}}
                @if (hasPermission('course_read') || hasPermission('course_category_read'))

                    <li class="sidebar-menu-item">
                        <a class="parent-item-content has-arrow">
                            <i class="las la-book-open"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.Courses') }}</span>
                        </a>

                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">
                            @if (hasPermission('course_category_read'))
                                <li class="sidebar-menu-item {{ set_menu(['category.index', 'admin/category*']) }}">
                                    <a
                                        href="{{ route('course-category.index') }}">{{ ___('course.Categories List') }}</a>
                                </li>
                            @endif
                            @if (hasPermission('course_read'))
                                <li class="sidebar-menu-item {{ set_menu(['admin/course*', 'admin/live-class/*']) }}">
                                    <a href="{{ route('course.index') }}">{{ ___('course.Courses List') }}</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                {{-- end Course  --}}


                {{-- live classes  --}}
                @if (module('LiveClass') && hasPermission('live_class_settings_read'))
                    <li class="sidebar-menu-item">
                        <a class="parent-item-content has-arrow">
                            <i class="las la-video"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.Live_classes') }}</span>
                            @if (env('APP_DEMO'))
                                <span class="badge badge-danger text-white">{{ ___('addon.Addon') }}</span>
                            @endif
                        </a>
                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">
                            <li class="sidebar-menu-item {{ set_menu(['admin/all-course-live-class*']) }}">
                                <a
                                    href="{{ route('live_class.course_all.index') }}">{{ ___('course.Live Class List') }}</a>
                            </li>
                            <li class="sidebar-menu-item {{ set_menu(['live_class_settings.index']) }}">
                                <a
                                    href="{{ route('live_class_settings.index') }}">{{ ___('course.Live Class Settings') }}</a>
                            </li>
                        </ul>
                    </li>
                @endif
                {{-- live classes  --}}


                {{-- start Assignment  --}}
                @if (hasPermission('course_assignment_list'))
                    <li class="sidebar-menu-item">
                        <a class="parent-item-content has-arrow">
                            <i class="las la-book-reader"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.Assignment') }}</span>
                        </a>

                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">
                            @if (hasPermission('course_assignment_list'))
                                <li
                                    class="sidebar-menu-item {{ set_menu(['admin/assignment/list', 'admin/assignment/submission-list/*']) }}">
                                    <a
                                        href="{{ route('course.assignment_list.index') }}">{{ ___('course.Assignment List') }}</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                {{-- end Assignment  --}}

                {{-- start Quizzes  --}}
                @if (hasPermission('course_quiz_list'))
                    <li class="sidebar-menu-item">
                        <a class="parent-item-content has-arrow">
                            <i class="las la-pen-alt"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.Quizzes') }}</span>
                        </a>

                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">
                            @if (hasPermission('course_quiz_list'))
                                <li
                                    class="sidebar-menu-item {{ set_menu(['admin/quiz/list', 'admin/quiz/submission-list/*']) }}">
                                    <a href="{{ route('admin.quiz.index') }}">{{ ___('course.Quiz Lists') }}</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                {{-- end Quizzes  --}}

                {{-- start enrollment  --}}
                @if (hasPermission('enroll_list'))
                    <li class="sidebar-menu-item">
                        <a class="parent-item-content has-arrow">
                            <i class="las la-wallet"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.Enrollment') }}</span>
                        </a>

                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">
                            @if (hasPermission('enroll_list'))
                                <li class="sidebar-menu-item {{ set_menu(['admin/enroll*']) }}">
                                    <a
                                        href="{{ route('admin.enroll.index') }}">{{ ___('backend_sidebar.Enrollment List') }}</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                {{-- end enrollment  --}}

                {{-- start certificate --}}
                @if (hasPermission('certificate_list') || hasPermission('certificate_template_list'))
                    <li class="sidebar-menu-item">
                        <a class="parent-item-content has-arrow">
                            <i class="las la-certificate"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.Certificate') }}</span>
                        </a>

                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">
                            @if (hasPermission('certificate_list'))
                                <li
                                    class="sidebar-menu-item {{ set_menu(['admin.certificate.index', 'admin/certificate/view*']) }}">
                                    <a
                                        href="{{ route('admin.certificate.index') }}">{{ ___('backend_sidebar.Certificate List') }}</a>
                                </li>
                            @endif
                            @if (hasPermission('certificate_template_list'))
                                <li
                                    class="sidebar-menu-item {{ set_menu(['admin.certificate.template.index', 'admin/certificate/template*']) }}">
                                    <a
                                        href="{{ route('admin.certificate.template.index') }}">{{ ___('backend_sidebar.Certificate Template') }}</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                {{-- end certificate --}}

                {{-- start Organization --}}
                @if (module('Organization') && (hasPermission('organization_create') || hasPermission(' organization_read')))
                    @include('organization::panel.organization.partials.sidebar')
                @endif
                {{-- end Organization --}}

                {{-- start Instructors --}}
                @if (hasPermission('instructor_list') || hasPermission('course_category_read'))
                    <li class="sidebar-menu-item">
                        <a class="parent-item-content has-arrow">
                            <i class="las la-chalkboard-teacher"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.Instructors') }}</span>
                        </a>

                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">

                            @if (hasPermission('instructor_list'))
                                <li class="sidebar-menu-item {{ set_menu(['admin.instructor.requests']) }}">
                                    <a
                                        href="{{ route('admin.instructor.requests') }}">{{ ___('backend_sidebar.Requested Instructor') }}</a>
                                </li>
                            @endif
                            @if (hasPermission('instructor_suspend_list'))
                                <li class="sidebar-menu-item {{ set_menu(['admin.instructor.suspends']) }}">
                                    <a
                                        href="{{ route('admin.instructor.suspends') }}">{{ ___('backend_sidebar.Suspended Instructor') }}</a>
                                </li>
                            @endif

                            @if (hasPermission('instructor_list'))
                                <li
                                    class="sidebar-menu-item {{ set_menu(['admin.instructor.index', 'admin/instructor/edit/*']) }}">
                                    <a
                                        href="{{ route('admin.instructor.index') }}">{{ ___('backend_sidebar.Instructor List') }}</a>
                                </li>
                            @endif

                            @if (hasPermission('instructor_create'))
                                <li class="sidebar-menu-item {{ set_menu(['admin.instructor.create']) }}">
                                    <a
                                        href="{{ route('admin.instructor.create') }}">{{ ___('backend_sidebar.Create Instructor') }}</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                {{-- end Instructors --}}
                {{-- start Students --}}
                @if (hasPermission('student_list'))
                    <li class="sidebar-menu-item">
                        <a class="parent-item-content has-arrow">
                            <i class="las la-male"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.Students') }}</span>
                        </a>

                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">
                            @if (hasPermission('student_list'))
                                <li
                                    class="sidebar-menu-item {{ set_menu(['admin.student.index', 'admin/student/edit/*']) }}">
                                    <a
                                        href="{{ route('admin.student.index') }}">{{ ___('backend_sidebar.Student List') }}</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                {{-- end Students --}}

                {{-- start Reviews --}}
                @if (hasPermission('review_list'))
                    <li class="sidebar-menu-item">
                        <a class="parent-item-content has-arrow">
                            <i class="las la-medal"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.Reviews') }}</span>
                        </a>

                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">
                            @if (hasPermission('review_list'))
                                <li class="sidebar-menu-item {{ set_menu(['admin.review.index']) }}">
                                    <a href="{{ route('admin.review.index') }}">{{ ___('course.Review List') }}</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                {{-- end Reviews --}}


                {{-- start Payouts  --}}
                @if (hasPermission('instructor_payout_request_list') ||
                        hasPermission('instructor_payout_list') ||
                        hasPermission('instructor_rejected_payout_list') ||
                        hasPermission('instructor_unpaid_payout_list'))

                    <li class="sidebar-menu-item">
                        <a class="parent-item-content has-arrow">
                            <i class="lab la-amazon-pay"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.Payouts') }}</span>
                        </a>

                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">
                            @if (hasPermission('instructor_payout_request_list'))
                                <li class="sidebar-menu-item {{ set_menu(['admin.instructor.payout.request']) }}">
                                    <a
                                        href="{{ route('admin.instructor.payout.request') }}">{{ ___('instructor.Request Payouts List') }}</a>
                                </li>
                            @endif
                            @if (hasPermission('instructor_unpaid_payout_list'))
                                <li class="sidebar-menu-item {{ set_menu(['admin.instructor.payout.unpaid']) }}">
                                    <a
                                        href="{{ route('admin.instructor.payout.unpaid') }}">{{ ___('instructor.Unpaid Payouts List') }}</a>
                                </li>
                            @endif
                            @if (hasPermission('instructor_rejected_payout_list'))
                                <li class="sidebar-menu-item {{ set_menu(['admin.instructor.payout.rejected']) }}">
                                    <a
                                        href="{{ route('admin.instructor.payout.rejected') }}">{{ ___('instructor.Rejected Payouts List') }}</a>
                                </li>
                            @endif
                            @if (hasPermission('instructor_payout_list'))
                                <li
                                    class="sidebar-menu-item {{ set_menu(['admin.instructor.payout.index', 'admin/instructor/payout-details/*']) }}">
                                    <a
                                        href="{{ route('admin.instructor.payout.index') }}">{{ ___('instructor.Payouts List') }}</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                {{-- end Payouts  --}}

                {{-- start offline payment  --}}
                @if (module('Offline') &&
                        (hasPermission('course_enroll_approval') ||
                            hasPermission('event_enroll_approval') ||
                            hasPermission('package_enroll_approval')))
                    @include('offline::admin.partials.sidebar')
                @endif
                {{-- end offline payment  --}}


                {{-- start Accounts  --}}
                @if (hasPermission('income_list') ||
                        hasPermission('account_list') ||
                        hasPermission('transaction_list') ||
                        hasPermission('expense_list'))

                    <li class="sidebar-menu-item">
                        <a class="parent-item-content has-arrow">
                            <i class="las la-money-check"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.Accounts') }}</span>
                        </a>

                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">
                            @if (hasPermission('account_list'))
                                <li class="sidebar-menu-item {{ set_menu(['admin.accounts.index']) }}">
                                    <a
                                        href="{{ route('admin.accounts.index') }}">{{ ___('account.Account List') }}</a>
                                </li>
                            @endif
                            @if (hasPermission('income_list'))
                                <li class="sidebar-menu-item {{ set_menu(['admin.accounts.income.index']) }}">
                                    <a
                                        href="{{ route('admin.accounts.income.index') }}">{{ ___('account.Income List') }}</a>
                                </li>
                            @endif
                            @if (hasPermission('expense_list'))
                                <li class="sidebar-menu-item {{ set_menu(['admin.accounts.expense.index']) }}">
                                    <a
                                        href="{{ route('admin.accounts.expense.index') }}">{{ ___('account.Expense List') }}</a>
                                </li>
                            @endif
                            @if (hasPermission('transaction_list'))
                                <li class="sidebar-menu-item {{ set_menu(['admin.accounts.transaction.index']) }}">
                                    <a
                                        href="{{ route('admin.accounts.transaction.index') }}">{{ ___('account.Transaction List') }}</a>
                                </li>
                            @endif


                        </ul>
                    </li>
                @endif
                {{-- end Accounts  --}}

                {{-- start Contacts  --}}
                @if (hasPermission('contact_read'))

                    <li class="sidebar-menu-item">
                        <a class="parent-item-content has-arrow">
                            <i class="lar la-address-book"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.Contacts') }}</span>
                        </a>

                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">
                            @if (hasPermission('contact_read'))
                                <li
                                    class="sidebar-menu-item {{ set_menu(['admin.contacts.index', 'admin/contacts/*']) }}">
                                    <a
                                        href="{{ route('admin.contacts.index') }}">{{ ___('backend_sidebar.Contacts') }}</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                {{-- end Contacts  --}}

                {{-- start Marketing  --}}
                @if (hasPermission('featured_course_list') || hasPermission('discount_course_list'))

                    <li class="sidebar-menu-item">
                        <a class="parent-item-content has-arrow">
                            <i class="lab la-hubspot"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.Marketing') }}</span>
                        </a>

                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">

                            @if (hasPermission('featured_course_list'))
                                <li class="sidebar-menu-item {{ set_menu(['admin.featured-course.index']) }}">
                                    <a
                                        href="{{ route('admin.featured-course.index') }}">{{ ___('course.Featured Course List') }}</a>
                                </li>
                            @endif

                            @if (hasPermission('discount_course_list'))
                                <li class="sidebar-menu-item {{ set_menu(['admin.discount-course.index']) }}">
                                    <a
                                        href="{{ route('admin.discount-course.index') }}">{{ ___('course.Discount Course List') }}</a>
                                </li>
                            @endif


                        </ul>
                    </li>
                @endif
                {{-- end Marketing  --}}
                {{-- start Reports  --}}
                @if (hasPermission('report_student_engagement') ||
                        hasPermission('report_purchase_history') ||
                        hasPermission('report_course_completion') ||
                        hasPermission('report_student_performance') ||
                        hasPermission('report_admin_revenue') ||
                        hasPermission('report_instructor_engagement'))

                    <li class="sidebar-menu-item">
                        <a class="parent-item-content has-arrow">
                            <i class="las la-bug"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.Reports') }}</span>
                        </a>

                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">

                            @if (hasPermission('report_student_engagement'))
                                <li class="sidebar-menu-item {{ set_menu(['report.student-engagement']) }}">
                                    <a
                                        href="{{ route('report.student-engagement') }}">{{ ___('report.Student_Engagement') }}</a>
                                </li>
                            @endif

                            @if (hasPermission('report_instructor_engagement'))
                                <li class="sidebar-menu-item {{ set_menu(['report.instructor-engagement']) }}">
                                    <a
                                        href="{{ route('report.instructor-engagement') }}">{{ ___('report.Instructor_Engagement') }}</a>
                                </li>
                            @endif

                            @if (hasPermission('report_purchase_history'))
                                <li class="sidebar-menu-item {{ set_menu(['report.purchase-history']) }}">
                                    <a
                                        href="{{ route('report.purchase-history') }}">{{ ___('report.Purchase_History') }}</a>
                                </li>
                            @endif
                            @if (hasPermission('report_course_completion'))
                                <li class="sidebar-menu-item {{ set_menu(['report.course-completion']) }}">
                                    <a
                                        href="{{ route('report.course-completion') }}">{{ ___('report.Course_Completion') }}</a>
                                </li>
                            @endif

                            @if (hasPermission('report_student_performance'))
                                <li class="sidebar-menu-item {{ set_menu(['report.student-performance']) }}">
                                    <a
                                        href="{{ route('report.student-performance') }}">{{ ___('report.Student_Performance') }}</a>
                                </li>
                            @endif

                            @if (module('Event') && hasPermission('report_event_booking'))
                                <li class="sidebar-menu-item {{ set_menu(['report.event-booking']) }}">
                                    <a
                                        href="{{ route('report.event-booking') }}">{{ ___('report.Event Booking') }}</a>
                                </li>
                            @endif

                            @if (hasPermission('report_admin_transaction'))
                                <li class="sidebar-menu-item {{ set_menu(['report.admin_transaction']) }}">
                                    <a
                                        href="{{ route('report.admin_transaction') }}">{{ ___('report.transaction') }}</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                {{-- end Reports  --}}
                {{-- start Testimonials  --}}
                @if (hasPermission('testimonial_read') || hasPermission('testimonial_create'))

                    <li class="sidebar-menu-item">
                        <a class="parent-item-content has-arrow">
                            <i class="lab la-chromecast"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.Testimonials') }}</span>
                        </a>

                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">
                            @if (hasPermission('testimonial_read'))
                                <li
                                    class="sidebar-menu-item {{ set_menu(['admin.testimonial.index', 'admin/testimonial/edit/*']) }}">
                                    <a
                                        href="{{ route('admin.testimonial.index') }}">{{ ___('common.Testimonial List') }}</a>
                                </li>
                            @endif
                            @if (hasPermission('testimonial_create'))
                                <li class="sidebar-menu-item {{ set_menu(['admin.testimonial.create']) }}">
                                    <a
                                        href="{{ route('admin.testimonial.create') }}">{{ ___('common.Create Testimonial') }}</a>
                                </li>
                            @endif


                        </ul>
                    </li>
                @endif
                {{-- end Testimonials  --}}




                @if (hasPermission('blog_category_read') || hasPermission('blog_read'))
                    <li class="sidebar-menu-item">
                        <a class="parent-item-content has-arrow">
                            <i class="las la-dice"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.Blogs') }}</span>
                        </a>


                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">
                            {{-- Start blog category --}}
                            @if (hasPermission('blog_category_read'))
                                <li
                                    class="sidebar-menu-item {{ set_menu(['blog-category.index', 'admin/blog-category*']) }}">
                                    <a
                                        href="{{ route('blog-category.index') }}">{{ ___('blog.Blog Category') }}</a>
                                </li>
                            @endif
                            {{-- End blog category --}}


                            {{-- Start blog --}}
                            @if (hasPermission('blog_read'))
                                <li class="sidebar-menu-item {{ set_menu(['blog.index', 'admin/blog/*']) }}">
                                    <a href="{{ route('blog.index') }}">{{ ___('blog.blog') }}</a>
                                </li>
                            @endif
                            {{-- End blog --}}
                        </ul>
                    </li>
                @endif

                {{-- start Subscription  --}}
                @if (module('Subscription') &&
                        (hasPermission('package_read') ||
                            hasPermission('package_duration_type_read') ||
                            hasPermission('package_purchase_read')))
                    @include('subscription::panel.admin.partials.sidebar')
                @endif
                {{-- end Subscription  --}}

                <!-- event Layout Start -->
                @if (module('Event') &&
                        (hasPermission('requested_event_list') ||
                            hasPermission('approved_event_list') ||
                            hasPermission('rejected_event_list') ||
                            hasPermission('event_category_read') ||
                            hasPermission('purchase_booking')))
                    @include('event::backend.admin.partials.sidebar')
                @endif
                <!-- event Layout End -->

                @if (hasPermission('slider_read') ||
                        hasPermission('brand_read') ||
                        hasPermission('page_read') ||
                        hasPermission('popular_course_category_list') ||
                        hasPermission('image_gallery_read') ||
                        hasPermission('footer_menu_read'))
                    <li class="sidebar-menu-item">
                        <a class="parent-item-content has-arrow">
                            <i class="las la-link"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.Website Setup') }}</span>
                        </a>


                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">

                            {{-- Start Home slider --}}
                            @if (hasPermission('slider_read'))
                                <li class="sidebar-menu-item {{ set_menu(['slider*', 'admin/slider*']) }}">
                                    <a href="{{ route('slider.index') }}">{{ ___('slider.Slider') }}</a>
                                </li>
                            @endif
                            {{-- End Home slider --}}
                            {{-- Start Popular Categories --}}
                            @if (hasPermission('popular_course_category_list'))
                                <li class="sidebar-menu-item {{ set_menu(['course-category.popular']) }}">
                                    <a
                                        href="{{ route('course-category.popular') }}">{{ ___('backend_sidebar.Popular Categories') }}</a>
                                </li>
                            @endif
                            {{-- End Popular Categories --}}

                            {{-- Start brand --}}
                            @if (hasPermission('brand_read'))
                                <li class="sidebar-menu-item {{ set_menu(['brand*', 'admin/brand*']) }}">
                                    <a href="{{ route('brand.index') }}">{{ ___('brand.Brand') }}</a>
                                </li>
                            @endif
                            {{-- End brand --}}

                            {{-- Start page --}}
                            @if (hasPermission('page_read'))
                                <li class="sidebar-menu-item {{ set_menu(['pages*', 'admin/pages*']) }}">
                                    <a href="{{ route('pages.index') }}">
                                        {{ ___('page.Page') }}
                                    </a>
                                </li>
                            @endif
                            {{-- End page Setting --}}

                            {{-- Start Image Gallery --}}
                            @if (hasPermission('image_gallery_read'))
                                <li class="sidebar-menu-item {{ set_menu(['admin/image-gallery*']) }}">
                                    <a href="{{ route('admin.image_gallery.index') }}">
                                        {{ ___('backend_sidebar.Image_Gallery') }}
                                    </a>
                                </li>
                            @endif
                            {{-- End Image Gallery --}}

                            {{-- Start footer menu --}}
                            @if (hasPermission('footer_menu_read'))
                                <li class="sidebar-menu-item {{ set_menu(['admin/footer-menu*']) }}">
                                    <a href="{{ route('footer-menu.index') }}">{{ ___('backend_sidebar.Footer Menu') }}
                                    </a>
                                </li>
                            @endif
                            {{-- End footer menu Setting --}}

                            {{-- Start payment method --}}
                            @if (hasPermission('footer_menu_read'))
                                <li class="sidebar-menu-item {{ set_menu(['admin/payment-method*']) }}">
                                    <a href="{{ route('payment_method.index') }}">{{ ___('backend_sidebar.Payment Method') }}
                                    </a>
                                </li>
                            @endif
                            {{-- End payment method --}}



                        </ul>
                    </li>
                @endif

                <!-- User Profile Layout Start -->
                <li class="sidebar-menu-item">
                    <a class="parent-item-content has-arrow">
                        <i class="las la-user-edit"></i>
                        <span class="on-half-expanded">{{ ___('profile.profile') }}</span>
                    </a>
                    <ul class="child-menu-list">
                        <li class="sidebar-menu-item {{ set_menu(['my.profile']) }}">
                            <a href=" {{ route('my.profile') }}">{{ ___('backend_sidebar.my_profile') }}</a>
                        </li>
                        <li class="sidebar-menu-item {{ set_menu(['my.profile.edit']) }}">
                            <a
                                href="{{ route('my.profile.edit') }}">{{ ___('backend_sidebar.edit_my_profile') }}</a>
                        </li>
                        <li class="sidebar-menu-item {{ set_menu(['passwordUpdate']) }}">
                            <a
                                href="{{ route('passwordUpdate') }}">{{ ___('backend_sidebar.update_password') }}</a>
                        </li>
                    </ul>
                </li>
                <!-- User Profile Layout End -->

                <!-- Forum Layout Start -->
                @if (module('Forum') && hasPermission('forum_read'))
                    @include('forum::partials.sidebar')
                @endif
                <!-- Forum Layout End -->

                <!-- second layer child menu list end  -->

                <!-- livechat start -->
                @if (module('LiveChat') && hasPermission('livechat_read'))
                    @include('livechat::partials.sidebar')
                @endif
                <!-- livechat end -->
                <!-- Language layout start -->
                @if (hasPermission('language_read'))
                    <li class="sidebar-menu-item {{ set_menu(['languages*']) }}">
                        <a href="{{ route('languages.index') }}" class="parent-item-content">
                            <i class="las la-language"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.language') }}</span>
                        </a>
                    </li>
                @endif
                <!-- Language layout end -->
                <!-- Addon start -->
                @if (hasPermission('addon_list'))
                    <li class="sidebar-menu-item {{ set_menu(['admin/addon*']) }}">
                        <a href="{{ route('admin.addon.index') }}" class="parent-item-content">
                            <i class="lab la-adn"></i>
                            <span class="on-half-expanded">{{ ___('common.Addons') }} </span>
                        </a>
                    </li>
                @endif
                <!-- Addon end -->


                <!-- Settings layout start -->
                @if (hasPermission('general_settings_read') ||
                        hasPermission('storage_settings_read') ||
                        hasPermission('home_section_settings_read') ||
                        hasPermission('seo_settings_read') ||
                        hasPermission('live_class_settings_read') ||
                        hasPermission('social_login_settings_read') ||
                        hasPermission('email_settings_read'))
                    <li class="sidebar-menu-item {{ set_menu(['setting*']) }}">
                        <a href="#" class="parent-item-content has-arrow">
                            <i class="las la-cog"></i>
                            <span class="on-half-expanded">{{ ___('backend_sidebar.settings') }}</span>
                        </a>

                        <!-- second layer child menu list start  -->
                        <ul class="child-menu-list">
                            @if (hasPermission('general_settings_read'))
                                <li class="sidebar-menu-item {{ set_menu(['settings.general-settings']) }}">
                                    <a
                                        href="{{ route('settings.general-settings') }}">{{ ___('settings.general_settings') }}</a>
                                </li>
                            @endif
                            {{-- Start Social Login method --}}
                            @if (module('SocialLogin') && hasPermission('social_login_settings_read'))
                                <li class="sidebar-menu-item {{ set_menu(['admin/social-login*']) }}">
                                    <a href="{{ route('socialLogin.index') }}">
                                        {{ ___('backend_sidebar.Social Login') }}
                                        @if (env('APP_DEMO'))
                                            <span
                                                class="badge badge-danger text-white">{{ ___('addon.Addon') }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                            {{-- End Social Login method --}}

                            {{-- Start 2 Factor Authentication method --}}
                            @if (module('TwoFA'))
                                <li class="sidebar-menu-item {{ set_menu(['2fa.admin.index']) }}">
                                    <a href="{{ route('2fa.admin.index') }}">
                                        {{ ___('backend_sidebar.2FA Settings') }}
                                        @if (env('APP_DEMO'))
                                            <span
                                                class="badge badge-danger text-white">{{ ___('addon.Addon') }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                            {{-- End 2 Factor Authentication method --}}

                            @if (module('LiveChat') && hasPermission('livechat_read'))
                                @include('livechat::partials.settings_sidebar')
                            @endif

                            
                            @if (hasPermission('seo_settings_read'))
                                <li class="sidebar-menu-item {{ set_menu(['settings.seo_setting']) }}">
                                    <a
                                        href="{{ route('settings.seo_setting') }}">{{ ___('settings.seo_settings') }}</a>
                                </li>
                            @endif

                            {{-- Start Twilio Settings --}}
                            @if (hasPermission('general_settings_read'))
                                <li class="sidebar-menu-item {{ set_menu(['settings.twilio-settings']) }}">
                                    <a href="{{ route('settings.twilio-settings') }}">
                                        {{ ___('backend_sidebar.Twilio Settings') }}
                                    </a>
                                </li>
                            @endif 
                            {{-- End Twilio Settings --}}

                            {{-- Start home section page --}}
                            @if (hasPermission('home_section_settings_read'))
                                <li class="sidebar-menu-item {{ set_menu(['admin/home-section-setting']) }}">
                                    <a href="{{ route('home_section.setting.index') }}">{{ ___('page.Home Section') }}
                                    </a>
                                </li>
                            @endif
                            {{-- End home section page Setting --}}
                            {{-- Start app home section page --}}
                            @if (hasPermission('home_section_settings_read'))
                                <li class="sidebar-menu-item {{ set_menu(['admin/home-section-setting/app*']) }}">
                                    <a href="{{ route('app_home_section.setting.index') }}">{{ ___('page.App Home Section') }}
                                    </a>
                                </li>
                            @endif
                            {{-- End app home section page Setting --}}

                            @if (hasPermission('storage_settings_read'))
                                <li class="sidebar-menu-item {{ set_menu(['settings.storagesetting']) }}">
                                    <a
                                        href="{{ route('settings.storagesetting') }}">{{ ___('settings.storage_settings') }}</a>
                                </li>
                            @endif

                            @if (hasPermission('email_settings_read'))
                                <li class="sidebar-menu-item {{ set_menu(['settings.mail-setting']) }}">
                                    <a
                                        href="{{ route('settings.mail-setting') }}">{{ ___('settings.email_settings') }}</a>
                                </li>
                            @endif
                        </ul>
                        <!-- second layer child menu list end  -->
                    </li>
                @endif
                <!-- Settings layout end -->

                <!-- Components Layout End -->
            </ul>
            <!-- parent menu list end  -->

        </div>
    </div>
</aside>

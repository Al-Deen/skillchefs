<div class="sidebar-wrapper bg-transparent mb-24">
    <!-- Mobile Device -->
    <div id="otSidebarBtnOpen" class="responsive-bar">
        <div class="sticky-icon">
            <i class="ri-equalizer-line"></i>
            <span>Filters</span>
        </div>
    </div>
    <nav class="ot-sidebar" id="ot-sidebar">
        <div class="ot-sidebar-btn-close" id="otSidebarBtnClose"><i class="ri-close-fill"></i></div>
        <div class="accordion" id="accordionExample">


            <div class="accordion-item ot-checkbox-dropdown">
                <h4 class="accordion-header" id="headingOne">
                    <button class="accordion-button " type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        {{ ___('frontend.Categories') }}
                    </button>
                </h4>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#headingOne">
                    <ul class="ot-checkbox-dropdown-list ">
                        @foreach ($data['categories'] as $category)
                            <li>
                                <label class="filter-options">
                                    <input class="ot-checkbox" type="checkbox"
                                        value="{{ @$category->course_category_id }}" name="category[]" />
                                    <span class="value"> {{ @$category->category->title }} </span>
                                    <span class="ot-checkmark"></span>
                                </label>
                            </li>
                        @endforeach
                        @if (@$data['category'] && @$data['category']->id)
                            <li>
                                <label class="filter-options">
                                    <input class="ot-checkbox" type="checkbox" checked
                                        value="{{ @$data['category']->id }}" name="category[]" />
                                    <span class="value"> {{ @$data['category']->title }} </span>
                                    <span class="ot-checkmark"></span>
                                </label>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>


            <div class="accordion-item ot-checkbox-dropdown">
                <h4 class="accordion-header" id="headingTwo">
                    <button class="accordion-button " type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        {{ ___('frontend.Instructor') }}
                    </button>
                </h4>
                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo"
                    data-bs-parent="#headingTwo">
                    <ul class="ot-checkbox-dropdown-list ">
                        @foreach ($data['instructors'] as $instructor)
                            <li>
                                <label class="filter-options">
                                    <input class="ot-checkbox" type="checkbox" value="{{ @$instructor->created_by }}"
                                        name="instructor[]" />
                                    <span class="value"> {{ @$instructor->instructor->name }} </span>
                                    <span class="ot-checkmark"></span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="accordion-item ot-checkbox-dropdown">
                <h4 class="accordion-header" id="headingThree">
                    <button class="accordion-button " type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        {{ ___('frontend.Language') }}
                    </button>
                </h4>
                <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree"
                    data-bs-parent="#headingThree">
                    <ul class="ot-checkbox-dropdown-list ">
                        @foreach ($data['languages'] as $language)
                            <li>
                                <label class="filter-options">
                                    <input class="ot-checkbox" type="checkbox" value="{{ @$language->language }}"
                                        name="language[]" />
                                    <span class="value"> {{ @$language->lang->name }} </span>
                                    <span class="ot-checkmark"></span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="accordion-item ot-checkbox-dropdown">
                <h4 class="accordion-header" id="headingFor">
                    <button class="accordion-button " type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                        {{ ___('frontend.Level') }}
                    </button>
                </h4>
                <div id="collapseFour" class="accordion-collapse collapse show" aria-labelledby="headingFor"
                    data-bs-parent="#headingFor">
                    <ul class="ot-checkbox-dropdown-list ">

                        @foreach (courseLevel() as $course_level)
                            <li>
                                <label class="filter-options">
                                    <input class="ot-checkbox" type="checkbox" value="{{ @$course_level->id }}"
                                        name="course_level[]" />
                                    <span class="value"> {{ @$course_level->name }}</span>
                                    <span class="ot-checkmark"></span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="accordion-item ot-checkbox-dropdown">
                <h4 class="accordion-header" id="headingSix">
                    <button class="accordion-button " type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                        {{ ___('frontend.Price') }}
                    </button>
                </h4>
                <div id="collapseSix" class="accordion-collapse collapse show" aria-labelledby="headingSix"
                    data-bs-parent="#headingSix">
                    <ul class="ot-checkbox-dropdown-list ">
                        <li>
                            <label class="filter-options-radio">
                                <input class="ot-checkbox" type="radio" value="0" name="is_free" />
                                <span class="value"> {{ ___('frontend.Paid') }}</span>
                                <span class="ot-checkmark"></span>
                            </label>
                        </li>
                        <li>
                            <label class="filter-options-radio">
                                <input class="ot-checkbox" type="radio" value="1" name="is_free" />
                                <span class="value"> {{ ___('frontend.Free') }}</span>
                                <span class="ot-checkmark"></span>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="accordion-item ot-checkbox-dropdown">
                <h4 class="accordion-header" id="headingEight">
                    <button class="accordion-button " type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseEight" aria-expanded="true" aria-controls="collapseEight">

                        {{ ___('frontend.Ratings') }}

                    </button>
                </h4>
                <div id="collapseEight" class="accordion-collapse collapse show" aria-labelledby="headingEight"
                    data-bs-parent="#headingEight">

                    <ul class="ot-checkbox-dropdown-list ">
                        <li class="mb-15">
                            <label class="filter-options">
                                <input class="ot-checkbox" type="checkbox" value="5" name="ratings[]" />
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ri-star-fill text-16 text-yellow"></i>
                                    <i class="ri-star-fill text-16 text-yellow"></i>
                                    <i class="ri-star-fill text-16 text-yellow"></i>
                                    <i class="ri-star-fill text-16 text-yellow"></i>
                                    <i class="ri-star-fill text-16 text-yellow"></i>
                                </div>
                                <span class="ot-checkmark"></span>
                            </label>
                        </li>
                        <li class="mb-15">
                            <label class="filter-options">
                                <input class="ot-checkbox" type="checkbox" value="4" name="ratings[]" />
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ri-star-fill text-16 text-yellow"></i>
                                    <i class="ri-star-fill text-16 text-yellow"></i>
                                    <i class="ri-star-fill text-16 text-yellow"></i>
                                    <i class="ri-star-fill text-16 text-yellow"></i>
                                    <i class="ri-star-fill text-16 text-gray2"></i>
                                </div>

                                <span class="ot-checkmark"></span>
                            </label>
                        </li>
                        <li class="mb-15">
                            <label class="filter-options">
                                <input class="ot-checkbox" type="checkbox" value="3" name="ratings[]" />
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ri-star-fill text-16 text-yellow"></i>
                                    <i class="ri-star-fill text-16 text-yellow"></i>
                                    <i class="ri-star-fill text-16 text-yellow"></i>
                                    <i class="ri-star-fill text-16 text-gray2"></i>
                                    <i class="ri-star-fill text-16 text-gray2"></i>
                                </div>
                                <span class="ot-checkmark"></span>
                            </label>
                        </li>
                        <li class="mb-15">
                            <label class="filter-options">
                                <input class="ot-checkbox" type="checkbox" value="2" name="ratings[]" />
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ri-star-fill text-16 text-yellow"></i>
                                    <i class="ri-star-fill text-16 text-yellow"></i>
                                    <i class="ri-star-fill text-16 text-gray2"></i>
                                    <i class="ri-star-fill text-16 text-gray2"></i>
                                    <i class="ri-star-fill text-16 text-gray2"></i>
                                </div>
                                <span class="ot-checkmark"></span>
                            </label>
                        </li>
                        <li class="mb-15">
                            <label class="filter-options">
                                <input class="ot-checkbox" type="checkbox" value="1" name="ratings[]" />
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ri-star-fill text-16 text-yellow"></i>
                                    <i class="ri-star-fill text-16 text-gray2"></i>
                                    <i class="ri-star-fill text-16 text-gray2"></i>
                                    <i class="ri-star-fill text-16 text-gray2"></i>
                                    <i class="ri-star-fill text-16 text-gray2"></i>
                                </div>
                                <span class="ot-checkmark"></span>
                            </label>
                        </li>
                    </ul>

                </div>
            </div>


        </div>
    </nav>
</div>

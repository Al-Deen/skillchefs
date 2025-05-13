@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
@section('content')
    <div class="page-content">

        {{-- breadecrumb Area S t a r t --}}
        @include('backend.ui-components.breadcrumb', [
            'title' => @$data['title'],
            'routes' => [
                route('dashboard')                  => ___('common.Dashboard'),
                route('book.index')      => 'Books',
                '#' => @$data['title'],
            ],
            'buttons' => 0,
        ])
        {{-- breadecrumb Area E n d --}}

        <!--  category create start -->
        <div class="card ot-card">

            <div class="card-body">
                <form action="{{ route('book.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- start general info -->
                    <div class="step-wrapper-contents active">
                        <div class="row">
                            <!-- Course Title -->
                            <div class="col-lg-6 col-md-6">
                                <div class="ot-contact-form mb-24">
                                    <label class="ot-contact-label">Title<span class="text-danger">*</span>  </label>
                                    <input class="form-control ot-contact-input" type="text" name="title" id="title"
                                           value="{{ old('title') }}" placeholder="Book Title" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="ot-contact-form mb-24">
                                    <label class="ot-contact-label">Instructor<span class="text-danger">*</span>  </label>
                                    <select class="form-select ot-input select2"
                                            id="instructor_id" name="instructor_id">
                                        <option selected="" disabled="" value="">
                                           Select instructor
                                        </option>
                                        @foreach ($data['instructors'] as $instructor)
                                            <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="ot-contact-form mb-24">
                                    <div class="ot-contact-form">
                                        <label class="ot-contact-label">Price </label>
                                        <input class="form-control ot-contact-input" type="number" name="price" id="price"
                                               value="{{ old('price') }}" placeholder="Enter price">
                                    </div>
                                </div>
                                <!-- Select level -->
                                <div class="ot-contact-form mb-24">
                                    <div class="ot-contact-form">
                                        <label class="ot-contact-label">Short File<span
                                                class="text-danger">*</span></label>
                                        <input class="form-control ot-contact-input" type="file" name="short_file" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="ot-contact-form mb-24">
                                    <div class="ot-contact-form">
                                        <label class="ot-contact-label">Payable Status <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control ot-contact-input select2" id="is_free" required  name="is_free">
                                            <option value="0"> Paid</option>
                                            <option value="1"> Free</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Select level -->
                                <div class="ot-contact-form mb-24">
                                    <div class="ot-contact-form">
                                        <div class="ot-contact-form mb-24">
                                            <div class="ot-contact-form">
                                                <label class="ot-contact-label">Full File <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control ot-contact-input" type="file" name="full_file" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="required ot-contact-label mb-2">FAQ About Book</label>
                                    <div id="service-items-container">
                                        <!-- FAQ Item Template -->
                                        <div class="faq-item border rounded p-3 mb-3 position-relative">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="required">Title</label>
                                                    <input type="text" name="point_title[]" class="form-control" placeholder="Enter the title">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="required">Description</label>
                                                    <textarea class="form-control ot-textarea" name="point_description[]" rows="5" placeholder="Enter Short Description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success mt-2 add-item-service"><i class="fa fa-plus"></i>Add More </button>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <!-- Course Descriptions [ CK Editor ]-->
                                <div class="ot-contact-form mb-24">
                                    <label class="ot-contact-label">{{ ___('label.description') }}</label>
                                    <textarea class="ckeditor-editor" placeholder="{{ ___('placeholder.Enter Description') }}" name="description"
                                              id="description">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <!-- Course Price -->
                                <div class="ot-contact-form mb-15">
                                    <label class="ot-contact-label">{{ ___('label.Thumbnail') }} </label>
                                    <div data-name="thumbnail" class="file" data-height="150px "></div>
                                    <small
                                        class="text-muted">{{ ___('placeholder.NB : Thumbnail size will 600px x 600px and not more than 1mb') }}</small>
                                    <div id="thumbnail"></div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <!-- Course Price -->
                                <div class="ot-contact-form">
                                    <label class="ot-contact-label">Status <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control ot-contact-input select2" id="status" required
                                            name="status">
                                        <option value="1"> Active</option>
                                        <option value="0"> Inactive</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-12 mt-3">
                        <button class="btn btn-lg ot-btn-primary" type="submit">
                            </span>Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!--  category create end -->
    </div>
@endsection
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.add-item-service').on('click', function () {
                const newFAQ = `
                <div class="faq-item border rounded p-3 mb-3 position-relative">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="required">Title</label>
                            <input type="text" name="point_title[]" class="form-control" placeholder="Enter the title" required>
                        </div>
                        <div class="col-md-6">
                            <label class="required">Description</label>
                            <textarea class="form-control ot-textarea" name="point_description[]" rows="5" placeholder="Enter Short Description"></textarea>
                        </div>
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-danger mt-2 remove-service-item">
                                <i class="fa fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>`;
                $('#service-items-container').append(newFAQ);
            });

            $('#service-items-container').on('click', '.remove-service-item', function () {
                $(this).closest('.faq-item').remove();
            });
        });
    </script>



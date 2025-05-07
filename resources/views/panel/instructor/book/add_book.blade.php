@extends('panel.instructor.layouts.master')
@section('title', @$data['title'])
@section('content')

    <!-- instructor Create new Course -->
    <section class="create-new-course">
        <!-- MultiStep S t a r t-->
        <div class="row">
            <div class="col-lg-12">
                <!-- Next - Previus -->
                <div class="d-flex align-items-center justify-content-between flex-wrap border-bottom mb-20 pb-20">
                    <!-- Section Tittle -->
                    <div class="section-tittle-two">
                        <h2 class="title font-600 mb-20">{{ $data['title'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- MultiStep End -->
        <form action="{{ route('instructor.book.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

             <!-- start general info -->
            <div class="step-wrapper-contents active">
                    <div class="row">
                        <!-- Course Title -->
                        <div class="col-lg-12">
                            <div class="ot-contact-form mb-24">
                                <label class="ot-contact-label">Title<span class="text-danger">*</span>  </label>
                                <input class="form-control ot-contact-input" type="text" name="title" id="title"
                                       value="{{ old('title') }}" placeholder="Book Title" required>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="ot-contact-form mb-24">
                                <div class="ot-contact-form">
                                    <label class="ot-contact-label">Price </label>
                                    <input class="form-control ot-contact-input" type="number" name="price" id="price"
                                           value="{{ old('price') }}" placeholder="price">
                                </div>
                            </div>
                            <!-- Select level -->
                            <div class="ot-contact-form mb-24">
                                <div class="ot-contact-form">
                                    <label class="ot-contact-label">Short File</label>
                                    <input class="form-control ot-contact-input" type="file" name="short_file">
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
                                                <textarea class="form-control ot-textarea" name="point_description[]" id="short_description" rows="5" placeholder="{{ ___('placeholder.Enter Short Description') }}">{{ old('short_description') }}</textarea>
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
            <div class="d-flex aling-items-center flex-wrap gap-10 mb-20">
                <button class="btn-primary-fill" type="submit"> Save </button>
            </div>

        </form>

    </section>
    <!-- End-of Create new Course -->

    <!-- Modal Custom -->

@endsection
@section('scripts')
    <script src="{{ url('frontend/js/instructor/__course.js') }}"></script>


    <script>
        $(document).ready(function () {
            let editorCounter = 1;
            // Add new FAQ
            $('.add-item-service').on('click', function () {
                editorCounter++;
                const newFAQ = `
            <div class="faq-item border rounded p-3 mb-3 position-relative">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="required">Title</label>
                        <input type="text" name="point_title[]" class="form-control" placeholder="Enter the title" required>
                    </div>
                    <div class="col-md-6">
                        <label class="required">Description</label>
                        <textarea class="form-control ot-textarea" name="point_description[]" id="short_description" name="point_description[]" rows="5" placeholder="{{ ___('placeholder.Enter Short Description') }}">{{ old('short_description') }}</textarea>
                    </div>
                    <div class="col-12 text-end">
                        <button type="button" class="btn btn-danger mt-2 remove-service-item"><i class="fa fa-trash"></i> Remove</button>
                    </div>
                </div>
            </div>
            `;
                $('#service-items-container').append(newFAQ);
            });

            // Remove FAQ
            $('#service-items-container').on('click', '.remove-service-item', function () {
                $(this).closest('.faq-item').remove();
            });
        });
    </script>
@endsection

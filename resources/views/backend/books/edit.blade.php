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
                <form action="{{ route('book.update', $data['book']->slug) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <!-- start general info -->
                    <div class="step-wrapper-contents active">
                        <div class="row">
                            <!-- Course Title -->
                            <div class="col-lg-6 col-md-6">
                                <div class="ot-contact-form mb-24">
                                    <label class="ot-contact-label">Title </label>
                                    <input class="form-control ot-contact-input" type="text" name="title" id="title"
                                           value="{{ @$data['book']->title }}" placeholder="Book Title">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="ot-contact-form mb-24">
                                    <label class="ot-contact-label">Instructor </label>
                                    <select class="form-select ot-input select2"
                                            id="instructor_id" name="instructor_id">
                                        <option selected="" disabled="" value="">
                                            Select instructor
                                        </option>
                                        @foreach ($data['instructors'] as $instructor)
                                            <option value="{{ $instructor->id }}" {{ $data['book']->instructor_id == $instructor->id ? 'selected' : '' }}>{{ $instructor->name }}</option>
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
                                               value="{{ @$data['book']->price }}" placeholder="price">
                                    </div>
                                </div>

                                <!-- Select level -->
                                <div class="ot-contact-form mb-24">
                                    <div class="ot-contact-form">
                                        <label class="ot-contact-label">Short File</label>
                                        <input class="form-control ot-contact-input" type="file" name="short_file">
                                        @if($data['book']->short_file)
                                            <div class="mt-2">
                                                <a target="_blank" class="btn btn-warning" href="{{ route('book.short-file.view', $data['book']->id) }}">View Short File</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="ot-contact-form mb-24">
                                    <div class="ot-contact-form">
                                        <label class="ot-contact-label">Payable Status
                                        </label>
                                        <select class="form-control ot-contact-input select2" id="is_free" required  name="is_free">
                                            <option value="0" {{ $data['book']->is_free == 0 ? 'selected' : '' }}> Paid</option>
                                            <option value="1" {{ $data['book']->is_free == 1 ? 'selected' : '' }}> Free</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Select level -->
                                <div class="ot-contact-form mb-24">
                                    <div class="ot-contact-form">
                                        <div class="ot-contact-form mb-24">
                                            <div class="ot-contact-form">
                                                <label class="ot-contact-label">Full File</label>
                                                <input class="form-control ot-contact-input" type="file" name="full_file">
                                                @if($data['book']->full_file)
                                                    <div class="mt-2">
                                                        <a target="_blank" class="btn btn-warning" href="{{ route('book.fullfile.view', $data['book']->id) }}">View Full File</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="required ot-contact-label mb-2">FAQ About Book</label>
                                    <div id="service-items-container">

                                        @php
                                            $titles = json_decode($data['book']->point_title, true);
                                            $descriptions = json_decode($data['book']->point_description, true);
                                        @endphp
                                        <!-- FAQ Item Template -->

                                        @if(!empty($titles) && !empty($descriptions))
                                            @foreach ($titles as $key => $point_title)
                                        <div class="faq-item border rounded p-3 mb-3 position-relative">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="required">Title</label>
                                                    <input type="text" name="point_title[]" class="form-control" value="{{ $point_title }}" placeholder="Enter the title">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="required">Description</label>
                                                    <textarea class="form-control ot-textarea" name="point_description[]" rows="5" placeholder="Enter Short Description">{{ $descriptions[$key] ?? '' }}</textarea>
                                                </div>
                                                <div class="col-12 text-end">
                                                    <button type="button" class="btn btn-danger mt-2 remove-service-item"><i class="fa fa-trash"></i> Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-success mt-2 add-item-service"><i class="fa fa-plus"></i>Add More </button>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <!-- Course Descriptions [ CK Editor ]-->
                                <div class="ot-contact-form mb-24">
                                    <label class="ot-contact-label">{{ ___('label.description') }}</label>
                                    <textarea class="ckeditor-editor" placeholder="{{ ___('placeholder.Enter Description') }}" name="description"
                                              id="description"><?= @$data['book']->description ?></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <!-- Course Price -->
                                <div class="ot-contact-form mb-15">
                                    <label class="ot-contact-label">{{ ___('label.Thumbnail') }} </label>
                                    <div @if (@$data['book']->thumbnailImage) data-val="{{ showImage(@$data['book']->thumbnailImage->original) }}" @endif
                                     data-name="thumbnail" class="file" data-height="150px "></div>
                                    <small
                                        class="text-muted">{{ ___('placeholder.NB : Thumbnail size will 600px x 600px and not more than 1mb') }}</small>
                                    <div id="thumbnail">
                                        <img src="{{ asset($data['book']->thumbnail) }}" style="width: 80px;height: 80px"  alt="img">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <!-- Course Price -->
                                <div class="ot-contact-form">
                                    <label class="ot-contact-label">Status
                                    </label>
                                    <select class="form-control ot-contact-input select2" id="status"
                                            name="status">
                                        <option value="1" {{ $data['book']->status == 1 ? 'selected' : '' }}> Active</option>
                                        <option value="0" {{ $data['book']->status == 0 ? 'selected' : '' }}> Inactive</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-12 mt-3">
                        <button class="btn btn-lg ot-btn-primary" type="submit">
                            </span> Update
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



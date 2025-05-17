@extends('frontend.layouts.master')
@section('title', @$data['title'])
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/plyr/plyr.css') }}" >
@endsection
@push('meta')
    <meta itemprop="name" content="{{ @$data['course']->meta_title }}">
    <meta itemprop="image" content="{{ showImage(@$data['course']->metaImage->original) }}">
    <meta itemprop="description" content="{{ @$data['course']->meta_description }}">
    <meta name="twitter:title" content="{{ @$data['course']->meta_title }}">
    <meta name="twitter:image" content="{{ showImage(@$data['course']->metaImage->original) }}">
    <meta name="twitter:description" content="{{ @$data['course']->meta_description }}">
    <meta property="og:site_name" content="{{ @$data['course']->meta_title }}" />
    <meta property="og:title" content="{{ @$data['course']->meta_title }}" />
    <meta property="og:description" content="{{ @$data['course']->meta_description }}" />
    <meta property="og:image" content="{{ showImage(@$data['course']->metaImage->original) }}" />
    <meta name="description" content="{{ @$data['course']->meta_description }}">
    <meta name="keywords" content="{{ @$data['course']->meta_keyword }}">

    <style>
        .pdf-controls {
            margin-top: 10px;
        }

        .pdf-controls button {
            margin: 0 10px;
        }

        canvas {
            user-select: none;
        }

        .pdf-jump {
            margin-top: 10px;
        }

        #jumpToPage {
            display: inline-block;
            width: 80px;
            text-align: center;
        }

        #jumpToPageBtn {
            margin-left: 10px;
        }

        /* Style for the story text content */
        .story-text-content {
            font-size: 1.2rem;
            line-height: 1.8;
            padding: 20px 40px;
            /* Padding on left and right for book-like spacing */
            text-align: justify;
            /* Justify the text for better readability */
            background-color: #fdfdfd;
            /* Light background for a paper-like feel */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Subtle shadow for depth */
            border-radius: 8px;
            /* Rounded corners for elegance */
            font-family: 'Georgia', serif;
            /* A serif font for a book-like aesthetic */
        }

        /* Add a container border for a book-like look */
        #storyTextContainer {
            position: relative;
            /* Required for the canvas to overlay correctly */
            /* Slightly darker background for contrast */
            border-radius: 12px;
            /* Rounded edges */
            padding: 10px;
            overflow: hidden;
            /* Prevent watermark from overflowing */
        }

        /* Watermark styling */
        .watermark-canvas {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 1;
        }

        /* Center modal title properly */
        .modal-title {
            font-weight: bold;
            font-family: 'Georgia', serif;
            color: #333;
        }

        /* Buttons styling for navigation */
        .pdf-controls button,
        .pdf-jump button {
            font-size: 1rem;
            padding: 6px 12px;
            border-radius: 6px;
            font-family: 'Arial', sans-serif;
            transition: all 0.3s ease-in-out;
        }

        .pdf-controls button:hover,
        .pdf-jump button:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>
@endpush
@section('content')
    <!--Bradcam S t a r t -->
    @include('frontend.partials.breadcrumb', [
        'breadcumb_title' => @$data['title'],
    ])
    <!--End-of Bradcam  -->


    <!-- course-details  S t a r t-->
    <div class="ot-course-details section-padding2">
        <div class="container px-3 px-md-5">
            <div class="row d-flex align-items-center flex-row-reverse">
                <!-- Right side: Book Image -->
                <div class="col-lg-6 col-md-12 text-center mb-4 mb-lg-0">
                    <div>
                        <img src="{{ asset(@$data['book']->thumbnail) }}" alt="img" class="img-fluid" style="max-width: 48%; height: auto;">
                    </div>
                    <div class="text-center mt-2">
                        <button class="btn btn-primary mt-3" id="bookPreview">
                            <i class="ri-book-open-line"></i> Preview
                        </button>
                    </div>
                </div>

                <!-- Left side: Title, instructor -->
                <div class="col-lg-6 col-md-12">
                    <h3 class="mb-3 text-center text-lg-start" id="book_title">
                        <strong>{{ @$data['book']->title }}</strong>
                    </h3>

                    @php
                        $user = \Illuminate\Support\Facades\Auth::user();
                    @endphp

                    <input type="hidden" id="getFile" value="{{ asset(@$data['book']->short_file) }}">
                    <input type="hidden" id="userPhone" value="{{ $user->phone ?? '' }}">
                    <input type="hidden" id="userName" value="{{ $user->name ?? '' }}">

                    <div class="d-flex align-items-center gap-3 mt-4 flex-column flex-sm-row text-center text-sm-start">
                        <div class="thumb">
                            <img src="{{ showImage(@$data['book']->instructor->image->original) }}" alt="Instructor Image"
                                 class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                        </div>
                        <div>
                            <h5 class="mb-0">
                                <a href="{{ route('frontend.instructor.details', [$data['book']->user->name, $data['book']->user->id]) }}">
                                    {{ @$data['book']->instructor->name }}
                                </a>
                            </h5>
                            <p class="mb-0">{{ @$data['book']->instructor->instructor->designation }}</p>
                        </div>
                    </div>

                    <div class="mt-5" id="course-summary" data-val="{{ encrypt(@$data['book']->id) }}">
                        <div class="d-flex align-items-center justify-content-center justify-content-lg-start">
                            @if ($data['book']->is_free == 1)
                                <h4>{{ ___('frontend.Free') }}</h4>
                            @else
                                <h4>{{ showPrice(@$data['book']->price) }}</h4>
                            @endif
                        </div>

                        @if (auth()->check())
                            @if(auth()->user()->phone)
                                <a href="javascript:void(0);"  class="btn-primary-fill mt-4 d-flex align-items-center justify-content-center w-100 ">
                                    {{ ___('frontend.Enroll Now') }}</a>
                                @else
                                <button
                                    class="btn-primary-fill mt-4 d-flex align-items-center justify-content-center w-100 offer_couter validAuthcheckout">
                                    {{ ___('frontend.Enroll Now') }}
                                </button>
                            @endif
                        @else
                            <button
                                class="btn-primary-fill mt-4 d-flex align-items-center justify-content-center w-100 offer_couter authcheckout">
                                {{ ___('frontend.Enroll Now') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
             <hr>
            <br>
            <div class="row">
                <div class="col-xl-9 col-lg-8 col-md-12">
                    <div class="ot-course-details-inner">
                        <div class="course-tab-widget">
                            <ul class="course-details-list">
                                <?= $data['book']->description ?>
                            </ul>
                        </div>
                        <br>
                        @php
                            $pointTiles =  json_decode($data['book']->point_title);
                            $pointDescription =  json_decode($data['book']->point_description);
                        @endphp
                            <div class="course-tab-widget mt-4">
                                <h2 class="course-details-title">Frequently Ask Questions</h2>
                                @if (count($pointTiles) > 0)
                                    <div class="theme-according mb-24" id="accordion1">
                                        @foreach ($pointTiles as $key => $title)
                                            <div class="card">
                                                <div class="card-header pink_bg" id="four4">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link text-white collapsed" data-bs-toggle="collapse"
                                                                data-bs-target="#collapseFour{{ $key }}" aria-expanded="false" aria-controls="four4">
                                                            <h6>{{ $title }}</h6>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div class="collapse" id="collapseFour{{ $key }}" data-parent="#accordion1">
                                                    <div class="card-body">
                                                        <ul class="course-video-lists">
                                                            @foreach ($pointDescription as $key => $description)
                                                                <li> <p>{{ $description }}</p> </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                 @else
                                    <div class="text-left">
                                        <p class="text-left"> No Data Found</p>
                                    </div>
                                @endif

                        </div>

                        <!-- course details tab  -->

                        <!-- COURSE_DETAILS_TABS::END    -->
                    </div>
                </div>
                <!-- modal for pdf view -->
                <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="float: right;">
                                <h5 class="modal-title text-center w-100" id="modalBookTitle"></h5> <!-- Centered Title -->
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <canvas id="pdfViewerCanvas" style="width: 100%;"></canvas>
                                <div class="pdf-controls text-center mt-3">
                                    <button id="prevPage" class="btn btn-secondary">Previous</button>
                                    <span>Page: <span id="pageNumber"></span> / <span id="totalPages"></span></span>
                                    <button id="nextPage" class="btn btn-secondary btn_Modaltop">Next</button>
                                </div>
                                <div class="pdf-jump text-center mt-3">
                                    <label for="jumpToPage">Jump to page:</label>
                                    <input type="number" id="jumpToPage" min="1" class="form-control d-inline-block w-auto"
                                           style="display: inline-block; width: 100px;" />
                                    <button id="jumpToPageBtn" class="btn btn-primary">Go</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- End-of course-details-->

@endsection


@section('scripts')
    <script src="{{ asset('frontend/js/__course.js') }}" type="module"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- pdf.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

    <script>
        let pdfDoc = null,
            currentPage = 1,
            totalPages = 0,
            scale = 1.5,
            canvas = document.getElementById('pdfViewerCanvas'),
            ctx = canvas.getContext('2d');

        // Open modal and load the PDF
        document.getElementById('bookPreview').addEventListener('click', function() {
            $('#pdfModal').modal('show');
            loadPDF();
        });

        function loadPDF() {
            const fileInput = document.querySelector("#getFile");
            const url = fileInput.value;
            var pdfjsLib = window['pdfjs-dist/build/pdf'];
            pdfjsLib.GlobalWorkerOptions.workerSrc =
                'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

            pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
                pdfDoc = pdfDoc_;
                totalPages = pdfDoc.numPages;
                document.getElementById('totalPages').textContent = totalPages;
                renderPage(currentPage);
            });
        }

        function renderPage(pageNum) {
            pdfDoc.getPage(pageNum).then(function(page) {
                var viewport = page.getViewport({
                    scale: scale
                });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };

                // Render the PDF page
                page.render(renderContext).promise.then(function() {
                    // After the PDF page is rendered, add the watermark
                    addWatermark();
                });

                // Update current page number
                document.getElementById('pageNumber').textContent = pageNum;
            });
        }

        function addWatermark() {
            var userName = $('#userName').val();
            var userPhone = $('#userPhone').val();

            // Set watermark properties
            ctx.font = "bold 40px Arial";
            ctx.fillStyle = "rgba(0, 0, 0, 0.2)";
            ctx.textAlign = "center";
            ctx.textBaseline = "middle";

            // Calculate center position
            const x = canvas.width / 2;
            const y = canvas.height / 2;

            ctx.save();
            ctx.translate(x, y);
            ctx.rotate(-Math.PI / 4); // Diagonal

            // Draw each line separately
            ctx.fillText(userName, 0, -25); // Slightly above center
            ctx.fillText(userPhone, 0, 25); // Slightly below center

            ctx.restore();
        }

        // Go to the Previous Page
        document.getElementById('prevPage').addEventListener('click', function() {
            if (currentPage <= 1) {
                return;
            }
            currentPage--;
            renderPage(currentPage);
        });

        // Go to the Next Page
        document.getElementById('nextPage').addEventListener('click', function() {
            if (currentPage >= totalPages) {
                return;
            }
            currentPage++;
            renderPage(currentPage);
        });

        // Jump to a specific page
        document.getElementById('jumpToPageBtn').addEventListener('click', function() {
            var jumpToPageNum = parseInt(document.getElementById('jumpToPage').value);
            if (jumpToPageNum >= 1 && jumpToPageNum <= totalPages) {
                currentPage = jumpToPageNum;
                renderPage(currentPage);
            } else {
                alert("Please enter a valid page number between 1 and " + totalPages);
            }
        });

        // Disable right-click on the modal to prevent context menu (download/print)
        document.getElementById('pdfModal').addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });
    </script>

    <script>
        $('#bookPreview').on('click', function() {
            $('#pdfModal').modal('show');
        });

        $('.close').on('click', function() {
            $('#pdfModal').modal('hide');
        });
        $('#bookPreview').on('click', function() {
            var bookTitle = $('#book_title').text();
            $('#modalBookTitle').text(bookTitle);
            $('#pdfModal').modal('show');
        });
    </script>

    {{-- scroll to top features --}}
    <script>
        const prevButton = document.querySelector("#prevPage");
        const nextButton = document.querySelector("#nextPage");
        const goButton = document.querySelector("#jumpToPageBtn");
        const modal = document.querySelector("#pdfModal");

        const scrollToTop = (button) => {
            button.addEventListener("click", () => {
                modal.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
                console.log("Scrolled to top of the modal");
            });
        };
        scrollToTop(prevButton);
        scrollToTop(nextButton);
        scrollToTop(goButton);
    </script>
@endsection

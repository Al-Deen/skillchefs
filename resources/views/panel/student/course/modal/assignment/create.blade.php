<div class="modal fade boostrap-modal" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content data">
            <div class="modal-body">
                <button type="button" class="close-icon" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ri-close-line" aria-hidden="true"></i>
                </button>
                <div class="custom-modal-body ">

                    <div class="d-flex justify-content-between small-tittle-two border-bottom mb-30 pb-8">
                        <span>
                            <h5 class="title text-capitalize font-600">
                                {{ $data['assignment']->title }}
                            </h5>
                            <small class="text-12 text-tertiary">{{ ___('student.Marks') }} :
                                {{ $data['assignment']->marks }}</small>
                        </span>
                        <div class="d-flex align-items-center  note_action">
                            <span class="gap-3 text-tertiary text-14">
                                <i class="ri-time-line"></i>
                            </span>
                            <span class="assignment-date ms-1 text-14">
                                {{ date('d M Y, h:i a', strtotime($data['assignment']->deadline)) }}</span>
                            <div class="edits">
                            </div>
                        </div>

                    </div>
                    @if ($data['assignment']->assignmentFile)
                        @php
                              $user = \Illuminate\Support\Facades\Auth::user();
                              $filePath = $data['assignment']->assignmentFile->original;
                              $fileFullName = $data['assignment']->assignmentFile->name;
                              $filename = implode('-', array_slice(explode('-', $fileFullName), 4));

                        @endphp

                      <div>
                          <input type="hidden" id="getFile" value="{{ asset('storage/' . $filePath) }}">
                          <input type="hidden" id="userPhone" value="{{ $user->phone ?? '' }}">
                          <input type="hidden" id="userName" value="{{ $user->name ?? '' }}">
                      </div>

                        <h6 class="title mb-25">
                            <strong>{{ ___('student.Attachment') }} : </strong>

                            <button class="btn btn-sm btn-primary ms-2" id="bookPreview">
                                <i class="ri-book-open-line"></i> Preview
                            </button>
                            <!-- Download Button -->
                            <a href="{{ route('student.assignment.download', [$data['enroll_id'], encryptFunction($data['assignment']->id)]) }}"
                               class="btn btn-sm btn-secondary ms-2">
                                <i class="ri-download-2-fill"></i> {{ $filename }}
                            </a>
                        </h6>
                    @endif

                    <h6 class="title mb-25">
                        <strong>{{ ___('student.Details')}} : </strong>
                        <p class="pera mb-6">
                            <?= $data['assignment']->details ?>
                        </p>
                    </h6>
                    @if ($data['assignment']->note)
                        <h6 class="title mb-25 mt-25">
                            <strong>{{ ___('student.Note')}} : </strong>
                            <p class="pera mb-6">
                                <?= $data['assignment']->note ?>
                            </p>
                        </h6>
                    @endif


                    @php

                        $submission = @$data['assignment']
                                       ->assignmentSubmit()
                                       ->where('user_id', $data['enroll']->user_id)
                                       ->first();

                    @endphp

                    @if($submission)
                        @if($submission->is_submitted == 11)
                        <h6 class="title mb-25 mt-25">
                            <strong>{{ ___('student.Submit Status')}} : </strong>
                            <span class="ms-2 text-14 text-success">{{ ___('student.Submitted') }}</span>
                        </h6>

                            @if ($submission->assignmentFile)
                                @php
                                    $user = \Illuminate\Support\Facades\Auth::user();
                                    $submitFilePath = $submission->assignmentFile->original;
                                    $submitFileFullName = $submission->assignmentFile->name;
                                    $submitFilename = implode('-', array_slice(explode('-', $submitFileFullName), 4));
                                @endphp
                            <div>
                                <input type="hidden" id="submitFilePath" value="{{ asset('storage/' . $submitFilePath) }}">
                            </div>

                                <h6 class="title mb-25">
                                    <strong>Submitted Attachment : </strong>
                                    <button class="btn btn-sm btn-success ms-2" id="submitFilePreview">
                                        <i class="ri-book-open-line"></i>   {{ $submitFilename }}
                                    </button>
                                </h6>
                           @endif
                        @endif

                       @if (now() < $data['assignment']->deadline)
                                <form action="{{ $data['url'] }}" class="row p-2" method="post" id="modal_values"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="ot-contact-form mb-24">
                                        <label for="content" class="form-label ">File Upload (PDF)</label>
                                        <div class="ot_fileUploader left-side mb-2 file-upload-browse">
                                            <input class="form-control form-control file_placeholder" type="text"
                                                   placeholder="{{ ___('student.Assignment File') }}" id="placeholder">
                                            <button class="border-0" type="button">
                                                <label class="btn-uplode" for="assignment_file">{{ ___('student.Brouse') }}</label>
                                                <input type="file" class="d-none form-control" name="assignment_file"
                                                       accept=".pdf" id="assignment_file">
                                            </button>
                                        </div>
                                        <div class="invalid-feedback d-inline error-assignment_file"></div>
                                    </div>

                                    <div class="btn-wrapper d-flex flex-wrap gap-10 mt-20">
                                        <button class="btn-primary-fill " type="button"
                                                onclick="submitMainForm()">{{ @$data['button'] }}</button>
                                        <button class="btn-primary-outline close-modal"
                                                type="button">{{ ___('student.Discard') }}</button>
                                    </div>
                                </form>

                       @else

                        <div class="text-center border-bottom pb-2 mb-4">
                            <h3 class="text-primary fw-bold">
                                <i class="ri-award-line me-2"></i> {{ ___('student.Result') }}
                            </h3>
                        </div>
                        @if($submission->is_reviewed == 1)
                        <table class="table table-bordered table-striped align-middle text-center mt-4">
                            <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ ___('student.Full Marks') }}</th>
                                <th scope="col">{{ ___('student.Obtained Mark') }}</th>
                                <th scope="col">{{ ___('student.Status') }}</th>
                                <th scope="col">{{ ___('student.Comment') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><strong>{{ $data['assignment']->marks }}</strong></td>
                                <td>
                                  <strong>{{ $submission->marks }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $submission->status->class }}">
                                        {{ $submission->status->name }}
                                    </span>
                                </td>
                                <td>
                                     {!! $submission->details  !!}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                         @else
                            <div class="text-center mt-4">
                                <h4 class="text-{{ @$submission->status->class }}">
                                    <i class="ri-information-line me-1"></i> {{ @$submission->status->name }}
                                </h4>
                            </div>
                        @endif
                    @endif
                    @else
                        @if (now() > $data['assignment']->deadline)
                            <h6 class="title mb-25 mt-25">
                                <strong>{{ ___('student.Submit Status')}} : </strong>
                                <span class="ms-2 text-14 text-danger">{{ ___('student.Expired') }}</span>
                            </h6>
                        @else
                        <form action="{{ $data['url'] }}" class="row p-2" method="post" id="modal_values"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="ot-contact-form mb-24">
                                <label for="content" class="form-label ">File Upload (PDF)</label>
                                <div class="ot_fileUploader left-side mb-2 file-upload-browse">
                                    <input class="form-control form-control file_placeholder" type="text"
                                           placeholder="{{ ___('student.Assignment File') }}" id="placeholder">
                                    <button class="border-0" type="button">
                                        <label class="btn-uplode" for="assignment_file">{{ ___('student.Brouse') }}</label>
                                        <input type="file" class="d-none form-control" name="assignment_file"
                                               accept=".pdf" id="assignment_file">
                                    </button>
                                </div>
                                <div class="invalid-feedback d-inline error-assignment_file"></div>
                            </div>

                            <div class="btn-wrapper d-flex flex-wrap gap-10 mt-20">
                                <button class="btn-primary-fill " type="button"
                                        onclick="submitMainForm()">{{ @$data['button'] }}</button>
                                <button class="btn-primary-outline close-modal"
                                        type="button">{{ ___('student.Discard') }}</button>
                            </div>
                        </form>
                       @endif
                    @endif

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="float: right;">
                    <h5 class="modal-title text-center w-100">   {{ $data['assignment']->title }}</h5> <!-- Centered Title -->
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
<script src="{{ asset('frontend/js/student/__modal.min.js') }}"></script>
<!-- jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Then Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- pdf.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

<script>
    $(document).ready(function() {
        let pdfDoc = null,
            currentPage = 1,
            totalPages = 0,
            scale = 1.5,
            canvas = document.getElementById('pdfViewerCanvas'),
            ctx = canvas.getContext('2d');


        function loadPDF(url) {
            var pdfjsLib = window['pdfjs-dist/build/pdf'];
            pdfjsLib.GlobalWorkerOptions.workerSrc =
                'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

            pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
                pdfDoc = pdfDoc_;
                totalPages = pdfDoc.numPages;
                document.getElementById('totalPages').textContent = totalPages;
                currentPage = 1;
                renderPage(currentPage);
            }).catch(function(error) {
                alert("Failed to load PDF.");
                console.error(error);
            });
        }


        function renderPage(pageNum) {
            pdfDoc.getPage(pageNum).then(function(page) {
                var viewport = page.getViewport({ scale: scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };

                page.render(renderContext).promise.then(function() {
                    addWatermark();
                });

                document.getElementById('pageNumber').textContent = pageNum;
            });
        }


        function addWatermark() {
            var userName = $('#userName').val();
            var userPhone = $('#userPhone').val();

            ctx.font = "bold 40px Arial";
            ctx.fillStyle = "rgba(0, 0, 0, 0.2)";
            ctx.textAlign = "center";
            ctx.textBaseline = "middle";

            const x = canvas.width / 2;
            const y = canvas.height / 2;

            ctx.save();
            ctx.translate(x, y);
            ctx.rotate(-Math.PI / 4);

            ctx.fillText(userName, 0, -25);
            ctx.fillText(userPhone, 0, 25);

            ctx.restore();
        }


        $('#bookPreview').on('click', function() {
            let url = $('#getFile').val();
            if(!url) {
                alert("No file URL found.");
                return;
            }
            $('#pdfModal').modal('show');
            loadPDF(encodeURI(url));
        });

        $('#submitFilePreview').on('click', function() {
            let url = $('#submitFilePath').val();
            if(!url) {
                alert("No submitted file URL found.");
                return;
            }
            $('#pdfModal').modal('show');
            loadPDF(encodeURI(url));
        });

        $('#prevPage').on('click', function() {
            if (currentPage <= 1) return;
            currentPage--;
            renderPage(currentPage);
            scrollModalToTop();
        });

        $('#nextPage').on('click', function() {
            if (currentPage >= totalPages) return;
            currentPage++;
            renderPage(currentPage);
            scrollModalToTop();
        });

        $('#jumpToPageBtn').on('click', function() {
            var jumpToPageNum = parseInt($('#jumpToPage').val());
            if (jumpToPageNum >= 1 && jumpToPageNum <= totalPages) {
                currentPage = jumpToPageNum;
                renderPage(currentPage);
                scrollModalToTop();
            } else {
                alert("Please enter a valid page number between 1 and " + totalPages);
            }
        });


        $('.close, .close-icon').on('click', function() {
            $('#pdfModal').modal('hide');
        });

        $('#pdfModal').on('contextmenu', function(e) {
            e.preventDefault();
        });
        function scrollModalToTop() {
            let modalBody = document.querySelector('#pdfModal .modal-body');
            if (modalBody) {
                modalBody.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        }
    });
</script>

{{-- scroll to top features --}}
<script>
$(document).ready(function() {
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
});
</script>

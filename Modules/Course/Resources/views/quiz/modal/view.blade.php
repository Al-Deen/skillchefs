<div class="modal fade lead-modal" id="lead-modal" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content data">
            <div class="modal-header modal-header-image mb-3">
                <h5 class="modal-title">{{ @$data['title'] }} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-12">

                        <div
                            class="section-tittle border-bottom d-flex align-items-center justify-content-between flex-wrap mb-10 pb-20">
                            <h6 class="small-title text-capitalize font-600">{{ ___('student.Answer sheet') }}</h6>
                        </div>
                        <div
                            class="small-tittle-two  d-flex align-items-center justify-content-between flex-wrap mb-30 pb-8">
                            <p class="text-18 font-400 text-secondary">{{ ___('student.Correct Answers') }}: <strong
                                    class="text-title font-500">{{ @$data['result']->questionSubmit()->where('is_correct', 1)->count() }}/{{ $data['result']->quiz->questions->count() }}</strong>
                            </p>
                            <p class="text-18 font-400 text-secondary">{{ ___('student.Obtained Mark') }}: <strong
                                    class="text-title font-500">{{ @$data['result']->marks }} /
                                    {{ @$data['result']->quiz->marks }}</span></strong></p>
                        </div>

                    </div>
                </div>
                <div class="row">

                    @if (@$data['result']->quiz->questions)
                        @foreach (@$data['result']->quiz->questions as $key => $question)
                            <div class="col-lg-6">
                                <!-- Single quiz-->
                                <div class="ans-sheet mb-30">
                                    <h5 class="quize-number text-16 text-title mb-3 0">{{ ___('student.Q') }}.
                                        <?= @$question->title ?>
                                    </h5>
                                    <ul class="quize-list">
                                        @if (@$question->type == 0)
                                            @foreach (json_decode(@$question->options ?? '[]') as $key2 => $option)
                                                <li class="single-list-quize">
                                                    <!-- Check Box -->
                                                    <div
                                                        class="remember-checkbox quize  {{ @$question->submitAnswer($question, $data['result']->user_id)->answer && in_array($option, json_decode(@$question->submitAnswer($question, $data['result']->user_id)->answer)) ? 'selected-quize' : '' }} {{ @$question->submitAnswer($question, $data['result']->user_id)->is_correct == 1 ? 'true' : 'false' }}">
                                                        <label>
                                                            <input class="ot-checkbox" type="radio"
                                                                id="option-one{{ $key2 }}" name="option"
                                                                value="{{ $option }}" />
                                                            <small class="text-title text-15 text-secondary">
                                                                {{ $key2 + 1 }})
                                                                {{ $option }}</small>
                                                            <span class="ot-checkmark radio"></span>
                                                        </label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @else
                                            @foreach (json_decode(@$question->options ?? '[]') as $key2 => $option)
                                                <li class="single-list-quize">
                                                    <div
                                                        class="remember-checkbox quize {{ @$question->submitAnswer($question, $data['result']->user_id)->answer && in_array($option, json_decode(@$question->submitAnswer($question, $data['result']->user_id)->answer)) ? 'selected-quize' : '' }} {{ @$question->submitAnswer($question, $data['result']->user_id)->is_correct == 1 ? 'true' : 'false' }}">
                                                        <label>
                                                            <input class="ot-checkbox" type="checkbox"
                                                                id="option-one{{ $key2 }}" name="option"
                                                                value="{{ $option }}" />
                                                            <small class="text-title text-15 text-secondary">
                                                                {{ $key2 + 1 }})
                                                                {{ $option }}</small>
                                                            <span class="ot-checkmark"></span>
                                                        </label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    <p class="mt-20">
                                        <strong class="text-secondary">{{ ___('student.Ans') }} : </strong>
                                        @foreach (json_decode(@$question->answer ?? '[]') as $index => $answer)
                                            {{ $answer }}
                                            @if ($index != count(json_decode(@$question->answer ?? '[]')) - 1)
                                                ,
                                            @endif
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>

            </div>
        </div>
    </div>
</div>

 <!-- Single quiz-->
 @forelse ($data['questions'] as $key => $question)
     <div class="single-quize-wrapper">
         <h5 class="quize-number text-16 text-title mb-3 0" id="display-question"
             data-id="{{ encryptFunction($question->id) }}">{{ ___('student.Q') }}. <?= @$question->title ?></h5>
         <ul class="quize-list">
             @if (@$question->type == 0)
                 @foreach (json_decode(@$question->options ?? '[]') as $key2 => $option)
                     <li class="single-list-quize">
                         <!-- Check Box -->
                         <div class="remember-checkbox quize">
                             <label>
                                 <input class="ot-checkbox" type="radio" id="option-one{{ $key2 }}"
                                     name="option" value="{{ $option }}"
                                     {{ @$question->userAnswer->answer && in_array($option, json_decode(@$question->userAnswer->answer)) ? 'checked' : '' }} />
                                 <p class="text-title text-15 text-secondary">{{ $key2 + 1 }}) {{ $option }}
                                 </p>
                                 <span class="ot-checkmark radio"></span>
                             </label>
                         </div>
                     </li>
                 @endforeach
             @else
                 @foreach (json_decode(@$question->options ?? '[]') as $key2 => $option)
                     <li class="single-list-quize">
                         <!-- Check Box -->
                         <div class="remember-checkbox quize style2">
                             <label>
                                 <input class="ot-checkbox" type="checkbox" id="option-one{{ $key2 }}"
                                     name="option" value="{{ $option }}"
                                     {{ @$question->userAnswer->answer && in_array($option, json_decode(@$question->userAnswer->answer)) ? 'checked' : '' }} />
                                 <small class="text-title text-15 text-secondary">{{ $key2 + 1 }}) {{ $option }}
                                 </small>
                                 <span class="ot-checkmark"></span>
                             </label>
                         </div>
                     </li>
                 @endforeach
             @endif
         </ul>
     </div>
 @empty
     <div class="game-question-container">
         <h6 id="display-question text-tertiary">
             {{ ___('student.No Question Found') }}
         </h6>
     </div>
 @endforelse

 <!-- Submit btn -->
 <?= $data['questions']->links('panel.student.course.quiz.pagination') ?>

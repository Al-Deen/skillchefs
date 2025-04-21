   <!-- Become an instructor S t a r t-->
   <section class="become-instructor pt-50 mb-100 section-bg-two" id="ot_become_an_instructor" @if(@$section->color) style="background:{{ @$section->color }}" @endif>
       <div class="container">
           <div class="row justify-content-between align-items-center">
               <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 overflow-hidden">
                   <!-- about-img -->
                   <div class="about-img tilt-effect">
                       <img src="{{ showImage(gallery('become-an-instructor'), 'backend/uploads/default-images/become_instructor.png') }}" class="w-100" alt="img">
                   </div>
               </div>
               <div class="col-xxl-6 col-xl-6 col-lg-7 col-md-12">
                   <div class="about-caption mb-24 mt-24">
                       <h3 class="title font-600">{{ ___('frontend.Become an instructor') }}</h3>
                       <p class="pera">
                           {{ ___("frontend.become_instructor_text") }}
                       </p>
                       <a href="{{ route('becomeInstructor') }}"
                           class="btn-secondary-fill">{{ ___('frontend.Register here') }} <i
                               class="ri-arrow-right-line"></i></a>
                   </div>
               </div>
           </div>
       </div>
   </section>
   <!-- Become an instructor End-of about-->

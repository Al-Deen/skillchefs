<div class="row g-24">
    @forelse ($data['courses'] as $key => $course)
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 view-wrapper">
            @include('frontend.partials.course.course_widget', [
                'course' => $course,
            ])
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-warning text-center">
                <h4 class="text-16 font-500">{{ ___('frontend.No Courses Found') }}</h4>
            </div>

        </div>
    @endforelse
</div>
<?= $data['courses']->links('frontend.partials.pagination', ['event' => 'coursePagination']) ?>

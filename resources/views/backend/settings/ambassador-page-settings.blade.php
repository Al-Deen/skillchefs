@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
    <div class="page-content">
        {{-- Breadcrumb Area --}}
        @include('backend.ui-components.breadcrumb', [
            'title' => @$data['title'],
            'routes' => [
                route('dashboard') => ___('common.Dashboard'),
                '#' => @$data['title'],
            ],
            'buttons' => 1,
        ])

        <div class="card ot-card">

            <div class="card-body">
                <form action="{{ route('settings.update-ambassador-setting') }}" method="POST" id="pointsForm">
                    @csrf

                    {{-- Mail Host --}}
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="title" class="form-label">{{ ___('settings.Title') }} </label>
                            <input class="form-control ot-input @error('title') is-invalid @enderror" name="title"
                                   value="{{ @$data['data']->title }}"    placeholder="{{ ___('common.title') }}">
                            @error('title')
                            <div id="validationServer04Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="mail_host" class="form-label">{{ ___('settings.Description') }}</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Description">{{ @$data['data']->description }}</textarea>
                            @error('description')
                            <div id="validationServer04Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>


                    {{-- Dynamic Points --}}
                    <div class="row">
                        <div class="col-md-6">
                            <h5>{{ ___('settings.ambassador_points') }}</h5>
                            <div id="pointsContainer"></div>
                        </div>
                        <div class="col-md-6">
                            <h5>Questions</h5>
                            <div id="questionsContainer"></div>
                        </div>
                    </div>


                    <div class="mt-4">
                      <button class="btn btn-lg ot-btn-primary">{{ ___('common.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Style --}}
    <style>
        .point-group .btn {
            height: 38px;
        }

        .point-group input {
            height: 38px;
        }

        .point-group textarea {
            resize: vertical;
        }
    </style>


    <script>
        let pointIndex = 0;
        let questionIndex = 0;

        // Create Point Input Group
        function createPointGroup(index, isFirst = false) {
            const wrapper = document.createElement('div');
            wrapper.className = 'point-group mb-3';
            wrapper.setAttribute('data-index', index);

            const buttons = isFirst
                ? `<button type="button" class="btn btn-success" onclick="addPointRow()">+</button>`
                : `
                <button type="button" class="btn btn-success me-1" onclick="addPointRow()">+</button>
                <button type="button" class="btn btn-danger" onclick="removeRow(this)">-</button>
            `;

            wrapper.innerHTML = `
            <div class="row align-items-start">
                <div class="col-md-10">
                    <input type="text" name="points[${index}][title]" class="form-control mb-2" placeholder="Point Title" required>
                    <textarea name="points[${index}][description]" class="form-control" rows="2" placeholder="Point Description" required></textarea>
                </div>
                <div class="col-md-2 d-flex align-items-start pt-1">
                    ${buttons}
                </div>
            </div>
        `;
            return wrapper;
        }

        function addPointRow() {
            const container = document.getElementById('pointsContainer');
            const isFirst = container.children.length === 0;
            container.appendChild(createPointGroup(pointIndex++, isFirst));
        }

        // Create Question Input Group
        function createQuestionGroup(index, isFirst = false) {
            const wrapper = document.createElement('div');
            wrapper.className = 'question-group mb-3';
            wrapper.setAttribute('data-index', index);

            const buttons = isFirst
                ? `<button type="button" class="btn btn-success" onclick="addQuestionRow()">+</button>`
                : `
                <button type="button" class="btn btn-success me-1" onclick="addQuestionRow()">+</button>
                <button type="button" class="btn btn-danger" onclick="removeRow(this)">-</button>
            `;

            wrapper.innerHTML = `
            <div class="row align-items-start">
                <div class="col-md-10">
                    <input type="text" name="questions[${index}][title]" class="form-control" placeholder="Question Title" required>
                </div>
                <div class="col-md-2 d-flex align-items-start pt-1">
                    ${buttons}
                </div>
            </div>
        `;
            return wrapper;
        }

        function addQuestionRow() {
            const container = document.getElementById('questionsContainer');
            const isFirst = container.children.length === 0;
            container.appendChild(createQuestionGroup(questionIndex++, isFirst));
        }

        function removeRow(button) {
            const group = button.closest('.point-group') || button.closest('.question-group');
            group.remove();
        }

        // Initial load - load existing data or add empty rows if none
        document.addEventListener('DOMContentLoaded', () => {
            let existingPoints = {!! json_encode([
            'titles' => json_decode(@$data['data']->point_title ?? '[]', true),
            'descriptions' => json_decode(@$data['data']->point_description ?? '[]', true)
        ]) !!};

            if (existingPoints.titles.length > 0) {
                existingPoints.titles.forEach((title, index) => {
                    const isFirst = index === 0;
                    const wrapper = createPointGroup(pointIndex++, isFirst);
                    wrapper.querySelector(`input[name="points[${index}][title]"]`).value = title;
                    wrapper.querySelector(`textarea[name="points[${index}][description]"]`).value = existingPoints.descriptions[index] || '';
                    document.getElementById('pointsContainer').appendChild(wrapper);
                });
            } else {
                addPointRow();
            }

            let existingQuestions = {!! json_encode(json_decode(@$data['data']->questions ?? '[]', true)) !!};

            if (existingQuestions.length > 0) {
                existingQuestions.forEach((title, index) => {
                    const isFirst = index === 0;
                    const wrapper = createQuestionGroup(questionIndex++, isFirst);
                    wrapper.querySelector(`input[name="questions[${index}][title]"]`).value = title;
                    document.getElementById('questionsContainer').appendChild(wrapper);
                });
            } else {
                addQuestionRow();
            }
        });
    </script>






@endsection

@extends('backend.master')

@section('title', @$data['title'])

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush

@section('content')
    <div class="card shadow-sm">
        <h4 class="mb-4 text-sm-center text-primary mt-10">
            <i class="fas fa-id-card me-2"></i>{{ @$data['title'] }}
        </h4>
        <div class="card-body">
            <div class="row">
                {{-- Personal Info Table --}}
                <div class="col-md-6 mb-4">
                    <h5 class="text-secondary border-bottom pb-2 mb-3">
                        <i class="fas fa-user-circle me-2"></i>{{ ___('ambassador.Personal Information') }}
                    </h5>
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr>
                            <th width="40%">{{ ___('ambassador.Name') }}</th>
                            <td>{{ $data['ambassador']->user?->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>{{ ___('ambassador.Email') }}</th>
                            <td>{{ $data['ambassador']->user?->email ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>{{ ___('ambassador.Phone') }}</th>
                            <td>{{ $data['ambassador']->user?->phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>{{ ___('ambassador.University') }}</th>
                            <td>{{ $data['ambassador']?->university ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>{{ ___('ambassador.Graduation Year') }}</th>
                            <td>{{ $data['ambassador']?->graduation_year ?? 'N/A' }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Social Media Table --}}
                <div class="col-md-6 mb-4">
                    <h5 class="text-secondary border-bottom pb-2 mb-3">
                        <i class="fas fa-globe me-2"></i>{{ ___('ambassador.Social Profiles') }}
                    </h5>
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr>
                            <th width="40%">
                                <i class="fab fa-facebook text-primary me-1"></i> {{ ___('ambassador.Facebook Link') }}
                            </th>
                            <td>
                                @if($data['ambassador']->user?->facebook_id)
                                    <a href="{{ $data['ambassador']->user->facebook_id }}" target="_blank">
                                        {{ Str::limit($data['ambassador']->user->facebook_id, 50) }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <i class="fab fa-linkedin text-info me-1"></i> {{ ___('ambassador.Linkedln Link') }}
                            </th>
                            <td>
                                @if($data['ambassador']->user?->linkedin_id)
                                    <a href="{{ $data['ambassador']->user->linkedin_id }}" target="_blank">
                                        {{ Str::limit($data['ambassador']->user->linkedin_id, 50) }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <i class="fab fa-instagram text-danger me-1"></i> {{ ___('ambassador.Instagram Link') }}
                            </th>
                            <td>
                                @if($data['ambassador']->user?->instagram_id)
                                    <a href="{{ $data['ambassador']->user->instagram_id }}" target="_blank">
                                        {{ Str::limit($data['ambassador']->user->instagram_id, 50) }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <i class="fab fa-quora text-danger me-1"></i> {{ ___('ambassador.Quora Link') }}
                            </th>
                            <td>
                                @if($data['ambassador']->user?->quora_id)
                                    <a href="{{ $data['ambassador']->user->quora_id }}" target="_blank">
                                        {{ Str::limit($data['ambassador']->user->quora_id, 50) }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <i class="fas fa-file-pdf text-danger me-1"></i> {{ ___('ambassador.CV/Resume') }}
                            </th>
                            <td>
                                @if($data['ambassador']->cv)
                                    <a href="{{ asset($data['ambassador']->cv) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i> View CV
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            @php
                $question_titles = json_decode($data['ambassador']->question_title);
                $question_answers = json_decode($data['ambassador']->question_answer);
            @endphp

            <div class="row mt-4">
                <div class="col-md-12">
                    <h5 class="text-secondary border-bottom pb-2 mb-4">
                        <i class="fas fa-question-circle me-2"></i> {{ ___('ambassador.Question & Answer ') }}
                    </h5>

                    <div class="row gy-3">
                        @foreach($question_titles as $key => $question)
                            <div class="col-md-6">
                                <div class="card shadow-sm border rounded">
                                    <div class="card-body p-3">
                                        <h6 class="card-title text-primary fw-semibold">
                                            {{ $question }}
                                        </h6>
                                        <p class="card-text mb-0 text-dark">
                                            {{ $question_answers[$key] ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

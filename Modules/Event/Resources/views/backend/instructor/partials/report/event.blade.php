<div class="col-xl-12">
    <div class="small-tittle-two border-bottom d-flex align-items-center justify-content-between flex-wrap mb-20 pb-8 gap-10">
        <div class="country d-flex align-items-center ">
            <span class="country text-title font-600 ml-10">{{ ___('event.Event') }}</span>
        </div>
        <div class="right d-flex flex-wrap justify-content-between">
            <!-- search-tab -->
            <div class="search-tab ml-0 mr-0 mb-20">
                <a href="{{ route('instructor.sales_report.event.download') }}"
                    class="tab-btn">{{ ___('event.download report') }}</a>
            </div>
            <!-- /End -->
        </div>
    </div>
</div>
<div class="col-xl-12">
    <div class="activity-table">
        <table class="table-responsive">
            <thead>
                <tr>
                    <th>{{ ___('common.ID') }}</th>
                    <th>{{ ___('event.Event Title') }}</th>
                    <th>{{ ___('event.Event Type') }}</th>
                    <th>{{ ___('event.Category') }}</th>
                    <th>{{ ___('event.Ticket Price') }}</th>
                    <th>{{ ___('event.Event Duration') }}</th>
                    <th>{{ ___('event.Total Registered') }}</th>
                    <th>{{ ___('event.Total Income') }}</th>
                    <th>{{ ___('event.Status') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['enrolls'] as $key => $event)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a target="_blank" href="{{ route('event.home.details', $event->slug) }}">
                                {{ Str::limit(@$event->title, 30) }}
                            </a>
                        </td>
                        <td>{{ @$event->event_type }}</td>
                        <td>{{ @$event->category->title }}</td>
                        <td>{{ @$event->isPaid() }}</td>
                        <td class="create-date">{{ showDate(@$event->start) }} - {{ showDate(@$event->end) }}</td>
                        <td>{{ @$event->register->count() }}</td>
                        <td>{{ showPrice(@$event->register_income[0]->income) }}</td>
                        <td>{{ statusBackend(@$event->status->class, $event->status->name) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">
                            {{-- No Data Found --}}
                            <div class="row justify-content-center">
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <div class="not-data-found table-img text-center pt-50 pb-10">
                                        <img src="{{ @showImage(setting('empty_table'), 'backend/assets/images/no-data.png') }}"
                                            alt="img" class="w-100 mb-20 w-25">
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- /resources/views/events/list.blade.php -->
@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.css">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css"
    integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
#calendar a {
    color: #000000;
    text-decoration: none;
}

.mr-auto {
    margin-right: auto;
}
</style>
<script src="{{ asset('js/script.js') }}"></script>
@endpush

@section('content')
<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-md-12'>
            <div class='card'>
                <div class='card-body'>
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <input type="hidden" id="eventId">
                    <label for="title">Title</label>
                    <input type="text" placeholder="Enter Title" class="form-control" id="title" name="title" value=""
                        required>
                </div>
                <div>

                    <label for="is_all_day">All Day</label>
                    <input type="checkbox" id="is_all_day" checked name="is_all_day" value="" required>
                </div>
                <div>
                    <label for="startDateTime">Start Date/Time</label>
                    <input type="text" placeholder="Select start date" readonly class="form-control" id="startDateTime"
                        name="startDate" value="" required>
                </div>
                <div>
                    <label for="endDateTime">End Date/Time</label>
                    <input type="text" placeholder="Select end date" readonly class="form-control" id="endDateTime"
                        name "endDate" value="" required>
                </div>
                <div>
                    <label for="description">Description</label>
                    <textarea placeholder="Eneter Description" class="form-control" id="description"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger mr-auto" style="display: none" id="deleteEventBtn"
                    onclick="deleteEvent()">Delete Event
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick='submitEventFormData()'>Save changes</button>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.js"></script>
<script type="module"
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"
    integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
const eventsStoreUrl = "{{ route('events.store') }}";
const refetchEventsUrl = "{{ route('refetch-events') }}";
const eventsUpdateUrl = "{{ route('events.update', ['event' => ':eventId']) }}";
const baseUrl = "{{ url('/') }}";
</script>

@endpush
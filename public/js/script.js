// public/js/script.js
var calendar = null;
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        initialDate: new Date(),
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        locale: 'es',
        events: refetchEventsUrl,
        editable: true,
        dateClick: function (info) {
            let startDate, endDate, allDay;
            allDay = $('#is_all_day').prop('checked');
            if (allDay) {
                startDate = moment(info.date).format("YYYY-MM-DD");
                endDate = moment(info.date).format("YYYY-MM-DD");
                initializeStartDateEndDateFormat("Y-m-d", true);

            } else {
                initializeStartDateEndDateFormat("Y-m-d H:i", false);
                startDate = moment(info.date).format("YYYY-MM-DD HH:mm:ss");
                endDate = moment(info.date).add(30, "minutes").format("YYYY-MM-DD HH:mm:ss");
            }
            $('#startDateTime').val(startDate);
            $('#endDateTime').val(endDate);
            modalReset();
            $('#eventModal').modal('show');
        },
        eventClick: function (info) {
            console.log(info);
            modalReset();
            const event = info.event;
            $('#title').val(event.title);
            $("#eventId").val(info.event.id);
            $("#description").val(event.extendedProps.description);
            $("#startDateTime").val(event.extendedProps.startDay);
            $("#endDateTime").val(event.extendedProps.endDay);
            $("#allDay").prop('checked', event.allDay);
            $("#eventModal").modal('show');
            $("#deleteEventBtn").show();
            if (event.allDay) {
                initializeStartDateEndDateFormat("Y-m-d", true);
            } else {
                initializeStartDateEndDateFormat("Y-m-d H:i", false);
            }
        },
        eventDrop: function (info) {
            const event = info.event;
            resizeEventUpdate(event);
        },
        eventResize: function (info) {
            const event = info.event;
            resizeEventUpdate(event);
        },
    });
    calendar.render();
    $('#is_all_day').change(function () {
        let is_all_day = $(this).prop('checked');
        if (is_all_day) {
            let start = $('#startDateTime').val().slice(0, 10);
            $('#startDateTime').val(start);
            let endDateTime = $('#endDateTime').val().slice(0, 10);
            $('#endDateTime').val(endDateTime);
            initializeStartDateEndDateFormat('d-m-Y', is_all_day);
        } else {
            let start = $('#startDateTime').val().slice(0, 10);
            $('#startDateTime').val(start + " 00:00");
            let endDateTime = $('#endDateTime').val().slice(0, 10);
            $('#endDateTime').val(endDateTime + " 00:30");
            initializeStartDateEndDateFormat('d-m-Y H:i', is_all_day);

        }
    })

});

function initializeStartDateEndDateFormat(format, allDay) {
    let timePicker = !allDay;
    $('#startDateTime').datetimepicker({
        format: format,
        timepicker: timePicker
    });
    $('#endDateTime').datetimepicker({
        format: format,
        timepicker: timePicker
    });
}

function modalReset() {
    $('#title').val('');
    $('#description').val('');
    $('#eventId').val('');
    $('#deleteEventBtn').hide('');
}


function submitEventFormData() {
    let eventId = $('#eventId').val();
    let url = eventsUpdateUrl.replace(':eventId', eventId);
    let postData = {
        start: $('#startDateTime').val(),
        end: $('#endDateTime').val(),
        title: $('#title').val(),
        description: $('#description').val(),
        is_all_day: $('#is_all_day').prop('checked') ? 1 : 0
    };
    if (postData.is_all_day) {
        // postData.end = moment().add(1, "days").format{"YYYY-MM-DD"};
    }

    if (eventId) {
        url = eventsUpdateUrl.replace(':eventId', eventId);
        postData._method = "PUT";
    }

    $.ajax({
        type: 'POST',
        url: url,
        dataType: "json",
        data: postData,
        success: function (res) {
            if (res.success) {
                calendar.refetchEvents();
                $('#eventModal').modal('hide');
            } else {
                alert("Something going wrong!!");
            }
        }
    });
}

function deleteEvent() {
    let eventId = $("#eventId").val();
    let url = '';
    if (eventId) {
        url = `${baseUrl}/events/${eventId}`;
    }
    $.ajax({
        type: 'DELETE',
        url: url,
        dataType: "json",
        data: {},
        success: function (res) {
            if (res.success) {
                calendar.refetchEvents();
                $('#eventModal').modal('hide');
            } else {
                alert("Something going wrong!!");
            }
        }
    });
}


function resizeEventUpdate(event) {
    let eventId = event.id;
    let url = `${baseUrl}/events/${eventId}/resize`;
    let start = null, end = null;
    if (event.allDay) {
        start = moment(event.start).format("YYYY-MM-DD");
        end = start;
        if (event.end) {
            end = moment(event.end).format("YYYY-MM-DD");
        }
    } else {
        start = moment(event.start).format("YYYY-MM-DD HH:mm:ss");
        end = start;
        if (event.end){
            end = moment(event.end).format("YYYY-MM-DD HH:mm:ss");
        }
    }
    let postData = {
        start: start,
        end: end,
        is_all_day: event.allDay ? 1 : 0,
        _method: "PUT"
    };

    $.ajax({
        type: 'POST',
        url: url,
        dataType: "json",
        data: postData,
        success: function (res) {
            if (res.success) {
                calendar.refetchEvents();
            } else {
                alert("Something going wrong!!");
            }
        }
    });
}


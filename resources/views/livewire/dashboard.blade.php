<div>
    <div id='calendar' class="dark:text-white"></div>
</div>
@push('styles')
    <style>
        .fc-event-main {
            cursor: pointer;
            /* Change cursor to pointer on hover */
        }
    </style>
@endpush

@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                events: @json($events),
                initialView: 'timeGridFourDay',
                slotMinTime: '07:00:00', // Start time
                slotMaxTime: '21:00:00', // End time
                nowIndicator: true,
                views: {
                    timeGridFourDay: {
                        type: 'timeGrid',
                        duration: {
                            days: 4
                        }
                    }
                },
                eventClick: function(info) {
                    var event = {
                        title: info.event.title,
                        start: info.event.start.toISOString(),
                        end: info.event.end ? info.event.end.toISOString() : null,
                    };
                }
            });
            calendar.render();
        });
    </script>
@endpush

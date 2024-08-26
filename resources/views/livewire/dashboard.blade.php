<div>
    <div id='calendar' class="dark:text-white"></div>

    <div id="schedule-detail-modal" tabindex="-1" aria-hidden="true"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
        <div class="relative max-h-full w-full max-w-2xl">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between rounded-t border-b p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white lg:text-2xl">
                        Schedule details
                    </h3>
                    <button type="button" id="event-modal"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="space-y-6 p-6">

                    <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                        <div class="flex flex-col pb-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Thesis Title</dt>
                            <dd class="text-lg font-semibold" id="thesisTitle"></dd>
                        </div>
                        <div class="flex flex-col py-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Team Name</dt>
                            <dd class="text-lg font-semibold" id="teamName"></dd>
                        </div>
                        <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Members</dt>
                            <dd class="text-lg font-semibold" id="members"></dd>
                        </div>
                        <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Panelists</dt>
                            <dd class="text-lg font-semibold" id="panelists"></dd>
                        </div>
                        <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Venue</dt>
                            <dd class="text-lg font-semibold" id="venue"></dd>
                        </div>
                        <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Type</dt>
                            <dd class="text-lg font-semibold" id="typeOfDefense"></dd>
                        </div>
                    </dl>

                </div>
            </div>
        </div>
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
                const $targetEl = document.getElementById('schedule-detail-modal');
                const modal = new Modal($targetEl);

                let calendarEl = document.getElementById('calendar');
                let calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth', // Set initial view to month
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay' // Add views here
                    },
                    slotMinTime: '07:00:00', // Start time
                    slotMaxTime: '21:00:00', // End time
                    nowIndicator: true,
                    events: @json($events),
                    views: {
                        timeGridFourDay: {
                            type: 'timeGrid',
                            duration: {
                                days: 4
                            }
                        }
                    },
                    eventClick: function(info) {
                        console.log(info);
                        var event = {
                            id: info.event.id,
                            title: info.event.title,
                            start: info.event.start.toISOString(),
                            end: info.event.end ? info.event.end.toISOString() : null,
                        };

                        const members = info.event.extendedProps.members.map(member => member.name).join(
                            ', ');
                        const panelists = info.event.extendedProps.panelists.map(member => member.name)
                            .join(', ');
                        document.getElementById('thesisTitle').innerHTML = event.title;
                        document.getElementById('teamName').innerHTML = info.event.extendedProps.teamName;
                        document.getElementById('members').innerHTML = members;
                        document.getElementById('panelists').innerHTML = panelists;
                        document.getElementById('venue').innerHTML = info.event.extendedProps.venue;
                        document.getElementById('typeOfDefense').innerHTML = info.event.extendedProps
                            .typeOfDefense;
                        modal.show();
                    }
                });

                calendar.render();

                const modalCloseBtn = document.getElementById('event-modal');
                modalCloseBtn.addEventListener('click', function() {
                    modal.hide();
                });
            });
        </script>
    @endpush

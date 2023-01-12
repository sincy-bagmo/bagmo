/**
 * App Calendar
 */

/**
 * ! If both start and end dates are same Full calendar will nullify the end date value.
 * ! Full calendar will end the event on a day before at 12:00:00AM thus, event won't extend to the end date.
 **/

/**
 * ! Customized script for minimum functions and requirements .
 * ! Refer the file app-calendar.js in same location for full options js file
 * ! Customized by Root
**/

'use-strict';

// RTL Support
var direction = 'ltr',
    assetPath = '../../../app-assets/';
if ($('html').data('textdirection') == 'rtl') {
    direction = 'rtl';
}

if ($('body').attr('data-framework') === 'laravel') {
    assetPath = $('body').attr('data-asset-path');
}

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar'),
        eventToUpdate,
        sidebar = $('.event-sidebar'),
        calendarsColor = {
            Primary: 'primary',
            Success: 'success',
            Danger: 'danger',
            Warning: 'warning',
            Info: 'info'
        },

        operation = $('#operation'),
        doctor_name = $('#doctor_name'),
        booking_date = $('#booking_date'),
        created_at = $('#created_at'),
        description = $('#description'),

        selectAll = $('.select-all'),
        calEventFilter = $('.calendar-events-filter'),
        filterInput = $('.input-filter'),
        calendarEditor = $('#event-description-editor');

        // Event click function
        function eventClick(info) {
            eventToUpdate = info.event;
            if (eventToUpdate.url) {
                info.jsEvent.preventDefault();
                window.open(eventToUpdate.url, '_blank');
            }

            sidebar.modal('show');
            operation.text(eventToUpdate.title);
            doctor_name.text(eventToUpdate.extendedProps.doctor);
            var dateTimeOptions1 = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true };
            var dateTimeOptions2 = {year: 'numeric', month: 'numeric', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true};
            booking_date.text(eventToUpdate.start.toLocaleString("en-GB", dateTimeOptions1));
            created_at.text(eventToUpdate.extendedProps.created.toLocaleString("en-GB", dateTimeOptions2));
            description.text(eventToUpdate.extendedProps.description);
        }

        // Selected Checkboxes
        function selectedCalendars() {
            var selected = [];
            $('.calendar-events-filter input:checked').each(function () {
                selected.push($(this).attr('data-value'));
            });
            return selected;
        }

        // --------------------------------------------------------------------------------------------------
        // AXIOS: fetchEvents
        // * This will be called by fullCalendar to fetch events. Also this can be used to refetch events.
        // --------------------------------------------------------------------------------------------------
        function fetchEvents(info, successCallback) {
            // Fetch Events from API endpoint reference
            /* $.ajax(
                {
                    url: '../../../app-assets/data/app-calendar-events.js',
                    type: 'GET',
                    success: function (result) {
                        // Get requested calendars as Array
                        var calendars = selectedCalendars();

                        return [result.events.filter(event => calendars.includes(event.extendedProps.calendar))];
                    },
                    error: function (error) {
                        console.log(error);
                    }
                }
            ); */

            var calendars = selectedCalendars();
            // We are reading event object from app-calendar-events.js file directly by including that file above app-calendar file.
            // You should make an API call, look into above commented API call for reference
            selectedEvents = events.filter(function (event) {
                // console.log(event.extendedProps.calendar.toLowerCase());
                return calendars.includes(event.extendedProps.calendar.toLowerCase());
            });
            // if (selectedEvents.length > 0) {
            successCallback(selectedEvents);
            // }
        }

        // Calendar plugins
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: fetchEvents,
            editable: false,
            dragScroll: true,
            dayMaxEvents: 2,
            eventResizableFromStart: true,
            customButtons: {
                sidebarToggle: {
                    text: 'Sidebar'
                }
            },
            headerToolbar: {
                start: 'sidebarToggle, prev,next, title',
                end: 'dayGridMonth,listMonth'
            },
            direction: direction,
            initialDate: new Date(),
            navLinks: false, // can click day/week names to navigate views
            eventClassNames: function ({ event: calendarEvent }) {
                const colorName = calendarsColor[calendarEvent._def.extendedProps.calendar];
                return [
                    // Background Color
                    'bg-light-' + colorName
                ];
            },
            eventClick: function (info) {
                eventClick(info);
            },
        });

        // Render calendar
        calendar.render();

        // Hide left sidebar if the right sidebar is open
        $('.btn-toggle-sidebar').on('click', function () {
            $('.app-calendar-sidebar, .body-content-overlay').removeClass('show');
        });

        // Select all & filter functionality
        if (selectAll.length) {
            selectAll.on('change', function () {
                var $this = $(this);
                if ($this.prop('checked')) {
                    calEventFilter.find('input').prop('checked', true);
                } else {
                    calEventFilter.find('input').prop('checked', false);
                }
                calendar.refetchEvents();
            });
        }

        if (filterInput.length) {
            filterInput.on('change', function () {
                $('.input-filter:checked').length < calEventFilter.find('input').length
                    ? selectAll.prop('checked', false)
                    : selectAll.prop('checked', true);
                calendar.refetchEvents();
            });
        }

        $('.fc-next-button , .fc-prev-button').on('click', function() {
            $('.body-content-overlay').addClass('loading');
            var monthAndYear = $('.fc-toolbar-title').text();
            var arr = monthAndYear.split(' ');
            var month = arr[0];
            var year = arr[1];

            var fullDate = new Date(monthAndYear);
            month = fullDate.toLocaleString("en-GB", {month: '2-digit'});

            $.ajax({
                url: '/admin/calendar/events',
                method : 'GET',
                data : {
                    month : month,
                     year : year
                },
                success: function(response) {
                    if (response.status) {
                        var result = [];
                        $.each(response.orders, function (key, item) {
                            var date = new Date(item.booking_date);
                            result.push({
                                id: item.id,
                                url: '',
                                title: item.operation_name,
                                start: date,
                                end: date,
                                allDay: true,
                                extendedProps: {
                                    calendar: 'Primary',
                                    //custom
                                    doctor: item.doctor_name,
                                    created: new Date(item.created_at),
                                    description: item.description,
                                },
                            });
                        });

                        renderCalendarAjax(fullDate, result);
                    }
                }
            });     
        });

        function renderCalendarAjax(fullDate, result) {
            var initialView = 'dayGridMonth';
            if($('.fc-listMonth-button').hasClass('fc-button-active')) {
                initialView = 'listMonth';
            }

            var calendarAjax = new FullCalendar.Calendar(calendarEl, {
                initialView: initialView,
                events: result,
                editable: false,
                dragScroll: true,
                dayMaxEvents: 2,
                eventResizableFromStart: true,
                customButtons: {
                    sidebarToggle: {
                        text: 'Sidebar'
                    }
                },
                headerToolbar: {
                    start: 'sidebarToggle, prev,next, title',
                    end: 'dayGridMonth,listMonth'
                },
                direction: direction,
                initialDate: fullDate,
                navLinks: false, // can click day/week names to navigate views
                eventClassNames: function ({ event: calendarAjaxEvent }) {
                    const colorName = calendarsColor[calendarAjaxEvent._def.extendedProps.calendar];
                    return [
                        // Background Color
                        'bg-light-' + colorName
                    ];
                },
                eventClick: function (info) {
                    eventClick(info);
                },
            });     
            // Render calendar
            calendarAjax.render();
            $('.body-content-overlay').removeClass('loading');
        }
});

document.addEventListener('DOMContentLoaded', function() {
    const calendarBody = document.getElementById('calendarBody');
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    let startDateSelected = false;
    let startDate = null;
    let endDate = null;

    function updateCalendar() {
        const currentMonth = document.querySelector('input[name="currentMonth"]').value;
        fetch('holiday.blade.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                ajax: true,
                month: currentMonth
            })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('monthName').textContent = data.monthName;
            calendarBody.innerHTML = '';

            // Vorherige Monate
            data.prevMonthDays.forEach(day => {
                const div = document.createElement('div');
                div.classList.add('prev-month');
                div.setAttribute('data-date', `${data.prevMonth}-${String(day).padStart(2, '0')}`);
                div.innerHTML = `<span class="day-number">${day}</span>`;
                calendarBody.appendChild(div);
            });

            // Aktueller Monat
            data.currentMonthDays.forEach(day => {
                const div = document.createElement('div');
                div.classList.add('current-month');
                div.setAttribute('data-date', `${currentMonth}-${String(day).padStart(2, '0')}`);
                div.innerHTML = `<span class="day-number">${day}</span>`;
                calendarBody.appendChild(div);
            });

            // Nächste Monate
            data.nextMonthDays.forEach(day => {
                const div = document.createElement('div');
                div.classList.add('next-month');
                div.setAttribute('data-date', `${data.nextMonth}-${String(day).padStart(2, '0')}`);
                div.innerHTML = `<span class="day-number">${day}</span>`;
                calendarBody.appendChild(div);
            });
            markCalendarRange();
        });
        
    }

    function markCalendarRange() {
        const start = new Date(startDate);
        const end = new Date(endDate);
        const calendarDays = document.querySelectorAll('.calendar-body div[data-date]');
        calendarDays.forEach(d => {
            const dDate = new Date(d.getAttribute('data-date'));
            if (dDate >= start && dDate <= end) {
                d.classList.add('range');
            } else {
                d.classList.remove('range');
            }
        });
    }

    function markSelectedDate(date, type) {
        const calendarDays = document.querySelectorAll('.calendar-body div[data-date]');
        calendarDays.forEach(d => {
            if (d.getAttribute('data-date') === date) {
                d.classList.add(type);
            } else {
                d.classList.remove(type);
            }
        });
    }

    calendarBody.addEventListener('click', function(e) {
        const day = e.target.closest('div[data-date]');
        if (day) {
            const date = day.getAttribute('data-date');
            const [year, month, dayNumber] = date.split('-');
            const formattedDate = `${year}-${month}-${dayNumber.padStart(2, '0')}`;

            if (!startDateSelected) {
                startDate = formattedDate;
                endDate = null;
                startDateInput.value = formattedDate;
                endDateInput.value = null;
                startDateSelected = true;
                markSelectedDate(formattedDate, 'selected');
                markCalendarRange();
            } else {
                if (new Date(formattedDate) < new Date(startDate)) {
                    endDate = startDate;
                    startDate = formattedDate;
                    startDateInput.value = startDate;
                    endDateInput.value = endDate;
                } else {
                    endDate = formattedDate;
                    endDateInput.value = endDate;
                }

                startDateSelected = false;
                markCalendarRange();
            }
        }
    });

    startDateInput.addEventListener('change', function() {
        startDate = this.value;
        startDateSelected = true;
        markSelectedDate(startDate, 'selected');
        markCalendarRange();
    });

    endDateInput.addEventListener('change', function() {
        endDate = this.value;
        markCalendarRange();
    });

    document.querySelector('[name="prevMonth"]').addEventListener('click', function(e) {
        e.preventDefault();
        const currentMonth = document.querySelector('input[name="currentMonth"]').value;
        const [year, month] = currentMonth.split('-').map(Number);

        const newMonth = new Date(year, month);

        newMonth.setMonth(newMonth.getMonth() - 1);

        const newMonthStr = newMonth.toISOString().slice(0, 7);

        document.querySelector('input[name="currentMonth"]').value = newMonthStr;

        updateCalendar();
    });

    document.querySelector('[name="nextMonth"]').addEventListener('click', function(e) {
        e.preventDefault();
        const currentMonth = document.querySelector('input[name="currentMonth"]').value;
        const [year, month] = currentMonth.split('-').map(Number);
        
        const newMonth = new Date(year, month);
        
        newMonth.setMonth(newMonth.getMonth() + 1);

        const newMonthStr = newMonth.toISOString().slice(0, 7);

        document.querySelector('input[name="currentMonth"]').value = newMonthStr;

        updateCalendar();
    });

    document.querySelector('[name="currentMonthButton"]').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector('input[name="currentMonth"]').value = new Date().toISOString().slice(0, 7);
        updateCalendar();
    });

    updateCalendar();
});

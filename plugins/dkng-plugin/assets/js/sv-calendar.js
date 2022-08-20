(function ($, document, window) {

    (function () {

        if ( typeof window.CustomEvent === "function" ) return false;

        function CustomEvent ( event, params ) {
            params = params || { bubbles: false, cancelable: false, detail: null };
            var evt = document.createEvent( 'CustomEvent' );
            evt.initCustomEvent( event, params.bubbles, params.cancelable, params.detail );
            return evt;
        }

        window.CustomEvent = CustomEvent;
    })();

    const timeSubmit = new CustomEvent('timeSubmitted');
    let obj = {};
    let globalDate = '';

    function DatePicker(target) {
        this.target = target;
        let timezone  = $("body").attr('data-timezone');
        let timezone1 = $("body").attr('data-time-backend');
        let defaultTimezone = $("body").attr('data-data-default-timezone');
        timezone = ( timezone ) ? timezone : defaultTimezone;

        this.dateNow =  moment.tz(timezone1, timezone);
        // this.dateNow = moment.tz("America/Los_Angeles");
        console.log( 'this.dateNow', this.dateNow );
        this.selectedDate = this.dateNow.clone();
 		console.log( 'this.selectedDate', this.selectedDate );
        this.template = $(`<div class="sv-date-picker"></div>`);
        this.header = $('<div class="sv-date-picker__header"></div>');
        this.currentMonth = $(`<span class="current-month"></span>`);
        this.nextMonth = $('<i class="fa fa-chevron-right"></i>');
        this.prevMonth = $('<i class="fa fa-chevron-left"></i>');
        this.table = $(`
            <table>
                <thead>
                    <tr>
                        <th>S</th>
                        <th>M</th>
                        <th>T</th>
                        <th>W</th>
                        <th>T</th>
                        <th>F</th>
                        <th>S</th>
                    </tr>
                </thead>
            </table>
        `);
        this.tbody = $('<tbody></tbody>');

        let data = this.init(this.target);

        if(data) {
            this.dateNow = moment.utc(data.selectedDate, 'YYYY-MM-DD');
            this.selectedDate = this.dateNow.clone();
        }

        this.goUpdateMonth(0);
        this.updateTable();

        this.show(this.target);
    }

    DatePicker.prototype.generate = function(now)  {
        const _this = this;

        const startDay = now.clone().startOf('month').startOf('week');
        const endDay = now.clone().endOf('month').endOf('week');

        const date = startDay.clone().subtract(1, 'day');

        const calendarData = [];

        while (date.isBefore(endDay, 'day')) {
            calendarData.push({
                days: Array(7)
                    .fill(0)
                    .map(function () {
                        const value = date.add(1, 'day').clone();
                        const disabled = !now.isSame(value, 'month') || value.isBefore(moment.utc(), 'day');
                        const selected = _this.selectedDate.isSame(value, 'date');

                        return {
                            value, disabled, selected
                        }
                    })
            });
        }

        return calendarData;
    };

    DatePicker.prototype.updateTable = function(date) {
        const _this = this;

        this.calendarData = this.generate(this.dateNow);
        this.tbody.html($(generateTable(this.calendarData)));

        this.tbody.off().on('click', 'td', function (e) {
            _this.saveDate(_this.target, e.target);
            setTimeout(function () {
                _this.generateTimePicker();
            }, 0);
        });

        function generateTable(data) {
            let calendar = '';

            for(let week of data) {
                calendar += '<tr>';

                for(let day of week.days) {
                    const disabled = day.disabled ? 'disabled' : '';
                    const selected = day.selected ? 'selected' : '';

                    calendar += `<td class="${disabled}"><span class="${selected}">${day.value.format('D')}</span></td>`;
                }

                calendar += '</tr>';
            }

            return calendar;
        }
    };

    DatePicker.prototype.generateTimePicker = function () {
        this.table.detach();
        this.nextMonth.detach();
        this.prevMonth.detach();
        this.currentMonth.text('Time');

        const time = new TimePicker();
        time.init(this.template, this.target);
    };

    DatePicker.prototype.init = function (target) {
        const targetInput = $(target).closest('tr').find('.js-sending-date');
        const _this = this;

        this.header.append(this.prevMonth);
        this.header.append(this.currentMonth);
        this.header.append(this.nextMonth);

        this.table.append(this.tbody);

        this.template.append(this.header);
        this.template.append(this.table);

        this.template.on('click', function (e) {
            e.stopPropagation();
        });

        this.prevMonth.on('click', function () {
            _this.goUpdateMonth(-1);
            _this.updateTable();
        });

        this.nextMonth.on('click', function () {
            _this.goUpdateMonth(1);
            _this.updateTable();
        });

        if(targetInput.val()) {
            let selectedDate, selectedTime;

            const submittedDate = targetInput.val().split(' ');

            selectedDate = submittedDate[0];
            selectedTime = submittedDate[1];

            return {selectedDate, selectedTime}
        }

        return null;
    };

    DatePicker.prototype.goUpdateMonth = function (value) {
        if(this.dateNow.isSame(moment.utc(), 'month') && value < 0) return;

        this.dateNow.add(value, 'month');
        this.currentMonth.text(this.dateNow.format('MMMM YYYY'));
    };

    DatePicker.prototype.show = function (_this) {
        _this.classList.add('active');
        _this.disabled = true;

        let top, left;
        const isEdit = _this.classList.contains('sv-edit-field');

        if (isEdit) {
            top = _this.getBoundingClientRect().top + _this.getBoundingClientRect().height + window.pageYOffset - 5;
            left = window.innerWidth > 767 ? _this.getBoundingClientRect().left - 262 : _this.getBoundingClientRect().left - 290;
        } else {
            top = _this.getBoundingClientRect().top + _this.getBoundingClientRect().height + window.pageYOffset - 10;
            left = window.innerWidth > 767 ? _this.getBoundingClientRect().left - 250 : _this.getBoundingClientRect().left - 125;
        }

        this.template.css({
            top: top,
            left: left
        });

        $('body').prepend(this.template);
        this.template.fadeIn();
    };

    DatePicker.prototype.saveDate = function (target, trigger) {
        // const targetInput = $(target).closest('tr').find('.js-sending-date');
        // const targetInputVal = targetInput.val();
        // const targetInputValArray = targetInputVal.split(' ');

        let day = $(trigger).text();
        let month = this.dateNow.month() + 1;
        let date;

        if(+day < 10) {
            day = '0' + day;
        }

        if(+month < 10) {
            month = '0' + month;
        }

        // if(targetInputValArray.length === 2) {
        //     date = `${day}-${month}-${this.dateNow.year()} ${targetInputValArray[1]}`;
        // } else {
            date = `${month}-${day}-${this.dateNow.year()}`;
        // }

        // $(target).closest('tr').find('.js-sending-date').val(date);

        globalDate = date;
    };

    DatePicker.prototype.destroy = function () {
        this.template.remove();
        this.target.classList.remove('active');
        this.target.disabled = false;
    };

    function TimePicker() {
        this.template = $(`<div class="sv-date-picker__time">:</div>`);

        this.hours = $(`<div class="hours"></div>`);
        this.hUp = $('<i class="fa fa-chevron-up"></i>');
        this.hDown = $('<i class="fa fa-chevron-down"></i>');
        this.hCurrent = $('<input type="text" class="hours-time" value="12" maxlength="2">');

        this.minutes = $(`<div class="minutes"></div>`);
        this.mUp = $('<i class="fa fa-chevron-up"></i>');
        this.mDown = $('<i class="fa fa-chevron-down"></i>');
        this.mCurrent = $('<input type="text" class="minutes-time" value="00" maxlength="2">');

        this.timeSwitcher = $(`
            <div class="time-switcher">
                <span>AM</span>
                <input type="checkbox" id="timeSwitcher">
                <label for="timeSwitcher"></label>
                <span>PM</span>
            </div>
        `);

        this.actionButtons = $('<div class="sv-date-picker__navigation"></div>');
        this.submitButton = $('<button type="button">Submit</button>');
    }

    TimePicker.prototype.init = function (template, target) {
        this.target = target;
        this.targetInput = $(target).closest('tr').find('.js-sending-date');
        this.submittedDate = this.targetInput.val().split(' ');

        if(this.submittedDate.length === 2) {

            this.selectedTime = moment(this.submittedDate[1], 'HH:mm:ss').format('hh:mma');

            this.hCurrent.val(this.selectedTime.slice(0, 2));
            this.mCurrent.val(this.selectedTime.slice(3, 5));

            this.time = this.selectedTime.slice(-2);

            this.timeSwitcher.find('input[type="checkbox"]').attr('checked', this.time === 'pm' ? 'checked' : null);
        }

        this.hours.append(this.hUp);
        this.hours.append(this.hCurrent);
        this.hours.append(this.hDown);

        this.minutes.append(this.mUp);
        this.minutes.append(this.mCurrent);
        this.minutes.append(this.mDown);

        this.actionButtons.append(this.submitButton);

        this.template.prepend(this.hours);
        this.template.append(this.minutes);
        this.template.append(this.timeSwitcher);
        this.template.append(this.actionButtons);

        template.append(this.template);

        const _this = this;

        this.hUp.on('click', function () {
            _this.updateHCurrent(1, _this.hCurrent);
        });
        this.hDown.on('click', function () {
            _this.updateHCurrent(-1, _this.hCurrent);
        });
        this.mUp.on('click', function () {
            _this.updateMCurrent(1, _this.mCurrent);
        });
        this.mDown.on('click', function () {
            _this.updateMCurrent(-1, _this.mCurrent);
        });
        this.onFocus([this.hCurrent, this.mCurrent]);
        this.onBlur({
            0: {
                el: this.hCurrent,
                maxVal: 12
            },
            1: {
                el: this.mCurrent,
                maxVal: 59
            }
        });
        this.onInput([this.hCurrent, this.mCurrent]);
        this.submitButton.on('click', function () {
            const editButton = $('<button type="button" class="js-sending-date-edit sv-edit-field"></button>');

            const time = `${_this.hCurrent.val()}:${_this.mCurrent.val()}`;

            const amPm = _this.timeSwitcher.find('input[type="checkbox"]')[0].checked ? 'pm' : 'am';
            const fullTime = globalDate + ' ' + time + amPm;

            const displayInput = $(_this.target).closest('tr').find('.sv-email-campaign__date > div');
            const textBeforeDate = displayInput.data('prev-text') || '';

            displayInput.text(textBeforeDate + moment.utc(fullTime, 'MM-DD-YYYY hh:mma').format('MM-DD-YYYY hh:mma'));
            _this.targetInput.val(moment.utc(fullTime, 'MM-DD-YYYY hh:mma').format('YYYY-MM-DD HH:mm:ss'));

            displayInput.append(editButton);

            _this.destroy(template);

            if($(_this.target).hasClass('sv-button')) {
                $(_this.target).off();
            }

            editButton.datePicker();
        });
    };

    TimePicker.prototype.updateHCurrent = function(val, place) {

        let current = +place.val();
        current += val;

        if(current < 1) current = 12;
        if(current > 12) current = 1;
        if(current < 10) current = '0' + current;

        place.val(current);
    };

    TimePicker.prototype.updateMCurrent = function(val, place) {

        let current = +place.val();
        current += val;

        if(current < 0) current = 59;
        if(current > 59) current = 0;
        if(current < 10) current = '0' + current;

        place.val(current);
    };

    TimePicker.prototype.onFocus = function(elems) {
        for(let el of elems) {
            el.on('focus', function (e) {
                e.target.setSelectionRange(0, e.target.value.length);
            });
        }
    };

    TimePicker.prototype.onBlur = function(elems) {
        const keys = Object.keys(elems);

        for(let key of keys) {
            elems[key].el.on('focusout', function (e) {
                if(e.target.value > elems[key].maxVal) {
                    e.target.value = elems[key].maxVal;
                } else if(e.target.value < 10 && e.target.value.length < 2) {
                    e.target.value = '0' + e.target.value;
                }
            });
        }
    };

    TimePicker.prototype.onInput = function(elems) {
        for(let el of elems) {
            el.on('input', function (e) {
                if(!$.isNumeric(+e.target.value)) {
                    e.target.value = '';
                }
            });
        }
    };

    TimePicker.prototype.destroy = function(template) {
        this.target.classList.add('selected');
        this.target.classList.add('disabled');
        this.target.textContent = 'Scheduled';
        this.target.classList.remove('active');
        this.target.disabled = true;

        template.fadeOut(400, function () {
            template.remove();
        });

        destroyInstance();

        document.dispatchEvent(timeSubmit);
    };

    function bindDatePicker(e) {
        e.stopPropagation();

        destroyInstance();

        obj = new DatePicker(this);
    }

    document.addEventListener('click', destroyInstance);
    window.addEventListener('resize', destroyInstance);
    window.addEventListener('orientationchange', destroyInstance);

    function destroyInstance() {
        if(obj && 'destroy' in obj) {
            obj.destroy();
            obj = null;
        }
    }

    $.fn.datePicker = function() {
        $(this).on('click', bindDatePicker);

        return this;
    };
})(jQuery, document, window);
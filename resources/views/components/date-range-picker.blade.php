<div x-data="{
    showDatepicker: false,
    dateFrom: null,
    dateTo: null,
    hoverDate: null,
    month: '',
    year: '',
    no_of_days: [],
    blankdays: [],
    endToShow: '',
    selecting: false,
    combinedOutputValue: '',
    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September','October', 'November', 'December'],
    daysOfWeek: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

    init() {
        const today = new Date();
        this.month = today.getMonth();
        this.year = today.getFullYear();
        this.getNoOfDays();
    },

    formatDate(date) {
        const day = date.getDate();
        const month = date.toLocaleString('default', { month: 'short' });
        const year = date.getFullYear();
        const suffix = this.getDaySuffix(day);
        return `${day}${suffix} ${month} ${year}`;
    },

    getDaySuffix(day) {
        if (day >= 11 && day <= 13) return 'th';
        switch (day % 10) {
            case 1: return 'st';
            case 2: return 'nd';
            case 3: return 'rd';
            default: return 'th';
        }
    },

    convertToYmd(dateObject) {
        const year = dateObject.getFullYear();
        const month = dateObject.getMonth() + 1;
        const date = dateObject.getDate();
        return `${year}-${String(month).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
    },

    getDateValue(date) {
        const selectedDate = new Date(this.year, this.month, date);
        if (!this.selecting) {
            this.dateFrom = selectedDate;
            this.dateTo = null;
            this.selecting = true;
        } else {
            if (selectedDate < this.dateFrom) {
                this.dateTo = this.dateFrom;
                this.dateFrom = selectedDate;
            } else {
                this.dateTo = selectedDate;
            }
            this.combinedOutputValue = `${this.formatDate(this.dateFrom)} - ${this.formatDate(this.dateTo)}`;
            this.selecting = false;
            this.$dispatch('range-selected', {
                from: this.convertToYmd(this.dateFrom),
                to: this.convertToYmd(this.dateTo)
            });
            this.closeDatepicker();
        }
    },

    handleHover(date) {
        if (this.selecting) {
            this.hoverDate = new Date(this.year, this.month, date);
        }
    },

    isSameDate(d1, d2) {
        return d1.getFullYear() === d2.getFullYear() &&
               d1.getMonth() === d2.getMonth() &&
               d1.getDate() === d2.getDate();
    },

    isToday(date) {
        const today = new Date();
        const d = new Date(this.year, this.month, date);
        return this.isSameDate(today, d);
    },

    isDateFrom(date) {
        const d = new Date(this.year, this.month, date);
        return this.dateFrom && this.isSameDate(d, this.dateFrom);
    },

    isDateTo(date) {
        const d = new Date(this.year, this.month, date);
        return this.dateTo && this.isSameDate(d, this.dateTo);
    },

    isInRange(date) {
        const d = new Date(this.year, this.month, date);
        return this.dateFrom && this.dateTo && d > this.dateFrom && d < this.dateTo;
    },

    isInHoveredRange(date) {
        const d = new Date(this.year, this.month, date);
        return this.dateFrom && !this.dateTo && this.hoverDate && d > this.dateFrom && d < this.hoverDate;
    },

    isInRangeLast(date) {
        const d = new Date(this.year, this.month, date);
        return this.dateFrom && !this.dateTo && this.hoverDate && d > this.dateFrom && this.isSameDate(d, this.hoverDate);
    },

    getNoOfDays() {
        const daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
        const dayOfWeek = new Date(this.year, this.month).getDay();
        this.blankdays = Array.from({ length: dayOfWeek }, (_, i) => i + 1);
        this.no_of_days = Array.from({ length: daysInMonth }, (_, i) => i + 1);
    },

    closeDatepicker() {
        this.endToShow = '';
        this.showDatepicker = false;
        this.hoverDate = null;
    },

    clearDateRangePicker() {
        this.dateFrom = null;
        this.dateTo = null;
        this.combinedOutputValue = '';
    }
}" @clear-date-range-picker.window="clearDateRangePicker()" class="relative" @keydown.escape="closeDatepicker()" @click.outside="closeDatepicker()">
    <div class="flex items-center border rounded-md mt-3 bg-gray-200">
        <div class="relative w-full">
            <div class="absolute inset-y-0 start-0 flex items-center ps-1 pointer-events-none">
                <flux:icon.calendar-date-range class="cursor-pointer size-5" />
            </div>
            <input type="text" @click="endToShow = 'from'; init(); showDatepicker = true" x-model="combinedOutputValue"
                class="focus:outline-none border-0 w-full rounded-md ps-8 p-1.5" />
        </div>
    </div>

    <div class="bg-white mt-2 rounded-lg shadow p-4 absolute" style="width: 17rem" x-show="showDatepicker" x-transition>
        <div class="flex flex-col items-center">
            <div class="w-full flex justify-between items-center mb-2">
                <div>
                    <span x-text="monthNames[month]" class="text-lg font-bold text-gray-800"></span>
                    <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
                </div>
                <div>
                    <button type="button" class="hover:bg-gray-200 p-1 rounded-full"
                        @click="if (month == 0) {year--; month=11;} else {month--;} getNoOfDays()">
                        <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button type="button" class="hover:bg-gray-200 p-1 rounded-full"
                        @click="if (month == 11) {year++; month=0;} else {month++;}; getNoOfDays()">
                        <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="w-full flex flex-wrap mb-3 -mx-1">
                <template x-for="(day, index) in daysOfWeek" :key="index">
                    <div style="width: 14.26%" class="px-1">
                        <div x-text="day" class="text-gray-800 font-medium text-center text-xs"></div>
                    </div>
                </template>
            </div>

            <div class="flex flex-wrap -mx-1">
                <template x-for="blankday in blankdays">
                    <div style="width: 14.28%" class="text-center p-1 text-sm"></div>
                </template>
                <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                    <div style="width: 14.28%">
                        <div @mouseover="handleHover(date)" @click="getDateValue(date)" x-text="date"
                            class="p-2 cursor-pointer text-center text-sm leading-none transition ease-in-out duration-100 bg-blue-200"
                            :class="{
                                'font-bold': isToday(date),
                                'rounded-l-full': isDateFrom(date),
                                'rounded-r-full': isDateTo(date) || isInRangeLast(date),
                                'bg-blue-800 text-white': isDateFrom(date) || isDateTo(date) || isInRangeLast(date),
                                'bg-blue-200': isInRange(date) || isInHoveredRange(date)
                            }">
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

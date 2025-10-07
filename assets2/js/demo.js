(function ($) {
    "use strict";

    $(document).ready(function () {
        var date = new Date();

        $(".right-button").click({ date: date }, next_year);
        $(".left-button").click({ date: date }, prev_year);
        $(".month").click({ date: date }, month_click);

        $(".months-row").children().eq(date.getMonth()).addClass("active-month");
        init_calendar(date);
        $(".events-container").empty();
        show_timezone_selector();
    });

    function init_calendar(date) {
        $(".tbody").empty();
        var calendar_days = $(".tbody");
        var month = date.getMonth();
        var year = date.getFullYear();
        var day_count = days_in_month(month, year);
        var row = $("<tr class='table-row'></tr>");
        date.setDate(1);
        var first_day = date.getDay();

        for (var i = 0; i < 35 + first_day; i++) {
            var day = i - first_day + 1;
            if (i % 7 === 0) {
                calendar_days.append(row);
                row = $("<tr class='table-row'></tr>");
            }
            if (i < first_day || day > day_count) {
                var curr_date = $("<td class='table-date nil'>" + "</td>");
                row.append(curr_date);
            } else {
                var curr_date = $("<td class='table-date'>" + day + "</td>");
                curr_date.click({ day: day, month: month, year: year }, date_click);
                row.append(curr_date);
            }
        }
        calendar_days.append(row);
        $(".year").text(year);
    }

    function days_in_month(month, year) {
        var monthStart = new Date(year, month, 1);
        var monthEnd = new Date(year, month + 1, 1);
        return (monthEnd - monthStart) / (1000 * 60 * 60 * 24);
    }

    function month_click(event) {
        var date = event.data.date;
        $(".active-month").removeClass("active-month");
        $(this).addClass("active-month");
        var new_month = $(".month").index(this);
        date.setMonth(new_month);
        init_calendar(date);
    }

    function next_year(event) {
        var date = event.data.date;
        var new_year = date.getFullYear() + 1;
        $(".year").text(new_year);
        date.setFullYear(new_year);
        init_calendar(date);
    }

    function prev_year(event) {
        var date = event.data.date;
        var new_year = date.getFullYear() - 1;
        $(".year").text(new_year);
        date.setFullYear(new_year);
        init_calendar(date);
    }

    function date_click(event) {
        var day = event.currentTarget.textContent; // Access the text content of the clicked element
        var month = event.data.month;
        var year = event.data.year;
        console.log("Selected date: " + day + " " + months[month] + " " + year);
    }

    function show_timezone_selector() {
        $(".events-container").show(250);
        $("#dialog").hide(250);

        var form_container = $("<div class='form-container'></div>");
        var form_label = $("<label class='form-label' for='timezone'>Select Timezone</label>");
        var timezone_select = $("<select class='input' id='timezone' name='timezone'></select>").css({
            width: "100%",
        });

        var timezones = Intl.supportedValuesOf("timeZone");

        timezones.forEach(function (timezone) {
            var now = new Date();
            var formatter = new Intl.DateTimeFormat("en-US", {
                timeZone: timezone,
                hour: "numeric",
                minute: "numeric",
                hour12: true,
            });
            var time = formatter.format(now);
            var option = $("<option></option>")
                .attr("value", timezone)
                .text(`${timezone} (${time})`);
            timezone_select.append(option);
        });

        form_container.append(form_label).append(timezone_select);
        $(".events-container").append(form_container);

        $("#timezone").select2({
            width: "resolve",
        });
    }

})(jQuery);

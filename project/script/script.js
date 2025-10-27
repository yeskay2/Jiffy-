
function fetchEmployees(selectedDate) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {

                var resultContainer = document.getElementById('result-container');
                resultContainer.innerHTML = xhr.responseText;
            } else {
                console.error('Error occurred during AJAX request.');
            }
        }
    };
    xhr.open('GET', 'getevent.php?selectedDate=' + selectedDate, true);
    xhr.send();
}

var currentDate = new Date().toISOString().split('T')[0];
var inlineDateElement = document.getElementById('inline-date');
if (inlineDateElement) {
    inlineDateElement.value = currentDate;
    fetchEmployees(currentDate);

    inlineDateElement.addEventListener('change', function () {
        var selectedDate = this.value;
        fetchEmployees(selectedDate);
    });
}



const eventLinks = document.querySelectorAll('.event-link');
const popup = document.getElementById('event-details-popup');
const popupTitle = document.getElementById('popup-title');
const popupDetails = document.getElementById('popup-details');
const popupdate = document.getElementById('popup-date');

if (eventLinks && popup && popupTitle && popupDetails && popupdate) {
    eventLinks.forEach(link => {
        link.addEventListener('click', function (event) {
        event.preventDefault();
        const title = this.getAttribute('data-title');
        const details = this.getAttribute('data-details');
        const date = this.getAttribute('data-date');
        const start_time = this.getAttribute('data-start_time');
        const end_time = this.getAttribute('data-end_time');
        const location = this.getAttribute('data-location');
        popupTitle.textContent = title;
        popupDetails.textContent = details;
        popupdate.textContent = date;
        popup.style.display = 'block';
        });
    });
}


function closePopup() {
    popup.style.display = 'none';
}

document.addEventListener("DOMContentLoaded", function () {
    const eventModalContent = document.getElementById('eventModalContent');
    const eventModalElement = document.getElementById('eventModal');
    
    if (eventModalElement && eventModalContent) {
        const eventModal = new bootstrap.Modal(eventModalElement);

        const readMoreLinks = document.querySelectorAll('.read-more1');
        readMoreLinks.forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const description = this.getAttribute('data-description');
            const date = this.getAttribute('data-date');
            const start_time = this.getAttribute('data-start_time');
            const end_time = this.getAttribute('data-end_time');
            const location = this.getAttribute('data-location');

            let content = '<p>' + description + '</p>' + '<p>' + '<b>Date: </b>' + date + '</p>';

            if (start_time) {
                content += '<p>' + '<b>Start Time: </b>' + start_time + '</p>';
            }

            if (end_time) {
                content += '<p>' + '<b>End Time: </b>' + end_time + '</p>';
            }

            if (location) {
                content += '<p>' + '<b>Location: </b>' + location + '</p>';
            }

            eventModalContent.innerHTML = content;
            eventModal.show();
        });
        });

        // Only call updateSliderControls if it's defined
        if (typeof updateSliderControls === 'function') {
            updateSliderControls();
        }
    }
});




$(document).ready(function() {
    setTimeout(function() {
        $(".alert").alert('close');
    }, 3000);
});

function onlyNumberKey(evt) {
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}
var intervalId;

function checkTimeAndRedirect() {
    var currentTime = new Date();

    if (document.cookie.indexOf('redirected=true') === -1) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'check_time.php', true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;

                if (response === 'redirect') {
                   
                    window.location.href = 'logout.php';

                    
                    var expirationDate = new Date();
                    expirationDate.setHours(expirationDate.getHours() + 7);
                    document.cookie = 'redirected=true; expires=' + expirationDate.toUTCString();

                    
                    clearInterval(intervalId);
                }
            }
        };

        xhr.send();
    }
}


checkTimeAndRedirect();


intervalId = setInterval(checkTimeAndRedirect, 3000);

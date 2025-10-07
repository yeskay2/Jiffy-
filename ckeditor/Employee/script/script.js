

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
document.getElementById('inline-date').value = currentDate;
fetchEmployees(currentDate);

document.getElementById('inline-date').addEventListener('change', function () {
    var selectedDate = this.value;
    fetchEmployees(selectedDate);
});



const eventLinks = document.querySelectorAll('.event-link');
const popup = document.getElementById('event-details-popup');
const popupTitle = document.getElementById('popup-title');
const popupDetails = document.getElementById('popup-details');
const popupdate = document.getElementById('popup-date');

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


function closePopup() {
    popup.style.display = 'none';
}

document.addEventListener("DOMContentLoaded", function () {
    const eventModalContent = document.getElementById('eventModalContent');
    const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));

    const readMoreLinks = document.querySelectorAll('.read-more1');
    readMoreLinks.forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const description = this.getAttribute('data-description');
            const date = this.getAttribute('data-date');
            const start_time = this.getAttribute('data-start_time');
            const end_time = this.getAttribute('data-end_time');
            const location = this.getAttribute('data-location');

            let content = '<p>' + description + '</p>' + '<p>' + 'Date: ' + date + '</p>';

            if (start_time) {
                content += '<p>' + 'Time: ' + start_time + '</p>';
            }

            if (end_time) {
                content += '<p>' + 'Endtime: ' + end_time + '</p>';
            }

            if (location) {
                content += '<p>' + 'Location: ' + location + '</p>';
            }

            eventModalContent.innerHTML = content;
            eventModal.show();
        });
    });

    updateSliderControls();
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
$(document).ready(function() {
    setInterval(checkLogoutTime, 60000); 

    function checkLogoutTime() {
        var now = new Date();
        var targetTime = new Date();
        targetTime.setHours(18); 
        targetTime.setMinutes(29); 
        if (now >= targetTime) {
            window.location.href = 'logout.php';
        }
    }
});

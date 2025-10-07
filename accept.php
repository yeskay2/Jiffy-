<?php
$conn = mysqli_connect("localhost", "snh6_jiffy2", "mFbmeGA7HhkYqMt7AVxt", "snh6_jiffy2");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userid = isset($_GET['userid']) ? $_GET['userid'] : '';
$startDate = new DateTime('2024-07-20');
$endDate = new DateTime('2024-07-27');
$currentDate = new DateTime('2024-07-21');

$bookedSlots = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_POST['userid'];
    $date = $_POST['date'];
    $slot = $_POST['slot'];
    $MeetingDateTime = $date . ' ' . $slot;

    $update_query = "UPDATE job_applications SET interviewdate = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update_query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $MeetingDateTime, $userid);
        mysqli_stmt_execute($stmt);
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "Record updated successfully.";
        } else {
            echo "No records updated.";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
}

// Fetch booked slots
$booked_query = "SELECT interviewdate FROM job_applications WHERE interviewdate BETWEEN ? AND ?";
$stmt = mysqli_prepare($conn, $booked_query);
$start = $startDate->format('Y-m-d H:i:s');
$end = $endDate->format('Y-m-d H:i:s');
mysqli_stmt_bind_param($stmt, "ss", $start, $end);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($result)) {
    $bookedSlots[] = $row['interviewdate'];
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Interview Slot</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #bc2d75;
            color: #fff;
            padding: 10px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .btn-custom {
            background-color: #bc2d75;
            color: #fff;
        }
        .disabled-slot {
            background-color: #e9ecef;
            color: #6c757d;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Select Interview Slot</h2>
        </div>
        <form action="" method="POST">
            <input type="hidden" name="userid" value="<?php echo htmlspecialchars($userid); ?>" required>

            <div class="form-group">
                <label for="date">Select Date:</label>
                <select id="date" name="date" class="form-control" required>
                    <option selected disabled hidden value=''>Select Date</option>
                    <?php
                    for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
                        $formattedDate = $date->format('Y-m-d');
                        $isDisabled = ($date < $currentDate && $date != $currentDate) ? 'disabled' : '';
                       
                        echo "<option value='$formattedDate' $isDisabled>$formattedDate</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="slot">Select Time Slot:</label>
                <select id="slot" name="slot" class="form-control" required>
                 <option selected disabled hidden value=''>Select Slot</option>
                    <?php
                    for ($hour = 10; $hour <= 16; $hour++) {
                        $start = sprintf("%02d:00", $hour);
                        $end = sprintf("%02d:00", $hour + 1);
                        $slotValue = "$start-$end";
                        echo "<option value='$slotValue'>$start - $end</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-custom btn-block">Submit</button>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        const bookedSlots = <?php echo json_encode($bookedSlots); ?>;
        const currentDate = new Date('2024-07-21T00:00:00');

        document.getElementById('date').addEventListener('change', function () {
            const selectedDate = this.value;
            const slotSelect = document.getElementById('slot');

            // Enable all options first
            Array.from(slotSelect.options).forEach(option => {
                option.disabled = false;
                option.classList.remove('disabled-slot');
            });

            // Disable already booked slots for the selected date
            bookedSlots.forEach(slot => {
                const [bookedDate, bookedTime] = slot.split(' ');
                if (bookedDate === selectedDate) {
                    Array.from(slotSelect.options).forEach(option => {
                        if (option.value === bookedTime) {
                            option.disabled = true;
                            option.classList.add('disabled-slot');
                        }
                    });
                }
            });
        });

        // Disable dates before the current date, except the current date
        const dateSelect = document.getElementById('date');
        Array.from(dateSelect.options).forEach(option => {
            const optionDate = new Date(option.value);
            if (optionDate < currentDate.setHours(0, 0, 0, 0) && optionDate.toDateString() !== currentDate.toDateString()) {
                option.disabled = true;
                option.classList.add('disabled-slot');
            }
        });

        // Trigger change event to disable slots for the default selected date
        document.getElementById('date').dispatchEvent(new Event('change'));
    </script>
</body>
</html>

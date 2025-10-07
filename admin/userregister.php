<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
<h2>User Registration</h2>
<form action="" method="post" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="fullName">Full Name</label>
                                            <input type="text" class="form-control" id="fullName" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))" minlength="3" name="fullName" placeholder="Enter your full name">
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="email">Date of Birth</label>
                                            <input type="date" class="form-control" name="dob" placeholder="Date of birth" onfocus="(this.type='date')" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="phoneNumber">Phone Number</label>
                                            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" onkeypress="return onlyNumberKey(event)" maxLength="10" minLength="10" placeholder="Enter phone number">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="email">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="userType">Type</label>
                                            <select name="userType" class="selectpicker form-control" data-style="py-0" required>
                                                <option value="">Select Type</option>
                                                <option value="Trainee">Trainee</option>
                                                <option value="Employee">Employee</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="userRole">Role</label>
                                            <select name="userRole" class="selectpicker form-control" data-style="py-0" required>
                                               <?php 
                                                $sql = "SELECT * FROM roles WHERE Company_id = '$companyId'";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {                                               
                                                while($row = $result->fetch_assoc()) {
                                                    $roleName = $row["name"];
                                                    echo "<option value='' disable>Select Role</option>";
                                                    echo "<option value='$roleName'>$roleName</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No roles found</option>";
                                            }

                                               ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="userRole">Date of Joining</label>
                                            <input type="date" class="form-control" name="doj" placeholder="Date of Joining" onfocus="(this.type='date')" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="userRole">Address</label>
                                            <textarea class="form-control" name="address" placeholder="Address" required></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3 custom-file-small">
                                            <label for="profilePicture">Upload Profile Picture</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" accept=".png,.jpg,.jpeg" id="profilePicture" name="profilePicture">
                                                <label class="custom-file-label" for="profilePicture">Choose file</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="d-flex flex-wrap align-items-center justify-content-center mt-2">
                                            <button type="submit" class="custom-btn1 btn-2 mr-3 text-center">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

<script>
    // Basic validation (can be extended)
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        let isValid = true;
        const phone = document.getElementById('phone').value;
        const password = document.getElementById('password').value;

        // Validate phone number (simple check for 10 digits)
        if (!/^[0-9]{10}$/.test(phone)) {
            alert('Please enter a valid phone number.');
            event.preventDefault();
            isValid = false;
        }

        // Validate password length
        if (password.length < 8) {
            alert('Password should be at least 8 characters long.');
            event.preventDefault();
            isValid = false;
        }

        return isValid;
    });
</script>

</body>
</html>

<?php
session_start();
include "./../include/config.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoiceType = $_POST['invoiceType'];
    $projectName = $_POST['projectName'];
    $customerName = $_POST['customerName'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $dueDate = $_POST['dueDate'];  
    

    $services = [];
    if (isset($_POST['service']) && isset($_POST['description']) && isset($_POST['unitCost']) && isset($_POST['quantity'])) {
        $serviceNames = $_POST['service'];
        $descriptions = $_POST['description'];
        $unitCosts = $_POST['unitCost'];
        $quantities = $_POST['quantity'];   
        $tax = $_POST['tax'];    

        $numServices = count($serviceNames);
        for ($i = 0; $i < $numServices; $i++) {
            $serviceName = $serviceNames[$i];
            $description = $descriptions[$i];
            $unitCost = $unitCosts[$i];
            $quantity = $quantities[$i];         

            $service = [
                'name' => $serviceName,
                'description' => $description,
                'unitCost' => $unitCost,
                'quantity' => $quantity
            ];           

            $services[] = $service;
            $randomNumber = rand(10000, 99999);
            $invoiceFormat = "INV-" . $randomNumber;
        }
        $sql = "INSERT INTO invoices (invoice_type, project_name, customer_name, address, email, date, due_date,invoice_number,Company_id,tax)
                VALUES ('$invoiceType', '$projectName', '$customerName', '$address', '$email', '$date', '$dueDate','$invoiceFormat','$companyId','$tax')";

        if ($conn->query($sql) === TRUE) {
            $invoiceId = $conn->insert_id;
            foreach ($services as $service) {
                $serviceName = $service['name'];
                $description = $service['description'];
                $unitCost = $service['unitCost'];
                $quantity = $service['quantity'];

                $sql = "INSERT INTO invoice_services (invoice_id, service_name, description, unit_cost, quantity)
                        VALUES ($invoiceId, '$serviceName', '$description', $unitCost, $quantity)";
                
                $conn->query($sql);
            }
            $_SESSION['success'] = "Invoice created successfully!";
            header("Location: invoice.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "Invalid services data!";
    }
} else {
    echo "Form submission error!";
}
?>

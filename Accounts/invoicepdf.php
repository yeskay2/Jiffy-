<?php

include "./../include/config.php";
if (isset($_GET['invoice'])) {
    $id = $_GET['invoice'];
    $sql = "SELECT invoices.id, invoices.invoice_number, clientinformation.fullName AS customer_name,invoices.invoice_number,
                   invoices.tax, invoices.created_at, invoices.due_date, invoices.status, invoices.project_name,
                   invoices.address, invoices.email, invoices.date, invoices.due_date,
                   SUM(invoice_services.unit_cost * invoice_services.quantity) AS total_cost
            FROM invoices
            JOIN invoice_services ON invoices.id = invoice_services.invoice_id
            JOIN clientinformation ON invoices.customer_name = clientinformation.id
            WHERE invoices.id = ?
            GROUP BY invoices.id";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tax = $row['tax'];
        $total_cost = $row['total_cost'];
        $sqlCompany = "SELECT * FROM `schedules` WHERE `Company_id` = ?";
        $stmtCompany = $conn->prepare($sqlCompany);
        $stmtCompany->bind_param("i", $companyId);
        $stmtCompany->execute();
        $invoicenumber = $row['invoice_number'];
        $resultCompany = $stmtCompany->get_result();
        if ($resultCompany->num_rows > 0) {
            $rowCompany = $resultCompany->fetch_assoc();
        }
        $projectid = $row['project_name'];
        $sqlProject = "SELECT * FROM `projects` WHERE `id` = ?";
        $stmtProject = $conn->prepare($sqlProject);
        $stmtProject->bind_param("i", $projectid);
        $stmtProject->execute();
        $resultProject = $stmtProject->get_result();

        if ($resultProject->num_rows > 0) {
            $rowProject = $resultProject->fetch_assoc();
        }


        ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Invoice | JIFFY</title>
    <link rel="stylesheet" href="./../assets/css/style.css">
    <style>
      .clearfix:after {
        content: "";
        display: table;
        clear: both;
      }
      a {
        color: #5d6975;
        text-decoration: underline;
      }
      body {
        position: relative;
        width: 21cm;
        height: 29.7cm;
        margin: 0 auto;
        color: #001028;
        background: #ffffff;
        font-family: Arial, sans-serif;
        font-size: 12px;
        font-family: Arial;
      }
      header {
        padding: 10px 0;
        margin-bottom: 30px;
      }
      #logo {
        text-align: center;
        margin-bottom: 20px;
      }
      #logo img {
        width: 10 /104770px;
      }
      h1 {
        border-top: 2px solid #5d6975;
        border-bottom: 2px solid #5d6975;
        color: #5d6975;
        font-size: 2.4em;
        line-height: 1.4em;
        font-weight: normal;
        text-align: center;
        margin: 0 0 20px 0;
        background: url(dimension.png);
      }
      #project {
        float: left;
      }
      #project span {
        color: #000;
        font-weight: 800;
        text-align: right;
        width: 52px;
        margin-right: 10px;
        display: inline-block;
        font-size: 0.8em;
      }
      #company {
        float: right;
        text-align: right;
      }
      #project div,
      #company div {
        white-space: nowrap;
        line-height: 2;
      }
      table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 20px;
      }
      table tr:nth-child(2n-1) td {
        background: #f5f5f5;
      }
      table th,
      table td {
        text-align: center;
      }
      table th {
        padding: 10px 20px;
        color: #000;
        font-size: 14px;
        border-bottom: 1px solid #000;
        border-top: 1px solid #000;
        white-space: nowrap;
        font-weight: normal;
        font-weight: 600;
      }
      table .service,
      table .desc {
        text-align: left;
      }
      table td {
        padding: 20px;
        text-align: right;
        font-size: 13px;
      }
      table td.service,
      table td.desc {
        vertical-align: top;
      }
      table td.unit,
      table td.qty,
      table td.total {
        font-size: 1.2em;
      }
      table td.grand {
        border-top: 2px solid #000;
      }
      #notices .notice {
        color: #5d6975;
        font-size: 1.2em;
      }
      footer {
        color: #5d6975;
        width: 100%;
        height: 30px;
        position: absolute;
        bottom: 0;
        border-top: 1px solid #c1ced9;
        padding: 8px 0;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="<?=$rowCompany['logo']?>" style="width: 25%" />
      </div>
      <h1> <?=$invoicenumber?></h1>
      <div id="company" class="clearfix">
        <div><?= $rowCompany['Company_name']?></div>
        <div>
        <?php echo wordwrap($rowCompany['address'], 40, "<br>", true); ?>
        </div>       
        <div><a href="mailto:<?= $rowCompany['emailid']?>"><?= $rowCompany['emailid']?></a></div>
      </div>
      <div id="project">
        <div><span>PROJECT</span> <?=$rowProject['project_name']?></div>
        <div><span>CLIENT</span><?=$row['customer_name']?></div>
        <div><span>ADDRESS</span>
        <?php echo wordwrap($row['address'], 40, "<br>", true); ?>
    </div>
        <div>
          <span>EMAIL</span>
          <a href="mailto:<?=$row['email']?>"><?=$row['email']?></a>
        </div>
        <div><span>DATE</span><?php echo date('d-m-Y', strtotime($row['date'])); ?></div>
        <div><span>DUE DATE</span><?php echo date('d-m-Y', strtotime($row['due_date'])); ?></div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">SERVICE</th>
            <th class="desc">DESCRIPTION</th>
            <th>PRICE</th>
            <th>QTY</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
                        <?php
                        // Query invoice services details
                        $sqlServices = "SELECT * FROM invoice_services WHERE invoice_id = ?";
                        $stmtServices = $conn->prepare($sqlServices);
                        $stmtServices->bind_param("i", $id);
                        $stmtServices->execute();
                        $resultServices = $stmtServices->get_result();

                        while ($rowService = $resultServices->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='service'>" . $rowService['service_name'] . "</td>";
                            echo "<td class='desc'>" . $rowService['description'] . "</td>";
                            echo "<td class='unit'>" . $rowService['unit_cost'] . "</td>";
                            echo "<td class='qty'>" . $rowService['quantity'] . "</td>";
                            echo "<td class='total'>" . ($rowService['unit_cost'] * $rowService['quantity']) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                        <tr>
                            <td colspan="4">SUBTOTAL</td>
                            <td class="total"><?= $total_cost ?></td>
                        </tr>
                        <tr>
                            <td colspan="4">TAX <?= $tax ?>%</td>
                            <td class="total"><?= ($total_cost * $tax / 100) ?></td>
                        </tr>
                        <tr style="font-weight: bold">
                            <td colspan="4" class="grand total">GRAND TOTAL</td>
                            <td class="grand total" style="font-size: 17px"><?= number_format($total_cost + ($total_cost * $tax / 100), 2) ?></td>
                        </tr>
                    </tbody>
      </table>
      <button type="button" class="btn btn-primary" style="float: right;" onclick=(print())>Print</button>

    </main>
   
  </body>
</html>
<?php } } ?>
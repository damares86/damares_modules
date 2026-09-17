<?php

declare(strict_types=1);

$customerId = filter_input(INPUT_GET, 'idToMod', FILTER_VALIDATE_INT);
$customer->id = $customerId;
$customer->table = 'customers';
$stmt1 = $customer->showAllWhere('id', ['id']);

$url_pageName = (string) (filter_input(INPUT_GET, 'pageName', FILTER_DEFAULT) ?? '');
$url_tablePage = (string) (filter_input(INPUT_GET, 'tablePage', FILTER_DEFAULT) ?? '');

$id = 0;
$name = '';
$surname = '';
$details = [];
$details_opt = [];

if ($stmt1 instanceof PDOStatement) {
    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    if ($row1) {
        $id = (int) ($row1['id'] ?? 0);
        $name = (string) ($row1['name'] ?? '');
        $surname = (string) ($row1['surname'] ?? '');
        $details = !empty($row1['details']) ? (array) unserialize((string) $row1['details']) : [];
        $details_opt = !empty($row1['details_opt']) ? (array) unserialize((string) $row1['details_opt']) : [];
    }
}
?>

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3 class="d-inline"><?= htmlspecialchars((string) ($customer_edit_header ?? 'Edit Customer'), ENT_QUOTES, 'UTF-8') ?></h3>
            <a href="index.php?p=<?= urlencode($url_pageName) ?>&tablePage=<?= urlencode($url_tablePage) ?>&pageName=<?= urlencode($url_pageName) ?>" class="btn icon btn-info shadow mx-3 px-3">
                <i class="bi bi-arrow-left-circle"></i> &nbsp; <?= htmlspecialchars((string) ($common_back ?? 'Back'), ENT_QUOTES, 'UTF-8') ?>
            </a>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php"><?= htmlspecialchars((string) ($common_dashboard ?? 'Dashboard'), ENT_QUOTES, 'UTF-8') ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= htmlspecialchars((string) ($customer_edit_header ?? 'Edit Customer'), ENT_QUOTES, 'UTF-8') ?>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<br>

<section class="section">
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="card-title"><?= htmlspecialchars((string) ($customer_edit_title ?? 'Edit Customer Details'), ENT_QUOTES, 'UTF-8') ?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="core/mngCustomers.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label><?= htmlspecialchars((string) ($common_name ?? 'Name'), ENT_QUOTES, 'UTF-8') ?><span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group has-icon-left">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="<?= htmlspecialchars((string) ($customer_add_name_ph ?? 'Name'), ENT_QUOTES, 'UTF-8') ?>" id="first-name" name="name" data-parsley-required="true" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-person"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label><?= htmlspecialchars((string) ($common_surname ?? 'Surname'), ENT_QUOTES, 'UTF-8') ?><span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group has-icon-left">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="<?= htmlspecialchars((string) ($customer_add_surname_ph ?? 'Surname'), ENT_QUOTES, 'UTF-8') ?>" id="surname" name="surname" data-parsley-required="true" value="<?= htmlspecialchars($surname, ENT_QUOTES, 'UTF-8') ?>" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-person"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    $customers_details = [];
                                    $customers_details_opt = [];
                                    if (is_file(__DIR__ . '/../../core/customersDetails.php')) {
                                        require __DIR__ . '/../../core/customersDetails.php';
                                    } elseif (is_file('core/customersDetails.php')) {
                                        require 'core/customersDetails.php';
                                    }

                                    $counter = 0;
                                    foreach ($customers_details as $item) {
                                        $labelVar = 'customer_add_' . $item;
                                        $labelTxt = isset($$labelVar) ? (string) $$labelVar : ucfirst($item);
                                        $value = '';
                                        if (isset($details[$counter]) && is_array($details[$counter])) {
                                            $arrValues = array_values($details[$counter]);
                                            $value = (string) ($arrValues[0] ?? '');
                                        }
                                        $type = ($item === 'birth') ? 'date' : 'text';
                                        ?>
                                        <div class="col-md-3">
                                            <label><?= htmlspecialchars($labelTxt, ENT_QUOTES, 'UTF-8') ?> <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <div class="form-check mandatory">
                                                    <div class="position-relative">
                                                        <input type="<?= $type ?>" class="form-control" placeholder="<?= htmlspecialchars($labelTxt, ENT_QUOTES, 'UTF-8') ?>" name="<?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?>" data-parsley-required="true" value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $counter++;
                                    }

                                    $counter = 0;
                                    foreach ($customers_details_opt as $item) {
                                        $labelVar = 'customer_add_' . $item;
                                        $labelTxt = isset($$labelVar) ? (string) $$labelVar : ucfirst($item);
                                        $value = '';
                                        if (isset($details_opt[$counter]) && is_array($details_opt[$counter])) {
                                            $arrValues = array_values($details_opt[$counter]);
                                            $value = (string) ($arrValues[0] ?? '');
                                        }
                                        $type = ($item === 'birth') ? 'date' : 'text';
                                        ?>
                                        <div class="col-md-3">
                                            <label><?= htmlspecialchars($labelTxt, ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars((string) ($customer_add_optional ?? '(optional)'), ENT_QUOTES, 'UTF-8') ?></label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <div class="position-relative">
                                                    <input type="<?= $type ?>" class="form-control" placeholder="<?= htmlspecialchars($labelTxt, ENT_QUOTES, 'UTF-8') ?>" name="<?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?>" value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $counter++;
                                    }
                                    ?>

                                    <input type="hidden" name="idToMod" value="<?= $id ?>">
                                    <input type="hidden" name="operation" value="edit">
                                    <input type="hidden" name="origin" value="editCustomer">
                                    <input type="hidden" name="url_tablePage" value="<?= htmlspecialchars($url_tablePage, ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="url_pageName" value="<?= htmlspecialchars($url_pageName, ENT_QUOTES, 'UTF-8') ?>">

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1 shadow">
                                            <?= htmlspecialchars((string) ($common_submit ?? 'Submit'), ENT_QUOTES, 'UTF-8') ?>
                                        </button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1 shadow">
                                            <?= htmlspecialchars((string) ($common_reset ?? 'Reset'), ENT_QUOTES, 'UTF-8') ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="card-title"><?= htmlspecialchars((string) ($common_info ?? 'Info'), ENT_QUOTES, 'UTF-8') ?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
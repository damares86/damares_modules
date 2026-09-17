<?php

declare(strict_types=1);

?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?= htmlspecialchars((string) ($customer_add_header ?? 'Add Customer'), ENT_QUOTES, 'UTF-8') ?></h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?= htmlspecialchars((string) ($common_dashboard ?? 'Dashboard'), ENT_QUOTES, 'UTF-8') ?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <?= htmlspecialchars((string) ($customer_add_header ?? 'Add Customer'), ENT_QUOTES, 'UTF-8') ?>
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
                    <h4 class="card-title"><?= htmlspecialchars((string) ($customer_add_title ?? 'Add Customer Details'), ENT_QUOTES, 'UTF-8') ?></h4>
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
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="<?= htmlspecialchars((string) ($customer_add_name_ph ?? 'Enter name'), ENT_QUOTES, 'UTF-8') ?>"
                                                        id="first-name"
                                                        name="name"
                                                        data-parsley-required="true" />
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
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="<?= htmlspecialchars((string) ($customer_add_surname_ph ?? 'Enter surname'), ENT_QUOTES, 'UTF-8') ?>"
                                                        id="surname"
                                                        name="surname"
                                                        data-parsley-required="true" />
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

                                    foreach ($customers_details as $item) {
                                        $labelVar = 'account_add_' . $item;
                                        $labelTxt = isset($$labelVar) ? (string) $$labelVar : ucfirst($item);
                                        $type = ($item === 'birth') ? 'date' : 'text';
                                        ?>
                                        <div class="col-md-3">
                                            <label><?= htmlspecialchars($labelTxt, ENT_QUOTES, 'UTF-8') ?> <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <div class="form-check mandatory">
                                                    <div class="position-relative">
                                                        <input
                                                            type="<?= $type ?>"
                                                            class="form-control"
                                                            placeholder="<?= htmlspecialchars($labelTxt, ENT_QUOTES, 'UTF-8') ?>"
                                                            name="<?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?>"
                                                            data-parsley-required="true" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }

                                    foreach ($customers_details_opt as $item) {
                                        $labelVar = 'account_add_' . $item;
                                        $labelTxt = isset($$labelVar) ? (string) $$labelVar : ucfirst($item);
                                        $type = ($item === 'birth') ? 'date' : 'text';
                                        ?>
                                        <div class="col-md-3">
                                            <label><?= htmlspecialchars($labelTxt, ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars((string) ($customer_add_optional ?? '(optional)'), ENT_QUOTES, 'UTF-8') ?></label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <div class="position-relative">
                                                    <input
                                                        type="<?= $type ?>"
                                                        class="form-control"
                                                        placeholder="<?= htmlspecialchars($labelTxt, ENT_QUOTES, 'UTF-8') ?>"
                                                        name="<?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>

                                    <input type="hidden" name="operation" value="add">
                                    <input type="hidden" name="origin" value="addCustomer">

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
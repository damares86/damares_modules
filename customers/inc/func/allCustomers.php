<?php

declare(strict_types=1);



if (!isset($customer) || !($customer instanceof Customer)) {
    $customer = new Customer($db);
    if (!empty($prefix)) {
        $customer->prx = $prefix . '_';
    }
}$customer->table = 'customers';
$stmt = $customer->showAll('id');
?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?= htmlspecialchars((string) ($customer_all_header ?? 'Customers'), ENT_QUOTES, 'UTF-8') ?></h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?= htmlspecialchars((string) ($common_dashboard ?? 'Dashboard'), ENT_QUOTES, 'UTF-8') ?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <?= htmlspecialchars((string) ($customer_all_header ?? 'Customers'), ENT_QUOTES, 'UTF-8') ?>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>

<section class="section">
  <div class="card shadow">
    <div class="card-header"><?= htmlspecialchars((string) ($customer_all_title ?? 'All Customers'), ENT_QUOTES, 'UTF-8') ?> &nbsp; &nbsp; &nbsp;
      <a href="index.php?p=addCustomer" class="btn icon icon-left btn-success shadow"><i data-feather="plus-circle"></i> <?= htmlspecialchars((string) ($customer_all_add ?? 'Add Customer'), ENT_QUOTES, 'UTF-8') ?></a>
    </div>
    <div class="card-body">
      <table class="table" id="table">
        <thead>
          <tr>
            <th><?= htmlspecialchars((string) ($customer_all_surname_table ?? 'Surname'), ENT_QUOTES, 'UTF-8') ?></th>
            <th><?= htmlspecialchars((string) ($customer_all_name_table ?? 'Name'), ENT_QUOTES, 'UTF-8') ?></th>
            <th><?= htmlspecialchars((string) ($common_actions ?? 'Actions'), ENT_QUOTES, 'UTF-8') ?></th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($stmt instanceof PDOStatement) {
              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $cId = (int) ($row['id'] ?? 0);
                  $cSurname = (string) ($row['surname'] ?? '');
                  $cName = (string) ($row['name'] ?? '');
                  ?>
                  <tr>
                    <td><?= htmlspecialchars($cSurname, ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($cName, ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                      <a href="index.php?p=editCustomer&idToMod=<?= $cId ?>" class="btn icon btn-warning shadow edit-link" data-base-url="index.php?p=editCustomer&idToMod=<?= $cId ?>"><i class="bi bi-pencil-square"></i></a>
                      &nbsp; &nbsp;
                      <a href="#" class="btn icon btn-danger shadow" data-bs-toggle="modal" data-bs-target="#danger<?= $cId ?>"><i class="bi bi-trash"></i></a>
                      
                      <div class="modal fade text-left" id="danger<?= $cId ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?= $cId ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-danger">
                              <h5 class="modal-title white" id="myModalLabel<?= $cId ?>">
                                <?= htmlspecialchars((string) ($common_modal_title_sure ?? 'Are you sure?'), ENT_QUOTES, 'UTF-8') ?>
                              </h5>
                              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                              </button>
                            </div>
                            <div class="modal-body">
                              <?= htmlspecialchars((string) ($customer_all_modal_body ?? 'Do you really want to delete this customer?'), ENT_QUOTES, 'UTF-8') ?>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <span class="d-none d-sm-block"><?= htmlspecialchars((string) ($common_modal_cancel ?? 'Cancel'), ENT_QUOTES, 'UTF-8') ?></span>
                              </button>
                              <a href="core/mngCustomers.php?idToDel=<?= $cId ?>" class="btn btn-danger ml-1">
                                <?= htmlspecialchars((string) ($common_modal_confirm ?? 'Confirm'), ENT_QUOTES, 'UTF-8') ?>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <?php
              }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
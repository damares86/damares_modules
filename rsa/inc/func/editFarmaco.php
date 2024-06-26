<?php

$id = filter_input(INPUT_GET, "idToMod");
$rsa->id = $id;
$rsa->table = 'farmaci';
$stmt1 = $rsa->showAllWhere('id', ['id']);
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
extract($row1);

$url_tablePage = filter_input(INPUT_GET, 'tablePage');
$url_pageName = filter_input(INPUT_GET, 'pageName');

?>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3 class="d-inline">Modifica un farmaco</h3>
            <a href="index.php?p=<?= $url_pageName ?>&tablePage=<?= $url_tablePage ?>&pageName=<?= $url_pageName ?>" class="btn icon btn-info shadow mx-3 px-3">
                <i class="bi bi-arrow-left-circle"></i> &nbsp; <?= $common_back ?>
            </a>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php"><?= $common_dashboard ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Modifica un farmaco
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<br>

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Modifica farmaco: <b><?= $row1['principio'] ?></b></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="core/mngFarmaci.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Principio attivo <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="Nome del principio attivo" name="principio" data-parsley-required="true" value="<?= $row1['principio'] ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">&nbsp;</div>

                                    <div class="col-md-3">
                                        <label>Compresse per scatola <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="Numero compresse" name="cpr_box" data-parsley-required="true" value="<?= $row1['cpr_box'] ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">&nbsp;</div>

                                </div>

                                <input type="hidden" name="operation" value="edit">
                                <input type="hidden" name="origin" value="editFarmaco">
                                <input type="hidden" name="idToMod" value="<?= $id ?>">
                                <input type="hidden" name="url_tablePage" value="<?= $url_tablePage ?>">
                                <input type="hidden" name="url_pageName" value="<?= $url_pageName ?>">

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">
                                        <?= $common_submit ?>
                                    </button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                        <?= $common_reset ?>
                                    </button>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>
</section>
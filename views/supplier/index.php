  <div class="container container-dashboard f-column">
    <section class="dashboard-header bg-blue">
      <?php
      $title = 'Proveedores';
      $buttonName = 'Añadir';
      include 'views/includes/header-button-dash.php'; ?>
    </section>
    <?php if ($suppliers['valid']) { ?>

      <section class="bg-white dashboard-content shadow-sm">
        <div class="d-flex j-between f-items-end pd-b-1">
          <div class="d-flex f-items-end w-100-sm">
            <?php
            include 'views/includes/search.php';
            ?>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <?php
                $thead = [
                  ['name' => 'Razón social', 'order' => 'business_name', 'alt' => 'ASC'],
                  ['name' => 'Nombre comercial', 'order' => 'tradename', 'alt' => 'ASC'],
                  ['name' => 'CIF/NIF'],
                  ['name' => 'Email'],
                  ['name' => 'Teléfono'],
                  ['name' => 'Creado', 'order' => 'created', 'alt' => 'DESC', 'title' => 'fecha']
                ];
                include 'views/includes/thead-order.php'; ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($suppliers['result'] as $supplier) { ?>
                <tr>
                  <td><?= $supplier['business_name'] ?></td>
                  <td><?= $supplier['tradename'] ?></td>
                  <td><?= $supplier['cif'] ?></td>
                  <td><?= $supplier['email'] ?></td>
                  <td><?= $supplier['phone'] ?></td>
                  <td>
                    <div class="w-max">
                      <?= date_format(date_create($supplier['created']), 'd-m-Y'); ?>
                    </div>
                  </td>
                  <td>
                    <?php
                    $linkTable = [
                      'title' =>  'proveedor ' . $supplier['business_name'],
                      'links' => [
                        [
                          'name' => 'Editar',
                          'url' =>  '/update/' . $supplier['_id'],
                          'icon' => 'pen'
                        ]
                      ]
                    ];
                    include 'views/includes/dropdown-table.php';
                    ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="d-flex j-content-end pd-t-1">
          <?php include 'views/includes/pagination.php'; ?>
        </div>
      </section>
    <?php } ?>
  </div>
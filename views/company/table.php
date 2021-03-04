<thead>
    <tr>
        <?php
        $thead = [
            ['name' => 'Razón social', 'order' => 'companies.business_name', 'alt' => 'ASC'],
            ['name' => 'Nombre comercial', 'order' => 'companies.tradename', 'alt' => 'ASC'],
            ['name' => 'CIF/NIF'],
            ['name' => 'Estado', 'order' => 'comp_status.status', 'alt' => 'ASC'],
            ['name' => 'Creado', 'order' => 'companies.created', 'alt' => 'DESC', 'title' => 'fecha']
        ];
        include 'views/includes/thead-order.php';
        ?>
    </tr>
</thead>
<tbody>
    <?php foreach ($table['result'] as $company) { ?>
        <tr>
            <td><?= $company['business_name'] ?></td>
            <td><?= $company['tradename'] ?></td>
            <td><?= $company['cif'] ?></td>
            <td class="text-bold text-<?= ($company['_id_status'] == 1) ? 'green' : 'red'; ?>">
                <?= $company['status']; ?>
            </td>
            <td>
                <div class="w-max">
                    <?= date_format(date_create($company['created']), 'd-m-Y'); ?>
                </div>
            </td>
            <td>
                <?php
                $linkTable = [
                    'title' =>  'empresa ' . $company['business_name'],
                    'links' => [
                        [
                            'name' => 'Editar',
                            'url' => '/update/' . $company['_id'],
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
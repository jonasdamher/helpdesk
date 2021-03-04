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
    <?php foreach ($table['result'] as $supplier) { ?>
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
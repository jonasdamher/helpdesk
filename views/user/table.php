<thead>
    <tr>
        <?php
        $thead = [
            ['name' => 'Usuario', 'order' => 'users.lastname', 'alt' => 'ASC', 'title' => 'apellidos'],
            ['name' => 'Rol', 'order' => 'users._id_rol', 'alt' => 'ASC'],
            ['name' => 'Estado', 'order' => 'users._id_status', 'alt' => 'ASC'],
            ['name' => 'Creado', 'order' => 'users.created', 'alt' => 'DESC', 'title' => 'fecha']
        ];
        include 'views/includes/thead-order.php';
        ?>
    </tr>
</thead>
<tbody>
    <?php foreach ($table['result'] as $user) { ?>
        <tr>
            <td class="td-image">
                <?php
                $dirImage = 'users/' . $user['image'];
                $titleImage = $user['name'] . ' ' . $user['lastname'];
                $icon = 'user';
                $sizeImage = '64';

                include 'views/includes/image.php';
                ?>
                <div class="pd-l-1">
                    <p class="text-bold p"><?= $user['name'] . ' ' . $user['lastname']; ?></p>
                    <p class="text-gray"><?= $user['email']; ?></p>
                </div>
            </td>
            <td class="text-bold"><?= $user['rol']; ?></td>
            <td class="text-bold text-<?= ($user['_id_status'] == 1) ? 'green' : 'red'; ?>">
                <?= $user['status'] ?>
            </td>
            <td>
                <div class="w-max">
                    <?= date_format(date_create($user['created']), 'd-m-Y'); ?>
                </div>
            </td>
            <td>
                <?php
                $linkTable = [
                    'title' =>  'usuario ' . $user['name'] . ' ' . $user['lastname'],
                    'links' => [
                        [
                            'name' => 'Editar',
                            'url' => '/update/' . $user['_id'],
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
<thead>
    <tr>
        <?php
        $thead = [
            ['name' => 'Nombre', 'order' => 'articles.name', 'alt' => 'ASC'],
            ['name' => 'Código de barras'],
            ['name' => 'Proveedor', 'order' => 'suppliers.business_name', 'alt' => 'ASC'],
            ['name' => 'Unidades'],
            ['name' => 'Creado', 'order' => 'articles.created', 'alt' => 'DESC', 'title' => 'fecha']
        ];
        include 'views/includes/thead-order.php'; ?>
    </tr>
</thead>
<tbody>
    <?php foreach ($table['result'] as $article) { ?>
        <tr>
            <td class="td-image">
                <?php
                $dirImage = 'articles/' . $article['image'];
                $titleImage = $article['name'];
                $icon = 'box';
                $sizeImage = '64';

                include 'views/includes/image.php';
                ?>
                <div class="pd-l-1">
                    <p class="p"><?= $article['name']; ?>
                    <p>
                    <p class="text-bold text-gray"><?= $article['type']; ?>
                    <p>
                </div>
            </td>
            <td><?= $article['barcode']; ?></td>
            <td><a class="link text-blue" tabindex="-1" href="<?= URL_BASE . 'supplier/update/' . $article['_id_provider']; ?>"><?= $article['business_name'] ?></a></td>
            <td class="text-bold"><?= ($article['units'] == 0) ? 'Ninguna' : $article['units'] ?></td>
            <td>
                <div class="w-max">
                    <?= date_format(date_create($article['created']), 'd-m-Y'); ?>
                </div>
            </td>
            <td>
                <?php
                $linkTable = [
                    'title' =>  'proveedor ' . $article['name'],
                    'links' => [
                        [
                            'name' => 'Ver',
                            'url' =>  '/details/' . $article['_id'],
                            'icon' => 'eye'
                        ], [
                            'name' => 'Editar',
                            'url' =>  '/update/' . $article['_id'],
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
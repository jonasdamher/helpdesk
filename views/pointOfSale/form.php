<form class="form" action="<?= $urlForm ?>" method="post">
    <div class="d-flex f-wrap">
        <fieldset class="fieldset col-6 col-12-md pd-r-1 pd-r-0-md">
            <legend class="text-bold">Datos de punto de venta</legend>
            <div class="d-flex f-wrap">
                <div class="form-box-input col-12">
                    <label class="label" for="name">Nombre de punto de venta</label>
                    <input class="ipt ipt-default" id="name" name="name" type="text" value="<?= $pointOfSale['name'] ?>" maxlength="32" autocomplete="off" required />
                </div>
                <div class="form-box-input col-12">
                    <label class="label" for="company_code">Código de punto de venta</label>
                    <input class="ipt ipt-default" id="company_code" name="company_code" type="text" value="<?= $pointOfSale['company_code'] ?>" maxlength="32" autocomplete="off" />
                </div>
                <div class="form-box-input col-6 pd-r-1 col-12-sm pd-r-0-sm">
                    <label for="id_company">Empresa</label>
                    <div class="select">
                        <select class="ipt ipt-default" id="id_company" name="id_company" required>
                            <?php foreach (Utils::resultCheckSelect($companies, $pointOfSale['id_company']) as $value) { ?>
                                <option value="<?= $value['_id'] ?>"><?= $value['business_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-box-input col-6 col-12-sm">
                    <label for="id_status">Estado</label>
                    <div class="select">
                        <select class="ipt ipt-default" id="id_status" name="id_status" required>
                            <?php foreach (Utils::resultCheckSelect($status, $pointOfSale['id_status']) as $value) { ?>
                                <option value="<?= $value['_id'] ?>"><?= $value['status'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="fieldset col-6 col-12-md">
            <legend class="text-bold">Localización</legend>
            <div class="d-flex f-wrap">
                <div class="form-box-input col-12">
                    <label class="label" for="viewing-country">País</label>
                    <input class="ipt ipt-default" id="viewing-country" name="country" type="text" value="<?= $pointOfSale['country'] ?>" maxlength="32" autocomplete="off" />
                </div>
                <div class="form-box-input col-12">
                    <label class="label" for="address">Dirección</label>
                    <input class="ipt ipt-default" id="address" name="address" type="text" value="<?= $pointOfSale['address'] ?>" autocomplete="off" />
                </div>
                <div class="form-box-input col-12">
                    <label class="label" for="administrative_area_level_2">Provincia</label>
                    <input class="ipt ipt-default" id="administrative_area_level_2" name="province" type="text" value="<?= $pointOfSale['province'] ?>" maxlength="32" autocomplete="off" />
                </div>
                <div class="form-box-input col-6 pd-r-1 col-6-md pd-r-0-xs">
                    <label class="label" for="locality">Localidad</label>
                    <input class="ipt ipt-default" id="locality" name="locality" type="text" value="<?= $pointOfSale['locality'] ?>" maxlength="32" autocomplete="off" />
                </div>
                <div class="form-box-input col-6 col-6-md">
                    <label class="label" for="postal_code">Código postal</label>
                    <input class="ipt ipt-default" id="postal_code" name="postal_code" type="number" value="<?= $pointOfSale['postal_code'] ?>" maxlength="5" autocomplete="off" />
                </div>
            </div>
        </fieldset>
    </div>
    <input id="id_country" name="id_country" type="hidden" />
    <button class="btn btn-lg btn-dark border-rd shadow-lg f-self-end" type="submit">Registrar</button>
</form>
'use strict';

// PETICIONES AJAX CONTACTOS DE PUNTO DE VENTA

$('.contact-new').submit(function (e) {
    e.preventDefault();
    create(this, 'controller=contactPointOfSale&action=new', newTableContact);
});

$('.contact-update').submit(function (e) {
    e.preventDefault();
    update(this, 'controller=contactPointOfSale&action=update', updateTableContact);
});

$('.btn-contact-delete').click(function () {
    remove(this, 'controller=contactPointOfSale&action=delete');
});

// CONTACTS

function newTableContact(form) {

    removeLastRow();

    let table = $('.table').children('tbody');
    $(table).prepend(`<tr data-id="${form.id}"></tr>`);

    let row = $(`tr[data-id='${form.id}']`);
    $(row).prepend(`<td></td>
                    <td></td>
                    <td></td>
                    <td></td>`);

    let col = $(row).children('td');
    $(col[0]).html(form.name);
    $(col[1]).html((form.phone == null) ? 'Ninguno' : form.phone);
    $(col[2]).html(form.email);
    $(col[3]).html(buttonsActionsTable);
}

function updateTableContact(form) {

    let row = $(`tr[data-id='${$('#id_update').val()}']`),
        col = $(row).children('td');

    $(col[0]).html(form.name);
    $(col[1]).html((form.phone == null) ? 'Ninguno' : form.phone);
    $(col[2]).html(form.email);
}
'use strict';

$(function(){

// LABEL INPUTS

if ( $('.ipt')[0] ) {
  labelMovePositionOriginal();
}

$('.ipt').on('focus', function() {

 labelMovePositionOriginal(this, 'only');

})
.focusout( function() {

  let inputLength = $(this).val().trim().length,
      label = $(this).closest('.form-box-input').children('label');

  if(inputLength == 0){
    $(label).removeClass('label-mv text-dark').addClass('label');
  }

});

function labelMovePositionOriginal(ipt = '.ipt', type = 'all') {
 
  if(type == 'only') {
 
    let label = $(ipt).closest('.form-box-input').children('label');
    $(label).removeClass('label').addClass('label-mv text-dark');
  }

  else if(type == 'all') {

    $(ipt).each( function() {
      
      let label = $(this).closest('.form-box-input').children('label'),
      inputLength = $(this).val().trim().length;

      if(inputLength > 0) {
        
        $(label).removeClass('label').addClass('label-mv text-dark');
      }
    });
  }
}

// SNACKBAR

if ( $('.btn-snackbar').length ) {
  lifeTimeSnackbar();
}

function lifeTimeSnackbar() {
  setTimeout(()=> { 
    fadeSnackBar(); 
  }, 4000);
}

$('.btn-snackbar').click( function() {

  fadeSnackBar(this);

});

function fadeSnackBar(btn = '.btn-snackbar') {
  
  let snackbar = $(btn).parent().parent('.snackbar');

  $(snackbar).fadeOut();
}

// MOSTRAR TEXTO INPUT TYPE PASSWORD

$('.btn-view-pass').click( function(e) {

  e.preventDefault();

  let input = $(this).siblings('.ipt'),
      icon = $(this).children('[data-fa-i2svg]');

  if ($(input).is(':password')) {
    
    $(input).prop('type', 'text');
    $(icon).toggleClass('fa-eye');
  }else {

    $(input).prop('type', 'password');
    $(icon).toggleClass('fa-eye-slash');
  }
});

// MOSTRAR/ESCONDER MODAL

function closeModal(element){
  let modal = $(element).closest('.modal');
  $(modal).fadeToggle(function () {
    $(modal).addClass('d-none');
  });
}

$('.close-modal').click( function() {
  closeModal(this);
});

$('#btn-open-modal-new').click( function() {

  let modalContactNew = $('#modal-new');

  $(modalContactNew).fadeToggle( function() {
    $(modalContactNew).removeClass('d-none');
  });
});

$('.table tbody').on('click', '.btn-open-modal-update', function(e) {
  e.preventDefault();
  let modal = $('#modal-update'),
      form = $(modal).find('.form'),
      id = $(this).parents('tr').data('id'),
      url = $(form).data('url');

  $('#id_update').val(id);
  read(form,id, url);

  $(modal).fadeToggle( function() {
    $(modal).removeClass('d-none');
  });
});

$('.table tbody').on('click', '.btn-open-modal-delete', function(e) {
  e.preventDefault();
  let modal = $('#modal-delete'),
      id = $(this).parents('tr').data('id'),
      name = $(this).parents('tr').children('td')[0];
  $(modal).fadeToggle( function() {
    $(modal).removeClass('d-none');
  });
  
  $('.btn-delete').attr('data-id', id);
  $('.text-ref-delete').html($(name).text() );
});

// PETICIONES AJAX

function objectForm(form) {
  let newForm = {};
  form.map(row => {
    newForm[row['name']] = row['value'];
  });
  return newForm;
}

function ajaxRequest(data) {
  return $.ajax({
    method: 'POST',
    url: '/Ajax.php?'+data.url,
    data: { 
      form: JSON.stringify(data.form)
    }
  });
}

// RESPUESTA DE CONTACTO

function buttonsActionsTable() {
  return  `<div class="d-flex j-content-end">
  <div class="dropdown">
    <button class="btn btn-dropdown" title="Acción"><i class="fas fa-ellipsis-v"></i></button>
    <div class="dropdown-list shadow-lg d-none">
      <ul class="d-flex">
        <li>
          <a class="btn-open-modal-update link" title="Editar" href="#">
            <i class="fas fa-pen fa-1x"></i>
          </a>
          <a class="btn-open-modal-delete link" title="Eliminar" href="#">
            <i class="fas fa-trash fa-1x"></i>
          </a>
        </li>  
      </ul>
    </div>
  </div>  
  </div>`;
}

function removeLastRow() {
  let rows = $('.table').children('tbody').children('tr');

  if(rows.length >= 10) {
    $(rows[9]).remove();
  }
}

// ARTICLE

function newTableArticle(form) {
   
  removeLastRow();

  let table = $('.table').children('tbody');
  $(table).prepend(`<tr data-id="${form._id}"></tr>`);

  let row = $(`tr[data-id='${form._id}']`);
  $(row).prepend(`<td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>`);

  let col = $(row).children('td');
  $(col[0]).html(form.serial);
  $(col[1]).html(form.code);
  $(col[2]).html(form.status);
  $(col[3]).html(form.statusBorrowed);
  $(col[4]).html(form.created);
  $(col[5]).html(buttonsActionsTable);
}

function updateTableArticle(form) {
  let row = $(`tr[data-id='${$('#id_update').val()}']`),
      col = $(row).children('td');
  
  $(col[0]).html(form.serial);
  $(col[1]).html(form.code);
  $(col[2]).html(form.status);
}

// PTO

function newTableArticlePto(form) {
  removeLastRow();

  let table = $('.table').children('tbody');
  $(table).prepend(`<tr data-id="${form._id}"></tr>`);

  let row = $(`tr[data-id='${form._id}']`);
  $(row).prepend(`<td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>`);

  let col = $(row).children('td');
  $(col[0]).html(`<p class="p text-bold">${form.name}</p><p>${form.observations}</p>`);
  $(col[1]).html((form.serial != null) ? form.serial : 'Ninguno');
  $(col[2]).html((form.barcode != null) ? form.barcode : 'Ninguno');
  $(col[3]).html(form.type);
  $(col[4]).html(buttonsActionsTable);
}

function updateTableArticlePto(form) {
  let row = $(`tr[data-id='${$('#id_update').val()}']`),
      col = $(row).children('td');
  
  let p = $(col[0]).children('p');

  $(p[0]).text(form.name);
  $(p[1]).text(form.observations);
  $(col[1]).html((form.serial != null) ? form.serial : 'Ninguno');
  $(col[2]).html((form.barcode != null) ? form.barcode : 'Ninguno');
  $(col[3]).html(form.type);
}

// ARTICLE BORROWED

function newTableArticleBorrowed(form) {
  removeLastRow();

  let table = $('.table').children('tbody');
  $(table).prepend(`<tr data-id="${form._id}"></tr>`);

  let row = $(`tr[data-id='${form._id}']`);
  $(row).prepend(`<td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>`);

  let col = $(row).children('td');
  $(col[0]).html(`<p class="p text-bold">${form.name}</p><p>${form.observations}</p>`);
  $(col[1]).html((form.serial != null) ? form.serial : 'Ninguno');
  $(col[2]).html((form.barcode != null) ? form.barcode : 'Ninguno');
  $(col[3]).html(form.code);
  $(col[4]).html(buttonsActionsTable);
}

function updateTableArticleBorrwed(form) {
  let row = $(`tr[data-id='${$('#id_update').val()}']`),
      col = $(row).children('td');
  
  let p = $(col[0]).children('p');

  $(p[0]).text(form.name);
  $(p[1]).text(form.observations);
  $(col[1]).html((form.serial != null) ? form.serial : 'Ninguno');
  $(col[2]).html((form.barcode != null) ? form.barcode : 'Ninguno');
  $(col[3]).html((form.code != null) ? form.code : 'Ninguno');
}

// TIPOS DE RESPUESTA EN MODAL AL HACER PETICIÓN AJAX

function modalNewResponse(response, form, validResponse = null) {
  $('.text-error').html('');

  if(response['valid']) {
    
    $('.snackbar-message').text('Se ha creado con exito');
    $('.snackbar').removeClass('d-none');
    lifeTimeSnackbar();

    $(form)[0].reset();
    $('#table-details').removeClass('d-none');

    if(validResponse != null) {
      validResponse(response.schema);
    }
    
  }else {
  
    response['errors'].forEach(error => {
      $('.text-error').append('<p class="p pd-t-1">'+error+'</p>');
    });
  }
}

function modalUpdateReadResponse(response, form) {
modalUpdateReadResponse
  $('.text-error-update').html('');
  
  if(response.valid) {

    let formUpdate = $(form).serializeArray();

    formUpdate.forEach(field => {
      
      let valueResponse = response.read[field.name];

      if(valueResponse == undefined) {
        valueResponse = response.read['_'+field.name];
      }

      $('#'+field.name+'_update').val(valueResponse);

    });

    labelMovePositionOriginal();

  }else {
    response['errors'].forEach(error => {
      $('.text-error-update').append('<p class="p pd-t-1">'+error+'</p>');
    });
  }
}

function modalUpdateResponse(response, form, validResponse = null) {
  
  $('.text-error-update').html('');

  if(response['valid']) {
    
    closeModal(form);

    $('.snackbar-message').text('Se ha actualizado correctamente.');
    $('.snackbar').removeClass('d-none');
    lifeTimeSnackbar();
    
    if(validResponse != null) {
      validResponse(response.schema);
    }
  }else {
  
    response['errors'].forEach(error => {
      $('.text-error-update').append('<p class="p pd-t-1">'+error+'</p>');
    });
  }
}

function modalDeleteResponse(response, btn) {

  $('.text-error-delete').html('');
  
  if(response['valid']) {

    closeModal(btn);

    $('.snackbar-message').text('Se ha eliminado con exito');
    $('.snackbar').removeClass('d-none');
    lifeTimeSnackbar();
  
    $(`tr[data-id='${$(btn).attr('data-id')}']`).remove();

  }else {
    response['errors'].forEach(error => {
      $('.text-error-delete').append('<p class="p pd-t-1">'+error+'</p>');
    });
  }
}

// CRUD

function create(form, url, validResponse = null) {
  const data = { 
    form: objectForm($(form).serializeArray() ),
    url : url
  };

  ajaxRequest(data).done( function(res) {
    modalNewResponse(JSON.parse(res), form, validResponse);
  });
}

function read(form, id, url, fields = null) {
  const data = { 
    form: {
      id: id
    },
    url : url
  };

  if(fields != null) {
    data.form = {...data.form,...fields};
  }

  ajaxRequest(data).done( function(res) {
    modalUpdateReadResponse(JSON.parse(res),form );
  });
}

function update(form, url, validResponse = null) {
  
  const data = {
    form: objectForm($(form).serializeArray() ),
    url : url
  };

  return ajaxRequest(data).done( function(res) {
    modalUpdateResponse(JSON.parse(res), form, validResponse);
  });

}

function remove(btn, url, fields = null) {
  const data = { 
    form: {
      id: $(btn).attr('data-id')
    },
    url : url
  };

  if(fields != null) {
    data.form = {...data.form,...fields};
  }

  ajaxRequest(data).done( function(res) {
    modalDeleteResponse(JSON.parse(res), btn);
  });
}

// FINAL CRUD


// PETICIONES AJAX ARTICULO DE ARTICULOS GENERALES

$('.article-new').submit( function(e) {
  e.preventDefault();
  create(this, 'controller=article&action=new', newTableArticle);
});

$('.article-update').submit( function(e) {
  e.preventDefault();
  update(this, 'controller=article&action=update', updateTableArticle);
});

$('.btn-article-delete').click( function() {
  let fields = {id_article: $('#id_article').val()};
  remove(this, 'controller=article&action=delete', fields);
});

// PETICIONES AJAX ARTICULO DE PUNTO DE VENTA

$('.articlePto-new').submit( function(e) {
  e.preventDefault();
  create(this, 'controller=ArticlePointOfSale&action=new', newTableArticlePto);
});

$('.articlePto-update').submit( function(e) {
  e.preventDefault();
  update(this, 'controller=ArticlePointOfSale&action=update', updateTableArticlePto);
});

$('.btn-articlePto-delete').click( function() {
  remove(this, 'controller=ArticlePointOfSale&action=delete');
});

// PETICIONES AJAX ARTICULO EN PRESTAMO

$('.articleBorrowed-new').submit( function(e) {
  e.preventDefault();
  create(this, 'controller=ArticleBorrowed&action=new', newTableArticleBorrowed);
});

$('.articleBorrowed-update').submit( function(e) {
  e.preventDefault();
  update(this, 'controller=ArticleBorrowed&action=update', updateTableArticleBorrwed);
});

$('.btn-articleBorrowed-delete').click( function() {
  remove(this, 'controller=ArticleBorrowed&action=delete');
});

// Funciones especificas formulario

function datalistTransferData(input, idOtherInput) {
  let valInput = $(input).val(),
  datalist = $(input).siblings('datalist').find(`option[value='${valInput}']`)[0];
  const id = $(datalist).attr('data-id');
  $('#'+idOtherInput).val(id);
}

$('.viewing-article').on('change', function() {
  datalistTransferData(this, 'id_article_only');
});

$('.viewing-country').on('change', function() {
  datalistTransferData(this, 'id_country');
});

});
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/admin.js":
/*!**************************************!*\
  !*** ./resources/assets/js/admin.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(".button-logout").on("click", function (event) {
  event.preventDefault();
  document.getElementById('logout-form').submit();
});
$('.colorpicker').colorpicker(); //Table

$('.js-table').each(function (key, index) {
  var $this = $(this),
      $table = 'table_' + key;
  $table = $('.js-table').DataTable({
    // dom: 'Bfrltip',
    dom: 'Bfrtip',
    pageLength: 100,
    // bPaginate: false,
    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    destroy: true
  });

  if (typeof $this.data('order-column') !== 'undefined' && typeof $this.data('order-type') !== 'undefined') {
    $table.order([$this.data('order-column') - 1, $this.data('order-type')]).draw();
  }
});
CKEditorLaunch(); // CKEDITOR ????????????????

function CKEditorLaunch() {
  $(".text-editor").each(function (key, index) {
    var $this = $(this);
    $this.prop("id", "ckedit" + key + "x");
    CKEDITOR.replace("ckedit" + key + "x");
  });
  $(".text-editor-simple").each(function (key, index) {
    var $this = $(this);
    $this.prop("id", "ckedit-simple" + key + "x");
    CKEDITOR.replace("ckedit-simple" + key + "x", {
      customConfig: '/adminbsb/ckeditor/config-simple.js'
    });
  });
  $(".text-editor-table").each(function (key, index) {
    var $this = $(this);
    $this.prop("id", "ckedit-table" + key + "x");
    CKEDITOR.replace("ckedit-table" + key + "x", {
      customConfig: '/adminbsb/ckeditor/config-table.js'
    });
  });
  $(".text-editor-content").each(function (key, index) {
    var $this = $(this);
    $this.prop("id", "ckedit-content" + key + "x");
    CKEDITOR.replace("ckedit-content" + key + "x", {
      customConfig: '/adminbsb/ckeditor/config-content.js'
    });
  });
} // ????????????????/??????????????????


$(document).on('click', '.enable', function () {
  var $this = $(this),
      id = $this.data('id'),
      check = $this.val(),
      ajaxUrl = $('#ajaxUrl').val();
  $.ajax({
    url: '/admin/' + ajaxUrl + '/enable',
    method: 'POST',
    data: {
      id: id,
      check: check
    },
    headers: {
      'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    },
    dataType: 'json',
    success: function success(result) {
      if (result.status == 'ok') {
        console.log(result.message);
        $this.val(result.value);
      }
    }
  });
}); // ?????????????? ????????????

$(document).on('click', '.item-remove', function (e) {
  e.preventDefault();
  var $this = $(this).closest('tr'),
      id = $this.attr('item-id'),
      ajaxUrl = $('#ajaxUrl').val();
  $.ajax({
    url: '/admin/' + ajaxUrl + '/remove',
    method: 'POST',
    data: {
      id: id
    },
    headers: {
      'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    },
    dataType: 'json',
    success: function success(result) {
      if (result.status == 'ok') {
        console.log(result.message);
        $this.remove();
      }
    }
  });
});
$(document).on('change', '[name="is_category_check"]', function () {
  var $new_this = $('[name="is_category"]'),
      check = $new_this.val(),
      id = $new_this.data('id'),
      ajaxUrl = $('#ajaxUrl').val();
  $.ajax({
    url: '/admin/' + ajaxUrl + '/is-category',
    method: 'POST',
    data: {
      id: id,
      check: check
    },
    headers: {
      'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(result) {
      if (check == 1) check = 0;else check = 1;
      $new_this.val(check);
      $('.category-block').html(result);
      $('select').selectpicker('refresh');
      if (check == 0) CKEditorLaunch();
    }
  });
}); // ???????????????????? ??????????????????

$(document).on('click', 'button.addParam', function () {
  var $this = $(this),
      param = $this.data('param'),
      ajaxUrl = $('#ajaxUrl').val(),
      url = '/admin/param/add-param';
  if ($this.hasClass('changeParam')) var action = $this.data('action'),
      url = '/admin/' + ajaxUrl + '/' + action;
  $.ajax({
    url: url,
    method: "POST",
    data: {
      param: param
    },
    headers: {
      'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success($block) {
      $this.closest('.params').find('.params-items').append($block);
      $('select').selectpicker('refresh');

      if ($('*').hasClass('params-items')) {
        $(".params-item.solution-item").each(function (index) {
          var $this = $(this);
          $("input.price", $this).attr("name", "items[" + index + "][price]");
          $("input.desc", $this).attr("name", "items[" + index + "][desc]");
        });
      }
    }
  });
}); // ???????????????? ??????????????????

$(document).on('click', 'button.removeButton', function () {
  var $this = $(this),
      $rm = $this.closest('.params-item'),
      url = $('#ajaxUrl').val();

  if ($this.hasClass('removeArrJson')) {
    var $this = $(this).closest('.thumbnail'),
        url = '/admin/removeArrJson',
        id = $this.attr('id'),
        column = $this.data('column'),
        model = $this.data('model'),
        arr = $this.data('arr'),
        index = $this.data('index');

    if (id && column && model && arr) {
      if (!index) index = '';
      $.ajax({
        url: url,
        method: 'POST',
        data: {
          id: id,
          column: column,
          model: model,
          arr: arr,
          index: index
        },
        headers: {
          'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        success: function success(result) {
          if (result.status == 'ok') {
            console.log(result.message);
            $this.remove();
          }
        }
      });
    }
  } else if ($this.hasClass('removeImage')) {
    var $this = $(this).closest('.thumbnail'),
        id = $this.attr('id'),
        column = $this.data('column'),
        model = $this.data('model'),
        remove = $this.data('remove');
    $.ajax({
      url: '/admin/' + url + '/remove-image',
      method: 'POST',
      data: {
        id: id,
        column: column,
        model: model,
        remove: remove
      },
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'json',
      success: function success(result) {
        if (result.status == 'ok') {
          console.log(result.message);

          if ($('table').hasClass('images-table')) {
            $this = $this.closest('tr');
          }

          $this.remove();
        }
      }
    });
  } else {
    // if(id && item_id){
    //     $.ajax({
    //         url: '/admin/param/remove-param',
    //         method: 'POST',
    //         data: {},
    //         headers: {
    //             'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         dataType: 'json',
    //         success: function(result){
    //             if (result.status == 'ok') {
    //                 console.log(result.message);
    //                 $rm.remove();
    //             }
    //         }
    //     });
    // } else {
    $rm.remove(); // }
  }
}); // ????????????????????

var fixHelperModified = function fixHelperModified(e, tr) {
  var $originals = tr.children();
  var $helper = tr.clone();
  $helper.children().each(function (index) {
    $(this).width($originals.eq(index).width());
  });
  return $helper;
};

var updateIndex = function updateIndex(e, ui) {
  $('td.index', ui.item.parent()).each(function (i) {
    var position = i + 1;
    $(this).html(position);
    var id = $(this).parent('.order-table tbody tr').attr('id'),
        ajaxUrl = $('#ajaxUrl').val();
    if ($(this).closest('table').hasClass('images-table')) ajaxUrl = ajaxUrl + '/image';
    $.ajax({
      url: '/admin/' + ajaxUrl + '/change-position',
      method: 'POST',
      data: {
        id: id,
        position: position
      },
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function success(res) {},
      error: function error(msg) {
        console.log(msg);
      }
    });
  });
};

$(".order-table tbody").sortable({
  helper: fixHelperModified,
  stop: updateIndex
});
/* Language switch */

$(document).on('click', 'button.js_switch', function () {
  var $this = $(this); //active lang

  $('.js_switch').removeClass('active');
  $this.addClass('active'); //reset input

  $('.langActive_insert').removeClass('active_insert'); //set input

  $('.js_lang_' + $this.data('switch')).addClass('active_insert');
});
/* ?????????????????? ?????????? ???? ?????????????????? */

$(document).on('click', '.js_default_lang', function () {
  var $this = $(this),
      id = $this.data('id'),
      default_lang = $('.js_default_lang');
  $.ajax({
    url: '/admin/language/default_lang',
    method: 'POST',
    data: {
      id: id
    },
    headers: {
      'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(result) {
      if (result == 'ok') {
        default_lang.removeClass('btn-primary');
        default_lang.addClass('btn-default');
        $this.removeClass('btn-default');
        $this.addClass('btn-primary');
      }
    }
  });
});

/***/ }),

/***/ 1:
/*!********************************************!*\
  !*** multi ./resources/assets/js/admin.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\Games\OSPanel_2\domains\w-test1.local\resources\assets\js\admin.js */"./resources/assets/js/admin.js");


/***/ })

/******/ });
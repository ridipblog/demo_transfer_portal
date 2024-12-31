import ReuseModule from '../reuse_modules/ReuseModule.js'
const reuse_module = new ReuseModule()
import EmployeeProfileModule from './EmployeeProfileModule.js'
const employee_profile_module = new EmployeeProfileModule()
import TransferRequestModule from './TransferRequestModule.js'
const transfer_request_module = new TransferRequestModule()
$(document).ready(function (argument) {
  // ------------------ pre-profile request for tansfer ----------------
  $(document).on('click', '.profile-request-btn', function () {
    if ($('#directRequestModal').hasClass('hidden')) {
      $('#directRequestModal').removeClass('hidden')
      $('body').css('overflow', 'hidden')
      $('#request-profile-form-btn').val($(this).val())
    }
  })
  //   ------------------- request profile for transfer -----------------
  $(document).on('submit', '#request-profile-form', function (e) {
    e.preventDefault()
    employee_profile_module.requestProfileTransfer($('#request-profile-form'))
  })
  //   ----------------- request cancel by user after realize  wrong proposal he sent ------------------
  $(document).on('click', '#request-cancel-by-user', function () {
    reuse_module.confirmMessage(
      'Do you want to cancel the request ?',
      'Yes ,Cancel it'
    ).then((result) => {
      if (result.isConfirmed) {
        transfer_request_module.transferRequestCancel('#request-cancel-by-user')
      }
    })
  })
  //   ----------------------- request accecpt by target employee -------------------
  $(document).on('click', '#accpect-by-target', function () {
    reuse_module.confirmMessage(
      'Do you want to accept the request ?',
      'Yes ,Accept it'
    ).then((result) => {
      if (result.isConfirmed) {
        transfer_request_module.actionOnRequest('#accpect-by-target', 'accept')
      }
    })
  })
  //   ----------------------- request reject by target employee -------------------
  $(document).on('click', '#reject-by-target', function () {
    reuse_module.confirmMessage(
      'Do you want to reject the request ?',
      'Yes ,reject it'
    ).then((result) => {
      if (result.isConfirmed) {
        transfer_request_module.actionOnRequest('#reject-by-target', 'reject')
      }
    })
  })
  // ----------------- search profile for request by input ------------
  $(document).on('submit', '#filter-search-profile-form-input', function (e) {
    e.preventDefault()
    transfer_request_module.searchProfileForRequest('#filter-search-profile-form-input', 'by_input')
  })
  // ------------------ search profile for request by select ------------
  $(document).on('submit', '#filter-search-profile-form-select', function (e) {
    e.preventDefault()
    transfer_request_module.searchProfileForRequest('#filter-search-profile-form-select', 'by_select')
  })
  $('.directRequest').on('click', function () {})
  $('#closeDirectRequestModalButton').on('click', function () {
    $('#directRequestModal').addClass('hidden')
    $('body').css('overflow', 'visible')
  })
})

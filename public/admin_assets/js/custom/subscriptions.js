
$(document).on('change', 'input.subscription', function () {
    var isSubscriptions = $('input.subscriptions').is(':checked')

    var subscriptions = $('input.subscription').length
    var checkedSubscriptions = $('input.subscription:checked').length

    if (subscriptions == checkedSubscriptions) {
        $('input.subscriptions').prop('checked', true)
    } else {
        $('input.subscriptions').prop('checked', false)
    }
})

$(document).on('change', 'input.subscriptions', function () {
    var isSubscriptions = $('input.subscriptions').is(':checked')

    if (isSubscriptions) {
        $('input.subscription').prop('checked', true)
    } else {
        $('input.subscription').prop('checked', false)
    }
})

$(document).on('change', 'input.subscriptions , input.subscription', function () {
    var checkedSubscriptions = $('input.subscription:checked').length

    if (checkedSubscriptions) {
        $('.invoice-button').removeClass('d-none')
    } else {
        $('.invoice-button').addClass('d-none')
    }
})

$(document).on('click', '.subscription-details', function () {
    var description = $(this).data('description')
    $('#subscriptionModal .modal-body').empty().append(description)
    $('#subscriptionModal').modal('show')
})

$(document).on('click', '.invoice-button', function () {
    $('#invoiceModal').modal('show')
})

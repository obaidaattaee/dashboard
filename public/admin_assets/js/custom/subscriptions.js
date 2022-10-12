function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
}

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

    if ($('input.subscription:checked').length < 1) {
        toastr.warning(EMPTY_SUBSCRIPTIONS)
        return
    }
    var subscriptionDurations = []
    var subscriptionIds = []

    $('input.subscription:checked').each((index, element) => {
        subscriptionDurations[index] = $(element).data('duration')
        subscriptionIds[index] = $(element).val()
    })

    subscriptionDurations = subscriptionDurations.filter(onlyUnique)
    if (subscriptionDurations.length > 1) {
        toastr.warning(DIFFIRANTE_SUBSCRIPTIONS)
        return
    }
    $('.duration_type').empty().append('(' + subscriptionDurations[0] + ')')
    $('#subscription_ids').prop('value', subscriptionIds.toString())
    $('#invoiceModal').modal('show')

})


$(document).on('submit', '#invoice_form', function (event) {
    event.preventDefault()
    $('.loader').show()

    var url = $(this).prop('action')
    var formData = new FormData(this)

    $.ajax({
        url: url,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
    }).then(function (response) {
        $('.loader').hide()

        toastr.success(response.message)
        $('#invoiceModal').modal('hide')

        setTimeout(() => {
            window.location.reload()
        }, 2000);

    }).catch(function ({
        responseJSON
    }) {
        $('.loader').hide()
        if (responseJSON.errors && Object.keys(responseJSON.errors).length) {
            Object.keys(responseJSON.errors).forEach(error => {
                toastr.error(responseJSON.errors[error][0]);
            });
        } else {
            toastr.error(responseJSON.message)
        }
    })
})

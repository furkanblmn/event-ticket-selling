/**
 * Format input to numbers only
 */
function formatNumbersOnly(input) {
    if (!input) return

    input.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '')
    })
}

/**
 * Initialize form input formatters
 */
function initPaymentForm() {
    formatNumbersOnly(document.getElementById('cc_number'))
    formatNumbersOnly(document.getElementById('cc_cvv'))
    formatNumbersOnly(document.getElementById('cc_exp_month'))
    formatNumbersOnly(document.getElementById('cc_exp_year'))
    formatNumbersOnly(document.getElementById('customer_phone'))
}

// Initialize on page load
initPaymentForm()

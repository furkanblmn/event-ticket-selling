/**
 * Event Detail Page Script
 * Handles ticket category selection and purchase
 */

/**
 * Navigate to seat selection page
 */
function buyTicket() {
    const categorySelect = document.getElementById('category')
    const categoryId = categorySelect.value

    if (!categoryId) {
        alert('Lütfen bir bilet kategorisi seçin.')
        return
    }

    const eventId = categorySelect.dataset.eventId
    window.location.href = `/seat-plans/${eventId}/${categoryId}`
}

/**
 * Initialize category selection
 */
function initCategorySelection() {
    const categorySelect = document.getElementById('category')
    const buyBtn = document.getElementById('buy-ticket-btn')

    if (!categorySelect || !buyBtn) return

    categorySelect.addEventListener('change', function () {
        buyBtn.disabled = !this.value
    })

    buyBtn.disabled = true
}

// Initialize on page load
initCategorySelection()

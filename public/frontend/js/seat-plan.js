let selectedSeats = []
let currentMode = 'manual'

function switchMode(mode, clearSelections = true) {
    currentMode = mode
    const autoPanel = document.getElementById('auto-panel')
    const manualPanel = document.getElementById('manual-panel')
    const autoTab = document.getElementById('auto-tab')
    const manualTab = document.getElementById('manual-tab')

    const showAuto = mode === 'auto'
    autoPanel.classList.toggle('hidden', !showAuto)
    manualPanel.classList.toggle('hidden', showAuto)
    autoTab.classList.toggle('border-blue-600', showAuto)
    autoTab.classList.toggle('text-blue-600', showAuto)
    manualTab.classList.toggle('border-blue-600', !showAuto)
    manualTab.classList.toggle('text-blue-600', !showAuto)

    if (clearSelections) clearSelectedSeats()
}

/**
 * Clear all selected seats
 */
function clearSelectedSeats() {
    document.querySelectorAll('.seat-button.bg-green-500').forEach(btn => {
        btn.classList.remove('bg-green-500')
        btn.classList.add('bg-blue-400', 'hover:bg-blue-500')
    })
    selectedSeats = []
    updateSelectedSeats()
}

/**
 * Toggle individual seat selection
 */
function toggleSeat(seatId) {
    const button = document.querySelector(`[data-seat-id="${seatId}"]`)

    if (bookedSeats.includes(seatId) || button.dataset.available === '0') {
        return
    }

    const isSelected = selectedSeats.includes(seatId)

    if (isSelected) {
        deselectSeat(button, seatId)
    } else {
        selectSeat(button, seatId)
    }

    updateSelectedSeats()
}

/**
 * Select a seat
 */
function selectSeat(button, seatId) {
    selectedSeats.push(seatId)
    button.classList.remove('bg-blue-400', 'hover:bg-blue-500')
    button.classList.add('bg-green-500')
}

/**
 * Deselect a seat
 */
function deselectSeat(button, seatId) {
    selectedSeats = selectedSeats.filter(id => id !== seatId)
    button.classList.remove('bg-green-500')
    button.classList.add('bg-blue-400', 'hover:bg-blue-500')
}

/**
 * Automatically select specified number of seats
 */
function autoSelectSeats() {
    const count = parseInt(document.getElementById('auto-ticket-count').value)
    clearSelectedSeats()

    const availableSeats = Array.from(document.querySelectorAll('.seat-button[data-available="1"]:not([disabled])'))
    availableSeats.slice(0, count).forEach(button => {
        const seatId = parseInt(button.dataset.seatId)
        selectedSeats.push(seatId)
        button.classList.remove('bg-blue-400', 'hover:bg-blue-500')
        button.classList.add('bg-green-500')
    })

    updateSelectedSeats()
    switchMode('manual', false)
}

/**
 * Update selected seats display and form inputs
 */
function updateSelectedSeats() {
    const count = selectedSeats.length
    const total = count * pricePerSeat

    document.getElementById('selected-count').textContent = `${count} koltuk seçildi`
    document.getElementById('total-amount').textContent = `${total.toFixed(2)} ₺`

    updateHiddenInputs()
    updateContinueButton(count)
}

/**
 * Update hidden form inputs for selected seats
 */
function updateHiddenInputs() {
    const container = document.getElementById('selected-seats-container')
    container.innerHTML = ''

    selectedSeats.forEach(seatId => {
        const input = document.createElement('input')
        input.type = 'hidden'
        input.name = 'seats[]'
        input.value = seatId
        container.appendChild(input)
    })
}

/**
 * Enable/disable continue button based on selection
 */
function updateContinueButton(count) {
    document.getElementById('continue-btn').disabled = count === 0
}

/**
 * Zoom in on seat map
 */
function zoomIn() {
    zoomSeatMap(0.2)
}

/**
 * Zoom out on seat map
 */
function zoomOut() {
    zoomSeatMap(-0.2)
}

/**
 * Apply zoom to seat map
 */
function zoomSeatMap(delta) {
    const map = document.getElementById('seat-map')
    const currentScale = parseFloat(map.style.transform.match(/scale\(([\d.]+)\)/)?.[1] || 1)
    const newScale = Math.min(Math.max(currentScale + delta, 0.5), 2)
    map.style.transform = `scale(${newScale})`
}

/**
 * Reset zoom and clear selections
 */
function resetZoom() {
    document.getElementById('seat-map').style.transform = 'scale(1)'
    clearSelectedSeats()
}

updateSelectedSeats()

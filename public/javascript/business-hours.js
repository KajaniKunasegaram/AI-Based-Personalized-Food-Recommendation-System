

document.addEventListener('DOMContentLoaded', function() {
    // Setup CSRF token for AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Initialize modals
    const addShiftModal = new bootstrap.Modal(document.getElementById('addShiftModal'));
    const editShiftModal = new bootstrap.Modal(document.getElementById('editShiftModal'));
    
    // Variables for current state
    let currentTargetDay = null;
    let currentEditRow = null;
    let currentShiftId = null;
    
    // Default time values
    let openSelectedHour = "09";
    let openSelectedMinute = "00";
    let openSelectedPeriod = "AM";
    let closeSelectedHour = "05";
    let closeSelectedMinute = "00";
    let closeSelectedPeriod = "PM";
    
    // Time picker elements
    const openTimePicker = document.getElementById('open-time-picker');
    const closeTimePicker = document.getElementById('close-time-picker');
    const dropdown = document.getElementById('time-picker-dropdown');
    const hoursColumn = document.getElementById('hours-column');
    const minutesColumn = document.getElementById('minutes-column');
    
   // Initialize delete confirmation modal
const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
let shiftToDelete = null;

// Add functionality to delete buttons
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.stopPropagation();
        
        // Store the shift ID to delete
        shiftToDelete = this.getAttribute('data-shift-id');
        
        // Show the confirmation modal instead of using confirm()
        deleteConfirmModal.show();
    });
});

// Add event listener for the delete confirmation button
document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (shiftToDelete) {
        fetch(`/shifts/${shiftToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Find and remove the shift row
                const shiftRow = document.querySelector(`.shift-row[data-shift-id="${shiftToDelete}"]`);
                if (shiftRow) {
                    shiftRow.remove();
                }
                
                // Hide the modal
                deleteConfirmModal.hide();
                shiftToDelete = null;
            }
        })
        .catch(error => console.error('Error:', error));
    }
});
    
    // Add functionality to day selection
    document.querySelectorAll('.day-circle').forEach(circle => {
        circle.addEventListener('click', function() {
            // Remove active class from all circles
            document.querySelectorAll('.day-circle').forEach(c => {
                c.classList.remove('active');
            });
            
            // Add active class to clicked circle
            this.classList.add('active');
            
            // Get the day ID
            const dayId = this.getAttribute('data-day');
            
            // Handle "All" case
            if (this.id === 'all-circle') {
                // Show all day sections
                document.querySelectorAll('.day-section').forEach(section => {
                    section.classList.add('active');
                });
            } else {
                // Hide all day sections
                document.querySelectorAll('.day-section').forEach(section => {
                    section.classList.remove('active');
                });
                
                // Show only the selected day
                document.getElementById(dayId).classList.add('active');
            }
        });
    });
    
    // Add functionality to "Add Shift" buttons
    document.querySelectorAll('.add-shift-btn').forEach(button => {
        button.addEventListener('click', function() {
            const day = this.getAttribute('data-day');
            currentTargetDay = day.toLowerCase();
            
            document.getElementById('addShiftModalLabel').textContent = `ADD SHIFT - ${day}`;
            document.getElementById('day_of_week').value = day;
            
            // Reset time values to defaults
            openSelectedHour = "09";
            openSelectedMinute = "00";
            openSelectedPeriod = "AM";
            closeSelectedHour = "05";
            closeSelectedMinute = "00";
            closeSelectedPeriod = "PM";
            
            // Update displayed time values
            document.querySelector('#open-time-picker .time-text').textContent = "09:00 AM";
            document.querySelector('#close-time-picker .time-text').textContent = "05:00 PM";
            document.getElementById('open_time').value = formatTimeForStorage(openSelectedHour, openSelectedMinute, openSelectedPeriod);
            document.getElementById('close_time').value = formatTimeForStorage(closeSelectedHour, closeSelectedMinute, closeSelectedPeriod);
            
            addShiftModal.show();
        });
    });
    
    // Make all existing shift rows clickable for editing
    document.querySelectorAll('.shift-row').forEach(row => {
        row.addEventListener('click', function(e) {
            if (!e.target.closest('.delete-btn')) {
                openEditModal(this);
            }
        });
    });
    
    // Handle save button click in add modal
    document.getElementById('saveShiftBtn').addEventListener('click', function() {
        // Get form values
        const day = document.getElementById('day_of_week').value;
        const serviceTypes = [];
        
        if (document.getElementById('deliveryCheck').checked) {
            serviceTypes.push('Delivery');
        }
        
        if (document.getElementById('pickupCheck').checked) {
            serviceTypes.push('Pickup');
        }
        
        const isOpen = document.getElementById('status_toggle').checked;
        const openTime = document.getElementById('open_time').value;
        const closeTime = document.getElementById('close_time').value;
        
        // Validate form
        if (serviceTypes.length === 0) {
            alert('Please select at least one service type');
            return;
        }
        
        // Send the request to the server
        fetch('/shifts', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                day_of_week: day,
                service_types: serviceTypes,
                open_time: openTime,
                close_time: closeTime,
                is_open: isOpen
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // On success, refresh the page to show new shifts
                window.location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
        
        // Hide modal
        addShiftModal.hide();
    });
    
    // Handle save button click in edit modal
    document.getElementById('saveEditBtn').addEventListener('click', function() {
        // Get updated values
        const shiftId = document.getElementById('edit_shift_id').value;
        const isOpen = document.getElementById('editStatusToggle').checked;
        const openTime = document.getElementById('edit_open_time').value;
        const closeTime = document.getElementById('edit_close_time').value;
        
        // Send update request
        fetch(`/shifts/${shiftId}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                open_time: openTime,
                close_time: closeTime,
                is_open: isOpen
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the shift row in the UI
                const row = document.querySelector(`.shift-row[data-shift-id="${shiftId}"]`);
                if (row) {
                    // Update the time display
                    const timeCol = row.querySelector('.time-col');
                    
                    // Format the times for display
                    const openFormatted = formatTimeForDisplay(openTime);
                    const closeFormatted = formatTimeForDisplay(closeTime);
                    timeCol.textContent = `${openFormatted} - ${closeFormatted}`;
                    
                    // Update the status display
                    const statusText = row.querySelector('.status-col span:first-child');
                    statusText.textContent = isOpen ? 'Open' : 'Closed';
                    statusText.className = isOpen ? 'status-open' : 'status-closed';
                }
                
                // Hide the modal
                editShiftModal.hide();
            }
        })
        .catch(error => console.error('Error:', error));
    });
    
    // Format time for display (24h to 12h with AM/PM)
    function formatTimeForDisplay(timeStr) {
        const { hour, minute, period } = parseTimeString(timeStr);
        return `${hour}:${minute} ${period}`;
    }
    
    // Format time for storage (12h with AM/PM to 24h)
    function formatTimeForStorage(hour, minute, period) {
        // Convert to 24-hour format for storage
        let hour24 = parseInt(hour);
        if (period === 'PM' && hour24 < 12) {
            hour24 += 12;
        } else if (period === 'AM' && hour24 === 12) {
            hour24 = 0;
        }
        
        return `${hour24.toString().padStart(2, '0')}:${minute}`;
    }
    
    // Function to parse time string into hour, minute, and period components
    function parseTimeString(timeStr) {
        // Handle various time formats
        let hour = "12";
        let minute = "00";
        let period = "AM";
        
        // First check if it's a 24-hour format time (HH:MM)
        if (timeStr.includes(':')) {
            const parts = timeStr.trim().split(':');
            let hour24 = parseInt(parts[0].trim());
            
            // Convert to 12-hour format
            if (hour24 >= 12) {
                period = "PM";
                if (hour24 > 12) {
                    hour = (hour24 - 12).toString().padStart(2, '0');
                } else {
                    hour = "12";
                }
            } else {
                period = "AM";
                if (hour24 === 0) {
                    hour = "12";
                } else {
                    hour = hour24.toString().padStart(2, '0');
                }
            }
            
            // The minute part may have AM/PM after it
            let minutePart = parts[1].trim();
            if (minutePart.includes(' ')) {
                // Handle 12-hour format (HH:MM AM/PM)
                const [minVal, periodVal] = minutePart.split(' ');
                minute = minVal.trim().padStart(2, '0');
                if (periodVal) {
                    period = periodVal.toUpperCase();
                }
            } else {
                // Simple 24-hour format
                minute = minutePart.padStart(2, '0');
            }
        }
        
        return { hour, minute, period };
    }
    
    // Function to open edit modal for a shift
    function openEditModal(row) {
        currentEditRow = row;
        currentShiftId = row.getAttribute('data-shift-id');
        
        // Get current shift data
        const serviceType = row.querySelector('.service-col').textContent;
        const timeRange = row.querySelector('.time-col').textContent;
        const isOpen = row.querySelector('.status-col span:first-child').textContent.trim() === 'Open';
        
        // Parse time range
        const timeRangeParts = timeRange.split('-');
        const openTimeStr = timeRangeParts[0].trim();
        const closeTimeStr = timeRangeParts[1].trim();
        
        // Parse the times
        const openTimeParts = parseTimeString(openTimeStr);
        const closeTimeParts = parseTimeString(closeTimeStr);
        
        // Set the time values for the picker
        openSelectedHour = openTimeParts.hour;
        openSelectedMinute = openTimeParts.minute;
        openSelectedPeriod = openTimeParts.period;
        closeSelectedHour = closeTimeParts.hour;
        closeSelectedMinute = closeTimeParts.minute;
        closeSelectedPeriod = closeTimeParts.period;
        
        // Set modal fields
        document.getElementById('edit_shift_id').value = currentShiftId;
        document.getElementById('editStatusToggle').checked = isOpen;
        
        // Format times for display and storage
        const openTimeFormatted = formatTimeForStorage(openSelectedHour, openSelectedMinute, openSelectedPeriod);
        const closeTimeFormatted = formatTimeForStorage(closeSelectedHour, closeSelectedMinute, closeSelectedPeriod);
        
        // Set the time values
        document.getElementById('edit_open_time').value = openTimeFormatted;
        document.getElementById('edit_close_time').value = closeTimeFormatted;
        
        // Update the displayed times
        document.querySelector('#edit-open-time-picker .edit-time-text').textContent = `${openSelectedHour}:${openSelectedMinute} ${openSelectedPeriod}`;
        document.querySelector('#edit-close-time-picker .edit-time-text').textContent = `${closeSelectedHour}:${closeSelectedMinute} ${closeSelectedPeriod}`;
        
        // Toggle closed note visibility
        document.getElementById('closed-note').style.display = isOpen ? 'none' : 'block';
        
        // Show edit modal
        editShiftModal.show();
    }
    
    // Status toggle handler for edit modal
document.getElementById('editStatusToggle').addEventListener('change', function() {
    const isOpen = this.checked;
    const statusLabel = document.getElementById('status-label');
    const timeControls = document.getElementById('time-controls');
    const closedNote = document.getElementById('closed-note');
    
    if (isOpen) {
        statusLabel.textContent = 'Open';
        statusLabel.classList.remove('text-danger');
        statusLabel.classList.add('open');
        timeControls.style.display = 'block';
        closedNote.style.display = 'none';
    } else {
        statusLabel.textContent = 'Closed';
        statusLabel.classList.add('text-danger');
        statusLabel.classList.remove('open');
        timeControls.style.display = 'none';
        closedNote.style.display = 'block';
    }
});

// Function to open edit modal for a shift
function openEditModal(row) {
    currentEditRow = row;
    currentShiftId = row.getAttribute('data-shift-id');
    
    // Get current shift data
    const serviceType = row.querySelector('.service-col').textContent;
    const timeRange = row.querySelector('.time-col').textContent;
    const isOpen = row.querySelector('.status-col span:first-child').textContent.trim() === 'Open';
    
    // Update modal title to include service type
    document.getElementById('editShiftModalLabel').textContent = `UPDATE ${serviceType.toUpperCase()} SHIFT`;
    
    // Parse time range
    const timeRangeParts = timeRange.split('-');
    const openTimeStr = timeRangeParts[0].trim();
    const closeTimeStr = timeRangeParts[1].trim();
    
    // Parse the times
    const openTimeParts = parseTimeString(openTimeStr);
    const closeTimeParts = parseTimeString(closeTimeStr);
    
    // Set the time values for the picker
    openSelectedHour = openTimeParts.hour;
    openSelectedMinute = openTimeParts.minute;
    openSelectedPeriod = openTimeParts.period;
    closeSelectedHour = closeTimeParts.hour;
    closeSelectedMinute = closeTimeParts.minute;
    closeSelectedPeriod = closeTimeParts.period;
    
    // Set modal fields
    document.getElementById('edit_shift_id').value = currentShiftId;
    document.getElementById('editStatusToggle').checked = isOpen;
    
    // Update status label
    const statusLabel = document.getElementById('status-label');
    if (isOpen) {
        statusLabel.textContent = 'Open';
        statusLabel.classList.remove('text-danger');
        statusLabel.classList.add('open');
        document.getElementById('time-controls').style.display = 'block';
    } else {
        statusLabel.textContent = 'Closed';
        statusLabel.classList.add('text-danger');
        statusLabel.classList.remove('open');
        document.getElementById('time-controls').style.display = 'none';
    }
    
    // Format times for display and storage
    const openTimeFormatted = formatTimeForStorage(openSelectedHour, openSelectedMinute, openSelectedPeriod);
    const closeTimeFormatted = formatTimeForStorage(closeSelectedHour, closeSelectedMinute, closeSelectedPeriod);
    
    // Set the time values
    document.getElementById('edit_open_time').value = openTimeFormatted;
    document.getElementById('edit_close_time').value = closeTimeFormatted;
    
    // Update the displayed times
    document.querySelector('#edit-open-time-picker .edit-time-text').textContent = `${openSelectedHour}:${openSelectedMinute} ${openSelectedPeriod}`;
    document.querySelector('#edit-close-time-picker .edit-time-text').textContent = `${closeSelectedHour}:${closeSelectedMinute} ${closeSelectedPeriod}`;
    
    // Toggle closed note visibility
    document.getElementById('closed-note').style.display = isOpen ? 'none' : 'block';
    
    // Show edit modal
    editShiftModal.show();
}
    // Time picker functionality
    function populateTimePicker() {
        // Clear existing options
        hoursColumn.innerHTML = '';
        minutesColumn.innerHTML = '';
        
        // Create a period column if it doesn't exist
        if (!document.getElementById('period-column')) {
            const periodColumn = document.createElement('div');
            periodColumn.className = 'time-column';
            periodColumn.id = 'period-column';
            dropdown.querySelector('.time-columns').appendChild(periodColumn);
        }
        
        const periodColumn = document.getElementById('period-column');
        periodColumn.innerHTML = '';
        
        // Add hours (1-24) - Using 24 hour format
        for (let i = 1; i <= 24; i++) {
            const hourOption = document.createElement('div');
            hourOption.className = 'time-option';
            const hourText = i < 10 ? '0' + i : i.toString();
            hourOption.textContent = hourText;
            hourOption.dataset.value = hourText;
            hoursColumn.appendChild(hourOption);
        }
        
        // Add minutes (00-59) - All 60 minutes
        for (let i = 0; i < 60; i++) { 
            const minuteOption = document.createElement('div');
            minuteOption.className = 'time-option';
            const minuteText = i < 10 ? '0' + i : i.toString();
            minuteOption.textContent = minuteText;
            minuteOption.dataset.value = minuteText;
            minutesColumn.appendChild(minuteOption);
        }
        
        // Add AM/PM options
        const amOption = document.createElement('div');
        amOption.className = 'time-option';
        amOption.textContent = 'AM';
        amOption.dataset.value = 'AM';
        periodColumn.appendChild(amOption);
        
        const pmOption = document.createElement('div');
        pmOption.className = 'time-option';
        pmOption.textContent = 'PM';
        pmOption.dataset.value = 'PM';
        periodColumn.appendChild(pmOption);
        
        // Add click event to hour options
        hoursColumn.querySelectorAll('.time-option').forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected class from all options
                hoursColumn.querySelectorAll('.time-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                
                // Add selected class to clicked option
                this.classList.add('selected');
                
                // Update selected hour
                if (dropdown.dataset.target === 'open') {
                    openSelectedHour = this.dataset.value;
                } else {
                    closeSelectedHour = this.dataset.value;
                }
                
                updateTimeDisplay();
            });
        });
        
        // Add click event to minute options
        minutesColumn.querySelectorAll('.time-option').forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected class from all options
                minutesColumn.querySelectorAll('.time-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                
                // Add selected class to clicked option
                this.classList.add('selected');
                
                // Update selected minute
                if (dropdown.dataset.target === 'open') {
                    openSelectedMinute = this.dataset.value;
                } else {
                    closeSelectedMinute = this.dataset.value;
                }
                
                updateTimeDisplay();
            });
        });
        
        // Add click event to period options
        periodColumn.querySelectorAll('.time-option').forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected class from all options
                periodColumn.querySelectorAll('.time-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                
                // Add selected class to clicked option
                this.classList.add('selected');
                
                // Update selected period
                if (dropdown.dataset.target === 'open') {
                    openSelectedPeriod = this.dataset.value;
                } else {
                    closeSelectedPeriod = this.dataset.value;
                }
                
                updateTimeDisplay();
            });
        });
    }
    
    // Function to update time display and input value
    function updateTimeDisplay() {
        if (dropdown.dataset.target === 'open') {
            // Update open time
            const timeInput = document.getElementById(dropdown.dataset.input);
            
            // Update display with 12-hour format
            // Check for both normal and edit time text classes
            let timeText = document.querySelector(`#${dropdown.dataset.picker} .time-text`);
            if (!timeText) {
                timeText = document.querySelector(`#${dropdown.dataset.picker} .edit-time-text`);
            }
            
            if (timeText) {
                timeText.textContent = `${openSelectedHour}:${openSelectedMinute} ${openSelectedPeriod}`;
            }
            
            // Update hidden input with 24-hour format
            if (timeInput) {
                timeInput.value = formatTimeForStorage(openSelectedHour, openSelectedMinute, openSelectedPeriod);
            }
        } else {
            // Update close time
            const timeInput = document.getElementById(dropdown.dataset.input);
            
            // Update display with 12-hour format
            // Check for both normal and edit time text classes
            let timeText = document.querySelector(`#${dropdown.dataset.picker} .time-text`);
            if (!timeText) {
                timeText = document.querySelector(`#${dropdown.dataset.picker} .edit-time-text`);
            }
            
            if (timeText) {
                timeText.textContent = `${closeSelectedHour}:${closeSelectedMinute} ${closeSelectedPeriod}`;
            }
            
            // Update hidden input with 24-hour format
            if (timeInput) {
                timeInput.value = formatTimeForStorage(closeSelectedHour, closeSelectedMinute, closeSelectedPeriod);
            }
        }
        
        // Close dropdown after selection
        dropdown.style.display = 'none';
    }
    
    // Initialize the time picker
    populateTimePicker();
    
    // Function to highlight currently selected time in the picker
    function highlightSelectedTime() {
        const periodColumn = document.getElementById('period-column');
        if (!periodColumn) return;
        
        // First clear all selections
        hoursColumn.querySelectorAll('.time-option').forEach(opt => {
            opt.classList.remove('selected');
        });
        minutesColumn.querySelectorAll('.time-option').forEach(opt => {
            opt.classList.remove('selected');
        });
        periodColumn.querySelectorAll('.time-option').forEach(opt => {
            opt.classList.remove('selected');
        });
        
        // Then highlight the current selections
        if (dropdown.dataset.target === 'open') {
            const hourOption = hoursColumn.querySelector(`.time-option[data-value="${openSelectedHour}"]`);
            const minuteOption = minutesColumn.querySelector(`.time-option[data-value="${openSelectedMinute}"]`);
            const periodOption = periodColumn.querySelector(`.time-option[data-value="${openSelectedPeriod}"]`);
            
            if (hourOption) {
                hourOption.classList.add('selected');
                hourOption.scrollIntoView({ block: 'center', behavior: 'auto' });
            }
            
            if (minuteOption) {
                minuteOption.classList.add('selected');
                minuteOption.scrollIntoView({ block: 'center', behavior: 'auto' });
            }
            
            if (periodOption) {
                periodOption.classList.add('selected');
            }
        } else {
            const hourOption = hoursColumn.querySelector(`.time-option[data-value="${closeSelectedHour}"]`);
            const minuteOption = minutesColumn.querySelector(`.time-option[data-value="${closeSelectedMinute}"]`);
            const periodOption = periodColumn.querySelector(`.time-option[data-value="${closeSelectedPeriod}"]`);
            
            if (hourOption) {
                hourOption.classList.add('selected');
                hourOption.scrollIntoView({ block: 'center', behavior: 'auto' });
            }
            
            if (minuteOption) {
                minuteOption.classList.add('selected');
                minuteOption.scrollIntoView({ block: 'center', behavior: 'auto' });
            }
            
            if (periodOption) {
                periodOption.classList.add('selected');
            }
        }
    }
    
    // Handle open time picker click
    openTimePicker.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.style.display = 'block';
        dropdown.dataset.target = 'open';
        dropdown.dataset.picker = 'open-time-picker';
        dropdown.dataset.input = 'open_time';
        
        // Position the dropdown
        const rect = this.getBoundingClientRect();
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
        
        dropdown.style.position = 'fixed'; // Changed to fixed for better positioning in modal
        dropdown.style.top = rect.bottom + 'px';
        dropdown.style.left = rect.left + 'px';
        dropdown.style.zIndex = '1060'; // Higher than Bootstrap modal z-index
        
        // Highlight the current selection
        setTimeout(highlightSelectedTime, 50); // Small delay to ensure dropdown is visible
    });
    
    // Handle close time picker click
    closeTimePicker.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.style.display = 'block';
        dropdown.dataset.target = 'close';
        dropdown.dataset.picker = 'close-time-picker';
        dropdown.dataset.input = 'close_time';
        
        // Position the dropdown
        const rect = this.getBoundingClientRect();
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

        dropdown.style.position = 'fixed'; // Changed to fixed for better positioning in modal
        dropdown.style.top = rect.bottom + 'px';
        dropdown.style.left = rect.left + 'px';
        dropdown.style.zIndex = '1060'; // Higher than Bootstrap modal z-index
        
        // Highlight the current selection
        setTimeout(highlightSelectedTime, 50); // Small delay to ensure dropdown is visible
    });
    
    // Edit time pickers
    document.getElementById('edit-open-time-picker').addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.style.display = 'block';
        dropdown.dataset.target = 'open';
        dropdown.dataset.picker = 'edit-open-time-picker';
        dropdown.dataset.input = 'edit_open_time';
        
        // Position the dropdown
        const rect = this.getBoundingClientRect();
        dropdown.style.position = 'fixed'; // Changed to fixed for better positioning in modal
        dropdown.style.top = rect.bottom + 'px';
        dropdown.style.left = rect.left + 'px';
        dropdown.style.zIndex = '1060'; // Higher than Bootstrap modal z-index
        
        // Highlight the current selection
        setTimeout(highlightSelectedTime, 50); // Small delay to ensure dropdown is visible
    });
    
    document.getElementById('edit-close-time-picker').addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.style.display = 'block';
        dropdown.dataset.target = 'close';
        dropdown.dataset.picker = 'edit-close-time-picker';
        dropdown.dataset.input = 'edit_close_time';
        
        // Position the dropdown
        const rect = this.getBoundingClientRect();
        dropdown.style.position = 'fixed'; // Changed to fixed for better positioning in modal
        dropdown.style.top = rect.bottom + 'px';
        dropdown.style.left = rect.left + 'px';
        dropdown.style.zIndex = '1060'; // Higher than Bootstrap modal z-index
        
        // Highlight the current selection
        setTimeout(highlightSelectedTime, 50); // Small delay to ensure dropdown is visible
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function() {
        dropdown.style.display = 'none';
    });
    
    // Status toggle in add modal
    document.getElementById('status_toggle').addEventListener('change', function() {
        if (!this.checked) {
            // If closed, disable time inputs
            openTimePicker.style.opacity = '0.5';
            closeTimePicker.style.opacity = '0.5';
        } else {
            // If open, enable time inputs
            openTimePicker.style.opacity = '1';
            closeTimePicker.style.opacity = '1';
        }
    });
});
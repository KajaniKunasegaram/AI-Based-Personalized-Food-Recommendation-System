@extends('admin.layout')

@section('title','Business Hours')
@section('page_title','Business Hours')

@section('content')
    <html>
        <head>
            <meta charset="UTF-8" />
            <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->
            <meta name="csrf-token" content="{{ csrf_token() }}">            
            <title>Shift Schedule</title>
            <link rel="stylesheet" href="{{asset('css/business-hours.css')}}">
            <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" /> -->
            <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" /> -->
           
        </head>

        <body>
            <div class="container">
                <div class="week-days">
                    <div class="day-circle active" id="all-circle">All</div>
                        @foreach($days as $day)
                            <div class="day-circle" data-day="{{ $day }}">{{ ucfirst(substr($day, 0, 1)) }}</div>
                        @endforeach
                    </div>

                    @foreach($days as $day)
                        <div class="day-section active" id="{{ $day }}">
                            <div class="day-header">{{ ucfirst($day) }}</div>
                            <div class="row mx-0">
                                <div class="col-3 fw-bold service-col">Service</div>
                                <div class="col-6 fw-bold time-col">Time</div>
                                <div class="col-3 fw-bold status-col">Status</div>
                            </div>
                            
                            @foreach($shiftsData[$day] as $shift)
                                <div class="row mx-0 shift-row" data-shift-id="{{ $shift->id }}">
                                    <div class="col-3 service-col">{{ $shift->service_type }}</div>
                                    <div class="col-6 time-col">{{ $shift->time_range }}</div>
                                    <div class="col-3 status-col d-flex justify-content-end align-items-center">
                                        <span class="{{ $shift->is_open ? 'status-open' : 'status-closed' }}">
                                            {{ $shift->is_open ? 'Open' : 'Closed' }}
                                        </span>
                                        <span class="arrow-icon"><i class="fas fa-chevron-right"></i></span>
                                        <button class="delete-btn ms-2" data-shift-id="{{ $shift->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="add-shift">
                                <button class="btn btn-link text-decoration-none add-shift-btn" data-day="{{ ucfirst($day) }}">
                                    Add Shift
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Add Shift Modal -->
            <div class="modal fade add-shift-modal" id="addShiftModal" tabindex="-1" aria-labelledby="addShiftModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addShiftModalLabel">ADD SHIFT</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addShiftForm">
                                <input type="hidden" id="day_of_week" name="day_of_week">
                                
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="form-label">Status</label>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">Open</span>
                                            <label class="toggle-switch">
                                                <input type="checkbox" id="status_toggle" checked />
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="deliveryCheck" value="Delivery" name="service_types[]" checked />
                                                <label class="form-check-label" for="deliveryCheck">
                                                    Delivery
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="pickupCheck" value="Pickup" name="service_types[]" checked />
                                                <label class="form-check-label" for="pickupCheck">
                                                    Pickup
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="time-settings">
                                        <div class="time-group">
                                            <div class="time-label">Open at</div>
                                            <div class="time-input" id="open-time-picker">
                                                <span class="time-icon">⏱</span>
                                                <span class="time-text">09:00</span>
                                                <input type="hidden" id="open_time" name="open_time" value="09:00">
                                            </div>
                                        </div>
                                        <div class="time-group">
                                            <div class="time-label">Close at</div>
                                            <div class="time-input" id="close-time-picker">
                                                <span class="time-icon">⏱ </span>
                                                <span class="time-text">17:00</span>
                                                <input type="hidden" id="close_time" name="close_time" value="17:00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <div class="row w-100">
                                <div class="col-6">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        CANCEL
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-primary" id="saveShiftBtn">
                                        SAVE
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Shift Modal -->
            <div class="modal fade edit-shift-modal" id="editShiftModal" tabindex="-1" aria-labelledby="editShiftModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editShiftModalLabel">UPDATE PICKUP SHIFT</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editShiftForm">
                                <input type="hidden" id="edit_shift_id" name="shift_id">
                                <input type="hidden" id="edit_open_time" name="open_time" value="09:00">
                                <input type="hidden" id="edit_close_time" name="close_time" value="17:00">


                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="form-label">Status</label>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 fs-5 text-danger" id="status-label">Closed</span>
                                            <label class="edit-toggle-switch">
                                                <input type="checkbox" id="editStatusToggle" checked />
                                                <span class="edit-slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div id="time-controls" class="mb-4" style="display: none;">
                                    <div class="edit-time-settings">
                                        <div class="edit-time-group">
                                            <div class="edit-time-label">Open at</div>
                                            <div class="edit-time-input" id="edit-open-time-picker">
                                                <span class="edit-time-icon">⏱</span>
                                                <span class="edit-time-text">09:00</span>
                                                
                                            </div>
                                        </div>
                                        <div class="edit-time-group">
                                            <div class="edit-time-label">Close at</div>
                                            <div class="edit-time-input" id="edit-close-time-picker">
                                                <span class="edit-time-icon">⏱</span>
                                                <span class="edit-time-text">17:00</span>
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="closed-note" class="note" style="display: none">
                                    * Location will be closed during this time period
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <div class="row w-100">
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-secondary w-100" id="cancelEditBtn" data-bs-dismiss="modal">
                                        CANCEL
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-primary w-100" id="saveEditBtn">
                                        SAVE
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Time Picker Dropdown -->
            <div class="time-picker-dropdown" id="time-picker-dropdown">
                <div class="time-columns">
                    <div class="time-column" id="hours-column">
                        <!-- Hours will be populated by JavaScript -->
                    </div>
                    <div class="time-column" id="minutes-column">
                        <!-- Minutes will be populated by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteConfirmModalLabel">Delete Shift</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this shift?</p>
                        </div>
                        <div class="modal-footer">
                            <div class="row w-100">
                                <div class="col-6">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">DELETE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
            <script src="{{asset('javascript/business-hours.js')}}"></script>
        </body>
    </html>

@endsection

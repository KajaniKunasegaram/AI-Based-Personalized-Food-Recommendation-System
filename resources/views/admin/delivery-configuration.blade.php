@extends('admin.layout')

@section('title','Delivery Configuration')
@section('page_title','Delivery Configuration')

@section('content')
    <html>
        <head>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <style>
                body{
                    background:whitesmoke;
                }
                .contain{
                    display: flex;
                    flex-wrap: wrap;
                    width: 100%;
                    height:100%;
                    margin-bottom:50px;
                }

                .left-panel {
                    flex: 0 60%;
                    background-color: white;
                    padding: 20px;
                    border-right:2px solid whitesmoke;
                }

                .right-panel {
                    flex: 0 40%;
                    padding: 20px;
                    background-color: white;
                }

                .distance-limit {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding-bottom: 10px;
                    margin-bottom: 15px;
                    border-bottom: 1px solid #dee2e6;
                    font-size:18px;
                }

                .distance-value {
                    color: purple;
                }

                .form-title {
                    font-size: 1.5rem;
                    font-weight: bold;
                    margin-bottom: 25px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                .form-control {
                    border-radius: 0;
                    padding: 12px;
                    margin-bottom: 20px;
                    border: none;
                    border-bottom: 1px solid #dee2e6;
                    width: 100%;
                }

                

                .radio-option {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    padding: 8px 0;
                    cursor: pointer;
                    font-size: 15px;
                }

                .radio-option input[type="radio"] {
                    transform: scale(1.4);
                    accent-color: #28a745; 
                }

                .delete-icon {
                    color: #d9534f;
                    cursor: pointer;
                    font-size: 1.2rem;
                    margin-left: 10px;
                }

                .delete-icon:hover {
                    color: #c9302c;
                }

                .action-buttons {
                    display: flex;
                    justify-content: space-between;
                    margin-top: 50px;
                    flex-wrap: wrap;
                    gap: 10px; 
                }

                .btn-reset {
                    background-color: #e3e8e3;
                    color: #333;
                    border: none;
                    padding: 10px 0;
                    width: 48%;
                    border-radius: 4px;
                    font-weight: bold;
                }

                .btn-add {
                    background-color: #4CAF50;
                    color: white;
                    border: none;
                    padding: 10px 0;
                    width: 48%;
                    border-radius: 4px;
                    font-weight: bold;
                }

                /* Popup */
                .popup-overlay {
                    display: none;
                    position: fixed;
                    top: 0; left: 0;
                    width: 100%; height: 100%;
                    background: rgba(0,0,0,0.6);
                    justify-content: center;
                    align-items: center;
                    z-index: 999;
                }
                .popup-box {
                    width: 450px;
                    background: white;
                    padding: 20px;
                    border-radius: 10px;
              
                }

                .popup-columns {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 20px;
                    height:400px;
                    overflow-y:auto;
                }
                .mile-row {
                    background: #f4f4f4;
                    border: 1px solid #ddd;
                    padding: 8px;
                    margin-bottom: 6px;
                    border-radius: 6px;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }
                .mile-row-dis {
                    display: flex;
                    justify-content: space-between; /* left-right alignment */
                    align-items: center;           /* vertically center text */
                    padding: 8px;
                    margin-bottom: 6px;
                    border: 1px solid #ddd;
                    border-radius: 6px;
                    background: #f4f4f4;
                }
                .mile-left {
                    font-weight: 500;
                }

                .mile-right {
                    font-weight: bold;
                    color: purple;
                }

                .success-alert {
                    background: #d4edda;
                    color: #155724;
                    padding: 12px 20px;
                    border-radius: 6px;
                    margin-bottom: 15px;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    border: 1px solid #c3e6cb;
                    font-weight: 500;
                }

                @media (max-width: 900px) {
                    .left-panel {
                        flex: 100%;
                    }
                    .right-panel {
                        flex: 100%;
                    }
                }

                @media (max-width: 480px) {
                    .popup-box {
                        width: 95%;
                    }
                }
                
            </style>
        </head>

        <body>

        @if(session('success'))
            <div class="success-alert">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif
            <div class="contain">
                <div class="left-panel">
                    <div class="distance-limit">
                        <div>Distance Limit</div>
                        <div class="distance-value" id="open-popup">
                            <span id="selected-mile-text" class="selected-mile"></span>
                            ▶
                        </div>
                    </div>
                    @foreach($deliveries as $delivery)
                        <div class="mile-row-dis delivery-item" data-id="{{ $delivery->id }}">
                            <span class="mile-left">Postcode: {{ $delivery->postcode }}</span>
                            <span class="mile-right">
                                @if($delivery->delivery_charge === null)
                                    Free Charge
                                @else
                                    {{ number_format($delivery->delivery_charge, 2) }}
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="right-panel">
                    <div class="form-title">
                        <span id="form-heading">Add Delivery Charge</span>
                        <div id="delete-icon-container" style="display: none;">
                            <i class="fas fa-trash delete-icon" id="delete-button"></i>
                        </div>
                    </div>
                    <br>
                    <form method="POST" id="delivery-form"
                        action="{{ url('/admin/delivery-config') }}">
                        @csrf
                        <!-- <input type="hidden" name="distance" id="distance"> -->
                        <input type="hidden" id="delivery-id">

                        <div class="form-group">
                            <input type="text" name="postcode" id="postcode" class="form-control" placeholder="Postcode*" required>
                        </div>
                        
                       
                        <label class="radio-option">
                            <input type="radio" id="delivery_type" name="delivery_type" value="free" checked>
                            Free Delivery
                        </label>

                        <label class="radio-option">
                            <input type="radio" id="delivery_type" name="delivery_type" value="charge">
                            Delivery Charge
                        </label>
                      

                        <div class="form-group" id="charge-input-box" style="display:none;">
                            <input type="number" id="delivery_charge" name="delivery_charge" id="delivery_charge" class="form-control" placeholder="Enter Delivery Charge">
                        </div>

                        <div class="action-buttons">
                            <button type="button" class="btn-reset" id="reset-form">RESET</button>
                            <button type="submit" class="btn-add" id="submit-button">ADD</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- POPUP -->
            <div class="popup-overlay" id="distance-popup">
                <div class="popup-box">
                    <h3>Select Distance</h3>

                    <div class="popup-columns">

                        <!-- Column 1 : 0.5 → 14.5 -->
                        <div>
                            @for ($i = 0.5; $i <= 14.5; $i += 1)
                                <label class="mile-row">
                                    <input type="radio" name="mile" value="{{ $i }}">
                                    {{ number_format($i,1) }} miles
                                </label>
                            @endfor
                        </div>

                        <!-- Column 2 : 1 → 15 -->
                        <div>
                            @for ($i = 1; $i <= 15; $i++)
                                <label class="mile-row">
                                    <input type="radio" name="mile" value="{{ $i }}">
                                    {{ $i }} miles
                                </label>
                            @endfor
                        </div>

                    </div>

                    <br>
                    <button onclick="closePopup()" class="btn btn-dark" style="width:100%;">Close</button>
                </div>
            </div>

            <script>

                document.getElementById("open-popup").addEventListener("click", function() {
                    document.getElementById("distance-popup").style.display = "flex";
                });

                function closePopup() {
                    document.getElementById("distance-popup").style.display = "none";
                }

                document.querySelectorAll("input[name='mile']").forEach(radio => {
                    radio.addEventListener("change", function() {

                        let selectedValue = this.value + " miles";

                        document.getElementById("selected-mile-text").innerText = selectedValue;

                        closePopup();
                    });
                });

                document.addEventListener('DOMContentLoaded', function () {

                    let savedMile = localStorage.getItem('selected_mile');
                    let savedValue = localStorage.getItem('selected_mile_value');

                    // ✅ If no mile selected yet → default 5 miles
                    if (!savedMile) {
                        savedMile = '5 miles';
                        savedValue = '5';

                        localStorage.setItem('selected_mile', savedMile);
                        localStorage.setItem('selected_mile_value', savedValue);
                    }

                    // Show in UI
                    document.getElementById('selected-mile-text').innerText = savedMile;

                    // Auto check radio
                    let radio = document.querySelector(`input[name="mile"][value="${savedValue}"]`);
                    if (radio) {
                        radio.checked = true;
                    }
                });

                document.querySelectorAll("input[name='mile']").forEach(radio => {
                    radio.addEventListener("change", function () {

                        let selectedValue = this.value + " miles";

                        // Update UI
                        document.getElementById("selected-mile-text").innerText = selectedValue;

                        // Save selection
                        localStorage.setItem('selected_mile', selectedValue);
                        localStorage.setItem('selected_mile_value', this.value);

                        closePopup();
                    });
                });

                // Radio button logic
                const radios = document.getElementsByName("delivery_type");
                const chargeBox = document.getElementById("charge-input-box");

                radios.forEach(radio => {
                    radio.addEventListener("change", () => {
                        if (radio.value === "charge") {
                            chargeBox.style.display = "block";
                        } else {
                            chargeBox.style.display = "none";
                        }
                    });
                });

                document.querySelectorAll('.delivery-item').forEach(item => {
                    item.addEventListener('click', function () {

                        let id = this.dataset.id;

                        // highlight active row (optional but good UX)
                        document.querySelectorAll('.delivery-item').forEach(el => el.classList.remove('active'));
                        this.classList.add('active');

                        fetch(`/admin/delivery-config/${id}`)
                            .then(res => res.json())
                            .then(data => {

                                // Fill form
                                document.getElementById('delivery-id').value = data.id;
                                document.getElementById('postcode').value = data.postcode;

                                document.querySelector(`input[name="delivery_type"][value="${data.delivery_type}"]`).checked = true;

                                if (data.delivery_type === 'charge') {
                                    document.getElementById('charge-input-box').style.display = 'block';
                                    document.getElementById('delivery_charge').value = data.delivery_charge;
                                } else {
                                    document.getElementById('charge-input-box').style.display = 'none';
                                    document.getElementById('delivery_charge').value = '';
                                }

                                // 🔁 Change UI to UPDATE mode
                                document.getElementById('form-heading').innerText = 'Update Delivery Charge';
                                document.getElementById('submit-button').innerText = 'UPDATE';

                                document.getElementById('delivery-form').action =
                                    `/admin/delivery-config/update/${data.id}`;

                                // Show delete icon
                                document.getElementById('delete-icon-container').style.display = 'block';

                                document.getElementById('delete-button').onclick = function () {
                                    deleteDelivery(data.id);
                                };
                            });
                    });
                });

                function deleteDelivery(id) {
                    if (!confirm('Are you sure you want to delete this delivery charge?')) return;

                    fetch(`/admin/delivery-config/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(() => location.reload());
                }
                setTimeout(() => {
                    const alert = document.querySelector('.success-alert');
                    if (alert) alert.style.display = 'none';
                }, 3000);

                document.getElementById('reset-form').addEventListener('click', function() {
                    const form = document.getElementById('delivery-form');
                    form.reset(); // HTML form reset function
                    
                    // Extra: delivery charge box hide panna
                    document.getElementById('charge-input-box').style.display = 'none';
                        document.getElementById('form-heading').innerText = 'Add Delivery Charge';
                                document.getElementById('submit-button').innerText = 'ADD';
                });
            </script>

</body>
</html>

@endsection

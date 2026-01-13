@extends('admin.layout')

@section('title','Delivery Boys')
@section('page_title','Delivery Boys')

@section('content')

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
            
<div class="contain">
    <!-- Left Panel: List -->
    <div class="left-panel">
        @foreach($deliveryBoys as $boy)
            <div class="mile-row-dis delivery-item" data-id="{{ $boy->id }}">
                <span class="mile-left">{{ $boy->name }}</span>
                <span class="mile-right">{{ $boy->phone }}</span>
            </div>
        @endforeach
    </div>

    <!-- Right Panel: Form -->
    <div class="right-panel">
        <div class="form-title">
            <span id="form-heading">Add Delivery Boy</span>
            <div id="delete-icon-container" style="display: none;">
                <i class="fas fa-trash delete-icon" id="delete-button"></i>
            </div>
        </div>

        <form method="POST" id="delivery-form" action="{{ url('/admin/delivery-boys') }}">
            @csrf
            <input type="hidden" id="delivery-id">
            <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" required>

            <div class="action-buttons">
                <button type="button" class="btn-reset" id="reset-form">RESET</button>
                <button type="submit" class="btn-add" id="submit-button">ADD</button>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelectorAll('.delivery-item').forEach(item => {
    item.addEventListener('click', function () {
        const id = this.dataset.id;
        document.querySelectorAll('.delivery-item').forEach(el => el.classList.remove('active'));
        this.classList.add('active');

        fetch(`/admin/delivery-boys/${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('delivery-id').value = data.id;
                document.getElementById('name').value = data.name;
                document.getElementById('phone').value = data.phone;

                document.getElementById('form-heading').innerText = 'Update Delivery Boy';
                document.getElementById('submit-button').innerText = 'UPDATE';
                document.getElementById('delivery-form').action = `/admin/delivery-boys/update/${data.id}`;

                document.getElementById('delete-icon-container').style.display = 'block';
                document.getElementById('delete-button').onclick = function () {
                    if(confirm('Are you sure?')) {
                        fetch(`/admin/delivery-boys/${data.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        }).then(()=> location.reload());
                    }
                }
            });
    });
});

document.getElementById('reset-form').addEventListener('click', function() {
    const form = document.getElementById('delivery-form');
    form.reset();
    document.getElementById('form-heading').innerText = 'Add Delivery Boy';
    document.getElementById('submit-button').innerText = 'ADD';
    document.getElementById('delivery-id').value = '';
    document.getElementById('delete-icon-container').style.display = 'none';
});
</script>
@endsection

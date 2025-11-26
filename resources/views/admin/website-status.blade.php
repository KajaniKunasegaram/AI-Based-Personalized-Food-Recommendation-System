@extends('admin.layout')

@section('title','Website Status')
@section('page_title','website Status')

@section('content')
    <html>
        <head>
            <link rel="stylesheet" href="{{asset('css/website-status.css')}}">        
        </head>

        <body>
            <div class="container">
                <div class="status-group">
                    <div class="status-item">
                        <div class="status-label">Open as usual</div>
                        <label class="switch">
                            <input type="checkbox" name="open_as_usual" class="status-switch" value="1" checked>
                            <span class="slider"></span>
                        </label>
                    </div>                

                    <div class="status-item">
                        <div class="status-label">Closed for today</div>
                        <label class="switch">
                            <input type="checkbox" name="close_today" class="status-switch" value="1" >
                            <span class="slider"></span>
                        </label>
                    </div>      
                    
                    <div class="status-item">
                        <div class="status-label">Closed Until</div>
                        <label class="switch">
                            <input type="checkbox" name="closed_until" class="status-switch" value="1" >
                            <span class="slider"></span>
                        </label>
                    </div>      
                    
                    <div class="date-time-container" id="dateTimeContainer">
                        <div class="date-time-row">
                            <div class="date-field">
                                <div class="field-label">Reopen Date</div>
                                <input type="date" id="reOpenDate" name="reopen-date" class="input-field" placeholder="DD/MM/YYYY">
                            </div>
                        </div>

                        <div class="message-container">
                            <textarea name="message" rows="2" ></textarea>
                        </div>
                    </div>

                    <div class="status-item">
                        <div>
                            <div class="status-label">Closed</div>
                            <div class="note">Note : Website will be closed until it is set to open.</div>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="closed" value="1"  class="status-switch">
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div style="display: flex; justify-content: center; align-items: center;">
                        <button type="submit" style="margin-top:20px; margin-bottom:20px; padding:10px 20px;border:none;background-color:#34c759;color:white;border-radius:8px;cursor:pointer;">
                            Save Status
                        </button>
                    </div>

                </div>
            </div>

            <script>
                const switches = document.querySelectorAll('input[type="checkbox"].status-switch');
                const dateTimeContainer = document.getElementById('dateTimeContainer');

                function UpdateUI()
                {
                    const closeUntilChecked = document.querySelector('input[name="closed_until"]').checked;
                    dateTimeContainer.style.display = closeUntilChecked ? 'block' : 'none';
                }

                switches.forEach((switchElement) => {
                    switchElement.addEventListener('change', function(){
                        if(this.checked)
                        {
                            switches.forEach((otherSwitch) => {
                                if(otherSwitch !== this){
                                    otherSwitch.checked = false;
                                }
                            });
                        }
                        UpdateUI();
                    });
                });

                UpdateUI();

                window.addEventListener('DOMContentLoaded', () => {
                    const dateInput = document.getElementById('reOpenDate');

                    const today = new Date();
                    today.setDate(today.getDate() + 1); 
                    
                    const yyyy = today.getFullYear();
                    const mm = String(today.getMonth() + 1).padStart(2, '0'); 
                    const dd = String(today.getDate()).padStart(2, '0');
                    
                    const minDate = `${yyyy}-${mm}-${dd}`;
                    dateInput.min = minDate;
                });
            </script>
        </body>
    </html>

@endsection

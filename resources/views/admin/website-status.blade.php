@extends('admin.layout')
@section('title','Website Status')
@section('page_title','Website Status')
@section('content')
<link rel="stylesheet" href="{{asset('css/admin/website-status.css')}}">

<div class="container">
    <div class="status-group">

        {{-- Current Status Badge --}}
        @if($current)
        <div class="current-status-badge">
            Current:
            @if($current->status === 'open')
                <span class="badge green">🟢 Open as Usual</span>
            @elseif($current->status === 'closed_today')
                <span class="badge orange">🟠 Closed for Today</span>
            @elseif($current->status === 'closed_until')
                <span class="badge orange">🟠 Closed Until {{ $current->reopen_date }}</span>
            @elseif($current->status === 'closed')
                <span class="badge red">🔴 Closed</span>
            @endif
        </div>
        @endif

        @if(session('success'))
            <div style="color:green; padding:10px; margin-bottom:10px;">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.website.status.save') }}" method="POST">
            @csrf

            <div class="status-item">
                <div class="status-label">Open as usual</div>
                <label class="switch">
                    <input type="checkbox" name="open_as_usual" class="status-switch" value="1"
                        {{ $current && $current->status === 'open' ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>

            <div class="status-item">
                <div class="status-label">Closed for today</div>
                <label class="switch">
                    <input type="checkbox" name="close_today" class="status-switch" value="1"
                        {{ $current && $current->status === 'closed_today' ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>

            <div class="status-item">
                <div class="status-label">Closed Until</div>
                <label class="switch">
                    <input type="checkbox" name="closed_until" class="status-switch" value="1"
                        {{ $current && $current->status === 'closed_until' ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>

            <div class="date-time-container" id="dateTimeContainer"
                style="{{ $current && $current->status === 'closed_until' ? 'display:block' : 'display:none' }}">
                <div class="date-time-row">
                    <div class="date-field">
                        <div class="field-label">Reopen Date</div>
                        <input type="date" id="reOpenDate" name="reopen-date" class="input-field"
                            value="{{ $current && $current->reopen_date ? $current->reopen_date : '' }}">
                    </div>
                </div>
                <div class="message-container">
                    <textarea name="message" rows="2" placeholder="Optional message...">{{ $current ? $current->message : '' }}</textarea>
                </div>
            </div>

            <div class="status-item">
                <div>
                    <div class="status-label">Closed</div>
                    <div class="note">Note: Website will be closed until it is set to open.</div>
                </div>
                <label class="switch">
                    <input type="checkbox" name="closed" value="1" class="status-switch"
                        {{ $current && $current->status === 'closed' ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>

            <div style="display:flex; justify-content:center; align-items:center;">
                <button type="submit" style="margin-top:20px; margin-bottom:20px; padding:10px 20px; border:none; background-color:#34c759; color:white; border-radius:8px; cursor:pointer;">
                    Save Status
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const switches = document.querySelectorAll('input[type="checkbox"].status-switch');
    const dateTimeContainer = document.getElementById('dateTimeContainer');

    function UpdateUI() {
        const closeUntilChecked = document.querySelector('input[name="closed_until"]').checked;
        dateTimeContainer.style.display = closeUntilChecked ? 'block' : 'none';
    }

    switches.forEach((switchElement) => {
        switchElement.addEventListener('change', function() {
            if (this.checked) {
                switches.forEach((otherSwitch) => {
                    if (otherSwitch !== this) otherSwitch.checked = false;
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
        dateInput.min = `${yyyy}-${mm}-${dd}`;
    });
</script>

{{-- Badge CSS --}}
<style>
.current-status-badge {
    padding: 12px 16px;
    background: #f9f9f9;
    border-radius: 8px;
    margin-bottom: 20px;
    font-weight: 600;
    font-size: 14px;
}
.badge { padding: 4px 12px; border-radius: 20px; font-size: 13px; }
.badge.green  { background: #e6f9ec; color: #1a7a3c; }
.badge.orange { background: #fff4e0; color: #b85c00; }
.badge.red    { background: #fde8e6; color: #c0392b; }
</style>

@endsection

























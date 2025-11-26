@extends('admin.layout')

@section('title','Take Payment')
@section('page_title','Take Payment')

@section('content')
    <html>
        <head>
            <style>
                .payment {
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                    /* width: 100%;
                    height: 100%; */
                    padding: 15px;
                }

                .amount-section {
                    display: flex;
                    align-items: center;
                    margin-bottom: 20px;
                    width: 100%;
                }

                .amount-section input {
                    border: none;
                    border-bottom: 1px solid #dee2e6;
                    border-radius: 0;
                    padding: 5px 0;
                    font-size: 18px;
                    box-shadow: none;
                    width: 100%;
                }
                
                .amount-section input:focus {
                    outline: none;
                    box-shadow: none;
                    border-color: #4CAF50;
                }
                
                .share-icon {
                    font-size: 20px;
                    color: #6c757d;
                    
                }
                .flex-grow-1 {
                    width: 100%;
                }

                .required-field::after {
                    content: " *";
                    color: red;
                }
        
                .pay-btn {
                    background-color: #4CAF50;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    padding: 12px;
                    font-size: 16px;
                    width: 100%;
                    margin-bottom: 20px;
                }

                .scan-text {
                    text-align: center;
                    margin-bottom: 20px;
                }
                
                .qr-code {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    margin-bottom: 30px;
                }

                .qr-code #qrcode {
                    display: inline-block;
                }

                .qr-code img {
                    width: 100%;
                    max-width: 400px;
                    height: auto;
                }

                .email-section {
                    display: flex;
                    align-items: center;
                    margin-bottom: 20px;
                    width: 100%;
                }
                
                .email-section label {
                    margin-right: 10px;
                    color: #998;
                    font-weight: normal;
                    white-space: nowrap;
                }
                
                .email-section input {
                    flex-grow: 1;
                    border: none;
                    border-bottom: 1px solid #dee2e6;
                    border-radius: 0;
                    padding: 5px 0;
                    box-shadow: none;
                    width: 100%;
                }
                
                .email-section input:focus {
                    outline: none;
                    box-shadow: none;
                    border-color: #4CAF50;
                }

                .action-buttons {
                    display: flex;
                    justify-content: flex-end;
                    gap: 10px;
                    width: 100%;
                }
                
                .send-btn {
                    background-color: white;
                    color: #4CAF50;
                    border: 1px solid #4CAF50;
                    border-radius: 5px;
                    padding: 8px 20px;
                }
                
                .print-btn {
                    background-color: white;
                    color: #212529;
                    border: 1px solid #dee2e6;
                    border-radius: 5px;
                    padding: 8px 12px;
                }
                

            </style>
        </head>

        <body>
            <div class="payment">
                <form method="POST">

                    <!-- Amount Section -->
                    <div class="amount-section">
                        <div class="flex-grow-1">
                            <label for="amount" class="required-field">Enter Amount</label>
                            <input
                                type="text"
                                class="form-control"
                                id="amount"
                                name="amount"
                                value="0.00"
                                inputmode="numeric"
                            >
                        </div>                    
                    </div>

                    <!-- Generate QR Button -->
                    <button type="button" class="pay-btn" id="generateQR">
                        <i class="bi bi-qrcode me-2"></i> Generate QR Code
                    </button>

                    <!-- QR Code Display -->
                    <div id="qr-section" style="display: none;">
                        <div class="scan-text">
                            <p class="mb-1">SCAN TO PAY £<span id="qr-amount">0.00</span> to</p>
                            <p class="mb-0">Master Chef</p>
                        </div>
                        <div class="qr-code" style="text-align: center; padding: 20px;">
                            <div id="qrcode"></div>
                        </div>
                    </div>


                    <!-- Email Section -->
                     <div class="amount-section">
                        <div class="flex-grow-1">
                            <label for="email" class="required-field">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button class="send-btn" type="submit">SEND LINK</button>
                        <button type="button" class="print-btn" onclick="window.print()">
                            <i class="bi bi-printer"></i>
                        </button>
                    </div>
                </form>
            </div>



            <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
            <script>

                const amountInput = document.getElementById("amount");

                amountInput.addEventListener("input", function (e) {
                    let value = this.value.replace(/[^0-9]/g, ""); // remove non-numbers

                    if (value === "") {
                        this.value = "0.00";
                        return;
                    }

                    // Convert to decimal format
                    let num = parseInt(value).toString();

                    // If only 1 digit → 0.0X
                    if (num.length === 1) {
                        this.value = "0.0" + num;
                    }
                    // If 2 digits → 0.XX
                    else if (num.length === 2) {
                        this.value = "0." + num;
                    }
                    // If 3+ digits → normal decimal
                    else {
                        let decimal = num.slice(-2);
                        let whole = num.slice(0, -2);
                        this.value = whole + "." + decimal;
                    }
                });

                document.getElementById('generateQR').addEventListener('click',function(){
                    let amount=document.getElementById('amount').value.trim();

                    if(amount=="" )
                    {
                        alert("Please enter a valid amount");
                        return;
                    }

                    document.getElementById('qr-section').style.display = 'block';
                    document.getElementById('qr-amount').innerText = amount;

                    document.getElementById('qrcode').innerHTML="";

                    new QRCode(document.getElementById("qrcode"),{
                            text: "PAYMENT_AMOUNT=" + amount,
                            width: 250,
                            height: 250
                    });
                });
            </script>
        </body>
    </html>

@endsection

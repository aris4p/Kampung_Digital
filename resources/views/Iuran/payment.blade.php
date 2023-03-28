<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="card">
        <div class="card-body mx-4">
            <div class="container">
                <p class="my-5 mx-5" style="font-size: 30px;">Detail Pembelian</p>
                <div class="row">
                    <ul class="list-unstyled">
                        <li class="text-black">{{ $payment->warga->nama }}</li>
                        <li class="text-muted mt-1"><span class="text-black">Invoice</span> #{{ $payment->idtrx }}</li>
                        <li class="text-black mt-1">{{ $payment->created_at }}</li>
                    </ul>
                    <hr>


                    <div class="col-xl-10">
                        <p>{{ $payment->dana->nama }}</p>
                    </div>
                    <div class="col-xl-2">
                        <p class="float-end">Rp. {{$payment->nominaltrx }}
                        </p>
                    </div>

                    <hr>
                </div>
                <div class="row text-black">

                    <div class="col-xl-12">
                        <p class="float-end fw-bold">Total: Rp.{{ $payment->nominaltrx }}
                        </p>
                    </div>
                    <hr style="border: 2px solid black;">
                </div>
                <div class="row text-black">

                    <div class="col-xl-12">
                        <p  class="float-end fw-bold">
                            <button class="btn btn-primary" id="pay-button">Bayar</button>
                        </p>
                    </div>
                    <hr style="border: 2px solid black;">
                </div>

            </div>
        </div>
    </div>

    <form action="" id="submit_form" method="post">
        @csrf
        <input type="hidden" id="json_callback" name="json">
    </form>

    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        // For example trigger on button clicked, or any time you need
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay('{{ $payment->snap_token }}', {
                onSuccess: function(result){
                    /* You may add your own implementation here */
                    send_respond_to_form(result);
                },
                onPending: function(result){
                    /* You may add your own implementation here */
                    send_respond_to_form(result);
                },
                onError: function(result){
                    /* You may add your own implementation here */
                    send_respond_to_form(result);
                },
                onClose: function(){
                    /* You may add your own implementation here */
                    send_respond_to_form(result);
                }
            })
        });

        /*
            sementara tidak dipakai dahulu
        */
        // function send_respond_to_form(result){
        //     document.getElementById('json_callback').value = JSON.stringify(result);
        //     $('#submit_form').submit();
        // }

    </script>
</body>
</html>


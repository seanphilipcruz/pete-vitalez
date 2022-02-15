<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pete Vitalez | Receipt Authentication</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}" />
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
<div class="container">
    <div class="my-4">
        <div class="card">
            @if($response['code'] === 404)
                <div id="not-found-container" class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="text-center fs-3 text-open-sans d-flex justify-content-center align-items-center">
                                404, order not found.
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($response['code'] === 200)
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="fs-3">Order Code: <span class="fw-bold">{{ $response['order']->code }}</span></div>
                            <div class="fs-4">Hi Mr/Ms. {{ $response['order']->Customer->last_name }}</div>
                            <div class="ms-5 fs-5">Your order has been verified as {{ $response['status'] }} and includes the following:</div>
                            <div class="container">
                                <div class="ms-5">
                                    <div class="row my-3 justify-content-center">
                                        <div class="col-4">
                                            <img src="{{ asset('images/artworks/'.$response['order']->Product->image) }}" alt="{{ $response['order']->Product->title }}" class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="fs-5 my-3">Order Information</div>
                                        <div class="col col-md-6">
                                            <ul>
                                                <p class="my-1">Artwork Name: <span class="fw-bold">{{ $response['order']->Product->title }}</span></p>
                                                <p class="my-1">Price: <span class="fw-bold">PHP {{ $response['order']->total }}</span></p>
                                                <p class="my-1">Date Ordered: <span class="fw-bold">{{ date('F d, Y', strtotime($response['order']->created_at)) }}</span></p>
                                                @if($response['order']->Customer->middle_name === null || $response['order']->Customer->middle_name === "")
                                                    <p class="my-1">First Name: <span class="fw-bold">{{ $response['order']->Customer->first_name }}</span></p>
                                                    <p class="my-1">Last Name: <span class="fw-bold">{{ $response['order']->Customer->last_name }}</span></p>
                                                @else
                                                    <p class="my-1">First Name: <span class="fw-bold">{{ $response['order']->Customer->first_name }}</span></p>
                                                    <p class="my-1">Middle Name: <span class="fw-bold">{{ $response['order']->Customer->middle_name }}</span></p>
                                                    <p class="my-1">Last Name: <span class="fw-bold">{{ $response['order']->Customer->last_name }}</span></p>
                                                @endif
                                                <p class="my-1">Contact Number: <span class="fw-bold">{{ $response['order']->Customer->phone_number }}</span></p>
                                                <p class="my-1">Artwork Frame: <span class="fw-bold">@if($response['order']->is_done === 0) Framed @else No Frame @endif</span></p>
                                            </ul>
                                        </div>
                                        <div class="col col-md-6">
                                            <ul>
                                                <p class="my-1">Address: <span class="fw-bold">{{ $response['order']->Customer->address }}</span></p>
                                                <p class="my-1">City: <span class="fw-bold">{{ $response['order']->Customer->city }}</span></p>
                                                <p class="my-1">State/Province: <span class="fw-bold">{{ $response['order']->Customer->state }}</span></p>
                                                <p class="my-1">Country Code: <span class="fw-bold">{{ $response['order']->Customer->country }}</span></p>
                                                <p class="my-1">Postal Code: <span class="fw-bold">{{ $response['order']->Customer->zip_code }}</span></p>
                                                <p class="my-1">Complete Address: <span class="fw-bold">{{ $response['order']->Customer->complete_address }}</span></p>
                                                <p class="my-1">Status: <span class="fw-bold @if($response['order']->is_done === 2) text-success @elseif($response['order']->is_done === 1) text-warning @else text-danger @endif">@if($response['order']->is_done === 2) Delivered @elseif($response['order']->is_done === 1) On Delivery @else On Queue @endif</span></p>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col text-center">
                                            <div class="fs-5">
                                                @if($response['order']->is_done === 2)
                                                    Your order has been delivered, Thank you for supporting The Art of Pete Vitalez!
                                                @elseif($response['order']->is_done === 1)
                                                    Your order is now on delivery.
                                                @else
                                                    You will be contacted as soon as the order is done.
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
</body>
</html>

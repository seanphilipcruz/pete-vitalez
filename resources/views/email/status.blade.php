<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
        }

        .card-body {
            flex: 1 1 auto;
            padding: 1rem 1rem;
        }

        .row {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(-1 * var(--bs-gutter-y));
            margin-right: calc(-0.5 * var(--bs-gutter-x));
            margin-left: calc(-0.5 * var(--bs-gutter-x));
        }

        .row > * {
            flex-shrink: 0;
            width: 100%;
            max-width: 100%;
            padding-right: calc(var(--bs-gutter-x) * 0.5);
            padding-left: calc(var(--bs-gutter-x) * 0.5);
            margin-top: var(--bs-gutter-y);
        }

        .justify-content-center {
            justify-content: center !important;
        }

        .fw-bold {
            font-weight: 700 !important;
        }

        .text-center {
            text-align: center !important;
        }
        .col {
            flex: 1 0 0%;
        }

        .row-cols-auto > * {
            flex: 0 0 auto;
            width: auto;
        }

        .row-cols-1 > * {
            flex: 0 0 auto;
            width: 100%;
        }

        .row-cols-2 > * {
            flex: 0 0 auto;
            width: 50%;
        }

        .row-cols-3 > * {
            flex: 0 0 auto;
            width: 33.3333333333%;
        }

        .row-cols-4 > * {
            flex: 0 0 auto;
            width: 25%;
        }

        .row-cols-5 > * {
            flex: 0 0 auto;
            width: 20%;
        }

        .row-cols-6 > * {
            flex: 0 0 auto;
            width: 16.6666666667%;
        }

        .col-4 {
            flex: 0 0 auto;
            width: 33.33333333%;
        }

        .col-md-6 {
            flex: 0 0 auto;
            width: 50%;
        }

        .col-12 {
            flex: 0 0 auto;
            width: 100%;
        }

        .fw-bold {
            font-weight: 700 !important;
        }

        .text-end {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .my-1 {
            margin-top: 0.25rem !important;
            margin-bottom: 0.25rem !important;
        }

        .my-2 {
            margin-top: 0.5rem !important;
            margin-bottom: 0.5rem !important;
        }

        .my-3 {
            margin-top: 1rem !important;
            margin-bottom: 1rem !important;
        }

        .my-4 {
            margin-top: 1.5rem !important;
            margin-bottom: 1.5rem !important;
        }

        .mt-3 {
            margin-top: 1rem !important;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-accent-bg: transparent;
            --bs-table-striped-color: #212529;
            --bs-table-striped-bg: rgba(0, 0, 0, 0.05);
            --bs-table-active-color: #212529;
            --bs-table-active-bg: rgba(0, 0, 0, 0.1);
            --bs-table-hover-color: #212529;
            --bs-table-hover-bg: rgba(0, 0, 0, 0.075);
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            vertical-align: top;
            border-color: #dee2e6;
        }
        .table > :not(caption) > * > * {
            padding: 0.5rem 0.5rem;
            background-color: var(--bs-table-bg);
            border-bottom-width: 1px;
            box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
        }
        .table > tbody {
            vertical-align: inherit;
        }
        .table > thead {
            vertical-align: bottom;
        }

        .table-borderless > :not(caption) > * > * {
            border-bottom-width: 0;
        }
        .table-borderless > :not(:first-child) {
            border-top-width: 0;
        }
        .table-hover > tbody > tr:hover > * {
            --bs-table-accent-bg: var(--bs-table-hover-bg);
            color: var(--bs-table-hover-color);
        }

        .fs-1 {
            font-size: calc(1.375rem + 1.5vw) !important;
        }

        .fs-2 {
            font-size: calc(1.325rem + 0.9vw) !important;
        }

        .fs-3 {
            font-size: calc(1.3rem + 0.6vw) !important;
        }

        .fs-4 {
            font-size: calc(1.275rem + 0.3vw) !important;
        }

        .fs-5 {
            font-size: 1.25rem !important;
        }

        .fs-6 {
            font-size: 1rem !important;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="fs-3">Order Code: <span class="fw-bold">{{ $status['order']->code }}</span></div>
                    <div class="fs-4">Hi Mr/Ms. {{ $status['order']->Customer->last_name }}</div>
                    <div class="ms-5 fs-5">Your order @if($status['order']->is_done === 1) is now on delivery @else has been delivered @endif and has the following information:</div>
                    <div class="container">
                        <div class="ms-5">
                            <div class="row my-3 justify-content-center">
                                <div class="col-4">
                                    <img src="{{ asset('images/artworks/'.$status['order']->Product->image) }}" alt="{{ $status['order']->Product->title }}" class="img-fluid">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="fs-5 my-3">Order Information</div>
                                <div class="col col-md-6">
                                    <ul>
                                        <p class="my-1">Artwork Name: <span class="fw-bold">{{ $status['order']->Product->title }}</span></p>
                                        <p class="my-1">Price: <span class="fw-bold">PHP {{ $status['order']->total }}</span></p>
                                        <p class="my-1">Date Ordered: <span class="fw-bold">{{ date('F d, Y', strtotime($status['order']->created_at)) }}</span></p>
                                        @if($status['order']->Customer->middle_name === null || $status['order']->Customer->middle_name === "")
                                            <p class="my-1">First Name: <span class="fw-bold">{{ $status['order']->Customer->first_name }}</span></p>
                                            <p class="my-1">Last Name: <span class="fw-bold">{{ $status['order']->Customer->last_name }}</span></p>
                                        @else
                                            <p class="my-1">First Name: <span class="fw-bold">{{ $status['order']->Customer->first_name }}</span></p>
                                            <p class="my-1">Middle Name: <span class="fw-bold">{{ $status['order']->Customer->middle_name }}</span></p>
                                            <p class="my-1">Last Name: <span class="fw-bold">{{ $status['order']->Customer->last_name }}</span></p>
                                        @endif
                                        <p class="my-1">Contact Number: <span class="fw-bold">{{ $status['order']->Customer->phone_number }}</span></p>
                                    </ul>
                                </div>
                                <div class="col col-md-6">
                                    <ul>
                                        <p class="my-1">Address: <span class="fw-bold">{{ $status['order']->Customer->address }}</span></p>
                                        <p class="my-1">City: <span class="fw-bold">{{ $status['order']->Customer->city }}</span></p>
                                        <p class="my-1">State/Province: <span class="fw-bold">{{ $status['order']->Customer->state }}</span></p>
                                        <p class="my-1">Country Code: <span class="fw-bold">{{ $status['order']->Customer->country }}</span></p>
                                        <p class="my-1">Postal Code: <span class="fw-bold">{{ $status['order']->Customer->zip_code }}</span></p>
                                        <p class="my-1">Complete Address: <span class="fw-bold">{{ $status['order']->Customer->complete_address }}</span></p>
                                        <p class="my-1">Artwork Frame: <span class="fw-bold">@if($status['order']->is_framed === 1) Framed @else No Frame @endif</span></p>
                                        <p class="my-1">Status: <span class="fw-bold @if($status['order']->is_done === 2) text-success @elseif($status['order']->is_done === 1) text-warning @else text-danger @endif">@if($status['order']->is_done === 2) Delivered @elseif($status['order']->is_done === 1) On Delivery @else On Queue @endif</span></p>
                                    </ul>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col text-center">
                                    <div class="fs-5">
                                        @if($status['order']->is_done === 2)
                                            Your order has been delivered, Thank you for supporting The Art of Pete Vitalez!
                                        @elseif($status['order']->is_done === 1)
                                            Your order is now on delivery.
                                        @else
                                            You will be contacted as soon as the order is done.
                                        @endif
                                        <br>
                                        (This is a system generated message)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

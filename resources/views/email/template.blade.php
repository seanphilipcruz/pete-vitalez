<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Official Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
        }

        .navbar-brand > img {
            max-width: 90px;
        }

        img {
            transition: 0.8s;
        }

        img:hover {
            transform: scale(1.4);
        }

        .navbar {
            position: relative;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .navbar > .container-fluid {
            display: flex;
            flex-wrap: inherit;
            align-items: center;
            justify-content: space-between;
        }
        .navbar-brand {
            padding-top: 0.3125rem;
            padding-bottom: 0.3125rem;
            margin-right: 1rem;
            font-size: 1.25rem;
            text-decoration: none;
            white-space: nowrap;
        }

        .navbar-expand-md {
            flex-wrap: nowrap;
            justify-content: flex-start;
        }

        .navbar-light .navbar-brand {
            color: rgba(0, 0, 0, 0.9);
        }
        .navbar-light .navbar-brand:hover, .navbar-light .navbar-brand:focus {
            color: rgba(0, 0, 0, 0.9);
        }
        .navbar-light .navbar-nav .nav-link {
            color: rgba(0, 0, 0, 0.55);
        }
        .navbar-light .navbar-nav .nav-link:hover, .navbar-light .navbar-nav .nav-link:focus {
            color: rgba(0, 0, 0, 0.7);
        }
        .navbar-light .navbar-nav .nav-link.disabled {
            color: rgba(0, 0, 0, 0.3);
        }
        .navbar-light .navbar-nav .show > .nav-link,
        .navbar-light .navbar-nav .nav-link.active {
            color: rgba(0, 0, 0, 0.9);
        }
        .navbar-light .navbar-toggler {
            color: rgba(0, 0, 0, 0.55);
            border-color: rgba(0, 0, 0, 0.1);
        }
        .navbar-light .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280, 0, 0, 0.55%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        .navbar-light .navbar-text {
            color: rgba(0, 0, 0, 0.55);
        }
        .navbar-light .navbar-text a,
        .navbar-light .navbar-text a:hover,
        .navbar-light .navbar-text a:focus {
            color: rgba(0, 0, 0, 0.9);
        }

        .bg-light {
            background-color: rgba(13, 110, 25, 1) !important;
        }

        .justify-content-center {
            justify-content: center !important;
        }

        .container,
        .container-fluid {
            width: 100%;
            padding-right: var(--bs-gutter-x, 0.75rem);
            padding-left: var(--bs-gutter-x, 0.75rem);
            margin-right: auto;
            margin-left: auto;
        }

        @media (min-width: 576px) {
            .container {
                max-width: 540px;
            }
        }
        @media (min-width: 768px) {
            .container {
                max-width: 720px;
            }
        }
        @media (min-width: 992px) {
            .container {
                max-width: 960px;
            }
        }
        @media (min-width: 1200px) {
            .container {
                max-width: 1140px;
            }
        }
        @media (min-width: 1400px) {
            .container {
                max-width: 1320px;
            }
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
    <div class="container my-4">
        <div class="mt-3 fs-2 fw-bold text-center">The Art of Pete Vitalez</div>
        <div class="mb-2">
            <div class="row text-center">
                <div class="col-12 fs-5">{{ $invoice['contact']->address }}</div>
                <div class="col-12 fs-6">{{ $invoice['contact']->email }}</div>
                <div class="col-12 fs-6">{{ $invoice['contact']->contact_number }}</div>
            </div>
        </div>
        <div class="my-2">
            <hr />
                <div class="fs-3 fw-bold text-center">
                    Official Receipt
                </div>
            <hr />
        </div>
        <div class="row mb-4">
            <div class="col-12 col-md-6">
                <div class="fw-bold">Customer Information</div>
                @if(!$invoice['order']->middle_name)
                    <div><span class="fw-bold">Name</span>: {{ $invoice['order']->Customer->first_name }} {{ $invoice['order']->Customer->last_name }}</div>
                @else
                    <div><span class="fw-bold">Name</span>: {{ $invoice['order']->Customer->first_name }} {{ $invoice['order']->Customer->middle_name }} {{ $invoice['order']->Customer->last_name }}</div>
                @endif
                <div><span class="fw-bold">Email</span>: {{ $invoice['order']->Customer->email }}</div>
                <div><span class="fw-bold">Contact Number</span>: {{ $invoice['order']->Customer->phone_number }}</div>
                <div><span class="fw-bold">Address</span>: {{ $invoice['order']->Customer->address }} {{ $invoice['order']->Customer->city }}, {{ $invoice['order']->Customer->state }}  {{ $invoice['order']->Customer->country }} {{ $invoice['order']->Customer->zip_code }}</div>
            </div>
            <div class="col-12 col-md-6 text-md-end">
                <div><span class="fw-bold">Date of Purchase</span>: {{ $invoice['date_ordered'] }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-hover table-borderless">
                    <thead class="table-light">
                        <tr>
                            <th>Quantity</th>
                            <th>Description</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>{{ $invoice['order']->Product->title }}</td>
                            <td class="text-end">{{ $invoice['order']->Product->price }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col"></div>
            <div class="col-4">
                <table class="table table-hover table-borderless">
                    <thead class="table-light">
                        <tr>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-end">{{ $invoice['order']->total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="my-2">
            <hr />
                <div class="text-center my-4">
                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->generate(route('website.verify.invoice', $invoice['order']->code)) !!}
                    <div class="my-3">
                        This serves as your official receipt, thank you for supporting The Art of Pete Vitalez!
                        (This is a system generated message)
                    </div>
                </div>
            <hr />
        </div>
    </div>
</body>
</html>

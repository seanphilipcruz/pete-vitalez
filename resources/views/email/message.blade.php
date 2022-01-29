<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pete Vitalez | Website Message</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <style>
        .container {
            width: 100%;
            padding-right: var(--bs-gutter-x, 0.75rem);
            padding-left: var(--bs-gutter-x, 0.75rem);
            margin-right: auto;
            margin-left: auto;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .my-4 {
            margin-top: 1.5rem !important;
            margin-bottom: 1.5rem !important;
        }

        .text-open-sans {
            font-family: 'Open Sans', sans-serif;
            font-weight: 300 !important;
        }

        @media (min-width: 1200px) {
            .fs-3 {
                font-size: 1.75rem !important;
            }

            .fs-4 {
                font-size: 1.5rem !important;
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

        .justify-content-center {
            justify-content: center !important;
        }

        .col-8 {
            flex: 0 0 auto;
            width: 66.66666667%;
        }

        .fw-bold {
            font-weight: 700 !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="my-4 text-open-sans">
            <div class="fs-3 mb-3">Hi! Mr. Pete Vitalez!</div>
            <div class="fs-4">
                <div class="row justify-content-center mb-3">
                    <div class="col-8">
                        You have a new message from the website from <span class="fw-bold">{{ $website_message->name }}</span> about an <span class="fw-bold">{{ $website_message->subject }}</span>, this person can be contacted via <span class="fw-bold">{{ $website_message->email }}</span>.
                    </div>
                </div>
                <div class="row justify-content-center mb-3">
                    <div class="col-8">
                        {{ $website_message->content }}
                    </div>
                </div>
                <div class="row justify-content-center mb-3">
                    <div class="col-8 text-center">
                        (This is a system generated message)
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

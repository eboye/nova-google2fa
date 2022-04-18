<!DOCTYPE html>
<html lang="en" class="h-full font-sans">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ Nova::name() }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('app.css', 'vendor/nova') }}">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body class="text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-900 min-h-full">
<div class="h-full">
    <div class="px-view py-view mx-auto">
        <div class="mx-auto py-8 max-w-sm text-center text-90">
            <img class="inline-block" src="{{asset('img/nova_logo.svg')}}" width="137" height="27"
                 alt="{{config('app.name')}}"/>
        </div>

        <form class="bg-white shadow rounded-lg p-8 max-w-xl mx-auto" method="POST" action="/los/2fa/register">
            <h2 class="py-2">Recovery codes</h2>
            @csrf
            <p class="py-2">
                Recovery codes are used to access your account in the event you cannot recive two-factor
                authentication codes.
            </p>
            <p class="py-2 no-print">
                <strong>
                    Download, print or copy your codes before continuing two-factor authentication setup.
                </strong>
            </p>
            <div class="py-3">
                <label class="font-bold mb-2 flex items-center w-full" for="co">
                    <span>Recovery codes</span>
                    <button
                        class="no-print ml-auto flex-shrink-0 shadow rounded focus:outline-none focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
                        type="button"
                        onclick="window.print();return false;">
                        Print
                    </button>
                </label>
            </div>

            <div class="flex flex-col space-y-2 py-2 text-center bg-gray-100 text-sm rounded">
                @foreach ($recovery as $recoveryCode)
                    <pre>{{ $recoveryCode }}</pre>
                @endforeach
            </div>

            <button
                class="no-print mt-4 flex-shrink-0 shadow rounded focus:outline-none focus:ring bg-red-500 hover:bg-red-400 active:bg-red-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
                type="submit">
                Continue
            </button>
        </form>
    </div>
</div>
</body>
</html>

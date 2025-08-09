<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ __('OtpCodeNToken.subject', ['otp' => $details['otp_code'], 'app_name' => env('APP_NAME')]) }}</title>
    </head>

    <body class="bg-gray-100">
        <style>
            .bg-gray-100 {
                background-color: #f3f4f6;
            }

            .max-w-2xl {
                max-width: 42rem;
            }

            .mx-auto {
                margin-left: auto;
                margin-right: auto;
            }

            .my-8 {
                margin-top: 2rem;
                margin-bottom: 2rem;
            }

            .bg-white {
                background-color: #ffffff;
            }

            .rounded-lg {
                border-radius: 0.5rem;
            }

            .shadow-md {
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .overflow-hidden {
                overflow: hidden;
            }

            .bg-indigo-600 {
                background-color: #4f46e5;
            }

            .py-6 {
                padding-top: 1.5rem;
                padding-bottom: 1.5rem;
            }

            .px-8 {
                padding-left: 2rem;
                padding-right: 2rem;
            }

            .text-3xl {
                font-size: 1.875rem;
                line-height: 2.25rem;
            }

            .font-bold {
                font-weight: 700;
            }

            .text-white {
                color: #ffffff;
            }

            .text-center {
                text-align: center;
            }

            .p-8 {
                padding: 2rem;
            }

            .text-gray-700 {
                color: #374151;
            }

            .mb-6 {
                margin-bottom: 1.5rem;
            }

            .p-4 {
                padding: 1rem;
            }

            .text-4xl {
                font-size: 2.25rem;
                line-height: 2.5rem;
            }

            .text-indigo-600 {
                color: #4f46e5;
            }

            .mb-2 {
                margin-bottom: 0.5rem;
            }

            .py-4 {
                padding-top: 1rem;
                padding-bottom: 1rem;
            }

            .text-sm {
                font-size: 0.875rem;
                line-height: 1.25rem;
            }

            .text-gray-600 {
                color: #4b5563;
            }

            .font-semibold {
                font-weight: 600;
            }
        </style>

        <div class="max-w-2xl mx-auto my-8 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-indigo-600 py-6 px-8">
                <h1 class="text-3xl font-bold text-white text-center">{{ __('OtpCodeNToken.header') }}</h1>
            </div>
            <div class="p-8">
                <p class="text-gray-700 mb-6">{{ __('OtpCodeNToken.greeting', ['username' => $details['username']]) }},
                </p>
                <p class="text-gray-700 mb-6">{{ __('OtpCodeNToken.otp_message') }}</p>
                <div class="bg-gray-100 rounded-lg p-4 mb-6">
                    <p class="text-4xl font-bold text-center text-indigo-600">{{ $details['otp_code'] }}</p>
                </div>
                <p class="text-gray-700 mb-6">{!! __('OtpCodeNToken.valid_time', ['minutes' => 5]) !!}</p>
                <p class="text-gray-700 mb-2">{{ __('OtpCodeNToken.ignore_message') }}</p>
                <p>{{ __('OtpCodeNToken.verify_link') }}</p>
                <a
                    href="{{ env('APP_URL') . '/api/' . config('paths.auth.email.verify') . $details['token'] }}">{{ __('OtpCodeNToken.verify_email') }}</a>
                <p class="text-gray-700">{{ __('OtpCodeNToken.thanks') }}</p>
            </div>
            <div class="bg-gray-100 py-4 px-8">
                <p class="text-sm text-gray-600 text-center">&copy; 2025 Frontice By Pat. All rights reserved.</p>
            </div>
        </div>
    </body>

</html>

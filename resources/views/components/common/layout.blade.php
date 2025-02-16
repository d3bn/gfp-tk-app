<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} — Issue</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>

<body class="font-sans antialiased flex flex-col min-h-screen">
    <div class="mx-auto w-full max-w-5xl px-4 sm:px-6 lg:px-8 my-15">
        {{$slot}}
    </div>
</body>
</html>

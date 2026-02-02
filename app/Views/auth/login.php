<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - OSMS</title>
    <link rel="stylesheet" href="/assets/css/tailwind.min.css">
    <script defer src="/assets/js/alpine.min.js"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-blue-600">OSMS</h1>
            <p class="text-gray-500">Offline School Management System</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="/login" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                    Username
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" type="text" placeholder="Username" required>
            </div>
            <div class="mb-6" x-data="{ show: false }">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" placeholder="******************" required>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                        <button type="button" @click="show = !show" class="text-gray-500 focus:outline-none focus:text-gray-600" x-text="show ? 'Hide' : 'Show'"></button>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full" type="submit">
                    Sign In
                </button>
            </div>
        </form>
    </div>
</body>
</html>

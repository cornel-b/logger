<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Application Logs</title>

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link
        href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap"
        rel="stylesheet"
    />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ["Figtree", "sans-serif"],
                    },
                },
            },
        };
    </script>
</head>
<body class="font-sans antialiased bg-gray-100">
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Application Logs</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
            <tr
                class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal"
            >
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Timestamp</th>
                <th class="py-3 px-6 text-left">Level</th>
                <th class="py-3 px-6 text-left">Method</th>
                <th class="py-3 px-6 text-left">URL</th>
                <th class="py-3 px-6 text-left">Route Name</th>
                <th class="py-3 px-6 text-left">User ID</th>
                <!-- Add other headers if needed -->
            </tr>
            </thead>
            <tbody class="text-gray-700 text-sm font-light">
            @forelse ($logs as $log)
                <tr
                    class="border-b border-gray-200 hover:bg-gray-100"
                >
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        {{ $log->id }}
                    </td>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        {{ $log->created_at->format("Y-m-d H:i:s") }}
                    </td>
                    <td class="py-3 px-6 text-left">
                  <span
                      class="py-1 px-3 rounded-full text-xs font-semibold
                                        @if (strtolower($log->verbosity_level) === 'error' || strtolower($log->verbosity_level) === 'critical')
                                            bg-red-200 text-red-700
                                        @elseif (strtolower($log->verbosity_level) === 'warning')
                                            bg-yellow-200 text-yellow-700
                                        @elseif (strtolower($log->verbosity_level) === 'info')
                                            bg-blue-200 text-blue-700
                                        @elseif (strtolower($log->verbosity_level) === 'debug')
                                            bg-purple-200 text-purple-700
                                        @else
                                            bg-gray-200 text-gray-700
                                        @endif
                                        "
                  >
                    {{ $log->verbosity_level }}
                  </span>
                    </td>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                  <span
                      class="font-medium
                                        @if ($log->route_method === 'GET') text-green-600
                                        @elseif ($log->route_method === 'POST') text-blue-600
                                        @elseif ($log->route_method === 'PUT' || $log->route_method === 'PATCH') text-yellow-600
                                        @elseif ($log->route_method === 'DELETE') text-red-600
                                        @else text-gray-600 @endif"
                  >
                    {{ $log->route_method }}
                  </span>
                    </td>
                    <td class="py-3 px-6 text-left max-w-xs truncate">
                        {{ $log->route_url }}
                    </td>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        {{ $log->route_name ?? "N/A" }}
                    </td>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        {{ $log->user_id ?? "N/A" }}
                    </td>
                    <!-- Add other data cells if needed -->
                </tr>
            @empty
                <tr>
                    <td
                        colspan="7"
                        class="py-6 px-6 text-center text-gray-500"
                    >
                        No logs found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $logs->links() }}
    </div>
</div>
</body>
</html>

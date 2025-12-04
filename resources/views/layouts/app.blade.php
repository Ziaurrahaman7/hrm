<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        @if((auth()->user()->is_admin && request()->is('admin*')) || request()->is('employees*') || request()->is('departments*') || request()->is('skills*'))
            <!-- Admin Layout -->
            <div class="min-h-screen flex">
                <!-- Sidebar -->
                <div class="w-64 bg-gradient-to-b from-gray-800 to-gray-900 shadow-xl">
                    <div class="p-4 border-b border-gray-700">
                        <div class="flex items-center space-x-2">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="h-6 w-6 rounded">
                            <div>
                                <h2 class="text-white font-semibold text-sm">HRM System</h2>
                            </div>
                        </div>
                    </div>
                    <nav class="mt-4">
                        <div class="px-2 space-y-1">
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                </svg>
                                Dashboard
                            </a>
                            
                            <a href="{{ route('employees.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg {{ request()->routeIs('employees.*') ? 'bg-gray-700 text-white' : '' }}">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Employees
                            </a>
                            
                            <a href="{{ route('departments.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg {{ request()->routeIs('departments.*') ? 'bg-gray-700 text-white' : '' }}">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                                </svg>
                                Departments
                            </a>
                            
                            <a href="{{ route('skills.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg {{ request()->routeIs('skills.*') ? 'bg-gray-700 text-white' : '' }}">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                                Skills
                            </a>
                            

                            
                            <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg {{ request()->routeIs('admin.users') ? 'bg-gray-700 text-white' : '' }}">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                System Users
                            </a>
                        </div>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="flex-1 flex flex-col">
                    <!-- Header -->
                    <header class="bg-white shadow-sm border-b border-gray-200">
                        <div class="flex justify-between items-center px-6 py-4">
                            <h1 class="text-xl font-semibold text-gray-900">HRM Admin Panel</h1>
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700">User Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-500 hover:text-gray-700">Logout</button>
                                </form>
                            </div>
                        </div>
                    </header>

                    <!-- Page Content -->
                    <main class="flex-1 p-6">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        @else
            <!-- Regular Layout -->
            <div class="min-h-screen bg-gray-100">
                @include('layouts.navigation')

                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main>
                    {{ $slot }}
                </main>
            </div>
        @endif
    </body>
</html>

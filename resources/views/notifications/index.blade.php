@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Your Notifications</h1>
        <form action="{{ route('notifications.read-all') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Mark All as Read
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($notifications->isEmpty())
            <div class="p-8 text-center text-gray-500">
                You have no notifications.
            </div>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach($notifications as $notification)
                    <li class="{{ $notification->read() ? 'bg-white' : 'bg-gray-50' }}">
                        <a href="{{ $notification->data['url'] ?? '#' }}" class="block px-6 py-4 hover:bg-gray-100">
                            <div class="flex items-center">
                                @if(isset($notification->data['icon']))
                                    <div class="flex-shrink-0 mr-4">
                                        <i class="{{ $notification->data['icon'] }} text-xl text-gray-500"></i>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                    <p class="text-sm text-gray-500">{{ $notification->data['message'] ?? '' }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                                @if($notification->unread())
                                    <span class="ml-4 h-2 w-2 rounded-full bg-blue-500"></span>
                                @endif
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
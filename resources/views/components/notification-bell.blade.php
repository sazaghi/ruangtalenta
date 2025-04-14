<div class="position-relative" id="notification-container">
    <!-- Notification Bell Icon -->
    <button id="notification-button" class="btn btn-link position-relative p-2">
        <i class="bi bi-bell fs-5"></i>
        @if($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.5rem">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Notification Panel -->
    <div 
        id="notification-panel"
        class="position-absolute end-0 mt-2 w-72 bg-white rounded shadow-lg border-0 p-0 d-none"
        style="max-height: 400px; overflow-y: auto; z-index: 1000;"
    >
        <div class="p-3 border-bottom">
            <h5 class="mb-0 fw-bold">Notifikasi</h5>
            @if($unreadCount > 0)
                <small class="text-muted">{{ $unreadCount }} belum dibaca</small>
            @endif
        </div>
        
        @if($notifications->isEmpty())
            <div class="p-4 text-center text-muted">
                Tidak ada notifikasi
            </div>
        @else
            <div class="list-group list-group-flush">
                @foreach($notifications as $notification)
                    <a 
                        href="{{ $notification->data['url'] ?? '#' }}" 
                        class="list-group-item list-group-item-action {{ $notification->read() ? '' : 'bg-light' }} notification-item"
                        data-notification-id="{{ $notification->id }}"
                    >
                        <div class="d-flex align-items-center">
                            @if(isset($notification->data['icon']))
                                <div class="me-3">
                                    <i class="{{ $notification->data['icon'] }} text-primary"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold">{{ $notification->data['title'] ?? 'Notifikasi' }}</h6>
                                <p class="mb-1 small">{{ $notification->data['message'] ?? '' }}</p>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            @if($notification->unread())
                                <span class="badge bg-primary ms-2">Baru</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="p-2 border-top text-center">
                <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-link text-primary">
                    Lihat Semua
                </a>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const notificationButton = document.getElementById('notification-button');
    const notificationPanel = document.getElementById('notification-panel');
    
    // Toggle notification panel
    notificationButton.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        notificationPanel.classList.toggle('d-none');
    });
    
    // Close when clicking outside
    document.addEventListener('click', function(e) {
        if (!notificationPanel.contains(e.target) && e.target !== notificationButton) {
            notificationPanel.classList.add('d-none');
        }
    });
    
    // Mark as read when clicking notification
    document.querySelectorAll('.notification-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.stopPropagation();
            const notificationId = this.getAttribute('data-notification-id');
            
            if (this.classList.contains('bg-light')) {
                fetch(`/notifications/${notificationId}/read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        this.classList.remove('bg-light');
                        const badge = this.querySelector('.badge');
                        if (badge) badge.remove();
                        
                        // Update unread count
                        const unreadBadge = document.querySelector('#notification-button .badge');
                        if (unreadBadge) {
                            const count = parseInt(unreadBadge.textContent) - 1;
                            if (count > 0) {
                                unreadBadge.textContent = count;
                            } else {
                                unreadBadge.remove();
                            }
                        }
                    }
                }).catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    });
});
</script>
@extends('layouts.admin')

@section('title', 'Quản lý Liên hệ')
@section('page_title', 'Hộp thư & Yêu cầu hỗ trợ')

@push('styles')
    @vite(['resources/css/admin/messages.css'])
@endpush

@section('content')
    <div class="chat-container">
        
        <div class="chat-sidebar">
            <div class="chat-sidebar-header">
                <h3>Danh sách yêu cầu ({{ $messages->count() }})</h3>
            </div>
            
            <div class="contact-list">
                @forelse($messages as $message)
                    <a href="{{ route('admin.messages.index', ['id' => $message->id]) }}" 
                       class="contact-item {{ ($activeMessage && $activeMessage->id == $message->id) ? 'active' : '' }}">
                        <div class="contact-avatar">
                            {{ mb_strtoupper(mb_substr($message->name, 0, 1, 'UTF-8'), 'UTF-8') }}
                        </div>
                        <div class="contact-info">
                            <div class="contact-name">
                                {{ $message->name }}
                                <span class="contact-time">{{ $message->created_at->format('d/m H:i') }}</span>
                            </div>
                            <div class="contact-preview">{{ $message->message }}</div>
                        </div>
                    </a>
                @empty
                    <div style="padding: 30px; text-align: center; color: #9ca3af; font-size: 13px;">
                        Chưa có khách hàng nào gửi lời nhắn.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="chat-main">
            @if($activeMessage)
                <div class="message-detail-header">
                    <h2 style="margin: 0; font-size: 20px; font-weight: 800; color: #111827;">Yêu cầu hỗ trợ từ khách hàng</h2>
                    <div style="color: #6b7280; font-size: 13px; margin-top: 4px;">Gửi lúc: {{ $activeMessage->created_at->format('d/m/Y H:i:s') }}</div>
                    
                    <div class="contact-card">
                        <div class="contact-detail-item">
                            <span class="contact-detail-label">Họ và Tên</span>
                            <span class="contact-detail-value">{{ $activeMessage->name }}</span>
                        </div>
                        <div class="contact-detail-item">
                            <span class="contact-detail-label">Số điện thoại (Zalo/Gọi)</span>
                            <span class="contact-detail-value">{{ $activeMessage->phone }}</span>
                        </div>
                        <div class="contact-detail-item">
                            <span class="contact-detail-label">Địa chỉ Email</span>
                            <span class="contact-detail-value">{{ $activeMessage->email }}</span>
                        </div>
                    </div>
                </div>

                <div class="message-body">
                    <div style="font-weight: 700; color: #475569; margin-bottom: 12px; text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px;">Nội dung lời nhắn:</div>
                    <div class="message-content-box">
                        {!! nl2br(e($activeMessage->message)) !!}
                    </div>
                </div>
            @else
                <div style="flex: 1; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 15px;">
                    Chọn một tin nhắn bên trái để xem chi tiết
                </div>
            @endif
        </div>
        
    </div>
@endsection
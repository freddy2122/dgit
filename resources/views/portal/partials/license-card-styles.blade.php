@once
    @push('styles')
        <style>
            .license-card-surface {
                background: linear-gradient(152deg, #f3d0d8 0%, #e8b8c4 28%, #dfa8b6 55%, #ecc4ce 82%, #f5dce2 100%);
                border: 1px solid rgba(185, 28, 74, 0.22);
            }
            .license-card-pattern {
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'%3E%3Cpath d='M0 60c20-30 40 30 60 0s40 30 60 0' fill='none' stroke='%23c97a8a' stroke-width='0.35' opacity='0.45'/%3E%3Cpath d='M60 0v120M0 60h120' fill='none' stroke='%23b91c4a' stroke-width='0.25' opacity='0.2'/%3E%3C/svg%3E");
                background-size: 120px 120px;
            }
        </style>
    @endpush
@endonce

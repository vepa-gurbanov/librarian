
<div class="container-xl">
    @if(session('success'))
        <div class="toast-container position-fixed bottom-0 end-0 top-0 p-3">
            <div id="toast"
                 class="toast fade show bg-success-subtle text-success-emphasis" data-bs-delay="5000" data-bs-autohide="true" data-bs-animation="true" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    {!! session('success') !!}
                </div>
            </div>
        </div>
    @elseif(!empty($success))
        <div class="toast-container position-fixed bottom-0 end-0 top-0 p-3">
            <div id="toast"
                 class="toast fade show bg-success-subtle text-success-emphasis" data-bs-delay="5000" data-bs-autohide="true" data-bs-animation="true" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    {!! $success !!}
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="toast-container position-fixed bottom-0 end-0 top-0 p-3">
            <div id="toast"
                 class="toast fade show bg-danger-subtle text-danger-emphasis" data-bs-delay="5000" data-bs-autohide="true" data-bs-animation="true" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    {!! session('error') !!}
                </div>
            </div>
        </div>
    @elseif(!empty($error))
        <div class="toast-container position-fixed bottom-0 end-0 top-0 p-3">
            <div id="toast"
                 class="toast fade show bg-danger-subtle text-danger-emphasis" data-bs-delay="5000" data-bs-autohide="true" data-bs-animation="true" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    {!! $error !!}
                </div>
            </div>
        </div>
    @elseif($errors->any())
        <div class="toast-container position-fixed bottom-0 end-0 top-0 p-3">
            <div id="toast"
                 class="toast fade show bg-danger-subtle text-danger-emphasis" data-bs-delay="5000" data-bs-autohide="true" data-bs-animation="true" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<div class="toast-container position-fixed bottom-0 end-0 top-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body">
            Hello, world! This is a toast message.
        </div>
    </div>
</div>


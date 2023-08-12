
<div class="container-xl">
    @if(session('success'))
        <div class="toast-container position-fixed bottom-0 end-0 top-0 p-3">
            <div id="toast"
                 class="toast fade show bg-success-subtle text-success-emphasis" data-bs-animation="true" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <span class="bi-check-circle-fill"></span>
                    {!! session('success') !!}
                </div>
            </div>
        </div>
    @elseif(!empty($success))
        <div class="toast-container position-fixed bottom-0 end-0 top-0 p-3">
            <div id="toast"
                 class="toast fade show bg-success-subtle text-success-emphasis" data-bs-animation="true" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <span class="bi-check-circle-fill"></span>
                    {!! $success !!}
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="toast-container position-fixed bottom-0 end-0 top-0 p-3">
            <div id="toast"
                 class="toast fade show bg-danger-subtle text-danger-emphasis" data-bs-animation="true" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <span class="bi-exclamation-triangle-fill"></span>
                    {!! session('error') !!}
                </div>
            </div>
        </div>
    @elseif(!empty($error))
        <div class="toast-container position-fixed bottom-0 end-0 top-0 p-3">
            <div id="toast"
                 class="toast fade show bg-danger-subtle text-danger-emphasis" data-bs-animation="true" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <span class="bi-exclamation-triangle-fill"></span>
                    {!! $error !!}
                </div>
            </div>
        </div>
    @elseif($errors->any())
        <div class="toast-container position-fixed bottom-0 end-0 top-0 p-3">
            <div id="toast"
                 class="toast fade show bg-danger-subtle text-danger-emphasis" data-bs-animation="true" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <span class="bi-exclamation-triangle-fill"></span>
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
            <span class="bi-check-circle-fill"></span>
            <span id="content"></span>
        </div>
    </div>
</div>


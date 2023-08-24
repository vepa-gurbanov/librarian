<form action="{{ route('login') }}" method="POST" class="needs-validation" novalidate>
    @csrf
    @honeypot
    <div class="h2 text-white text-center">Log In</div>

    <div class="step-bar row">
        <div class="col step-content text-center" id="step-content-1">
            <span class="bi-check-circle-fill"></span>
            <div class="small fw-bold text-white">Step 1</div>
        </div>
        <div class="col step-content text-center" id="step-content-2">
            <span class="bi-check-circle-fill"></span>
            <div class="small fw-bold text-white">Step 2</div>
        </div>
    </div>

    <div class="lct mb-3">
        <label for="phone" class="form-lct-label">Phone</label>
        <div class="d-flex align-items-center form-lct-group">
            <input type="text" class="form-lct-input letter-spacing-number" id="phone" name="phone" placeholder="Enter phone" autofocus required>
            <div class="position-relative right-0 form-lct-icon">
                <svg id="false" class="d-none" viewBox="0 0 25 25"><path d="M22.222 0 25 2.778l-9.723 9.721L25 22.222 22.222 25 12.5 15.277 2.778 25 0 22.222 9.722 12.5 0 2.778 2.778 0 12.5 9.722 22.222 0z" class="fill-current" fill-rule="evenodd"></path></svg>
                <svg id="true" width="10" height="8" viewBox="0 0 10 8">
                    <path fill="#FFF" fill-rule="evenodd" stroke="#FFF" stroke-width=".728" d="M3.533 5.646l-2.199-2.19c-.195-.194-.488-.194-.684 0-.195.195-.195.487 0 .682l2.883 2.87L9.055 1.51c.195-.194.195-.487 0-.681-.196-.195-.49-.195-.685 0L3.533 5.646z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="redirection">
        <button type="button" class="lct-btn-primary my-3" name="login">Get verification code</button>
        <a href="#" class="lct-link mt-0 flex-center text-sm" id="i_have_code">I have verification code</a>
        <div class="flex-center">
            <a href="#" class="lct-link text-sm m-0">Resend? </a> <span class="mx-3">or</span>
            <a href="#" class="lct-link text-sm m-0">Sign up</a>
        </div>
    </div>
</form>

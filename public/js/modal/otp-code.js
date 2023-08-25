const inputs = document.querySelectorAll(".otp-field > input");
const button = document.querySelector("button[name=verify]");
const clearButton = $('button[name=clearOtpInput]');
let codeInputs = $('input.otp-input');

// on startup
clearButton.addClass("disabled");
if (inputs[0].value.length !== 0 || inputs[1].value.length !== 0 || inputs[2].value.length !== 0 || inputs[3].value.length !== 0 || inputs[4].value.length !== 0) {
    clearButton.removeClass("disabled");
}

// if (emptyArray.length > 1) {
//     clearButton.removeClass("disabled");
// } else {
//     clearButton.addClass("disabled");
// }

clearButton.on('click', function () {
    codeInputs.val(null);
    codeInputs.attr('disabled', true).removeClass('active')
    $(this).addClass('disabled')
    button.setAttribute("disabled", "disabled");
    codeInputs.first().attr('disabled', false).addClass('active')
    codeInputs.first().focus();
})
// END CLEAR BUTTON

window.addEventListener("load", () => inputs[0].focus());
button.setAttribute("disabled", "disabled");

inputs[0].addEventListener("paste", function (event) {
    event.preventDefault();

    if (inputs[0].value.length !== 0 || inputs[1].value.length !== 0 || inputs[2].value.length !== 0 || inputs[3].value.length !== 0 || inputs[4].value.length !== 0) {
        clearButton.removeClass("disabled");
    }
    const pastedValue = (event.clipboardData || window.clipboardData).getData(
        "text"
    );
    const otpLength = inputs.length;

    for (let i = 0; i < otpLength; i++) {
        if (i < pastedValue.length) {
            inputs[i].value = pastedValue[i];
            inputs[i].removeAttribute("disabled");
            inputs[i].focus;
        } else {
            inputs[i].value = ""; // Clear any remaining inputs
            inputs[i].focus;
        }
    }
});

inputs.forEach((input, index1) => {

    input.addEventListener("keyup", (e) => {
        const currentInput = input;
        const nextInput = input.nextElementSibling;
        const prevInput = input.previousElementSibling;

        if (inputs[0].value.length !== 0 || inputs[1].value.length !== 0 || inputs[2].value.length !== 0 || inputs[3].value.length !== 0 || inputs[4].value.length !== 0) {
            clearButton.removeClass("disabled");
        }
        if (currentInput.value.length > 1) {
            currentInput.value = "";
            return;
        }

        if (
            nextInput &&
            nextInput.hasAttribute("disabled") &&
            currentInput.value !== ""
        ) {
            nextInput.removeAttribute("disabled");
            nextInput.focus();
        }

        if (e.key === "Backspace") {
            inputs.forEach((input, index2) => {
                if (index1 <= index2 && prevInput) {
                    input.setAttribute("disabled", true);
                    input.value = "";
                    prevInput.focus();
                }
            });
        }

        if (e.key === "ArrowRight") {
            nextInput.focus();
        } else if (e.key === "ArrowLeft") {
            prevInput.focus();
        }

        button.classList.remove("active");
        button.setAttribute("disabled", "disabled");

        const inputsNo = inputs.length;
        if (!inputs[inputsNo - 1].disabled && inputs[inputsNo - 1].value !== "") {
            button.classList.add("active");
            button.removeAttribute("disabled");

            return;
        }
    });
});

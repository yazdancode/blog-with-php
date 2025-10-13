const urlParams = new URLSearchParams(window.location.search);
if (urlParams.has('error') && urlParams.get('error') === '1') {
    swal({
        title: "Login Error!",
        text: "Invalid email or password. Please try again.",
        icon: "error"
    });
}
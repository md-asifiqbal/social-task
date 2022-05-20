class Auth {
    //Login User
    register(email, password) {
        fetch("/api/auth/login", {
            headers: {
                "Content-Type": "application/json; Accept: application/json"
            },
            method: "POST",
            body: JSON.stringify({
                email: email,
                password: password
            })
        }).then(response => response.json()).then(json => {
            if (json.status) {
                localStorage.setItem("token", json.api_token);
                window.location.href = "/feed";
            } else {
                document.getElementById("emailHelp").classList.remove("d-none");
                document.getElementById("emailHelp").classList.add("d-block");
                document.getElementById("emailHelp").textContent = json.message;
            }
        });
    }
}
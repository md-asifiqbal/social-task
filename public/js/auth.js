class Auth {
    errorShow(message){
        document.getElementById("errormsgdiv").classList.remove("d-none");
        document.getElementById("errormsgdiv").classList.add("d-block");
        document.getElementById("errormsg").classList.remove("d-none");
        document.getElementById("errormsg").classList.add("d-block");
        document.getElementById("errormsg").textContent = message;
    }
    //Login User
    login(email, password) {
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
                this.errorShow(json.message);
            }
        });
    }

    //Register User
    register(first_name,last_name,email, password,password_confirmation) {
        fetch("/api/auth/register", {
            headers: {
                "Content-Type": "application/json; Accept: application/json"
            },
            method: "POST",
            body: JSON.stringify({
                first_name: first_name,
                last_name: last_name,
                email: email,
                password: password,
                password_confirmation: password_confirmation,
            })
        }).then(response => response.json()).then(json => {
            if (json.status) {
                window.location.href = "/login";
            } else {
                this.errorShow(json.message);
            }
        });
    }
}